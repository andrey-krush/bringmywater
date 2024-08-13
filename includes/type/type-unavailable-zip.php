<?php

class Type_Unavailable_Zip {

    public static function init_auto() : void {

        add_action('init', [__CLASS__, 'registerPostType']);
    }

    public static function registerPostType() : void {

        register_post_type( 'unavailable_zip', [
            'label'  => null,
            'labels' => [
                'name'               => 'Unavailable Zips',
                'singular_name'      => 'Unavailable Zip',
                'add_new'            => 'Add new Unavailable Zip',
                'add_new_item'       => 'Adding new Unavailable Zip',
                'edit_item'          => 'Edit Unavailable Zip',
                'new_item'           => 'New Unavailable Zip',
                'view_item'          => 'View Unavailable Zip',
                'search_items'       => 'Find Unavailable Zip',
                'not_found'          => 'Not found',
                'not_found_in_trash' => 'Not found in trash',
                'parent_item_colon'  => '',
                'menu_name'          => 'Unavailable Zips',
            ],
            'has_archive' => false,
            'public' => true,
            'publicly_queryable' => false,
            'show_ui' => true,
            'supports' => array( 'title')
        ] );



    }

}