<?php
/**
 * AIGA (Boston) custom post types
 *
 * @package AIGA
 */

function aiga_post_types_setup() {
  
   register_post_type( 'board_member',
    array(
          'labels' => array(
          'name' => 'Board Members',
          'singular_name' => 'Board Members',
          'add_new' => 'Add Board Member',
          'add_new_item' => 'Add New Board Member',
          'edit_item' => 'Edit Board Members',
          'new_item' => 'New Board Members',
          'all_items' => 'All Board Memberss',
          'view_item' => 'View Board Member',
          'search_items' => 'Search Board Members',
          'not_found' =>  'No board members found',
          'not_found_in_trash' => 'No board members found in Trash',
          'parent_item_colon' => '',
          'menu_name' => 'Board Members'
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'board-member' ),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => null
    )
  );
  
  /* Board Members Taxonomies */
  
  $args = array(
      'hierarchical'          => true,
      'labels'                => array(
      'name'                  => 'Board Member Categories',
      'singular_name'         => 'Category',
      'search_items'          => 'Search Categories',
      'popular_items'         => 'Popular Categories',
      'all_items'             => 'All Categories',
      'parent_item'           => null,
      'parent_item_colon'     => null,
      'edit_item'             => 'Edit Category',
      'update_item'           => 'Update Category',
      'add_new_item'          => 'Add New Category',
      'new_item_name'         => 'New Category',
      'add_or_remove_items'   => 'Add or remove categories',
      'choose_from_most_used' => 'Choose from the most used categories',
      'not_found'             => 'No categories found.',
      'menu_name'             => 'Board Member Categories',
      ),
      'show_ui'               => true,
      'show_admin_column'     => false,
      'query_var'             => true,
      'rewrite'               => array( 'slug' => 'members' )
  );
  
  register_taxonomy( 'members', 'board_member', $args );
  
}

// remove comments from this post type
function AIGA_remove_comments() {
	remove_post_type_support( 'board_member', 'comments' );
}

add_action( 'init', 'aiga_post_types_setup' );
add_action( 'init', 'AIGA_remove_comments' );
