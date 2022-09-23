<?php

namespace EventManagementSystem\App\Hooks\Handlers;

// if (!defined('ABSPATH')) {
//     exit;
// }

/**
 * Register and initialize custom post type for plugin_name
 * @since 1.0.0
 */

class EmsCustomPost
{
    // public function __construct()
    // {
    //     add_action('init', array($this, 'register'));
    // }
    public function registerPostType()
    {
        $args = array(
            'capability_type' => 'post',
            'public'          => false,
            'show_ui'         => false,
        );
        register_post_type('ems_event_data', $args);

        register_taxonomy('eventCategory', array('ems_event_data'), array(
            'hierarchical' => true,
            'show_ui' => false,
        ));

        register_taxonomy('eventOrganizer', array('ems_event_data'), array(
            'hierarchical' => true,
            'show_ui' => false,

        ));
    }
}
