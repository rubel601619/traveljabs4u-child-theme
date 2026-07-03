<?php
/*
 * This is the child theme for Pharmacy Mentor theme, generated with Generate Child Theme plugin by catchthemes.
 *
 * (Please see https://developer.wordpress.org/themes/advanced-topics/child-themes/#how-to-create-a-child-theme)
 */
add_action( 'wp_enqueue_scripts', 'pharmacy_mentor_child_enqueue_styles' );
function pharmacy_mentor_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}

add_filter( 'rest_destination_query', function( $args, $request ) {
    if ( ! empty( $request['search'] ) ) {
        $args['search_columns'] = [ 'post_title' ];
    }
    return $args;
}, 10, 2 );
/*
 * Your code goes below
 */