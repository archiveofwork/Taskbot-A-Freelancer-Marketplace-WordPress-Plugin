<?php

/**
 * Typograpy Settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/Theme_Settings/Settings
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */
Redux::setSection(
  $opt_name,
  array(
    'title'         => esc_html__('Colors settings', 'taskbot'),
    'id'            => 'styling_settings',
    'subsection'    => false,
    'icon'          => 'el el-globe',
    'fields'        => array(
      array(
        'id'        => 'tb_primary_color',
        'type'      => 'color',
        'title'     => esc_html__('Primary color', 'taskbot'),
        'subtitle'  => esc_html__('Add primary color', 'taskbot'),
        'default'   => '#fdd943',
      ),
      array(
        'id'        => 'tb_secondary_color',
        'type'      => 'color',
        'title'     => esc_html__('Secondary color', 'taskbot'),
        'subtitle'  => esc_html__('Select secondary color', 'taskbot'),
        'default'   => '#0A0F26',
      ),
      array(
        'id'        => 'tb_tertiary_color',
        'type'      => 'color',
        'title'     => esc_html__('Font color', 'taskbot'),
        'subtitle'  => esc_html__('Select font color', 'taskbot'),
        'default'   => '#1C1C1C',
      ),
      array(
        'id'        => 'tb_link_color',
        'type'      => 'color',
        'title'     => esc_html__('Hyper Link color', 'taskbot'),
        'subtitle'  => esc_html__('Select link color', 'taskbot'),
        'default'   => '#1DA1F2',
      ),
      array(
        'id'        => 'tb_button_color',
        'type'      => 'color',
        'title'     => esc_html__('Button text color', 'taskbot'),
        'subtitle'  => esc_html__('Select button text color', 'taskbot'),
        'default'   => '#1C1C1C',
      ),
    )
  )
);
