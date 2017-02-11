<?php

class WPURP_Import_Yummly extends WPURP_Premium_Addon {

    public function __construct( $name = 'import-yummly' ) {
        parent::__construct( $name );

        // Actions
        add_action( 'admin_init', array( $this, 'assets' ) );
        add_action( 'admin_menu', array( $this, 'import_menu' ) );
        add_action( 'admin_menu', array( $this, 'import_manual_menu' ) );
    }

    public function assets() {
        WPUltimateRecipe::get()->helper( 'assets' )->add(
            array(
                'file' => $this->addonPath . '/css/import_yummly.css',
                'premium' => true,
                'admin' => true,
                'page' => 'recipe_page_wpurp_import_yummly',
            )
        );
    }

    public function import_menu() {
        add_submenu_page( null, __( 'Import Yummly', 'wp-ultimate-recipe' ), __( 'Import Yummly', 'wp-ultimate-recipe' ), 'manage_options', 'wpurp_import_yummly', array( $this, 'import_page' ) );
    }

    public function import_page() {
        if ( !current_user_can('manage_options') ) {
            wp_die( 'You do not have sufficient permissions to access this page.' );
        }

        require( $this->addonDir. '/templates/before_importing.php' );
    }

    public function import_manual_menu() {
        add_submenu_page( null, __( 'Import Yummly', 'wp-ultimate-recipe' ), __( 'Import Yummly', 'wp-ultimate-recipe' ), 'manage_options', 'wpurp_import_yummly_manual', array( $this, 'import_manual_page' ) );
    }

    public function import_manual_page() {
        if ( !wp_verify_nonce( $_POST['import_yummly_manual'], 'import_yummly_manual' ) ) {
            die( 'Invalid nonce.' );
        }

        // Actually import recipe
        if( isset( $_POST['import_yummly_id'] ) && isset( $_POST['import_post_id'] )) {

            $post_id = intval( $_POST['import_post_id'] );
            $yummly_id = intval( $_POST['import_yummly_id'] );

            $this->import_yummly_recipe( $post_id, $yummly_id );
        }

        $this->custom_fields();
        require( $this->addonDir. '/templates/manual_import.php' );
    }

    private function import_yummly_recipe( $post_id, $yummly_id )
    {
        $yummly = $this->yummly_get_recipe( $yummly_id );

        // Recipe image
        $recipe_image_url = $yummly->recipe_image;

        if( $recipe_image_url ) {
            $recipe_image_id = $this->get_or_upload_attachment( $post_id, $recipe_image_url );

            if( $recipe_image_id ) {
                set_post_thumbnail( $post_id, $recipe_image_id );
            }
        }


        // Ingredient groups
        $yummly_ingredients = explode( "\n", $yummly->ingredients );

        $ingredient_groups = array();
        $group = '';
        foreach( $yummly_ingredients as $item ) {
            if( preg_match( "/^%(\S*)/", $item, $matches ) ) {
                // Ignore images
            } else if( preg_match( "/^!(.*)/", $item, $matches ) ) {
                // The next ingredients belong to this group
                $group = $matches[1];
            } else {
                // Ingredient line that belongs to this group
                $ingredient_groups[] = $group;
            }
        }

        // Ingredients
        $ingredients = $_POST['recipe_ingredients'];
        $new_ingredients = array();
        $ingredient_terms = array();

        if( $ingredients )
        {
            $i = 0;
            foreach( $ingredients as $ingredient )
            {
                if( trim( $ingredient['ingredient'] ) !== '' )
                {
                    $term = term_exists( $ingredient['ingredient'], 'ingredient' );

                    if ( $term === 0 || $term === null ) {
                        $term = wp_insert_term( $ingredient['ingredient'], 'ingredient' );
                    }

                    $ingredient['amount_normalized'] = WPUltimateRecipe::get()->helper( 'recipe_save' )->normalize_amount( $ingredient['amount'] );

                    if( !is_wp_error( $term ) )
                    {
                        $term_id = intval( $term['term_id'] );

                        $ingredient['ingredient_id'] = $term_id;
                        $ingredient['group'] = $ingredient_groups[$i];
                        $i++;

                        $new_ingredients[] = $ingredient;
                        $ingredient_terms[] = $term_id;
                    }
                }
            }
            wp_set_post_terms( $post_id, $ingredient_terms, 'ingredient' );
        }
        update_post_meta( $post_id, 'recipe_ingredients', $new_ingredients );

        // Instructions
        $yummly_instructions = explode("\n", $yummly->instructions);

        $instructions = array();
        $index = 0;
        $group = '';
        $image = '';
        foreach( $yummly_instructions as $item ) {
            if( strlen( $item ) > 1 ) {
                if( preg_match( "/^%(\S*)/", $item, $matches ) ) {

                    $image_id = $this->get_or_upload_attachment( $post_id, $matches[1] );

                    if( $image_id ) {
                        if( $index == 0 ) {
                            $image = strval( $image_id );
                        } else {
                            if( $instructions[$index-1]['image'] == '' ) {
                                $instructions[$index-1]['image'] = strval( $image_id );
                            } else {
                                // Previous instruction already has an image, so add a new step
                                $instructions[] = array(
                                    'description' => '',
                                    'group' => $group,
                                    'image' => strval( $image_id ),
                                );
                                $index++;
                            }
                        }
                    }
                } else if( preg_match( "/^!(.*)/", $item, $matches ) ) {
                    // The next instructions belong to this group
                    $group = $matches[1];
                } else {
                    $description = $this->yummly_richify( $item );

                    $instructions[] = array(
                        'description' => $description,
                        'group' => $group,
                        'image' => $image,
                    );
                    $image = '';
                    $index++;
                }
            }
        }
        update_post_meta( $post_id, 'recipe_instructions', $instructions );


        // Servings
        $yummly_servings = $yummly->serving_size;

        $match = preg_match( "/^\s*\d+/", $yummly_servings, $servings_array );
        if( $match === 1 ) {
            $servings = str_replace( ' ','', $servings_array[0] );
        } else {
            $servings = '';
        }

        $servings_type = preg_replace( "/^\s*\d+\s*/", "", $yummly_servings );

        update_post_meta( $post_id, 'recipe_servings', $servings );
        update_post_meta( $post_id, 'recipe_servings_type', $servings_type );

        $normalized_servings = WPUltimateRecipe::get()->helper( 'recipe_save' )->normalize_servings( $servings );
        update_post_meta( $post_id, 'recipe_servings_normalized', $normalized_servings );


        // Cooking Times
        $prep_time = $this->yummly_time_to_minutes( $yummly->prep_time );
        $cook_time = $this->yummly_time_to_minutes( $yummly->cook_time );
        $total_time = $this->yummly_time_to_minutes( $yummly->total_time );

        if( $prep_time != 0 ) {
            update_post_meta( $post_id, 'recipe_prep_time', $prep_time );
            update_post_meta( $post_id, 'recipe_prep_time_text', __( 'minutes', 'wp-ultimate-recipe' ) );
        }

        if( $cook_time != 0 ) {
            update_post_meta( $post_id, 'recipe_cook_time', $cook_time );
            update_post_meta( $post_id, 'recipe_cook_time_text', __( 'minutes', 'wp-ultimate-recipe' ) );
        }

        if( $total_time != 0 ) {
            $passive_time = $total_time - ( $prep_time + $cook_time );

            if( $passive_time > 0 ) {
                update_post_meta( $post_id, 'recipe_passive_time', $passive_time );
                update_post_meta( $post_id, 'recipe_passive_time_text', __( 'minutes', 'wp-ultimate-recipe' ) );
            }
        }


        // Nutritional information
        $fat = floatval( $yummly->fat ) > 0 ? strval( floatval( $yummly->fat ) ) : '';
        $calories = floatval( $yummly->calories ) > 0 ? strval( floatval( $yummly->calories ) ) : '';

        $nutritional = array(
            'fat' => $fat,
            'calories' => $calories,
        );

        add_post_meta( $post_id, 'recipe_nutritional', $nutritional );


        // Other metadata
        update_post_meta( $post_id, 'recipe_title', $yummly->recipe_title );
        update_post_meta( $post_id, 'recipe_description', $this->yummly_richify( $yummly->summary ) );
        update_post_meta( $post_id, 'recipe_rating', $this->yummly_richify( $yummly->rating ) );
        update_post_meta( $post_id, 'recipe_notes', $this->yummly_richify( $yummly->notes ) );
        update_post_meta( $post_id, 'yummly_yield', $yummly->yield );

        // Backup to remember which yummly recipe this originated from
        update_post_meta( $post_id, 'recipe_yummly_id', $yummly_id );


        // Switch post type to recipe
        set_post_type( $post_id, 'recipe' );

        // Add [recipe] shortcode instead of yummly one
        $post = get_post( $post_id );

        $update_content = array(
            'ID' => $post_id,
            'post_content' => $this->yummly_replace_shortcode( $post->post_content, '[recipe]' ),
        );
        wp_update_post( $update_content );

        // Update recipe terms
        WPUltimateRecipe::get()->helper( 'recipe_save' )->update_recipe_terms( $post_id );
    }

    private function get_yummly_recipes()
    {
        $import_yummly = array(
            'total' => 0,
            'import' => array(

            ),
            'problem' => array(

            ),
        );

        // Loop through all posts
        $limit = 100;
        $offset = 0;
        $total = 0;

        while(true) {
            $args = array(
                'post_type' => array( 'post', 'page'),
                'post_status' => 'any',
                'orderby' => 'ID',
                'order' => WPUltimateRecipe::option( 'import_recipes_order', 'ASC' ),
                'posts_per_page' => $limit,
                'offset' => $offset,
            );

            $query = new WP_Query( $args );

            if ( !$query->have_posts() ) break;

            $posts = $query->posts;

            foreach( $posts as $post ) {
                $recipes = $this->yummly_get_recipes_from_content( $post->post_content );

                if( count( $recipes ) == 1 && $post->post_type == 'post' ) {
                    $total++;
                    $import_yummly['import'][$post->ID] = $recipes[0];
                } else if( count( $recipes ) != 0 ) {
                    $import_yummly['problem'][$post->ID] = $recipes;
                }

                wp_cache_delete( $post->ID, 'posts' );
                wp_cache_delete( $post->ID, 'post_meta' );
            }

            $offset += $limit;
            wp_cache_flush();
        }

        $import_yummly['total'] = $total;

        return $import_yummly;
    }

    private function custom_fields()
    {
        $key = 'yummly_yield';
        $name = __( 'Yield', 'wp-ultimate-recipe' );

        $custom_fields = WPUltimateRecipe::addon( 'custom-fields' )->get_custom_fields();

        if( !array_key_exists( $key, $custom_fields ) ) {
            $custom_fields[$key] = array(
                'key' => $key,
                'name' => $name,
            );

            WPUltimateRecipe::addon( 'custom-fields' )->update_custom_fields( $custom_fields );
        }
    }

    function get_or_upload_attachment( $post_id, $url ) {
        $image_id = $this->get_attachment_id_from_url( $url );

        if( $image_id ) {
            return $image_id;
        } else {
            $media = media_sideload_image( $url, $post_id );

            $attachments = get_posts( array(
                    'numberposts' => '1',
                    'post_parent' => $post_id,
                    'post_type' => 'attachment',
                    'post_mime_type' => 'image',
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                )
            );

            if( sizeof( $attachments ) > 0 ) {
                return $attachments[0]->ID;
            }
        }

        return null;
    }

    /*
     * Source: https://philipnewcomer.net/2012/11/get-the-attachment-id-from-an-image-url-in-wordpress/
     */
    function get_attachment_id_from_url( $attachment_url = '' ) {

        global $wpdb;
        $attachment_id = false;

        // If there is no url, return.
        if ( '' == $attachment_url )
            return;

        // Get the upload directory paths
        $upload_dir_paths = wp_upload_dir();

        // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
        if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

            // If this is the URL of an auto-generated thumbnail, get the URL of the original image
            $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

            // Remove the upload path base directory from the attachment URL
            $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

            // Finally, run a custom database query to get the attachment ID from the modified attachment URL
            $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

        }

        return $attachment_id;
    }

    /*
     * Helper functions from Yummly plugin itself
     */

    private function yummly_get_recipes_from_content( $post_text )
    {
        $recipes = array();
        $needle_old = 'id="amd-yrecipe-recipe-';
        $preg_needle_old = '/(id)=("(amd-yrecipe-recipe-)[0-9^"]*")/i';
        $needle = '[amd-yrecipe-recipe:';
        $preg_needle = '/\[amd-yrecipe-recipe:([0-9]+)\]/i';

        if( strpos( $post_text, $needle_old ) !== false ) {
            preg_match_all( $preg_needle_old, $post_text, $matches );
            foreach ( $matches[0] as $match ) {
                $recipe_id = str_replace( 'id="amd-yrecipe-recipe-', '', $match );
                $recipe_id = str_replace( '"', '', $recipe_id );
                if( !in_array( $recipe_id, $recipes ) ) {
                    $recipes[] = intval( $recipe_id );
                }
            }
        }

        if( strpos( $post_text, $needle ) !== false ) {
            preg_match_all( $preg_needle, $post_text, $matches );
            foreach( $matches[0] as $match ) {
                $recipe_id = str_replace( '[amd-yrecipe-recipe:', '', $match );
                $recipe_id = str_replace( ']', '', $recipe_id );
                if( !in_array( $recipe_id, $recipes ) ) {
                    $recipes[] = intval( $recipe_id );
                }
            }
        }

        return $recipes;
    }

    private function yummly_replace_shortcode( $post_text, $replacement )
    {
        $output = $post_text;

        $needle_old = 'id="amd-yrecipe-recipe-';
        $preg_needle_old = '/(id)=("(amd-yrecipe-recipe-)[0-9^"]*")/i';
        $needle = '[amd-yrecipe-recipe:';
        $preg_needle = '/\[amd-yrecipe-recipe:([0-9]+)\]/i';

        if( strpos( $post_text, $needle_old ) !== false ) {
            preg_match_all( $preg_needle_old, $post_text, $matches );
            foreach( $matches[0] as $match ) {
                $recipe_id = str_replace( 'id="amd-yrecipe-recipe-', '', $match );
                $recipe_id = str_replace( '"', '', $recipe_id );
                $output = preg_replace( "/<img id=\"amd-yrecipe-recipe-".$recipe_id."\" class=\"amd-yrecipe-recipe\" src=\"[^\"]*\" alt=\"\" \/>/", $replacement, $output );
            }
        }

        if( strpos( $post_text, $needle ) !== false ) {
            preg_match_all( $preg_needle, $post_text, $matches );
            foreach ( $matches[0] as $match ) {
                $recipe_id = str_replace( '[amd-yrecipe-recipe:', '', $match );
                $recipe_id = str_replace( ']', '', $recipe_id );
                $output = str_replace( '[amd-yrecipe-recipe:' . $recipe_id . ']', $replacement, $output );
            }
        }

        return $output;
    }

    private function yummly_get_recipe( $recipe_id )
    {
        global $wpdb;

        $recipe = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "amd_yrecipe_recipes WHERE recipe_id=" . $recipe_id);

        return $recipe;
    }

    private function yummly_richify( $input )
    {
        $output = $this->yummly_bold( $input, '<strong>', '</strong>' );
        $output = $this->yummly_italic( $output, '<em>', '</em>' );
        $output = $this->yummly_link( $output, false );

        return $output;
    }

    private function yummly_derichify( $input )
    {
        $output = $this->yummly_bold( $input );
        $output = $this->yummly_italic( $output );
        $output = $this->yummly_link( $output );

        return $output;
    }

    private function yummly_bold( $input, $before = '', $after = '' )
    {
        return preg_replace( '/(^|\s)\*([^\s\*][^\*]*[^\s\*]|[^\s\*])\*(\W|$)/', '\\1'.$before.'\\2'.$after.'\\3', $input );
    }

    private function yummly_italic( $input, $before = '', $after = '' )
    {
        return preg_replace( '/(^|\s)_([^\s_][^_]*[^\s_]|[^\s_])_(\W|$)/', '\\1'.$before.'\\2'.$after.'\\3', $input );
    }

    private function yummly_link( $input, $remove = true )
    {
        if( $remove ) {
            $output = preg_replace( '/\[([^\]\|\[]*)\|([^\]\|\[]*)\]/', '\\1', $input );
        } else {
            $output = preg_replace( '/\[([^\]\|\[]*)\|([^\]\|\[]*)\]/', '<a href="\\2" target="_blank">\\1</a>', $input );
        }
        return $output;
    }

    private function yummly_time_to_minutes( $duration = 'PT' )
    {
        $date_abbr = array(
            'd' => 60*24,
            'h' => 60,
            'i' => 1
        );
        $result = 0;

        $arr = explode( 'T', $duration );
        if( isset( $arr[1] ) ) {
            $arr[1] = str_replace( 'M', 'I', $arr[1] );
        }
        $duration = implode( 'T', $arr );

        foreach( $date_abbr as $abbr => $time ) {
            if( preg_match( '/(\d+)' . $abbr . '/i', $duration, $val ) ) {
                $result += intval( $val[1] ) * $time;
            }
        }

        return $result;
    }
}

WPUltimateRecipe::loaded_addon( 'import-yummly', new WPURP_Import_Yummly() );