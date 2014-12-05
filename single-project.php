<?php
/*
 * PROJECT PAGE
 *
 * This is based on the custom post type post template. If you edit the post type name, you've got
 * to change the name of this template to reflect that name change.
 *
 * For Example, if your custom post type is "register_post_type( 'bookmarks')",
 * then your single template should be single-bookmarks.php
 *
 * Be aware that you should rename 'custom_cat' and 'custom_tag' to the appropiate custom
 * category and taxonomy slugs, or this template will not finish to load properly.
 *
 * For more info: http://codex.wordpress.org/Post_Type_Templates
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<div id="main" class="m-all t-all d-all cf" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">

								<header class="article-header">

									<h1 class="h1 single-title custom-post-type-title"><?php the_title(); ?></h1>

									<?php // Which piece of content should we feature?
										$feat = get_post_meta( $post->ID, '_cmb2_feat_content', true);
										if ($feat == 'option1') {
											// check for featured image and display
											if ( '' != get_the_post_thumbnail() ) { ?>
											<div class="post-thumbnail"><?php the_post_thumbnail( 'large' ); ?><p class="thumbnail-caption"><?php echo get_post(get_post_thumbnail_id())->post_excerpt; ?></p></div>
											<?php } 
											else {
												echo '';
											} 
										}

										elseif ($feat == 'option2') {
											// check for attachments and display image slider using Flexslider via WP Better Attachments
											echo do_shortcode('[wpba-flexslider]');
										}

										elseif ($feat == 'option3') {
											// check for video and display
											$video = get_post_meta ($post->ID, '_cmb2_video', true);
											// $embed_code = wp_oembed_get($video);
											if ( '' != $video) {
												echo do_shortcode('[fve]' . $video . '[/fve]');
												// note: using wp_oembed_get($video) forced the iframe to the $content_width set in functions.php
												// so we're using the Fluid Video Embed plugin to allow smooth scaling
											} else {
												echo "We're missing the video URL!";
											}
										}

									?>

									<?php // display the custom tagline field ?>
									<h2 class="tagline"><?php 
										$tagline = get_post_meta( $post->ID, '_cmb2_tagline', true );

										if( !empty( $tagline ) ) {
        									echo $tagline;
    									}
    									else {
    										echo '';
    									}
									?></h2>

								</header>
									
								<section class="entry-content m-all t-3of10 d-3of10 cf">

									<?php // display the quote custom fields ?>
									<div class="quote"><?php
									    $quote = get_post_meta( $post->ID, '_cmb2_quote', true );
									    $quotee = get_post_meta( $post->ID, '_cmb2_quotee', true );

									    if( !empty( $quote ) ) {
											$quote_block = $quote . '<br>&mdash; ' . $quotee;
											echo apply_filters('the_content', $quote_block);
										}
									?></div>

								</section> <!-- end left section -->

								<section class="entry-content m-all t-7of10 d-7of10 last-col cf">
									<div class="the-content"><?php the_content(); ?></div>
								</section> <!-- end right section -->

								<footer class="article-footer m-all t-all d-all cf">
								</footer>

							</article>

							<?php endwhile; ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry cf">
										<header class="article-header">
											<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
											<p><?php // _e( 'This is the error message in the single-project.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div>

				</div>

			</div>

<?php get_footer(); ?>
