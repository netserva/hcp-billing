<?php
 
 
function ausValidateIntegerValue($number, $min_value=1, $max_value=999999999)
    {
    $result=false;

    if (!is_float($number) && filter_var($number, FILTER_VALIDATE_INT, array("options"=>array("min_range"=>$min_value, "max_range"=>$max_value)))!==false) //don't allow numbers like 1.0 to bypass validation
        {
            $result = true;
        }

    return $result;
    }

 
function ausCustomPost($url, $post_info="", $refer="")
    {
    $user_agent="hostingbilling cURL";
    $connect_timeout=AUS_CONNECTION_TIMEOUT;
    $server_response_array=array();
    $formatted_headers_array=array();

    if (filter_var($url, FILTER_VALIDATE_URL) && !empty($post_info))
        {
        if (empty($refer) || !filter_var($refer, FILTER_VALIDATE_URL))  
            {
                $refer = $url;
            }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connect_timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $connect_timeout);
        curl_setopt($ch, CURLOPT_REFERER, $refer);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_info);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_HEADERFUNCTION,
            function($curl, $header) use (&$formatted_headers_array)
                {
                $len=strlen($header);
                $header=explode(":", $header, 2);
                if (count($header)<2)  
                return $len;

                $name=strtolower(trim($header[0]));
                $formatted_headers_array[$name]=trim($header[1]);

                return $len;
                }
            );

        $result=curl_exec($ch);
        $curl_error=curl_error($ch); 
        curl_close($ch);

        $server_response_array['headers']=$formatted_headers_array;
        $server_response_array['error']=$curl_error;
        $server_response_array['body']=$result;
        }

    return $server_response_array;
    }

 
function ausGetRawDomain($url)
    {
    $raw_domain="";

    if (!empty($url))
        {
        $url_array=parse_url($url);
        if (empty($url_array['scheme']))  
            {
            $url="http://".$url;
            $url_array=parse_url($url);
            }

        if (!empty($url_array['host']))
            {
            $raw_domain=$url_array['host'];

            $raw_domain=trim(str_ireplace("www.", "", filter_var($raw_domain, FILTER_SANITIZE_URL)));
            }
        }

    return $raw_domain;
    }


 
function ausGenerateScriptSignature()
    {
    $script_signature="";
    $root_ips_array=gethostbynamel(ausGetRawDomain(AUS_ROOT_URL));

    if (!empty($root_ips_array))  
        {
        $script_signature=hash("sha256", gmdate("Y-m-d").AUS_PRODUCT_ID.AUS_PRODUCT_KEY.implode("", $root_ips_array));
        }

    return $script_signature;
    }


 
function ausVerifyServerSignature($notification_server_signature)
    {
    $result=false;
    $root_ips_array=gethostbynamel(ausGetRawDomain(AUS_ROOT_URL));

    if (!empty($notification_server_signature) && !empty($root_ips_array) && hash("sha256", implode("", $root_ips_array).AUS_PRODUCT_KEY.AUS_PRODUCT_ID.gmdate("Y-m-d"))==$notification_server_signature) //server signature valid
        {
        $result=true;
        }

    return $result;
    }


 
function ausCheckSettings()
    {
    $notifications_array=array();

    if (!filter_var(AUS_ROOT_URL, FILTER_VALIDATE_URL) || !ctype_alnum(substr(AUS_ROOT_URL, -1)))  
        {
        $notifications_array[]=AUS_CORE_NOTIFICATION_INVALID_ROOT_URL;
        }

    if (!ausValidateIntegerValue(AUS_PRODUCT_ID))  
        {
        $notifications_array[]=AUS_CORE_NOTIFICATION_INVALID_PRODUCT_ID;
        }

    if (empty(AUS_PRODUCT_KEY) || AUS_PRODUCT_KEY=="some_random_key")  
        {
        $notifications_array[]=AUS_CORE_NOTIFICATION_INVALID_PRODUCT_KEY;
        }

    if (!@is_writable(AUS_DIRECTORY))  
        {
        $notifications_array[]=APL_CORE_NOTIFICATION_INVALID_PERMISSIONS;
        }

    return $notifications_array;
    }


 
function ausGetVersion($version_number="")
    {
    $notifications_array=array();
    $aus_core_notifications=ausCheckSettings();  

    if (empty($aus_core_notifications))  
        {
        $post_info="product_id=".rawurlencode(AUS_PRODUCT_ID)."&product_key=".rawurlencode(AUS_PRODUCT_KEY)."&version_number=".rawurlencode($version_number)."&user_local_path=".rawurlencode(dirname(AUS_DIRECTORY))."&script_signature=".rawurlencode(ausGenerateScriptSignature());

        $content_array=ausCustomPost(AUS_ROOT_URL."/aus_callbacks/version_info.php", $post_info);
 
        if (!empty($content_array['headers']['notification_server_signature'])) 
            { 
            $notifications_array['notification_case']=$content_array['headers']['notification_case'];
            $notifications_array['notification_text']=$content_array['headers']['notification_text'];
            if (!empty($content_array['headers']['notification_data']))  
                {
                $notifications_array['notification_data']=json_decode($content_array['headers']['notification_data'], true);
                }
            }
        else  
            {
            $notifications_array['notification_case']="notification_no_connection";
            $notifications_array['notification_text']=AUS_NOTIFICATION_NO_CONNECTION;
            }
        }
    else  
        {
        $notifications_array['notification_case']="notification_script_corrupted";
        $notifications_array['notification_text']=implode("; ", $aus_core_notifications);
        }

    return $notifications_array;
    }


 
function ausGetAllVersions()
    {
    $notifications_array=array();
    $aus_core_notifications=ausCheckSettings(); 

    if (empty($aus_core_notifications))  
        {
        $post_info="product_id=".rawurlencode(AUS_PRODUCT_ID)."&product_key=".rawurlencode(AUS_PRODUCT_KEY)."&user_local_path=".rawurlencode(dirname(AUS_DIRECTORY))."&script_signature=".rawurlencode(ausGenerateScriptSignature());

        $content_array=ausCustomPost(AUS_ROOT_URL."/aus_callbacks/get_all_updates.php", $post_info);
        
 
        if (!empty($content_array['headers']['notification_server_signature']))
            {
            $notifications_array['notification_case']=$content_array['headers']['notification_case'];
            $notifications_array['notification_text']=$content_array['headers']['notification_text'];
 
            if (!empty($content_array['headers']['notification_data']))  
                {
                $notifications_array['notification_data']=json_decode($content_array['headers']['notification_data'], true);
             
                }
            }
        else  
            {
            $notifications_array['notification_case']="notification_no_connection";
            $notifications_array['notification_text']=AUS_NOTIFICATION_NO_CONNECTION;
            }
        }
    else  
        {
        $notifications_array['notification_case']="notification_script_corrupted";
        $notifications_array['notification_text']=implode("; ", $aus_core_notifications);
        }

    return $notifications_array;
    }


 
function ausDownloadFile($file_type="version_upgrade_file", $version_number="")
    { 
    $notifications_array=array();
    $aus_core_notifications=ausCheckSettings();  

    if (empty($aus_core_notifications))  
        {
        if (class_exists("ZipArchive")) 
            {
            $post_info="product_id=".rawurlencode(AUS_PRODUCT_ID)."&product_key=".rawurlencode(AUS_PRODUCT_KEY)."&version_number=".rawurlencode($version_number)."&user_local_path=".rawurlencode(dirname(AUS_DIRECTORY))."&file_type=".rawurlencode($file_type)."&script_signature=".rawurlencode(ausGenerateScriptSignature());

            $content_array=ausCustomPost(AUS_ROOT_URL."/aus_callbacks/download_update.php", $post_info);
          
            if (!empty($content_array['headers']['notification_server_signature'])) 
                {
                $notifications_array['notification_case']=$content_array['headers']['notification_case'];
                $notifications_array['notification_text']=$content_array['headers']['notification_text'];
                if (!empty($content_array['headers']['notification_data']))  
                    { 
                    $notifications_array['notification_data']=json_decode($content_array['headers']['notification_data'], true);
                    }

                if (!empty($content_array['body'])) 
                    {
                    if (!empty($content_array['headers']['content-disposition']))  
                        {
                        $zip_file_name=str_ireplace("filename=", "", stristr($content_array['headers']['content-disposition'], "filename="));
                        }

                    if (empty($zip_file_name))  
                        {
                        $zip_file_name="$file_type.zip";  
                        }

                    $script_root_directory=dirname(AUS_DIRECTORY);  
                    $zip_archive_local_destination="$script_root_directory/$zip_file_name";  

                    $zip_file=@fopen($zip_archive_local_destination, "w+");
                    $fwrite=@fwrite($zip_file, $content_array['body']); 
 
                    if (ausValidateIntegerValue($fwrite))  
                        {
                        $zip_file=new ZipArchive;
                        if ($zip_file->open("$script_root_directory/$zip_file_name")===true)  
                            {
                            $zip_file->extractTo($script_root_directory);
                            $zip_file->close();

                            if (AUS_DELETE_EXTRACTED=="YES")  
                                {
                                $removed_files_total=ausDeleteFileDirectory($script_root_directory, array($zip_file_name));
                                if (!ausValidateIntegerValue($removed_files_total))
                                    {
                                    $notifications_array['notification_case']="notification_zip_delete_failed";
                                    $notifications_array['notification_text']=AUS_NOTIFICATION_ZIP_DELETE_ERROR;
                                    }
                                }
                            }
                        else  
                            {
                            $notifications_array['notification_case']="notification_zip_extract_failed";
                            $notifications_array['notification_text']=AUS_NOTIFICATION_ZIP_EXTRACT_ERROR;
                            }
                        }
                    else  
                        {
                        $notifications_array['notification_case']="notification_zip_extract_failed";
                        $notifications_array['notification_text']=AUS_NOTIFICATION_ZIP_EXTRACT_ERROR;
                        }
                    }
                }
            else  
                {
                $notifications_array['notification_case']="notification_no_connection";
                $notifications_array['notification_text']=AUS_NOTIFICATION_NO_CONNECTION;
                }
            }
        else
            {
            $notifications_array['notification_case']="notification_ziparchive_class_missing";
            $notifications_array['notification_text']=AUS_NOTIFICATION_ZIPARCHIVE_CLASS_MISSING;
            }
        }
    else  
        {
        $notifications_array['notification_case']="notification_script_corrupted";
        $notifications_array['notification_text']=implode("; ", $aus_core_notifications);
        }

    return $notifications_array;
    }

 
function ausFetchQuery($query_type="upgrade", $version_number="")
    {
    $notifications_array=array();
    $aus_core_notifications=ausCheckSettings();  

    if (empty($aus_core_notifications))  
        {
        $post_info="product_id=".rawurlencode(AUS_PRODUCT_ID)."&product_key=".rawurlencode(AUS_PRODUCT_KEY)."&version_number=".rawurlencode($version_number)."&user_local_path=".rawurlencode(dirname(AUS_DIRECTORY))."&query_type=".rawurlencode($query_type)."&script_signature=".rawurlencode(ausGenerateScriptSignature());

        $content_array=ausCustomPost(AUS_ROOT_URL."/aus_callbacks/get_query.php", $post_info);
        if (!empty($content_array['headers']['notification_server_signature'])) 
            {
            $notifications_array['notification_case']=$content_array['headers']['notification_case'];
            $notifications_array['notification_text']=$content_array['headers']['notification_text'];
            $notifications_array['notification_data']=json_decode($content_array['body'], true);
            }
        else  
            {
            $notifications_array['notification_case']="notification_no_connection";
            $notifications_array['notification_text']=AUS_NOTIFICATION_NO_CONNECTION;
            }
        }
    else  
        {
        $notifications_array['notification_case']="notification_script_corrupted";
        $notifications_array['notification_text']=implode("; ", $aus_core_notifications);
        }

    return $notifications_array;
    }

 
  function ausDeleteFileDirectory($root_directory, $files_array=array())
    {
    $removed_records=0;

    if (!empty($root_directory) && is_dir($root_directory))  
        {
        if (empty($files_array))  
            {
            $files_array=scandir($root_directory);
            }

        $files_array=array_filter($files_array);  
        $files_array=array_diff($files_array, array(".", "..", "")); 
        $files_array=array_values($files_array); 

        if (!empty($files_array))  
            {
            foreach ($files_array as $file)
                {
                if (is_file("$root_directory/$file") && unlink("$root_directory/$file"))  
                    {
                    $removed_records++;
                    }

                if (is_dir("$root_directory/$file"))  
                    {
                    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator("$root_directory/$file", FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $path)
                        {
                        $path->isDir() && !$path->isLink() ? rmdir($path->getPathname()) : unlink($path->getPathname());
                        }

                    if (rmdir("$root_directory/$file"))
                        {
                        $removed_records++;
                        }
                    }
                }
            }
        }

    return $removed_records;
    }