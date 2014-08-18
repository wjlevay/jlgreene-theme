<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

// USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
require_once( 'library/custom-post-type.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
 require_once( 'library/admin.php' );

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  // let's get language support going, if you need it
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'bones_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  bones_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'bones_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

/*
Disabled this because it was causing large images to be displayed at 640px

if ( ! isset( $content_width ) ) {
	$content_width = 640;
}
*/

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'bones-thumb-600' => __('600px by 150px'),
        'bones-thumb-300' => __('300px by 100px'),
    ) );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/


/************* DISABLE UPDATE NAGS & NOTIFICATIONS ********************/

// via http://www.wpoptimus.com/626/7-ways-disable-update-wordpress-notifications/

if(!current_user_can('update_core')) {
  function remove_core_updates(){
    global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
  }

  add_filter('pre_site_transient_update_core','remove_core_updates');
  add_filter('pre_site_transient_update_plugins','remove_core_updates');
  add_filter('pre_site_transient_update_themes','remove_core_updates');
}


/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'bonestheme' ),
		'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!


/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'bonestheme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


/************* GOOGLE FONTS *********************/

/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
function bones_fonts() {
  wp_register_style('WebTypeFonts', '//cloud.webtype.com/css/2f57aede-3067-49aa-a38b-dcd8f7a080dc.css');
  wp_enqueue_style( 'WebTypeFonts');
}

add_action('wp_print_styles', 'bones_fonts');


/************* ALLOW HTML IN CATEGORY DESCRIPTION FIELD *********************/

/*
Found here: http://premium.wpmudev.org/blog/how-to-display-your-wordpress-category-description-in-your-theme/
*/

remove_filter('pre_term_description', 'wp_filter_kses');


/************* PAGE SLUG AS BODY CLASS *********************/

/* 
Set page slug as a body class (via http://timneill.net/2013/05/wordpress-add-page-slug-to-body-class-including-parents/)
*/

function add_body_class($classes) {
    // You can modify this check so it will run on every post type
    if (is_page()) {
        global $post;
        
        // If we *do* have an ancestors list, process it
        // http://codex.wordpress.org/Function_Reference/get_post_ancestors
        if ($parents = get_post_ancestors($post->ID)) {
            foreach ((array)$parents as $parent) {
                // As the array contains IDs only, we need to get each page
                if ($page = get_page($parent)) {
                    // Add the current ancestor to the body class array
                    $classes[] = "{$page->post_type}-{$page->post_name}";
                }
            }
        }
 
        // Add the current page to our body class array
        $classes[] = "{$post->post_type}-{$post->post_name}";
    }
    
    return $classes;
}

add_filter('body_class', 'add_body_class');


/************* FIRST PARAGRAPH CLASS *********************/

function first_paragraph($content){
    return preg_replace('/<p([^>]+)?>/', '<p$1 class="first">', $content, 1);
}
add_filter('the_content', 'first_paragraph');


/************* RELATED PROJECTS *********************/

/*
Get related "project" custom post types by the custom taxonomy "project_cat"
via http://wordpress.stackexchange.com/questions/43336/displaying-related-posts-in-a-custom-post-type-by-a-custom-taxonomy
This is used in the template file single-project.php
*/

function get_related_projects() {

  // Get array of terms
  $terms = get_the_terms($post->ID, 'project_cat', 'string');
  // Pluck out the IDs to get an array of IDs
  $term_ids = wp_list_pluck($terms, 'term_id');
  $exclude_post = $post->ID;

    // Set up arguments for the new WP_Query below
    $args=array(
      'post_type' => 'project',
      'tax_query' => array(
        array(
          'taxonomy' => 'project_cat',
          'field' => 'id',
          'terms' => $term_ids,
          'operator' => 'IN' // or 'AND' or 'NOT IN'
        )
      ),
      'post__not_in' => array($exclude_post), // Exclude the project being displayed
      'posts_per_page'=> 2, // Number of related posts that will be shown
      'orderby' => 'rand'
    );

  $related = new WP_Query( $args );
  if ($related->have_posts()) {
    echo '<h3>related projects:</h3>';
  }
  while ($related->have_posts()) : $related->the_post();
  $postcount++; ?>                

  <?php // If it's the first project, put it in a left column, if it's the second, put it in a right column
  if ($postcount == 1) : echo '<div class="rel-project m-all t-1of2 d-1of2 cf">'; 
  else : echo '<div class="rel-project m-all t-1of2 d-1of2 last-col cf">';
  endif ; ?>

    <?php // check for featured image and display
      if ( '' != get_the_post_thumbnail() ) { ?>
      <div class="post-thumbnail"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'medium' ); ?></a></div>
      <?php } 
      else {
        echo '';
      } 
    ?>
    <h3 class="project-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
    <p class="project-cat"><?php
      printf(__('%1$s', 'bonestheme'), get_the_term_list( get_the_ID(), 'project_cat', "", " &middot; ", "" ));
    ?></p>
  </div>

  <?php endwhile;
  wp_reset_query();
  wp_reset_postdata();

}


/************* CUSTOM META BOXES *********************/

/*
We're using the meta box tool recommended in this version of the Bones framework:
https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress

The files are located within the theme folder, in /library/metabox
*/

function jlg_metaboxes( $meta_boxes ) {
    $prefix = '_cmb_'; // Prefix for all fields

    $meta_boxes['tagline_metabox'] = array(
        'id' => 'tagline_metabox',
        'title' => 'Project Tagline',
        'pages' => array('project'), // post type
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => false, // Show field names on the left
        'fields' => array(
            array(
                'name' => 'Project Tagline',
                'desc' => 'Enter a tagline that will display at the top of the Project page',
                'id' => $prefix . 'tagline',
                'type' => 'text'
            ),
        ),
    );

    $meta_boxes['about_tagline_metabox'] = array(
        'id' => 'about_tagline_metabox',
        'title' => 'About Page Tagline',
        'pages' => array('page'), // post type
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => false, // Show field names on the left
        'show_on'    => array( 'key' => 'page-template', 'value' => 'page-about.php' ), // Specific page template to display this metabox
        'fields' => array(
            array(
                'name' => 'About Page Tagline',
                'desc' => 'Enter a tagline that will display at the top of the About page',
                'id' => $prefix . 'about_tagline',
                'type' => 'text'
            ),
        ),
    );

    $meta_boxes['quote_metabox'] = array(
        'id' => 'quote_metabox',
        'title' => 'Project Quote',
        'pages' => array('project'), // post type
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name' => 'Project Quote',
                'desc' => 'Enter a great quote about this project',
                'id' => $prefix . 'quote',
                'type' => 'text'
            ),
            array(
                'name' => 'Who Said It?',
                'desc' => 'Enter the name.',
                'id' => $prefix . 'quotee',
                'type' => 'text_medium'
            ),
        ),
    );

    $meta_boxes['project_viz_metabox'] = array(
        'id' => 'project_viz_metabox',
        'title' => 'Project Visibility',
        'pages' => array('project'), // post type
        'context' => 'side',
        'priority' => 'core',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name' => __( 'Feature this project?', 'cmb' ),
                'desc' => __( 'Feature this project on the homepage.', 'cmb' ),
                'id'   => $prefix . 'featured_project',
                'type' => 'checkbox',
            ),
            array(
                'name' => __( 'Is this project new?', 'cmb' ),
                'desc' => __( 'Label this project as "new."', 'cmb' ),
                'id'   => $prefix . 'new_project',
                'type' => 'checkbox',
            ),
        ),
    );

    $meta_boxes['post_link_metabox'] = array(
        'id' => 'post_link_metabox',
        'title' => 'External Link',
        'pages' => array('post'), // post type
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name' => 'Link Text',
                'desc' => 'Enter the text that should display for this link.',
                'id' => $prefix . 'linkText',
                'type' => 'text_medium'
            ),
            array(
                'name' => __( 'Link URL', 'cmb' ),
                'desc' => 'Enter the URL for this link.',
                'id'   => $prefix . 'linkURL',
                'type' => 'text_url',
            ),
        ),
    );

    $meta_boxes['post_image_size_metabox'] = array(
        'id' => 'post_image_size_metabox',
        'title' => 'Featured Image Size',
        'pages' => array('post'), // post type
        'context' => 'side',
        'priority' => 'low',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name' => __( 'Use full-size image', 'cmb' ),
                'desc' => __( 'Check this box if you want the featured image for this post to span the full width of the page.', 'cmb' ),
                'id'   => $prefix . 'large_image',
                'type' => 'checkbox',
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'jlg_metaboxes' );

// Initialize the metabox class
add_action( 'init', 'initialize_cmb_meta_boxes', 9999 );
function initialize_cmb_meta_boxes() {
    if ( !class_exists( 'cmb_Meta_Box' ) ) {
        require_once( 'library/metabox/init.php' );
    }
}


/* DON'T DELETE THIS CLOSING TAG */ ?>
