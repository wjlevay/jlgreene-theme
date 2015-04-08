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


if ( ! isset( $content_width ) ) {
	$content_width = 1240;
}


/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
//add_image_size( 'thumbnail@1.5x', 600, 600 );
//add_image_size( 'medium@1.5x', 1422, 1422 );

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

// add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

// function bones_custom_image_sizes( $sizes ) {
//     return array_merge( $sizes, array(
//         'bones-thumb-600' => __('600px by 150px'),
//         'bones-thumb-300' => __('300px by 100px'),
//     ) );
// }

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/


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


/************* REDIRECT SINGLE POST TO INDEX *********************/

// via http://wordpress.stackexchange.com/questions/65300/force-redirect-single-php-to-index

add_action('wp', 'single_redirect');
 function single_redirect(){ 
    if(is_singular('post')){ 
            wp_redirect( home_url( '/news' ) ); exit;  
        }

  }


/************* FIRST PARAGRAPH CLASS *********************/

function first_paragraph($content){
    return preg_replace('/<p([^>]+)?>/', '<p$1 class="first">', $content, 1);
}
add_filter('the_content', 'first_paragraph');



/************* DISPLAY SHORT TITLE IN MENUS *********************/

// via https://wordpress.org/support/topic/replace-page-titles-in-submenu?replies=3#post-6585463

// function jcs_short_title($title, $menu_item_id){

//   $short_title = get_post_meta($menu_item_id, '_cmb2_short_title', true);
//   if($short_title){
//     $title = $short_title;
//   }

//   return $title;
// }
// add_filter( 'jcs/item_title', 'jcs_short_title', 10, 2 );


/************* CUSTOM ORDERBY *********************/

/* This function ignores an initial 'the-' in a post slug for the purposes of alpha sorting */

// add_filter('posts_orderby', 'edit_posts_orderby');
// function edit_posts_orderby($orderby_statement) {
//   $orderby_statement = "CASE WHEN post_name LIKE 'the-%' THEN substring(post_name, 5, 1000) ELSE post_name END";
//   return $orderby_statement;
// }

/************* CUSTOM META BOXES *********************/

/*
We're using the meta box tool recommended in this version of the Bones framework:
https://github.com/WebDevStudios/CMB2

The files are located within the theme folder.
*/

/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB directory)
 *
 * @category JLGreene
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

/**
 * Get the bootstrap!
 */
if ( file_exists(  __DIR__ . '/library/cmb2/init.php' ) ) {
  require_once  __DIR__ . '/library/cmb2/init.php';
} elseif ( file_exists(  __DIR__ . '/library/CMB2/init.php' ) ) {
  require_once  __DIR__ . '/library/CMB2/init.php';
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field object $field Field object
 *
 * @return bool                     True if metabox should show
 */
function cmb2_hide_if_no_cats( $field ) {
  // Don't show this field if not in the cats category
  if ( ! has_tag( 'cats', $field->object_id ) ) {
    return false;
  }
  return true;
}

add_filter( 'cmb2_meta_boxes', 'jlg_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function jlg_metaboxes( array $meta_boxes ) {

  // Start with an underscore to hide fields from custom fields list
  $prefix = '_cmb2_';

  // PROJECT SHORT TITLE
  $meta_boxes['short_title_metabox'] = array(
      'id'            => 'short_title_metabox',
      'title'         => __( 'Short Title', 'cmb2' ),
      'object_types'  => array( 'project' ), // post type
      'context'       => 'normal',
      'priority'      => 'high',
      'show_names'    => false, // Show field names on the left if true
      'fields'        => array(
          array(
              'desc'  => __( 'OPTIONAL: Enter a shorter title that will display on the project grid page', 'cmb2' ),
              'id'    => $prefix . 'short_title',
              'type'  => 'text',
          ),
      ),
  );

  // PROJECT TAGLINE
  $meta_boxes['tagline_metabox'] = array(
      'id'            => 'tagline_metabox',
      'title'         => __( 'Tagline', 'cmb2' ),
      'object_types'  => array( 'project', 'page' ), // post type
      'context'       => 'normal',
      'priority'      => 'high',
      'show_names'    => false, // Show field names on the left if true
      'fields'        => array(
          array(
              'desc'  => __( 'Enter a tagline that will display below the featured content', 'cmb2' ),
              'id'    => $prefix . 'tagline',
              'type'  => 'textarea_small',
          ),
      ),
  );

  // QUOTE
  $meta_boxes['quote_metabox'] = array(
      'id'            => 'quote_metabox',
      'title'         => __( 'Quote', 'cmb2' ),
      'object_types'  => array('project', 'page'), // post type
      'context'       => 'normal',
      'priority'      => 'high',
      'show_names'    => true, // Show field names on the left
      'fields'        => array(
          array(
              'name'  => __( 'The Quote', 'cmb2' ),
              'desc'  => __( 'Enter the quote with quotation marks.<br>Straight quotes will be auto-transformed to curly quotes.', 'cmb2' ),
              'id'    => $prefix . 'quote',
              'type'  => 'textarea_small',
          ),
          array(
              'name'  => __( 'Who Said It?', 'cmb2' ),
              'desc'  => __( 'Enter the quotee\'s name, title, etc. This will be automatically preceded with a dash.<br>To italicize the name of a publication, use the &lt;em&gt; tag like this: &lt;em&gt;The New York Times&lt;/em&gt;', 'cmb2' ),
              'id'    => $prefix . 'quotee',
              'type'  => 'text',
              'sanitization_cb' => false,
          ),
      ),
  );

  // PROJECT VIDEO
  $meta_boxes['video_metabox'] = array(
      'id'            => 'video_metabox',
      'title'         => __( 'Project Video', 'cmb2' ),
      'object_types'  => array('project'), // post type
      'context'       => 'normal',
      'priority'      => 'high',
      'show_names'    => true, // Show field names on the left
      'fields'        => array(
          array(
            'desc'    => __( 'Enter the URL of a related video', 'cmb2' ),
            'id'      => $prefix . 'video',
            'type'    => 'oembed',
          ),
      ),
  );

  // PROJECT FEATURED CONTENT
  $meta_boxes['feat_content_metabox'] = array(
      'id'            => 'feat_content_metabox',
      'title'         => __( 'Featured Content', 'cmb2' ),
      'object_types'  => array('project'), // post type
      'context'       => 'side',
      'priority'      => 'low',
      'show_names'    => true, // Show field names on the left
      'fields'        => array(
          array(
            'desc'    => __( 'Choose which type of content should be featured at the top of the project page', 'cmb2' ),
            'id'      => $prefix . 'feat_content',
            'type'    => 'radio',
            'options' => array(
              'option1' => __( 'Single Featured Image', 'cmb2' ),
              'option2' => __( 'Image Carousel', 'cmb2' ),
              'option3' => __( 'Video', 'cmb2' ),
            ),
            'default'  => 'option1',
          ),
      ),
  );

  // Add other metaboxes as needed

  return $meta_boxes;
}


/* DON'T DELETE THIS CLOSING TAG */ ?>
