<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MY_Zip extends CI_Zip
{
    public function read_dir($path, $preserve_filepath = true, $root_path = null, $ignore = [])
    {
        if (!$fp = @opendir($path)) {
            return false;
        }

        // Set the original directory root for child dir's to use as relative
        if (null === $root_path) {
            $root_path = dirname($path).'/';
        }

        while (false !== ($file = readdir($fp))) {
            if ('.' == substr($file, 0, 1) || in_array($path.$file, $ignore)) {
                continue;
            }

            if (@is_dir($path.$file)) {
                $this->read_dir($path.$file.'/', $preserve_filepath, $root_path, $ignore);
            } else {
                if (false !== ($data = file_get_contents($path.$file))) {
                    $name = str_replace('\\', '/', $path);

                    if (false === $preserve_filepath) {
                        $name = str_replace($root_path, '', $name);
                    }

                    $this->add_data($name.$file, $data);
                }
            }
        }

        return true;
    }
}

// End of file MY_Zip.php
// Location: ./application/libraries/MY_Zip.php
