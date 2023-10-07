<?php
/**
 *
 * Class 'Taskbot_file_permission' file upload with permissions
 *
 * @package     Taskbot
 * @subpackage  Taskbot/includes
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/
if (!class_exists('Taskbot_file_permission')){
    class Taskbot_file_permission{
  
        private static $instance = null;
        private static $encrpytion_salt  = '^^tbkey^^';
        public function __construct(){
           
        }

        /**
         * Returns the *Singleton* instance of this class.
         *
         * @return
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         */
        public static function getInstance(){
            if (self::$instance==null){
                self::$instance = new Taskbot_file_permission();
            }
            return self::$instance;
        }

        /**
         * Upload file in temp folder
         *
         * @return
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         */
        public static function uploadFile($submitted_file){
            $response   = array();
            $upload     = wp_upload_dir();
            $upload_dir = $upload['basedir'];
            $upload_dir = $upload_dir . '/taskbot-temp/';
            //check if file type is allowed
			$file_info 		= wp_check_filetype_and_ext($submitted_file['tmp_name'], $submitted_file['name'], false);
			$ext_verify 	= empty($file_info['ext']) ? '' : $file_info['ext'];
         	$type_verify 	= empty($file_info['type']) ? '' : $file_info['type'];

			 if (!$ext_verify || !$type_verify) {
				$response['message'] = esc_html__('These file types are not allowed', 'taskbot');
				$response['type']    = 'error';
				return $response;
			}

            //create directory if not exists
            if (!is_dir($upload_dir)) {
                wp_mkdir_p($upload_dir);
            }

            $name = preg_replace("/[^A-Z0-9._-]/i", "_", $submitted_file["name"]);
            $i = 0;
            $parts = pathinfo($name);
            while (file_exists($upload_dir . $name)) {
                $i++;
                $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
            }            
            //move files
            $is_moved = move_uploaded_file($submitted_file["tmp_name"], $upload_dir . '/' . $name);

            if ($is_moved) {
                $size = $submitted_file['size'];
                $file_size = size_format($size, 2);
                $response['type'] = 'success';
                $response['message'] = esc_html__('File uploaded', 'taskbot');
                $url = $upload['baseurl'] . '/taskbot-temp/' . $name;
                $response['thumbnail'] = $upload['baseurl'] . '/taskbot-temp/' . $name;
                $response['name'] = $name;
                $response['url'] = $url;
                $response['size'] = $file_size;
            } else {
                $response['message'] = esc_html__('Some errors occurred, please try again later', 'taskbot');
                $response['type'] = 'error';
            }

            return $response;
        }

        /**
         * Get encrypt file
         *
         * @return
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         */
        public static function getEncryptFile($file, $post_id, $is_upload=false, $encrypt_file=true){
            $result     = array();
            $post_type	= get_post_type($post_id);
            $i          = time();
			
            if(($post_type == 'product' || $post_type == 'jobs') && !empty($encrypt_file)) {

                $file_detail            = pathinfo($file);
                $extension 			    = $file_detail['extension'];
                $filename 			    = $file_detail['filename'];

                if($is_upload) {
                    $filename           = $file_detail['filename'].'-'.$i; 
                } 

                $reverse_file_name      = strrev($filename);
                $new_file_name          = strrev(base64_encode($reverse_file_name.self::$encrpytion_salt.$post_id));
                $new_file_name          = $new_file_name. '.' . $extension;
                $result['url']          = $file_detail['dirname'].'/'.$new_file_name;
                $result['name']         = $new_file_name;
                $result['encrypt_file']         = $encrypt_file;
                return $result;

            } else {

                $file_detail        = pathinfo($file);
                $extension 			= $file_detail['extension'];
                $filename 			= $file_detail['filename'];
                
                if($is_upload) {
                    $new_file_name 	= $filename .'-'.$i.'.' . $extension;
                } else {
                    $new_file_name 	= $filename . '.' . $extension;
                }

                $result['url']      = $file_detail['dirname'].'/'.$new_file_name;
                $result['name']     = $new_file_name;                
                $result['encrypt_file']         = $encrypt_file;
                return $result;
            }
        }

        /**
         * Get decrypt file
         *
         * @return
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
         */
        public static function getDecrpytFile($file){
            $result              = array();
            $file_detail         = pathinfo($file['url']);
            $attachment_id       = $file['attachment_id'];
            $extension 			 = $file_detail['extension'];

            if(!empty($attachment_id)) {
                //get attachment post meta
                $parent_post_id = wp_get_post_parent_id($attachment_id);
                $post_type      = get_post_type($parent_post_id);
                $is_encrypted   = get_post_meta($attachment_id, 'is_encrypted', true);
                
                if($post_type == 'product' || $post_type == 'jobs' ) {                    
                    if($is_encrypted) {
                        $file 	       = explode('^^',base64_decode(strrev($file_detail['filename'])));
                        $filename      = strrev($file[0]).'.'.$extension; 
                    } else {
                        $filename      = $file_detail['filename'].'.'.$extension; 
                    }
                } else {
                    $filename          = $file_detail['filename'].'.'.$extension;
                }

                if($is_encrypted) {
                    $file 	       = explode('^^',base64_decode(strrev($file_detail['filename'])));
                    $filename      = strrev($file[0]).'.'.$extension; 
                } else {
                    $filename      = $file_detail['filename'].'.'.$extension; 
                }
              
                $result['dirname']   = $file_detail['dirname']; 
                $result['filename']  = $filename;
            }
                      
            return $result;
            
        }
         
        /**
         * File download
         *
         * @return
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
        */
        public static function downloadFile($attachmentId){
            $post_id    = !empty($attachmentId) ? get_post_field('post_parent',$attachmentId,true) : '';
            $post_id    = !empty($post_id) ? $post_id : '';

            if(!is_user_logged_in()) {
                session_start();
                $json['type']               = 'error';
                $json['message']            = esc_html__('Oops!', 'taskbot');
                $json['message_desc']       = esc_html__('You are not allowed to download this file', 'taskbot');
                $_SESSION["redirect_url"]   = !empty($post_id) ? get_the_permalink($post_id): '';
                return $json;
            }

            $json = array();
            $attachmentId = !empty($attachmentId) ? intval($attachmentId) : '';
          
            if (!empty($attachmentId)) {
                $post_data = get_post_meta($attachmentId);
                $destinationfile = false;

                if (!empty($post_data)) {

                    $filename        = $post_data['_wp_attached_file'][0];
                    $uploadspath     = wp_upload_dir();
                    $sourcefile      = $uploadspath['basedir'].'/'.$filename;

                    if(!file_exists($sourcefile)) {
                        $json['type']         = 'error';
                        $json['message']      = esc_html__('Oops!', 'taskbot');
                        $json['message_desc'] = esc_html__('Oh no! Looks like like there were no attachments', 'taskbot');
                        return $json;
                    }

                    $param = array();
                    $param['url']               = $filename;
                    $param['attachment_id']     = $attachmentId;
                    $file_detail     = self::getDecrpytFile($param);
                    $file            = pathinfo($file_detail['filename']);
                    $newfilename     = $file['filename'].'-'.time().'.'.$file['extension'];
                    $thisdir         = "/download-temp";
                    $folderPath      = $uploadspath['basedir'].$thisdir."/"; //  directory with absolute path
                    $serverfilepath  = $uploadspath['baseurl'].$thisdir."/"; //  directory with server path
                    
                    if(!is_dir($folderPath)){
                        mkdir($folderPath, 0777, true);
                    }    

                    $destinationfile = $folderPath.$newfilename;
                    copy($sourcefile,$destinationfile);  
                    set_transient('temp_download_file_'.time(), serialize($destinationfile),5);
                    $destinationfile = $serverfilepath.$newfilename;
                
                } else {
                    $json['type'] = 'error';
                    $json['message'] = esc_html__('Oops!', 'taskbot');
                    $json['message_desc'] = esc_html__('Oh no! Looks like there were no attachments', 'taskbot');
                    return $json;
                }

                $json['type'] = 'success';
                $json['attachment'] = strrev(base64_encode($destinationfile));
                $json['message'] = esc_html__('WooHoo!', 'taskbot');
                $json['message_desc'] = esc_html__('Your download was successful', 'taskbot');
                return $json;

            } else {
                $json['type'] = 'error';
                $json['message'] = esc_html__('Oops!', 'taskbot');
                $json['message_desc'] = esc_html__('Looks like there was an error. Can you please try again?', 'taskbot');
                return $json;
            }
        }

        /**
         * Zip file download
         *
         * @return
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
        */
        public static function downloadZipFile($post_id,$type,$meta){
            $json = array();

            if(!is_user_logged_in() ) {
                $json['type']         = 'error';
                $json['message']      = esc_html__('Oops!', 'taskbot');
                $json['message_desc'] = esc_html__('You are not allowed to download this file', 'taskbot');
                return $json;
            }
			
            $post_author = get_post_field('post_author', $post_id);
            $buyer_id = get_post_meta($post_id, '_buyer_id', true);
            $user        = wp_get_current_user();
			
            if($user->ID != $post_author && $user->ID != $buyer_id  ) {
                $json['type']         = 'error';
                $json['message']      = esc_html__('Oops!', 'taskbot');
                $json['message_desc'] = esc_html__('You are not allowed to download this file', 'taskbot');
                return $json;
            }
			
            if (!empty($post_id)) {
                $post_data = get_post_meta($post_id, $meta, true);

                if (!empty($post_data)) {

                    if (!empty($type)) {
                        $attachments = $post_data[$type];
                    } else {
                        $attachments = $post_data;
                    }

                    $zip = new ZipArchive();
                    $uploadspath = wp_upload_dir();
                    $folderRalativePath = $uploadspath['baseurl'] . "/download-temp";
                    $folderAbsolutePath = $uploadspath['basedir'] . "/download-temp";
                    wp_mkdir_p($folderAbsolutePath);
                    $filename = round(microtime(true)) . '.zip';
                    $zip_name = $folderAbsolutePath . '/' . $filename;
                    $zip->open($zip_name, ZipArchive::CREATE);
                    $download_url = $folderRalativePath . '/' . $filename;
                    $param= array();

                    foreach ($attachments as $file) {
                        $response                   = wp_remote_get($file['url']);
                        $filedata                   = wp_remote_retrieve_body($response);
                        $param['url']               = $file['url'];
                        $param['attachment_id']     = $file['attachment_id'];
                        $file_detail                = self::getDecrpytFile($param);
                        $zip->addFromString($file_detail['filename'], $filedata);
                    }

                    $zip->close();
                    set_transient('temp_download_file_'.time(), serialize($download_url),5);
                } else {
                    $json['type'] = 'error';
                    $json['message'] = esc_html__('Oops!', 'taskbot');
                    $json['message_desc'] = esc_html__('Oh no! Looks like there were no attachments', 'taskbot');
                    return $json;
                }

                $json['type']           = 'success';
                $json['attachment']     = strrev(base64_encode($download_url));
                $json['message']        = esc_html__('WooHoo!', 'taskbot');
                $json['message_desc']   = esc_html__('Your download was successful', 'taskbot');
                return $json;
            } else {
                $json['type'] = 'error';
                $json['message'] = esc_html__('Oops!', 'taskbot');
                $json['message_desc'] = esc_html__('Looks like there was an error. Can you please try again?', 'taskbot');
                return $json;
            }
        }

        /**
         * Modify uploaded file
         *
         * @return
         * @throws error
         * @author Amentotech <theamentotech@gmail.com>
        */
        public static function modifyUploadedFile($attachment_id, $parent_post_id){
           
            $uploadspath      = wp_upload_dir();
            $post_data        = get_post_meta($attachment_id);
            $old_file         = $uploadspath['basedir'].'/'.$post_data['_wp_attached_file'][0];
            $file_type        = wp_check_filetype($post_data['_wp_attached_file'][0]);
            $file             = self::getEncryptFile($post_data['_wp_attached_file'][0],$parent_post_id);
            $replace_with     = $uploadspath['basedir'].'/'.$file['url'];
            $newfilename      = $file['name'];

            if(file_exists($old_file) && $file_type['ext']) {
                rename($old_file,$replace_with);
                update_post_meta($attachment_id,'_wp_attached_file',$file['url']);
                update_post_meta($attachment_id,'is_encrypted','1');
                $post_array                 = array();
                $post_array['ID']           = $attachment_id;
                $post_array['post_title']   = $newfilename;
                $post_array['post_name']    = sanitize_title_with_dashes($newfilename);
                wp_update_post($post_array);

                if(isset($post_data['_wp_old_slug'][0])){
                    update_post_meta($attachment_id,'_wp_old_slug',$post_array['post_name']);
                }
            }
            
            if(isset($post_data['_wp_attachment_metadata'][0])){
                $attachment_metadata         = unserialize($post_data['_wp_attachment_metadata'][0]);
                $attachment_metadata['file'] = $replace_with;
                $file_detail                 = pathinfo($replace_with);
                if(!empty($attachment_metadata['sizes'])){                    
                    foreach($attachment_metadata['sizes'] as $key=> &$attachment){
                        $width              = $attachment['width'];
                        $height             = $attachment['height'];
                        $replace_file       = $file_detail['filename'].'-'.$width.'x'.$height.'.'.$file_detail['extension'];
                        $replace_dir_file   = $file_detail['dirname'].'/'.$file_detail['filename'].'-'.$width.'x'.$height.'.'.$file_detail['extension'];
                        $old_file           = $uploadspath['path'].'/'.$attachment['file'];
                        
                        if(file_exists($old_file)) {
                            rename($old_file,$replace_dir_file);
                        }

                        $attachment['file'] = $replace_file;
                    }
                }
                
                update_post_meta($attachment_id,'_wp_attachment_metadata',$attachment_metadata);
            }
        }
    }
}
