<?php
/*
 * CUSTOM POST TYPE ARCHIVE TEMPLATE
 *
 * This is the custom post type archive template. If you edit the custom post type name,
 * you've got to change the name of this template to reflect that name change.
 *
 * For Example, if your custom post type is called "register_post_type( 'bookmarks')",
 * then your template name should be archive-bookmarks.php
 *
 * For more info: http://codex.wordpress.org/Post_Type_Templates
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<div id="main" class="cf" role="main">

							<h1 class="archive-title h1 tagline">Projects</h1>

							<div class="projects-grid">

								<?php if (have_posts()) : while (have_posts()) : the_post(); $postcount++; ?>

									<?php // if it's an odd project, put it in a left column, if it's even, put it in a right column
										if ($postcount % 2) : echo '<div class="project m-all t-1of2 d-1of2 cf">'; 
										else : echo '<div class="project m-all t-1of2 d-1of2 last-col cf">';
										endif ; ?>

										<?php // check for featured image and display
											if ('' != get_the_post_thumbnail() ) { ?>
											<div class="post-thumbnail"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'medium' ); ?></a></div>
											<?php } 
											else {
												echo '';
											} 
										?>

										<?php // check for short title and display
											$short_title = get_post_meta( $post->ID, '_cmb2_short_title', true);
											if ( !empty( $short_title ) ) { ?>
												<h3 class="project-title h4"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php echo $short_title; ?></a></h3>
											<?php } 
											else { ?>
												<h3 class="project-title h4"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
											<?php } 
										?>

									</div>

								<?php endwhile; ?>

										<?php bones_page_navi(); ?>

								<?php else : ?>

										<article id="post-not-found" class="hentry cf">
											<header class="article-header">
												<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
											</header>
											<section class="entry-content">
												<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
											</section>
											<footer class="article-footer">
													<p><?php // _e( 'This is the error message in the archive-project.php template.', 'bonestheme' ); ?></p>
											</footer>
										</article>

								<?php endif; ?>

							</div>

						</div>

				</div>

			</div>

<?php get_footer(); ?>
