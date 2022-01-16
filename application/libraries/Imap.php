<?php

declare(strict_types=1);

/**
 * Helper class for imap access.
 *
 * @copyright  Copyright (c) Tobias Zeising (http://www.aditu.de)
 * @license    GPLv3 (http://www.gnu.org/licenses/gpl-3.0.html)
 * @author     Tobias Zeising <tobias.zeising@aditu.de>
 */
class Imap
{
    /**
     * imap connection.
     */
    private $imap = false;

    /**
     * mailbox url string.
     */
    private $mailbox = '';

    /**
     * currentfolder.
     */
    private $folder = 'Inbox';

    /**
     * initialize imap helper.
     *
     * @param $mailbox imap_open string
     * @param $username
     * @param $password
     * @param $encryption ssl or tls
     */
    public function __construct($mailbox, $username, $password, $encryption = false)
    {
        $enc = '';
        if (null != $encryption && isset($encryption) && 'ssl' == $encryption) {
            $enc = '/imap/ssl/novalidate-cert';
        } elseif (null != $encryption && isset($encryption) && 'tls' == $encryption) {
            $enc = '/imap/tls/novalidate-cert';
        }
        $this->mailbox = '{'.$mailbox.$enc.'}';
        $this->imap = @imap_open($this->mailbox, $username, $password);
    }

    /**
     * close connection.
     */
    public function __destruct()
    {
        if (false !== $this->imap) {
            imap_close($this->imap);
        }
    }

    /**
     * returns true after successfull connection.
     *
     * @return bool true on success
     */
    public function isConnected()
    {
        return false !== $this->imap;
    }

    /**
     * returns last imap error.
     *
     * @return string error message
     */
    public function getError()
    {
        return imap_last_error();
    }

    /**
     * select given folder.
     *
     * @param $folder name
     *
     * @return bool successfull opened folder
     */
    public function selectFolder($folder)
    {
        $result = imap_reopen($this->imap, $this->mailbox.$folder);
        if (true === $result) {
            $this->folder = $folder;
        }

        return $result;
    }

    /**
     * returns all available folders.
     *
     * @return array with foldernames
     */
    public function getFolders()
    {
        $folders = imap_list($this->imap, $this->mailbox, '*');

        return str_replace($this->mailbox, '', $folders);
    }

    /**
     * returns the number of messages in the current folder.
     *
     * @return int message count
     */
    public function countMessages()
    {
        return imap_num_msg($this->imap);
    }

    /**
     * returns the number of unread messages in the current folder.
     *
     * @return int message count
     */
    public function countUnreadMessages()
    {
        $result = imap_search($this->imap, 'UNSEEN');
        if (false === $result) {
            return 0;
        }

        return count($result);
    }

    /**
     * returns unseen emails in the current folder.
     *
     * @param $withbody without body
     *
     * @return array messages
     */
    public function getUnreadMessages($withbody = true)
    {
        $emails = [];
        $result = imap_search($this->imap, 'UNSEEN');
        if ($result) {
            foreach ($result as $k => $i) {
                $emails[] = $this->formatMessage($i, $withbody);
            }
        }

        return $emails;
    }

    /**
     * returns all emails in the current folder.
     *
     * @param $withbody without body
     *
     * @return array messages
     */
    public function getMessages($withbody = true)
    {
        $count = $this->countMessages();
        $emails = [];
        for ($i = 1; $i <= $count; ++$i) {
            $emails[] = $this->formatMessage($i, $withbody);
        }

        // sort emails descending by date
        // usort($emails, function($a, $b) {
        // try {
        // $datea = new \DateTime($a['date']);
        // $dateb = new \DateTime($b['date']);
        // } catch(\Exception $e) {
        // return 0;
        // }
        // if ($datea == $dateb)
        // return 0;
        // return $datea < $dateb ? 1 : -1;
        // });

        return $emails;
    }

    /**
     * returns email by given id.
     *
     * @param $id
     * @param $withbody without body
     *
     * @return array messages
     */
    public function getMessage($id, $withbody = true)
    {
        return $this->formatMessage($id, $withbody);
    }

    /**
     * delete given message.
     *
     * @param $id of the message
     *
     * @return bool success or not
     */
    public function deleteMessage($id)
    {
        return $this->deleteMessages([$id]);
    }

    /**
     * delete messages.
     *
     * @param $ids array of ids
     *
     * @return bool success or not
     */
    public function deleteMessages($ids)
    {
        if (false == imap_mail_move($this->imap, implode(',', $ids), $this->getTrash(), CP_UID)) {
            return false;
        }

        return imap_expunge($this->imap);
    }

    /**
     * move given message in new folder.
     *
     * @param $id of the message
     * @param $target new folder
     *
     * @return bool success or not
     */
    public function moveMessage($id, $target)
    {
        return $this->moveMessages([$id], $target);
    }

    /**
     * move given message in new folder.
     *
     * @param $ids array of message ids
     * @param $target new folder
     *
     * @return bool success or not
     */
    public function moveMessages($ids, $target)
    {
        if (false === imap_mail_move($this->imap, implode(',', $ids), $target, CP_UID)) {
            return false;
        }

        return imap_expunge($this->imap);
    }

    /**
     * mark message as read.
     *
     * @param $id of the message
     * @param $seen true = message is read, false = message is unread
     *
     * @return bool success or not
     */
    public function setUnseenMessage($id, $seen = true)
    {
        $header = $this->getMessageHeader($id);
        if (false == $header) {
            return false;
        }

        $flags = '';
        $flags .= (strlen(trim($header->Answered)) > 0 ? '\\Answered ' : '');
        $flags .= (strlen(trim($header->Flagged)) > 0 ? '\\Flagged ' : '');
        $flags .= (strlen(trim($header->Deleted)) > 0 ? '\\Deleted ' : '');
        $flags .= (strlen(trim($header->Draft)) > 0 ? '\\Draft ' : '');

        $flags .= ((true == $seen) ? '\\Seen ' : ' ');
        //echo "\n<br />".$id.": ".$flags;
        imap_clearflag_full($this->imap, $id, '\\Seen', ST_UID);

        return imap_setflag_full($this->imap, $id, trim($flags), ST_UID);
    }

    /**
     * return content of messages attachment.
     *
     * @param $id of the message
     * @param $index of the attachment (default: first attachment)
     *
     * @return binary attachment
     */
    public function getAttachment($id, $index = 0)
    {
        // find message
        $attachments = false;
        $messageIndex = imap_msgno($this->imap, $id);
        $header = imap_headerinfo($this->imap, $messageIndex);
        $mailStruct = imap_fetchstructure($this->imap, $messageIndex);
        $attachments = $this->getAttachments($this->imap, $messageIndex, $mailStruct, '');

        if (false == $attachments) {
            return false;
        }

        // find attachment
        if ($index > count($attachments)) {
            return false;
        }
        $attachment = $attachments[$index];

        // get attachment body
        $partStruct = imap_bodystruct($this->imap, imap_msgno($this->imap, $id), $attachment['partNum']);
        $filename = $partStruct->dparameters[0]->value;
        $message = imap_fetchbody($this->imap, $id, $attachment['partNum'], FT_UID);

        switch ($attachment['enc']) {
            case 0:
            case 1:
                $message = imap_8bit($message);

                break;

            case 2:
                $message = imap_binary($message);

                break;

            case 3:
                $message = imap_base64($message);

                break;

            case 4:
                $message = quoted_printable_decode($message);

                break;
        }

        return [
            'name' => $attachment['name'],
            'size' => $attachment['size'],
            'content' => $message, ];
    }

    /**
     * add new folder.
     *
     * @param $name of the folder
     *
     * @return bool success or not
     */
    public function addFolder($name)
    {
        return imap_createmailbox($this->imap, $this->mailbox.$name);
    }

    /**
     * remove folder.
     *
     * @param $name of the folder
     *
     * @return bool success or not
     */
    public function removeFolder($name)
    {
        return imap_deletemailbox($this->imap, $this->mailbox.$name);
    }

    /**
     * rename folder.
     *
     * @param $name of the folder
     * @param $newname of the folder
     *
     * @return bool success or not
     */
    public function renameFolder($name, $newname)
    {
        return imap_renamemailbox($this->imap, $this->mailbox.$name, $this->mailbox.$newname);
    }

    /**
     * clean folder content of selected folder.
     *
     * @return bool success or not
     */
    public function purge()
    {
        // delete trash and spam
        if ($this->folder == $this->getTrash() || 'spam' == strtolower($this->folder)) {
            if (false === imap_delete($this->imap, '1:*')) {
                return false;
            }

            return imap_expunge($this->imap);
            // move others to trash
        }
        if (false == imap_mail_move($this->imap, '1:*', $this->getTrash())) {
            return false;
        }

        return imap_expunge($this->imap);
    }

    /**
     * returns all email addresses.
     *
     * @return array with all email addresses or false on error
     */
    public function getAllEmailAddresses()
    {
        $saveCurrentFolder = $this->folder;
        $emails = [];
        foreach ($this->getFolders() as $folder) {
            $this->selectFolder($folder);
            foreach ($this->getMessages(false) as $message) {
                $emails[] = $message['from'];
                $emails = array_merge($emails, $message['to']);
                if (isset($message['cc'])) {
                    $emails = array_merge($emails, $message['cc']);
                }
            }
        }
        $this->selectFolder($saveCurrentFolder);

        return array_unique($emails);
    }

    /**
     * save email in sent.
     *
     * @param $header
     * @param $body
     */
    public function saveMessageInSent($header, $body)
    {
        return imap_append($this->imap, $this->mailbox.$this->getSent(), $header."\r\n".$body."\r\n", '\\Seen');
    }

    /**
     * convert to utf8 if necessary.
     *
     * @param $string utf8 encoded string
     * @param mixed $str
     *
     * @return true or false
     */
    public function convertToUtf8($str)
    {
        if ('UTF-8' != mb_detect_encoding($str, 'UTF-8, ISO-8859-1, GBK')) {
            $str = utf8_encode($str);
        }

        return iconv('UTF-8', 'UTF-8//IGNORE', $str);
    }

    /**
     * @param $id
     * @param bool $withbody
     *
     * @return array
     */
    protected function formatMessage($id, $withbody = true)
    {
        $header = imap_headerinfo($this->imap, $id);

        // fetch unique uid
        $uid = imap_uid($this->imap, $id);

        // get email data
        $subject = '';
        if (isset($header->subject) && strlen($header->subject) > 0) {
            foreach (imap_mime_header_decode($header->subject) as $obj) {
                $subject .= $obj->text;
            }
        }
        $subject = $this->convertToUtf8($subject);
        $email = [
            'to' => isset($header->to) ? $this->arrayToAddress($header->to) : '',
            'from' => $this->fromAddress($header->from[0]),
            'date' => $header->date,
            'subject' => $subject,
            'uid' => $uid,
            'unread' => strlen(trim($header->Unseen)) > 0,
            'answered' => strlen(trim($header->Answered)) > 0,
        ];
        if (isset($header->cc)) {
            $email['cc'] = $this->arrayToAddress($header->cc);
        }

        // get email body
        if (true === $withbody) {
            $body = $this->getBody($uid);
            $email['body'] = $body['body'];
            $email['html'] = $body['html'];
        }

        // get attachments
        $mailStruct = imap_fetchstructure($this->imap, $id);
        $attachments = $this->attachments2name($this->getAttachments($this->imap, $id, $mailStruct, ''));
        if (count($attachments) > 0) {
            foreach ($attachments as $val) {
                foreach ($val as $k => $t) {
                    if ('name' == $k) {
                        $decodedName = imap_mime_header_decode($t);
                        $t = $this->convertToUtf8($decodedName[0]->text);
                    }
                    $arr[$k] = $t;
                }
                $email['attachments'][] = $arr;
            }
        }

        return $email;
    }

    // private helpers

    /**
     * get trash folder name or create new trash folder.
     *
     * @return trash folder name
     */
    private function getTrash()
    {
        foreach ($this->getFolders() as $folder) {
            if ('trash' === strtolower($folder) || 'papierkorb' === strtolower($folder)) {
                return $folder;
            }
        }

        // no trash folder found? create one
        $this->addFolder('Trash');

        return 'Trash';
    }

    /**
     * get sent folder name or create new sent folder.
     *
     * @return sent folder name
     */
    private function getSent()
    {
        foreach ($this->getFolders() as $folder) {
            if ('sent' === strtolower($folder) || 'gesendet' === strtolower($folder)) {
                return $folder;
            }
        }

        // no sent folder found? create one
        $this->addFolder('Sent');

        return 'Sent';
    }

    /**
     * fetch message by id.
     *
     * @param $id of the message
     *
     * @return header
     */
    private function getMessageHeader($id)
    {
        $count = $this->countMessages();
        for ($i = 1; $i <= $count; ++$i) {
            $uid = imap_uid($this->imap, $i);
            if ($uid == $id) {
                return imap_headerinfo($this->imap, $i);
            }
        }

        return false;
    }

    /**
     * convert attachment in array(name => ..., size => ...).
     *
     * @param $attachments with name and size
     *
     * @return array
     */
    private function attachments2name($attachments)
    {
        $names = [];
        foreach ($attachments as $attachment) {
            $names[] = [
                'name' => $attachment['name'],
                'size' => $attachment['size'],
            ];
        }

        return $names;
    }

    /**
     * convert imap given address in string.
     *
     * @param $headerinfos the infos given by imap
     *
     * @return string in format "Name <email@bla.de>"
     */
    private function toAddress($headerinfos)
    {
        $email = '';
        $name = '';
        if (isset($headerinfos->mailbox, $headerinfos->host)) {
            $email = $headerinfos->mailbox.'@'.$headerinfos->host;
        }

        if (!empty($headerinfos->personal)) {
            $name = imap_mime_header_decode($headerinfos->personal);
            $name = $name[0]->text;
        } else {
            $name = $email;
        }

        $name = $this->convertToUtf8($name);

        return $name.' <'.$email.'>';
    }

    /**
     * convert imap given address in string.
     *
     * @param $headerinfos the infos given by imap
     *
     * @return string in format "Name <email@bla.de>"
     */
    private function fromAddress($headerinfos)
    {
        $email = '';
        if (isset($headerinfos->mailbox, $headerinfos->host)) {
            $email = $headerinfos->mailbox.'@'.$headerinfos->host;
        }

        return $email;
    }

    /**
     * converts imap given array of addresses in strings.
     *
     * @param $addresses imap given addresses as array
     *
     * @return array with strings (e.g. ["Name <email@bla.de>", "Name2 <email2@bla.de>"]
     */
    private function arrayToAddress($addresses)
    {
        $addressesAsString = [];
        foreach ($addresses as $address) {
            $addressesAsString[] = $this->toAddress($address);
        }

        return $addressesAsString;
    }

    /**
     * returns body of the email. First search for html version of the email, then the plain part.
     *
     * @param $uid message id
     *
     * @return string email body
     */
    private function getBody($uid)
    {
        $body = $this->get_part($this->imap, $uid, 'TEXT/HTML');
        $html = true;
        // if HTML body is empty, try getting text body
        if ('' == $body) {
            $body = $this->get_part($this->imap, $uid, 'TEXT/PLAIN');
            $html = false;
        }
        $body = $this->convertToUtf8($body);

        return ['body' => $body, 'html' => $html];
    }

    /**
     * returns a part with a given mimetype
     * taken from http://www.sitepoint.com/exploring-phps-imap-library-2/.
     *
     * @param $imap imap stream
     * @param $uid message id
     * @param $mimetype
     * @param mixed $structure
     * @param mixed $partNumber
     *
     * @return string email body
     */
    private function get_part($imap, $uid, $mimetype, $structure = false, $partNumber = false)
    {
        if (!$structure) {
            $structure = imap_fetchstructure($imap, $uid, FT_UID);
        }
        if ($structure) {
            if ($mimetype == $this->get_mime_type($structure)) {
                if (!$partNumber) {
                    $partNumber = 1;
                }
                $text = imap_fetchbody($imap, $uid, $partNumber, FT_UID | FT_PEEK);

                switch ($structure->encoding) {
                    case 3: return imap_base64($text);

                    case 4: return imap_qprint($text);

                    default: return $text;
               }
            }

            // multipart
            if (1 == $structure->type) {
                foreach ($structure->parts as $index => $subStruct) {
                    $prefix = '';
                    if ($partNumber) {
                        $prefix = $partNumber.'.';
                    }
                    $data = $this->get_part($imap, $uid, $mimetype, $subStruct, $prefix.($index + 1));
                    if ($data) {
                        return $data;
                    }
                }
            }
        }

        return false;
    }

    /**
     * extract mimetype
     * taken from http://www.sitepoint.com/exploring-phps-imap-library-2/.
     *
     * @param $structure
     *
     * @return string mimetype
     */
    private function get_mime_type($structure)
    {
        $primaryMimetype = ['TEXT', 'MULTIPART', 'MESSAGE', 'APPLICATION', 'AUDIO', 'IMAGE', 'VIDEO', 'OTHER'];

        if ($structure->subtype) {
            return $primaryMimetype[(int) $structure->type].'/'.$structure->subtype;
        }

        return 'TEXT/PLAIN';
    }

    /**
     * get attachments of given email
     * taken from http://www.sitepoint.com/exploring-phps-imap-library-2/.
     *
     * @param $imap stream
     * @param $mailNum email
     * @param $part
     * @param $partNum
     *
     * @return array of attachments
     */
    private function getAttachments($imap, $mailNum, $part, $partNum)
    {
        $attachments = [];

        if (isset($part->parts)) {
            foreach ($part->parts as $key => $subpart) {
                if ('' != $partNum) {
                    $newPartNum = $partNum.'.'.($key + 1);
                } else {
                    $newPartNum = ($key + 1);
                }
                $result = $this->getAttachments(
                    $imap,
                    $mailNum,
                    $subpart,
                    $newPartNum
                );
                if (0 != count($result)) {
                    array_push($attachments, $result);
                }
            }
        } elseif (isset($part->disposition)) {
            if ('attachment' == strtolower($part->disposition)) {
                $partStruct = imap_bodystruct(
                    $imap,
                    $mailNum,
                    $partNum
                );

                return [
                    'name' => $part->dparameters[0]->value,
                    'partNum' => $partNum,
                    'enc' => $partStruct->encoding,
                    'size' => $part->bytes,
                ];
            }
        }

        return $attachments;
    }
}
