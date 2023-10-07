<?php

namespace thickboxmodel;

// die if accessed directly
if (!defined('ABSPATH')) {
    die('no kiddies please!');
}

/**
 * 
 * Class 'Taskbot_Admin_Metabox_Thickbox_Modal' defines the custom post type Buyers
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/metabox
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */

if (!class_exists('Taskbot_Admin_Metabox_Thickbox_Modal')) {

    class Taskbot_Admin_Metabox_Thickbox_Modal {

        /**
         * @access  public
         * @Init Hooks in Constructor
        */
        public function __construct() {

            add_action('admin_footer', array(&$this, 'taskbot_prepare_profile_popup'));
        }

        /**
         * Thickbox popup
         * @access  public
         *
        */
        public function taskbot_prepare_profile_popup() {	
            global $post;
            add_ThickBox();
            ob_start();
            ?>
            <div class="modal hidden fade taskbot-profilepopup" tabindex="-1" role="dialog" id="taskbot-thickbox-popup">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="taskbot-modalcontent modal-content">
                        <div class="modal-body" id="taskbot-profile-model"></div>
                    </div>
                </div>
            </div>
            <?php 
            echo ob_get_clean();
		}

    }

}

new Taskbot_Admin_Metabox_Thickbox_Modal();
