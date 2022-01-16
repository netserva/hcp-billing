<?php

declare(strict_types=1);

/**
 * Makes email body parts into array of objects
 * so they can be acted on by other classes
 * access data, execute detectors, etc...
 * array is indexed by MIME part number 1, 1.1, 1.2, 2 etc...
 * extends body so that this class
 * can manipulate messages on the mail server
 * also connected to peek class through peek_parent
 * so functions can talk to mail server and get
 * other items like the attachment_dir.
 */
include_once 'peeker_body.php'; // the parent

include_once 'peeker_file.php'; // the spawn

class peeker_parts extends peeker_body
{
    public $parts_array = [];
    public $parts_count;

    // holds any files written to disk
    // by save_all_attachments() function
    public $local_file_name_array = [];
    public $local_file_name_count;

    /**
     * Constructor, connect to parent class.
     *
     * @param mixed $peek_parent
     * @param mixed $imap_h_obj
     */
    public function __construct(&$peek_parent, $imap_h_obj)
    {
        // pass the parent on to the header class
        parent::__construct($peek_parent, $imap_h_obj);
        $this->log_state('LOADING parts class');
    }

    /**
     * Wrapper, pass on to parent class.
     */
    public function get_parts(): void
    {
        $this->get_body();
    }

    /**
     * Parse e-mail structure into array var
     * this will handle nested parts properly
     * it will recurse and use the initial part number
     * concatenating it with nested parts using dot .
     * Useful information on type numbers and encodings
     * from http://php.net.
     *
     * @param mixed      $structure_parts_array
     * @param null|mixed $part_no
     * @param null|mixed $recurse_part_no
     */
    public function extract_parts($structure_parts_array, $part_no = null, $recurse_part_no = null)
    {
        //pe($structure_parts_array);
        // we are in a recursion section
        if (null !== $part_no) {
            $base_part_no = $part_no;
        }

        foreach ($structure_parts_array as $part_no => $part_def_obj) {
            //p($part_no);p($base_part_no);p($part_def_obj);
            // check if we are at root of tree
            if (null === $recurse_part_no) {
                ++$part_no;
            } else {
                $part_no = ($base_part_no).'.'.($recurse_part_no++);
            }

            // start with part as number 1 - will this always work?
            // get just one part as a string, it's probably encoded
            $part_string = imap_fetchbody($this->peek_parent->resource, $this->Msgno, $part_no);

            // DECODE the part if it's encoded
            if (3 == $part_def_obj->encoding) { // base64
                $part_string = base64_decode($part_string);
            } elseif (4 == $part_def_obj->encoding) { // quoted printable
                $part_string = quoted_printable_decode($part_string);
            }
            // If binary or 8bit - we don't need to decode

            // attachments, multipart types are 1-9
            $sub_type = strtoupper($part_def_obj->subtype);

            // type 0 is text
            // handle everything else or XML files (which are type 0, but subtype XML)
            if ($part_def_obj->type || 'XML' == $sub_type) {
                // first try dparameter value for the filename
                // get an attachment, set filename to dparameter value
                $filename = '';
                if ($part_def_obj->ifdparameters && count($part_def_obj->dparameters)) {
                    foreach ($part_def_obj->dparameters as $dp) {
                        $attr = strtoupper($dp->attribute);
                        if (('NAME' == $attr) or ('FILENAME' == $attr)) {
                            //p('dparams');p($dp);
                            $filename = $dp->value;

                            break;
                        }
                    }
                }

                // if no filename yet, try the parameter value, maybe it's there
                if ('' == $filename) {
                    if ($part_def_obj->ifparameters && count($part_def_obj->parameters)) {
                        foreach ($part_def_obj->parameters as $p) {
                            $attr = strtoupper($p->attribute);
                            if (('NAME' == $attr) or ('FILENAME' == $attr)) {
                                $filename = $p->value;

                                break;
                            }
                        }
                    }
                }

                // store the part_def_obj id value
                // is used as the "cid" for inline attachment display
                $cid = (isset($part_def_obj->id)) ? $part_def_obj->id : '';
                //trim the tag chars to prepare it for storage
                $cid = trim($cid, '<>');

                // still no filename, last attempt
                // check the cid, otherwise make up a filename
                // and give it an extension from the subtype
                if ('' == $filename) {
                    if ('' == $cid) {
                        // changed to uppercase above
                        if ('DELIVERY-STATUS' === $sub_type) {
                            // handle the DSN message see RFC 1894 for details
                            $filename = 'Delivery-Status-Notification.txt';
                        } else {
                            //$filename = 'no_filename_probably_RELATED_or_ALTERNATIVE_part_node'.'.'.$sub_type;
                            $filename = '';
                        }
                        $part_string = '';
                    } else {
                        $filename = $cid.'.'.$sub_type;
                    }
                }

                // don't rely on ifdisposition, check it here
                $disposition = (isset($part_def_obj->disposition)) ? $part_def_obj->disposition : '';
                $bytes = (isset($part_def_obj->bytes)) ? $part_def_obj->bytes : '';

                // this is a little heavy handed
                // is there a better design for this?
                $assoc_array = ['filename' => $filename,
                    'string' => $part_string,
                    'encoding' => $part_def_obj->encoding,
                    'part_no' => $part_no,
                    'cid' => $cid,
                    'disposition' => $disposition,
                    'bytes' => $bytes,
                    'type' => $part_def_obj->type,
                    'subtype' => $sub_type, ];
                // only create the object if
                // there is a filename
                if ('' !== $filename) {
                    $this->parts_array[] = new peeker_file($assoc_array);
                }
            }

            // detect text file and HTML attachments
            // type 0, disposition ATTACHMENT
            // if text file has no extension
            // it is reported as type application, subtype OCTET-STREAM
            // NOTE: text files with improper extension are not handled here!
            // they are handled above and saved with their filename
            elseif ($part_def_obj->ifdisposition and 'ATTACHMENT' == strtoupper($part_def_obj->disposition)) {
                // the filename is assumed to be in the first array item value
                // this may be incorrect
                $filename = $part_def_obj->dparameters[0]->value;

                // fill in the parts array, this is a bit redundant
                // with the code a few lines above that fills in same info
                $assoc_array = ['filename' => $filename,
                    'string' => $part_string,
                    'encoding' => $part_def_obj->encoding,
                    'part_no' => $part_no,
                    'disposition' => $part_def_obj->disposition,
                    'type' => $part_def_obj->type,
                    'subtype' => $sub_type, ];

                $this->parts_array[$part_no] = new peeker_file($assoc_array);
            }

            // Text or HTML email INLINE (not ATTACHMENT), type is 0
            else {
                // creates an instance var for $this->HTML or $this->PLAIN
                // NOTE: only works for the last part or sub-part extracted
                // but, are there ever more than two parts sent in type == 0?
                // yes, sometimes attachments break up the plain parts
                //
                // do not fill the parts_array with this multipart email
                // because it maps directly to the more accessible PLAIN and HTML
                // properties in the body class
                // reconstruct the text by concatenating it
                if ('PLAIN' === $sub_type) {
                    $this->PLAIN .= $part_string;
                }

                if ('HTML' === $sub_type) {
                    $this->HTML .= $part_string;
                }
            }

            // if there are subparts call this function recursively
            // adding the dot and number to traverse the object
            if (isset($part_def_obj->parts) && count($part_def_obj->parts)) {
                // start at sub index 1 for the next lower level on the tree
                $this->extract_parts($part_def_obj->parts, $part_no, 1);
            }
        }
        // store the count, helps determine if we have an attachment
        $this->parts_count = count($this->parts_array);

        return true;
    }

    /**
     * access the count.
     */
    public function get_parts_count()
    {
        return $this->parts_count;
    }

    /**
     * access the array.
     */
    public function get_parts_array()
    {
        return $this->parts_array;
    }

    // ------- detectors - return boolean ------- //
    /**
     * returns true if the message has
     * at least one attachment
     * looks at the parts_array to determine.
     */
    public function has_attachment()
    {
        return (bool) $this->parts_count;
    }

    /**
     * returns true if the message has
     * at least one attachment of dispostion
     * looks at the parts_array to determine.
     *
     * @param mixed $disp
     */
    public function has_at_least_one_attachment_with_disposition($disp)
    {
        if ($this->has_attachment()) {
            foreach ($this->parts_array as $p) {
                if ($p->get_disposition() === $disp) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * the 'moblog' detector
     * returns true if the message has one file
     * attached or inline - only one file of subtype
     * looks at the parts_array to determine
     * subtype uses shortest indicator eg. jpg not jpeg.
     *
     * @param mixed $subtype
     */
    public function has_at_least_one_attachment($subtype)
    {
        if ($this->has_attachment()) {
            foreach ($this->parts_array as $p) {
                if ($p->get_subtype() === $subtype) {
                    return true;
                }
            }
        }

        return false;
    }

    //---------- callbacks ---------//

    //---------TRANSFORM DATA---------//

    /**
     * rewrites the specified string with new appended text.
     *
     * @param mixed $str
     */
    public function insert_HTML($str): void
    {
        // going to have to fix some broken HTML here
        // to be able to insert the HTML where we want to
        // have to get_html_filtered() because other
        // filtering operations could be going on
        $html_f = $this->get_html_filtered();
        // make sure there are body tags around the HTML
        // before trying to replace them
        if (!str_contains('</body>', $html_f)) {
            $this->HTML_rewritten = $html_f.$str;
        } else {
            $this->HTML_rewritten = str_replace('</body>', $str.'</body>', $html_f);
        }
        //pe($this->HTML_rewritten);
    }

    /**
     * rewrites the specified string with new appended text.
     *
     * @param mixed $str
     */
    public function insert_PLAIN($str): void
    {
        $this->PLAIN_rewritten = $this->PLAIN.$str;
        //pe($this->PLAIN_rewritten);
    }

    /**
     * rewrites the HTML string in the body HTML property
     * to point to imgs via img src URL rather than cid:.
     *
     * @param mixed $base_url
     */
    public function rewrite_html_transform_img_tags($base_url = ''): void
    {
        $cid_array = [];
        $file_path_array = [];
        foreach ($this->parts_array as $file) {
            // if we don't have an inline image, skip
            if (('INLINE' !== $file->get_disposition()) or (5 != $file->get_type())) {
                continue;
            }
            // add in the other text that surround the inline tag
            $cid_string = 'cid:'.$file->get_cid();
            $fn = $file->get_filename();
            // make a better filename for URL - could just encode it here
            $file_name = preg_replace('/[^a-z0-9_\-\.]/i', '_', $fn);
            // construct the path
            // gather together into arrays so we can do one str_replace
            $cid_array[] = $cid_string;
            $file_path_array[] = $base_url.$this->fingerprint.DIRECTORY_SEPARATOR.$file_name;
        }

        $this->HTML_rewritten = str_replace($cid_array, $file_path_array, $this->get_html_filtered());
        //p($this->HTML_rewritten);
    }

    //---------RENDER to BROWSER---------//

    /**
     * send one raw jpeg image to the browser
     * with its own header, only send the first one.
     */
    public function render_first_jpeg(): void
    {
        foreach ($this->parts_array as $p) {
            $sub_t = strtolower($p->subtype);
            if ('jpg' == $sub_t || 'jpeg' == $sub_t) {
                header('Content-Type: image/jpeg;');
                echo $p['string'];
                // only send out the first one
                exit();
            }
        }
    }

    //---------SAVE to FILE SYSTEM---------//
    // 20090415 - these could be broken out
    // alongside the functions to prepare the data
    // for table insertion. so, file writing and db
    // calls can be packaged out nicely
    // TODO: 20110809 break these out into layer?
    // maybe peeker_file_methods.php?

    /**
     * save the header string.
     *
     * @param mixed $file_name
     */
    public function save_header_string($file_name = 'header_string.txt'): void
    {
        // if there is no immediate dir, make one from the fingerprint
        $dir = $this->_make_dir($this->peek_parent->attachment_dir.$this->get_fingerprint());
        $fn = $dir.$file_name;
        $this->_save_file($fn, $this->header_string);
    }

    /**
     * save the body string.
     *
     * @param mixed $file_name
     */
    public function save_body_string($file_name = 'body_string.txt'): void
    {
        // if there is no immediate dir, make one from the fingerprint
        $dir = $this->_make_dir($this->peek_parent->attachment_dir.$this->get_fingerprint());
        $fn = $dir.$file_name;
        $this->_save_file($fn, $this->body_string);
    }

    /**
     * save the PLAIN part.
     *
     * @param mixed $file_name
     */
    public function save_PLAIN($file_name = 'PLAIN.txt'): void
    {
        // if there is no immediate dir, make one from the fingerprint
        $dir = $this->_make_dir($this->peek_parent->attachment_dir.$this->get_fingerprint());
        $fn = $dir.$file_name;
        $this->_save_file($fn, $this->PLAIN);
    }

    /**
     * save the HTML part.
     *
     * @param mixed $file_name
     */
    public function save_HTML($file_name = 'HTML.html'): void
    {
        // if there is no immediate dir, make one from the fingerprint
        $dir = $this->_make_dir($this->peek_parent->attachment_dir.$this->get_fingerprint());
        $fn = $dir.$file_name;
        $this->_save_file($fn, $this->HTML);
    }

    /**
     * save all real parts to files on the filesystem
     * iterate the parts_array ignoring the junk
     * $dir should end in slash.
     *
     * @param null|mixed $dir
     */
    public function save_all_attachments($dir = null)
    {
        // if there is no immediate dir, make one from the fingerprint
        if (null === $dir) {
            // make sure we have someplace to write the files first
            if ($att_dir = $this->peek_parent->get_attachment_dir()) {
                $dir = $this->_make_dir($att_dir.$this->get_fingerprint());
            } else {
                $this->log_state('attachment_dir not set yet: '.$filename.' not written to disk.');

                return false;
            }
        } else {
            $dir = $this->_make_dir($dir);
        }

        // define the pattern that is going to make a nice filename
        $pattern_for_filename = '/[^a-z0-9_\-\.]/i';
        // Save file attachments to disk
        foreach ($this->parts_array as $attach) {
            // don't bother saving the 'node' MIME parts
            // there may be other parts that need to be listed here
            if ('ALTERNATIVE' === $attach->get_subtype()
                or 'RELATED' === $attach->get_subtype()) {
                continue;
            }
            // at this point should mainly be dealing with
            // image or text or HTML files
            // make sure the filename is not MIME encoded
            $a_f = $this->peek_parent->decode_mime($attach->filename);
            //if ($a_f === '') continue;
            $a_f = preg_replace($pattern_for_filename, '_', $a_f);
            $local_rewrtten_filepath = $dir.$a_f;
            // add this rewritten filename to the list
            $this->local_file_name_array[] = $local_rewrtten_filepath;

            $this->log_state('Saving attachment to file: '.$local_rewrtten_filepath);
            $this->_save_file($local_rewrtten_filepath, $attach->get_string());
        }
        $this->local_file_name_count = count($this->local_file_name_array);

        return true;
    }

    /**
     * from php.net comments on unlink() function
     * recursive in case there are directories
     * uses array_map and glob
     * added 20110809.
     *
     * @param null|mixed $path
     */
    public function delete_all_attachments($path = null)
    {
        $path = (null === $path) ? $this->peek_parent->get_attachment_dir().$this->get_fingerprint() : $path;

        if (is_file($path)) {
            @unlink($path);
        } else {
            // target this object's method to make a recursive function
            // using array_map()
            // glob does not find any dot dirs . or ..
            // nor does it find 'hidden' files starting with .
            array_map([&$this, 'delete_all_attachments'], glob($path.DIRECTORY_SEPARATOR.'*'));
            @rmdir($path);
        }

        return true;
    }

    /**
     * returns the array of file names written
     * by the save_all_attachments() function
     * the filenames have been changed from the original
     * to allow them to live comfortably on a generic filesystem
     * use get_parts_array() method to get original filenames.
     */
    public function get_local_file_name_array()
    {
        return $this->local_file_name_array;
    }

    //-------- file utilities ---------//
    /**
     * if it doesn't exist already
     * create a writeable directory
     * where we can store stuff.
     *
     * @param mixed $potential_name
     */
    public function _make_dir($potential_name = '')
    {
        if (!is_dir($potential_name)) {
            mkdir($potential_name, 0o777);
        }

        return rtrim($potential_name, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
    }

    /**
     * Save messages on local disc, potential
     * name and file lock collision here.
     *
     * @param mixed $filename
     * @param mixed $data
     */
    public function _save_file($filename, $data): void
    {
        $fp = fopen($filename, 'w+');
        $wrote = fwrite($fp, $data);
        fclose($fp);
    }
}

//EOF
