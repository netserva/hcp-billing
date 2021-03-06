<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Setting extends CI_Model
{
    private static $db;

    public function __construct()
    {
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    public static function update_template($group, $data)
    {
        return self::$db->where('email_group', $group)->update('email_templates', $data);
    }

    public function save_translation($post = [])
    {
        $data = '';
        $this->load->helper('file');
        $language = $post['_language'];
        $lang = $this->db->get_where('languages', ['name' => $language])->result();
        $lang = $lang[0];
        $file = $post['_file'];
        $altpath = $post['_path'];
        if ('english' == $language) {
            $fullpath = $altpath.'english/'.$file.'_lang.php';
        } else {
            $fullpath = './application/language/'.$language.'/'.$file.'_lang.php';
        }
        $eng = $this->lang->load($file, 'english', true, true, $altpath);
        if ('english' == $language) {
            $trn = $eng;
        } else {
            $trn = $this->lang->load($file, $language, true, true);
        }
        foreach ($eng as $key => $value) {
            if (isset($post[$key])) {
                $newvalue = $post[$key];
            } elseif (isset($trn[$key])) {
                $newvalue = $trn[$key];
            } else {
                $newvalue = $value;
            }

            $nvalue = str_replace("'", "\\'", $newvalue);
            $data .= '$lang[\''.$key.'\'] = \''.$nvalue.'\';'."\r\n";
            if (isset($groups[$key])) {
                $data .= "\r\n".'// '.$groups[$key]."\r\n";
            }
        }
        $data .= "\r\n"."\r\n";
        if ('hd' == $file) {
            $data .= "if(file_exists(APPPATH.'/language/".$language."/custom_language.php')){"."\r\n";
            $data .= "\t"."include APPPATH.'/language/".$language."/custom_language.php';"."\r\n";
            $data .= '}'."\r\n"."\r\n"."\r\n";
            $data .= '/* End of file hd_lang.php */';
        } else {
            $data .= '/* End of file '.$file.'_lang.php */'."\r\n";
            $data .= '/* Location: ./application/language/'.$language.'/'.$file.'_lang.php */'."\r\n";
        }
        $data = '<?php'."\r\n".$data;
        write_file($fullpath, $data);

        if ('hd' == $file) {
            $data2 = '';
            $keys = ['invoice', 'reference_no', 'date_issued', 'due_date', 'from', 'to',
                'item_name', 'amount', 'vat', 'tax', 'price', 'discount', 'total', 'paid', 'balance_due',
                'payment_information', 'notes', 'partially_paid', 'fully_paid', 'not_paid', 'draft',
                'accepted', 'declined', 'pending', 'page', 'page_of', ];
            foreach ($keys as $key) {
                $value = $post[$key];
                $value = str_replace("'", "\\'", $value);
                $data2 .= '$l[\''.$key.'\'] = \''.$value.'\';'."\r\n";
            }
            $data2 = '<?php'."\r\n".$data2;
            write_file('./application/modules/fopdf/helpers/languages/'.$lang->code.'.inc', $data2);
        }

        return true;
    }

    public function backup_translation($language, $files)
    {
        $this->load->helper('file');
        $path = './application/language/'.$language.'/'.$language.'-backup.json';
        foreach ($files as $file => $altpath) {
            if ('english' !== $language) {
                $altpath = './application/';
            }
            $file = str_replace('_lang.php', '', $file);
            $strings[$file] = $this->lang->load($file, $language, true, true, $altpath);
        }

        return defined(JSON_UNESCAPED_UNICODE) ? write_file($path, json_encode($strings, JSON_UNESCAPED_UNICODE)) : write_file($path, json_encode($strings));
    }

    public function restore_translation($language, $files)
    {
        $this->load->helper('file');
        $json = read_file('./application/language/'.$language.'/'.$language.'-backup.json');
        $str = json_decode($json, true);

        foreach ($files as $file => $altpath) {
            $file = str_replace('_lang.php', '', $file);
            $eng = $this->lang->load($file, 'english', true, true, $altpath);
            foreach ($eng as $key => $value) {
                if (isset($str[$file][$key])) {
                    $lang[$key] = $str[$file][$key];
                } else {
                    $lang[$key] = $value;
                }
            }
            $lang['_language'] = $language;
            $lang['_file'] = $file;
            $lang['_path'] = $altpath;
            $this->save_translation($lang);
        }

        return true;
    }

    public function translation_stats($files)
    {
        $stats = [];
        $fstats = [];
        foreach (App::languages() as $lang) {
            $lang = $lang->name;
            $translated = 0;
            $total = 0;
            foreach ($files as $file => $altpath) {
                $diff = 0;
                $count = 0;
                $shortfile = str_replace('_lang.php', '', $file);
                $en = $this->lang->load($shortfile, 'english', true, true, $altpath);
                if ('english' != $lang) {
                    $tr = $this->lang->load($shortfile, $lang, true, true, './application/');

                    foreach ($en as $key => $value) {
                        $translation = $tr[$key] ?? $value;
                        if (!empty($translation) && $translation != $value) {
                            ++$diff;
                        }
                        ++$count;
                    }
                    $fstats[$shortfile] = [
                        'total' => $count,
                        'translated' => $diff,
                    ];
                } else {
                    $diff = $count = count($en);
                    $fstats[$shortfile] = [
                        'total' => count($en),
                        'translated' => $diff,
                    ];
                }
                $total += $count;
                $translated += $diff;
            }
            $stats[$lang]['total'] = $total;
            $stats[$lang]['translated'] = $translated;
            $stats[$lang]['files'] = $fstats;
        }

        return $stats;
    }

    public function add_translation($language, $files)
    {
        $this->load->helper('file');
        $lang = $this->db->get_where('locales', ['language' => str_replace('_', ' ', $language)])->result();
        $l = $lang[0];
        $slug = strtolower(str_replace(' ', '_', $language));
        $dirpath = './application/language/'.$slug;
        $icon = explode('_', $l->locale);
        if (isset($icon[1])) {
            $icon = strtolower($icon[1]);
        } else {
            $icon = strtolower($icon[0]);
        }

        if (is_dir($dirpath)) {
            return false;
        }
        mkdir($dirpath, 0o755);

        foreach ($files as $file => $path) {
            $source = $path.'english/'.$file;
            $destin = './application/language/'.$language.'/'.$file;
            $data = read_file($source);
            $data = str_replace('/english/', '/'.$language.'/', $data);
            $data = str_replace('system/language', 'application/language', $data);
            write_file($destin, $data);
        }

        $data = read_file('./application/modules/fopdf/helpers/languages/en.inc');
        write_file('./application/modules/fopdf/helpers/languages/'.$l->code.'.inc', $data);

        $insert = [
            'code' => $l->code,
            'name' => $slug,
            'icon' => $icon,
            'active' => '0',
        ];

        return $this->db->insert('languages', $insert);
    }

    public static function timezones()
    {
        $timezoneIdentifiers = DateTimeZone::listIdentifiers();
        $utcTime = new DateTime('now', new DateTimeZone('UTC'));

        $tempTimezones = [];
        foreach ($timezoneIdentifiers as $timezoneIdentifier) {
            $currentTimezone = new DateTimeZone($timezoneIdentifier);

            $tempTimezones[] = [
                'offset' => (int) $currentTimezone->getOffset($utcTime),
                'identifier' => $timezoneIdentifier,
            ];
        }

        $timezoneList = [];
        foreach ($tempTimezones as $tz) {
            $sign = ($tz['offset'] > 0) ? '+' : '-';
            $offset = gmdate('H:i', abs($tz['offset']));
            $timezoneList[$tz['identifier']] = 'UTC '.$sign.$offset.' - '.
                                $tz['identifier'];
        }

        return $timezoneList;
    }
}

// End of file model.php
