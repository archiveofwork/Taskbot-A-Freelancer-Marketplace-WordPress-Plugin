<?php
/**
 * Menu
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard/menus
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/ 
?>
<nav class="tb-navbar navbar-expand-lg">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#tenavbar" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation','taskbot');?>">
        <i class="tb-icon-menu"></i>
    </button>
    <div id="tenavbar" class="collapse navbar-collapse">
        <?php TaskbotHeader::taskbot_prepare_navigation('primary-menu', '', 'navbar-nav tb-navbarnav', '0'); ?>
    </div>
</nav>