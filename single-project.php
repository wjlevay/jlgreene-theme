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

									<h1 class="h2 single-title custom-post-type-title"><?php the_title(); ?></h1>
									<p class="project-cat"><?php
										printf(__('%1$s', 'bonestheme'), get_the_term_list( get_the_ID(), 'project_cat', "", " &middot; ", "" ));
									?></p>

									<?php // display the quote custom fields ?>
									<div class="quote"><?php
									    $quote = get_post_meta( $post->ID, '_cmb_quote', true );
									    $quotee = get_post_meta( $post->ID, '_cmb_quotee', true );

									    if( !empty( $quote ) ) {
											$quote_block = $quote . '<br>&mdash; ' . $quotee;
											echo apply_filters('the_content', $quote_block);
										}
									?></div>

								</section> <!-- end left section -->

								<section class="entry-content m-all t-1of2 d-1of2 last-col cf">
									<div class="the-content"><?php the_content(); ?></div>
								</section> <!-- end right section -->

								<footer class="article-footer m-all t-all d-all cf">
									
									<?php // get two related projects
									
									// Get array of terms
									$terms = get_the_terms($post->ID, 'project_cat', 'string');
									// Pluck out the IDs to get an array of IDs
									$term_ids = wp_list_pluck($terms, 'term_id');

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
											'post__not_in' => array($post->ID), // Exclude the project being displayed
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
									wp_reset_postdata();
									?>
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
