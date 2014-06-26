<?php
/*
 * CUSTOM POST TYPE TEMPLATE
 *
 * This is the custom post type post template. If you edit the post type name, you've got
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

									<?php // check for featured image and display
										if ( '' != get_the_post_thumbnail() ) { ?>
										<div class="post-thumbnail"><?php the_post_thumbnail( 'large' ); ?></div>
										<?php } 
										else {
											echo '';
										} 
									?>

									<?php // display the custom tagline field ?>
									<h2 class="tagline h1"><?php 
										$tagline = get_post_meta( $post->ID, '_cmb_tagline', true );

										if( !empty( $tagline ) ) {
        									echo $tagline;
    									}
    									else {
    										echo 'You forgot to add a tagline!';
    									}
									?></h2>

								</header>
									
								<section class="entry-content m-all t-1of2 d-1of2 cf">

									<h1 class="single-title custom-post-type-title"><?php the_title(); ?></h1>
									<p class="byline vcard"><?php
										printf( __( '%1$s', 'bonestheme' ), get_the_term_list( $post->ID, 'project_cat', ' ', ', ', '' ) );
									?></p>

									<?php // display the quote custom fields ?>
									<p class="quote"><?php
									    $quote = get_post_meta( $post->ID, '_cmb_quote', true );
									    $quotee = get_post_meta( $post->ID, '_cmb_quotee', true );

									    if( !empty( $quote ) ) {
											echo $quote . '<br>&mdash; ' . $quotee;
										}
									?></p>

								</section> <!-- end left section -->

								<section class="entry-content m-all t-1of2 d-1of2 last-col cf">
									<?php the_content(); ?>
								</section> <!-- end right section -->

								<footer class="article-footer m-all t-all d-all cf">
									<h3>related projects:</h3>
									<?php // echo bones_related_projects(); ?>
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
											<p><?php _e( 'This is the error message in the single-project.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div>

				</div>

			</div>

<?php get_footer(); ?>
