<?php
/*
Plugin Name: Nicechannels Telegram Ads Taxonomies
Plugin URI: 
Description: Enables you to display how many times a post/page had been viewed.
Version: 1.0
Author: ahmaddeveloper
Author URI: http://ahmaddeveloper.in
Text Domain: nicechannels
*/
 
 defined('ABSPATH') or die("No script kiddies please!");

// custom post telegram ads
function nicechannels_custom_post_telegram_ads() {
		$labels = array(
		'name' => __( 'Telegram Ads' , 'nicechannels'),
		'singular_name' => __( 'Telegram Ads' , 'nicechannels'),
		'add_new' =>  __( 'Add New' , 'nicechannels'),
		'add_new_item' => __( 'Add New Ads' , 'nicechannels'),
		'edit_item' => __( 'Edit Ads' , 'nicechannels'),
		'new_item' => __( 'New Item' , 'nicechannels'),
		'all_items' => __( 'All Ads' , 'nicechannels'),
		'view_item' => __( 'View Ads' , 'nicechannels'),
		'search_items' => __( 'Search Ads' , 'nicechannels'),
		'not_found' => __( 'not_found' , 'nicechannels'),
		'not_found_in_trash' => __( 'Not Found In Trash' , 'nicechannels'),
		'parent_item_colon' => '',
		'menu_name' => 'Telegram Ads'
		);
		$args = array(
		'labels' => $labels,
		'description' => 'Save Information',
		'public' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-star-empty',
		'taxonomies' => array( 'post_tag' ),
		'supports' => array( 'title', 'editor', 'thumbnail' , 'comments', 'taxonomies'),
		'has_archive' => true,
		);
		register_post_type( 'telegram_ads', $args );
	}
	add_action( 'init', 'nicechannels_custom_post_telegram_ads' );
	
	// taxonomies custom post telegram ads
	function nicechannels_taxonomies_telegram_ads() {
		$labels = array(
		'name' => __( 'Categories' , 'nicechannels'),
		'singular_name' => __( 'Categories' , 'nicechannels'),
		'search_items' => __( 'Search Categories' , 'nicechannels'),
		'all_items' => __( 'All Categories' , 'nicechannels'),
		'parent_item' => __( 'Parent Category', 'nicechannels' ),
		'parent_item_colon' => __( 'Parent Category:' , 'nicechannels'),
		'edit_item' => __( 'Edit Category' , 'nicechannels'), 
		'update_item' => __( 'Update Category', 'nicechannels' ),
		'add_new_item' => __( 'Add New Category', 'nicechannels' ),
		'new_item_name' => __( 'New Category Name', 'nicechannels' ),
		'menu_name' => __( 'Categorys', 'nicechannels' ),
		);
		$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		);
		register_taxonomy( 'telegram_ads_category', 'telegram_ads', $args );
	}
	add_action( 'init', 'nicechannels_taxonomies_telegram_ads', 0 );
	
	// add the custom columns to the telegram ads post type:
    add_filter( 'manage_telegram_ads_posts_columns', 'nicechannels_set_custom_telegram_ads_columns' );
    function nicechannels_set_custom_telegram_ads_columns($columns) {
        unset( $columns['author'] );
		$columns['paypal_transaction'] = __( 'Paypal Transaction ID', 'nicechannels' );
        $columns['featured'] = __( 'Post Featured', 'nicechannels' );
        $columns['ad_expiration_date'] = __( 'Expiration Date', 'nicechannels' );
        return $columns;
	}
	
    // add the data to the custom columns for the telegram ads post type:
    add_action( 'manage_posts_custom_column' , 'nicechannels_custom_telegram_ads_column', 10, 2 );
    function nicechannels_custom_telegram_ads_column( $column, $post_id ) {
        switch ( $column ) {
            case 'paypal_transaction' :
			echo get_post_meta( $post_id , 'paypal_transaction' , true ); 
			break;
			case 'featured' :
			echo "<p>  ". get_post_meta( $post_id , 'featured_post' , true )."</p> "; 
			break;		
			case 'ad_expiration_date' :
			echo "<p>  ". get_post_meta( $post_id , 'ad_expiration_date' , true )."</p> "; 
			break;
		}
	}

	//get the telegram ads post category
	function telegram_get_post_category($postId, $before, $sep = ' \ ', $link=false) {
		if ((get_the_term_list( $postId, 'telegram_ads_category' ) != '')) {
			if (get_the_term_list( $postId, 'types' ) != '') {
				$category = get_the_term_list($postId, 'telegram_ads_category', $before, $sep , '' );
				return $link ? $category: strip_tags($category);
				}else{
				return "";
			}
			}else{
			return "";
		}
	}

 