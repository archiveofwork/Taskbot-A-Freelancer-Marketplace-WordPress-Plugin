<?php if (!defined('FW')) die('Forbidden');
/**
 * @var string $uri Demo directory url
 */

$manifest                           = array();
$manifest['title']                  = esc_html__('Default', 'taskbot');
$manifest['screenshot']             = TASKBOT_DIRECTORY_URI. '/demo-content/images/default.jpg';
$manifest['preview_link']           = 'https://wp-guppy.com/taskbot/';
$manifest['id']                     = 'taskbot';
$manifest['supported_extensions']   = array(
                                            'backups' => array()
                                        );