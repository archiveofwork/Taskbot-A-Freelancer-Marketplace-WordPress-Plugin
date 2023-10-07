<?php
ini_set('display_errors', 'On');
require TASKBOT_DIRECTORY.'libraries/vendor/autoload.php';
use Dompdf\Dompdf;

if (!class_exists('TaskbotPDFHelper')) {
    /**
     * Render Videoask Iframe
     * 
     * @package Taskbot
     */
    class TaskbotPDFHelper
    {
        public function TaskbotBuyerServicePDF($order_id = '',$user_id='',$type='') {
            $json = array();
            if(!empty($order_id)) {
                
                $dompdf             = new Dompdf();
                $args               = array();
                $args['identity']   = $user_id;
                $args['order_id']   = $order_id;
                ob_start();
                ?>
                  <html>
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <title><?php echo esc_html_e('Invoice','taskbot');?></title>
                        <style>
                            , ::after, *::before {
                                margin: 0px;
                                padding: 0px;
                                box-sizing: border-box;
                            }
                        </style>
                    </head>
                    <body>
            <?php
                if( !empty($type) && $type === 'sellers' ){
                    taskbot_get_template_part('dashboard/dashboard', 'seller-invoice-detail',$args);
                } else if( !empty($type) && $type === 'buyers' ){
                    taskbot_get_template_part('dashboard/dashboard', 'invoice-detail',$args);
                }
                $output_html    = ob_get_clean();
                $output_html    = $output_html.'</body></html>';
                $dompdf->loadHtml($output_html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();

                $upload             = wp_upload_dir();
                $upload_dir         = $upload['basedir'];
                $upload_rel_dir     = $upload['baseurl'] . '/invoices/';
                $upload_dir         = $upload_dir . '/invoices/';


                //create directory if not exists
                if (!is_dir($upload_dir)) {
                    wp_mkdir_p($upload_dir);
                }

                $filename  = rand(100,2500).$order_id.date('Y-m-d-H-i-s').'.pdf';
                $file_name = $upload_dir.$filename;

                ob_end_flush();

                $pdf_gen = $dompdf->output();

                if (!file_put_contents($file_name, $pdf_gen)) {
                    return true;
                } else {
                    
                    return $filename;
                }        
            }
        }
    }
}