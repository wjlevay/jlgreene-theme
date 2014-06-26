<?php
/*
 * CUSTOM POST TYPE TAXONOMY TEMPLATE
 *
 * This is the custom post type taxonomy template. If you edit the custom taxonomy name,
 * you've got to change the name of this template to reflect that name change.
 *
 * For Example, if your custom taxonomy is called "register_taxonomy('shoes')",
 * then your template name should be taxonomy-shoes.php
 *
 * For more info: http://codex.wordpress.org/Post_Type_Templates#Displaying_Custom_Taxonomies
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<div id="main" class="cf" role="main">

							<h1 class="archive-title h2 hide"><span><?php _e( 'Projects Categorized:', 'bonestheme' ); ?></span> <?php single_cat_title(); ?></h1>
							<h2 class="archive-title h1 tagline">
								<?php // display the description instead of the title
									echo category_description();
								?>
							</h1>

							<?php if (have_posts()) : while (have_posts()) : the_post(); $postcount++; ?>

								<?php // if it's an odd project, put it in a left column, if it's even, put it in a right column
									if ($postcount % 2) : echo '<div class="project m-all t-1of2 d-1of2 cf">'; 
									else : echo '<div class="project m-all t-1of2 d-1of2 last-col cf">';
									endif ; ?>

									<?php // check if it's a new project so we can add the "new-project" class to the thumbnail
										$new = get_post_meta( $post->ID, '_cmb_new_project', true );
										if ( !empty( $new ) ) {
											$new_class = 'new-project';
											$new_caption= '<div class="new-overlay"></div><p class="h1 new-overlay-text">new</p>';
										}
										else {
											$new_class = '';
											$new_caption = '';
										}
									?>

									<?php // check for featured image and display, and add the "new-project class" if needed
										if ('' != get_the_post_thumbnail() ) { ?>
										<div class="post-thumbnail <?php echo $new_class; ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'medium' ); echo $new_caption; ?></a></div>
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
												<p><?php _e( 'This is the error message in the taxonomy-project_cat.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div>

				</div>

			</div>

<?php get_footer(); ?>
