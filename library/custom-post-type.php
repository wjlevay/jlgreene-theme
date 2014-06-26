<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'bones_flush_rewrite_rules' );

// Flush your rewrite rules
function bones_flush_rewrite_rules() {
	flush_rewrite_rules();
}

// let's create the function for the custom type
function custom_post_example() { 
	// creating (registering) the custom type 
	register_post_type( 'project', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Projects', 'bonestheme' ), /* This is the Title of the Group */
			'singular_name' => __( 'Project', 'bonestheme' ), /* This is the individual type */
			'all_items' => __( 'All Projects', 'bonestheme' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'bonestheme' ), /* The add new menu item */
			'add_new_item' => __( 'Add New Project', 'bonestheme' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Projects', 'bonestheme' ), /* Edit Display Title */
			'new_item' => __( 'New Project', 'bonestheme' ), /* New Display Title */
			'view_item' => __( 'View Project', 'bonestheme' ), /* View Display Title */
			'search_items' => __( 'Search Project', 'bonestheme' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is the example custom post type', 'bonestheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'project', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'projects', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
		) /* end of options */
	); /* end of register post type */
	
	/* this adds your post categories to your custom post type */
	/* register_taxonomy_for_object_type( 'category', 'project' ); */
	/* this adds your post tags to your custom post type */
	/* register_taxonomy_for_object_type( 'post_tag', 'project' ); */
	
}

	// adding the function to the Wordpress init
	add_action( 'init', 'custom_post_example');
	
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	
	// now let's add custom categories (these act like categories)
	register_taxonomy( 'project_cat', 
		array('project'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true,     /* if this is true, it acts like categories */
			'labels' => array(
				'name' => __( 'Project Categories', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Project Category', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Project Categories', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Project Categories', 'bonestheme' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Project Category', 'bonestheme' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Project Category:', 'bonestheme' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Project Category', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Project Category', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Project Category', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Project Category Name', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'projects' ),
		)
	);
	
	// now let's add custom tags (these act like categories)
	register_taxonomy( 'project_tag', 
		array('project'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => false,    /* if this is false, it acts like tags */
			'labels' => array(
				'name' => __( 'Project Tags', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Project Tag', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Project Tags', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Project Tags', 'bonestheme' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Project Tag', 'bonestheme' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Project Tag:', 'bonestheme' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Project Tag', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Project Tag', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Project Tag', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Project Tag Name', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'query_var' => true,
		)
	);
	
	/*
		looking for custom meta boxes?
		check out this fantastic tool:
		https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
	*/
	

?>
