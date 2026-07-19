<?php
/*
 * This is the child theme for Pharmacy Mentor theme, generated with Generate Child Theme plugin by catchthemes.
 *
 * (Please see https://developer.wordpress.org/themes/advanced-topics/child-themes/#how-to-create-a-child-theme)
 */

define( 'CHILD_THEME_DIR', get_stylesheet_directory() );

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
 * Our Clinics — Custom Post Type, ACF Fields, AJAX Search
 */

// 1. Register Clinic CPT
add_action( 'init', 'pmc_register_clinic_cpt' );
function pmc_register_clinic_cpt() {
    $labels = [
        'name'                  => __( 'Our Clinics', 'pharmacy-mentor-child' ),
        'singular_name'         => __( 'Clinic', 'pharmacy-mentor-child' ),
        'add_new'               => __( 'Add New', 'pharmacy-mentor-child' ),
        'add_new_item'          => __( 'Add New Clinic', 'pharmacy-mentor-child' ),
        'edit_item'             => __( 'Edit Clinic', 'pharmacy-mentor-child' ),
        'new_item'              => __( 'New Clinic', 'pharmacy-mentor-child' ),
        'view_item'             => __( 'View Clinic', 'pharmacy-mentor-child' ),
        'search_items'          => __( 'Search Clinics', 'pharmacy-mentor-child' ),
        'not_found'             => __( 'No clinics found', 'pharmacy-mentor-child' ),
        'not_found_in_trash'    => __( 'No clinics found in Trash', 'pharmacy-mentor-child' ),
        'menu_name'             => __( 'Our Clinics', 'pharmacy-mentor-child' ),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => [ 'slug' => 'clinic' ],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_icon'          => 'dashicons-plus-alt',
        'supports'           => [ 'title', 'editor', 'thumbnail' ],
        'show_in_rest'       => true,
        'rest_base'          => 'clinics',
    ];

    register_post_type( 'clinic', $args );
}

// 2. Register ACF fields for Clinic
add_action( 'acf/init', 'pmc_register_clinic_acf_fields' );
function pmc_register_clinic_acf_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( [
        'key'      => 'group_clinic_details',
        'title'    => 'Clinic Details',
        'fields'   => [
            [
                'key'          => 'field_clinic_address',
                'label'        => 'Address',
                'name'         => 'clinic_address',
                'type'         => 'textarea',
                'rows'         => 2,
                'required'     => 1,
            ],
            [
                'key'          => 'field_clinic_postcode',
                'label'        => 'Postcode',
                'name'         => 'clinic_postcode',
                'type'         => 'text',
                'required'     => 1,
            ],
            [
                'key'          => 'field_clinic_phone',
                'label'        => 'Phone',
                'name'         => 'clinic_phone',
                'type'         => 'text',
            ],
            [
                'key'          => 'field_clinic_latitude',
                'label'        => 'Latitude',
                'name'         => 'clinic_latitude',
                'type'         => 'number',
                'instructions'  => 'e.g. 51.5074',
            ],
            [
                'key'          => 'field_clinic_longitude',
                'label'        => 'Longitude',
                'name'         => 'clinic_longitude',
                'type'         => 'number',
                'instructions'  => 'e.g. -0.1278',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'clinic',
                ],
            ],
        ],
    ] );
}

// 3. AJAX handler — search clinics
add_action( 'wp_ajax_search_clinics', 'pmc_ajax_search_clinics' );
add_action( 'wp_ajax_nopriv_search_clinics', 'pmc_ajax_search_clinics' );
function pmc_ajax_search_clinics() {
    if ( ! wp_verify_nonce( $_POST['nonce'] ?? '', 'clinic_search_nonce' ) ) {
        wp_send_json_error( 'Invalid nonce' );
    }

    $search = isset( $_POST['search'] ) ? sanitize_text_field( $_POST['search'] ) : '';

    $args = [
        'post_type'      => 'clinic',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
    ];

    if ( '' !== $search ) {
        $args['s'] = $search;
        add_filter( 'posts_join', 'pmc_clinic_search_join' );
        add_filter( 'posts_where', 'pmc_clinic_search_where' );
    }

    $query   = new WP_Query( $args );

    if ( '' !== $search ) {
        remove_filter( 'posts_join', 'pmc_clinic_search_join' );
        remove_filter( 'posts_where', 'pmc_clinic_search_where' );
    }

    $clinics = [];

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $lat = get_field( 'clinic_latitude' );
            $lng = get_field( 'clinic_longitude' );
            $clinics[] = [
                'id'        => get_the_ID(),
                'title'     => get_the_title(),
                'link'      => get_permalink(),
                'address'   => get_field( 'clinic_address' ),
                'postcode'  => get_field( 'clinic_postcode' ),
                'phone'     => get_field( 'clinic_phone' ),
                'content'   => wp_strip_all_tags( get_the_content() ),
                'latitude'  => $lat ? (float) $lat : null,
                'longitude' => $lng ? (float) $lng : null,
                'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ),
            ];
            unset( $lat, $lng );
        }
        wp_reset_postdata();
    }

    wp_send_json( $clinics );
}

function pmc_clinic_search_join( $join ) {
    global $wpdb;
    if ( strpos( $join, 'pmc_pm' ) === false ) {
        $join .= " LEFT JOIN {$wpdb->postmeta} pmc_pm ON {$wpdb->posts}.ID = pmc_pm.post_id AND pmc_pm.meta_key = 'clinic_postcode' ";
    }
    return $join;
}

function pmc_clinic_search_where( $where ) {
    global $wpdb;
    $search = sanitize_text_field( $_POST['search'] ?? '' );
    if ( $search ) {
        $where .= $wpdb->prepare( ' OR pmc_pm.meta_value LIKE %s', '%' . $wpdb->esc_like( $search ) . '%' );
    }
    return $where;
}

// 4. Enqueue assets on Our Clinic pages
add_action( 'wp_enqueue_scripts', 'pmc_enqueue_clinic_assets' );
function pmc_enqueue_clinic_assets() {
    $is_listing = is_page_template( 'page-templates/our-clinic.php' );
    $is_single  = is_singular( 'clinic' );

    if ( ! $is_listing && ! $is_single ) {
        return;
    }

    $api_key = get_option( 'hp_gmaps_api_key' );
    if ( ! $api_key ) {
        $api_key = defined( 'PMC_GOOGLE_MAPS_API_KEY' ) ? PMC_GOOGLE_MAPS_API_KEY : '';
    }

    if ( $is_listing ) {
        wp_enqueue_style( 'clinic-style', get_stylesheet_directory_uri() . '/assets/css/our-clinic.css', [], '1.0' );

        wp_enqueue_script(
            'clinic-js',
            get_stylesheet_directory_uri() . '/assets/js/our-clinic.js',
            [ 'jquery' ],
            '1.0',
            true
        );

        wp_localize_script( 'clinic-js', 'pmcClinicVars', [
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'clinic_search_nonce' ),
            'apiKey'  => $api_key ?: '',
        ] );

        // Pass initial clinic data to JS
        $query   = new WP_Query( [
            'post_type'      => 'clinic',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'title',
            'order'          => 'ASC',
        ] );
        $clinics = [];
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $lat = get_field( 'clinic_latitude' );
                $lng = get_field( 'clinic_longitude' );
                $clinics[] = [
                    'id'        => get_the_ID(),
                    'title'     => get_the_title(),
                    'link'      => get_permalink(),
                    'address'   => get_field( 'clinic_address' ),
                    'postcode'  => get_field( 'clinic_postcode' ),
                    'phone'     => get_field( 'clinic_phone' ),
                    'content'   => wp_strip_all_tags( get_the_content() ),
                    'latitude'  => $lat ? (float) $lat : null,
                    'longitude' => $lng ? (float) $lng : null,
                    'thumbnail' => get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ),
                ];
                unset( $lat, $lng );
            }
            wp_reset_postdata();
        }
        wp_localize_script( 'clinic-js', 'pmcInitialClinics', $clinics );
    }
}


add_action( 'after_setup_theme', 'pmc_child_theme_setup' );
function pmc_child_theme_setup() {
    // Add support for title tag
    add_theme_support( 'title-tag' );
}


$schema_file = CHILD_THEME_DIR . '/inc/schema.php';

if ( file_exists( $schema_file ) ) {
    require_once $schema_file;
}


/*
 * Featured Image column in admin list tables
 * Adds an "Image" column (60px) before the title for posts, pages and the Clinic CPT.
 */

// Post types that should display the Image column.
pmc_featured_image_column_post_types();

function pmc_featured_image_column_post_types() {
    return apply_filters( 'pmc_featured_image_column_post_types', [ 'post', 'page' ] );
}

// Register the column for each supported post type.
add_action( 'admin_init', 'pmc_add_featured_image_column' );
function pmc_add_featured_image_column() {
    $post_types = pmc_featured_image_column_post_types();

    foreach ( $post_types as $post_type ) {
        // Posts and pages use the generic hooks; CPTs use the {post_type} variant.
        if ( 'page' === $post_type ) {
            add_filter( 'manage_pages_columns', 'pmc_featured_image_column_head' );
            add_action( 'manage_pages_custom_column', 'pmc_featured_image_column_content', 10, 2 );
        } elseif ( 'post' === $post_type ) {
            add_filter( 'manage_posts_columns', 'pmc_featured_image_column_head' );
            add_action( 'manage_posts_custom_column', 'pmc_featured_image_column_content', 10, 2 );
        } else {
            add_filter( "manage_{$post_type}_posts_columns", 'pmc_featured_image_column_head' );
            add_action( "manage_{$post_type}_posts_custom_column", 'pmc_featured_image_column_content', 10, 2 );
        }

        // Remove core's default "Image" (thumbnail) column to avoid duplicates.
        add_filter( "manage_{$post_type}_posts_columns", 'pmc_remove_core_thumbnail_column' );
    }
}

// Strip the core-added "thumbnail" column if present.
function pmc_remove_core_thumbnail_column( $columns ) {
    unset( $columns['thumbnail'] );
    return $columns;
}

// Insert the "Image" column right before the title column.
function pmc_featured_image_column_head( $columns ) {
    $new_columns = [];

    foreach ( $columns as $key => $label ) {
        if ( 'title' === $key ) {
            $new_columns['pmc_featured_image'] = __( 'Image', 'pharmacy-mentor-child' );
        }
        $new_columns[ $key ] = $label;
    }

    // Ensure the column exists even if no title column was found.
    if ( ! isset( $new_columns['pmc_featured_image'] ) ) {
        $new_columns['pmc_featured_image'] = __( 'Image', 'pharmacy-mentor-child' );
    }

    return $new_columns;
}

// Render the featured image (or placeholder) inside a 60x60 container.
function pmc_featured_image_column_content( $column_name, $post_id ) {
    if ( 'pmc_featured_image' !== $column_name ) {
        return;
    }

    if ( has_post_thumbnail( $post_id ) ) {
        $image = get_the_post_thumbnail(
            $post_id,
            [ 50, 50 ],
            [ 'style' => 'width:50px;height:50px;object-fit:cover;' ]
        );
        echo $image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    } else {
        echo '<span aria-hidden="true" class="empty-image">—</span>';
    }
}

// Enqueue the admin stylesheet for the featured image column.
add_action( 'admin_enqueue_scripts', 'pmc_featured_image_column_admin_styles' );
function pmc_featured_image_column_admin_styles() {
    wp_enqueue_style(
        'pmc-featured-image-column',
        get_stylesheet_directory_uri() . '/assets/css/admin.css',
        [],
        wp_get_theme()->get( 'Version' )
    );
}

