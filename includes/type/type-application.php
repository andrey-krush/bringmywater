<?php

class Type_Application {

    public static function init_auto() : void {

        add_action('init', [__CLASS__, 'registerPostType']);

    }

    public static function registerPostType() : void {

        register_post_type( 'application', [
            'label'  => null,
            'labels' => [
                'name'               => 'Applications',
                'singular_name'      => 'Application',
                'add_new'            => 'Add new application',
                'add_new_item'       => 'Adding new application',
                'edit_item'          => 'Edit application',
                'new_item'           => 'New application',
                'view_item'          => 'View application',
                'search_items'       => 'Find application',
                'not_found'          => 'Not found',
                'not_found_in_trash' => 'Not found in trash',
                'parent_item_colon'  => '',
                'menu_name'          => 'Applications',
            ],
            'has_archive' => true,
            'public' => true,
            'publicly_queryable' => false,
            'show_ui' => true,
            'supports' => array( 'title')
        ] );



    }

}