<?php

/**
 * Schema custom post type.
 *
 * Lets users create custom JSON-LD schema objects from the dashboard and assign
 * them to the front page, any post, any page, or any record of a custom post
 * type. The stored JSON is output in the document head on the matching page as
 * an application/ld+json script.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register the Schema custom post type.
 */
add_action( 'init', function () {

    register_post_type( 'schema', array(
        'labels' => array(
            'name'                  => 'Schema',
            'singular_name'         => 'Schema',
            'add_new'               => 'Add New Schema',
            'add_new_item'          => 'Add New Schema',
            'edit_item'             => 'Edit Schema',
            'new_item'              => 'New Schema',
            'all_items'             => 'All Schema',
            'view_item'             => 'View Schema',
            'search_items'          => 'Search Schema',
            'not_found'             => 'No schema found',
            'not_found_in_trash'    => 'No schema found in Trash',
            'menu_name'             => 'Schema',
        ),
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'capability_type'     => 'post',
        'supports'            => array( 'title' ),
        'menu_icon'           => 'dashicons-editor-code',
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
    ) );

} );

/**
 * Register the meta box for target + schema JSON.
 */
add_action( 'add_meta_boxes', function () {

    add_meta_box(
        'schema_settings',
        'Schema Settings',
        'schema_render_meta_box',
        'schema',
        'normal',
        'high'
    );

} );

/**
 * Render the meta box fields.
 *
 * @param WP_Post $post
 */
function schema_render_meta_box( $post ) {

    wp_nonce_field( 'schema_save_meta', 'schema_meta_nonce' );

    $post_type = get_post_meta( $post->ID, '_schema_post_type', true );
    $post_id   = get_post_meta( $post->ID, '_schema_post_id', true );
    $json      = get_post_meta( $post->ID, '_schema_json', true );

    if ( '' === $post_type ) {
        $post_type = 'page';
    }

    $ajax_nonce = wp_create_nonce( 'schema_get_posts' );

    $post_types = get_post_types( array( 'public' => true ), 'objects' );
    unset( $post_types['attachment'] );
    ?>

    <div style="display: flex; gap: 1rem;">
        <p style="flex: 1; width: 50%; padding: .5rem 1rem; border: 1px solid #dee2e6; background: #fdfbfb; border-radius: .5rem;">
            <label for="schema_post_type"><strong>Post type</strong></label><br>
            <select name="schema_post_type" id="schema_post_type" style="width:100%;">
                <option value="front" <?php selected( $post_type, 'front' ); ?>>Front Page / Home Page</option>
                <?php foreach ( $post_types as $key => $obj ) : ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $post_type, $key ); ?>>
                        <?php echo esc_html( $obj->label ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br><small>Choose the type of content this schema applies to.</small>
        </p>

        <p style="flex: 1; width: 50%; padding: .5rem 1rem; border: 1px solid #dee2e6; background: #fdfbfb; border-radius: .5rem;">
            <label for="schema_post_id"><strong>Target record</strong></label><br>
            <select name="schema_post_id" id="schema_post_id" style="width:100%;"></select>
            <br><small id="schema_post_id_hint">Pick the specific page, post or custom post type record.</small>
        </p>
    </div>

    <p>
        <label for="schema_json"><strong>Schema object (JSON-LD)</strong></label><br>
        <textarea name="schema_json" id="schema_json" rows="20" style="width:100%;font-family:monospace;"><?php echo esc_textarea( $json ); ?></textarea>
        <br><small>Paste a valid JSON-LD object. Example: <code>{ "@context": "https://schema.org", "@graph": [ ... ] }</code></small>
    </p>

    <script type="text/javascript">
        jQuery( function ( $ ) {
            var ajaxNonce = <?php echo wp_json_encode( $ajax_nonce ); ?>;
            var currentId = <?php echo wp_json_encode( (string) $post_id ); ?>;

            function loadRecords( type, selected ) {
                var $select = $( '#schema_post_id' );
                if ( 'front' === type ) {
                    $select.html( '<option value="front">Front Page</option>' ).prop( 'disabled', true ).val( 'front' );
                    return;
                }
                $select.prop( 'disabled', false ).html( '<option>Loading…</option>' );
                $.post( ajaxurl, {
                    action: 'schema_get_posts',
                    nonce: ajaxNonce,
                    post_type: type
                }, function ( resp ) {
                    var opts = '';
                    $.each( resp, function ( i, v ) {
                        opts += '<option value="' + v.id + '">' + v.title + '</option>';
                    });
                    var $s = $select.html( opts );
                    if ( selected ) {
                        $s.val( selected );
                    }
                } );
            }

            loadRecords( $( '#schema_post_type' ).val(), currentId );

            $( '#schema_post_type' ).on( 'change', function () {
                loadRecords( $( this ).val(), '' );
            } );
        } );
    </script>
    <?php
}

/**
 * AJAX handler to return records for a given post type.
 */
add_action( 'wp_ajax_schema_get_posts', function () {

    check_ajax_referer( 'schema_get_posts', 'nonce' );

    $post_type = isset( $_POST['post_type'] ) ? sanitize_text_field( wp_unslash( $_POST['post_type'] ) ) : '';

    if ( ! $post_type || ! post_type_exists( $post_type ) ) {
        wp_send_json_error( 'Invalid post type' );
    }

    $records = get_posts( array(
        'post_type'      => $post_type,
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
        'no_found_rows'  => true,
    ) );

    $out = array();
    foreach ( $records as $record ) {
        $out[] = array(
            'id'    => (string) $record->ID,
            'title' => $record->post_title ? $record->post_title : '(no title #' . $record->ID . ')',
        );
    }

    wp_send_json( $out );
} );

/**
 * Save the meta box data.
 *
 * @param int $post_id
 */
add_action( 'save_post_schema', function ( $post_id ) {

    if ( ! isset( $_POST['schema_meta_nonce'] ) || ! wp_verify_nonce( $_POST['schema_meta_nonce'], 'schema_save_meta' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['schema_post_type'] ) ) {
        update_post_meta( $post_id, '_schema_post_type', sanitize_text_field( wp_unslash( $_POST['schema_post_type'] ) ) );
    }

    if ( isset( $_POST['schema_post_id'] ) ) {
        update_post_meta( $post_id, '_schema_post_id', sanitize_text_field( wp_unslash( $_POST['schema_post_id'] ) ) );
    }

    if ( isset( $_POST['schema_json'] ) ) {
        update_post_meta( $post_id, '_schema_json', wp_unslash( $_POST['schema_json'] ) );
    }
} );

/**
 * Output the matching schema(s) in the document head.
 */
add_action( 'wp_head', function () {

    $schemas = get_posts( array(
        'post_type'      => 'schema',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'no_found_rows'  => true,
    ) );

    if ( empty( $schemas ) ) {
        return;
    }

    $current_id = is_singular() ? (int) get_the_ID() : 0;

    foreach ( $schemas as $schema ) {

        $post_type = get_post_meta( $schema->ID, '_schema_post_type', true );
        $post_id   = get_post_meta( $schema->ID, '_schema_post_id', true );
        $json      = get_post_meta( $schema->ID, '_schema_json', true );

        if ( empty( $json ) ) {
            continue;
        }

        $matched = false;

        if ( 'front' === $post_type && is_front_page() ) {
            $matched = true;
        } elseif ( 'front' !== $post_type && is_singular() && (int) $post_id === $current_id ) {
            $matched = true;
        }

        if ( ! $matched ) {
            continue;
        }

        $decoded = json_decode( $json, true );

        if ( null === $decoded && JSON_ERROR_NONE !== json_last_error() ) {
            continue;
        }

        echo "\n<script type=\"application/ld+json\">\n" . wp_json_encode( $decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "\n</script>\n";
    }

}, 100 );

/**
 * Disable Rank Math's native JSON-LD output on records that have a custom
 * schema, to avoid duplicate structured data.
 */
add_filter( 'rank_math/json_ld', function ( $data, $jsonld ) {

    if ( ! is_singular() && ! is_front_page() ) {
        return $data;
    }

    $current_id = is_singular() ? (int) get_the_ID() : 0;

    $schemas = get_posts( array(
        'post_type'      => 'schema',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'no_found_rows'  => true,
        'fields'         => 'ids',
    ) );

    foreach ( $schemas as $schema_id ) {
        $post_type = get_post_meta( $schema_id, '_schema_post_type', true );
        $post_id   = get_post_meta( $schema_id, '_schema_post_id', true );

        if ( 'front' === $post_type && is_front_page() ) {
            return array();
        }

        if ( 'front' !== $post_type && is_singular() && (int) $post_id === $current_id ) {
            return array();
        }
    }

    return $data;

}, 99, 2 );
