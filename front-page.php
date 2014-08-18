<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<div id="main" class="cf" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">

								<header class="article-header">

									<?php // display image slider using Flexslider via WP Better Attachments ?>
										<?php echo do_shortcode('[wpba-flexslider]'); ?>
									<!--end flexslider-->

									<?php // display the site description ?>
									<h2 class="tagline h1"><?php bloginfo('description'); ?></h2>

								</header>
									
								<section class="entry-content m-all t-1of2 d-1of2 cf">
									<?php
										// the content (pretty self explanatory huh)
										the_content();
									?>
								</section> <!-- end left section -->

								<div class="latest-news m-all t-1of2 d-1of2 last-col cf">
									<?php // display only the most recent post

									$latest_news = new WP_Query( array( 'posts_per_page' => 1 ) );

									if ($latest_news->have_posts()) : while ($latest_news->have_posts()) : $latest_news->the_post(); ?>

									<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">

										<header class="article-header">
											<div class="post-thumbnail latest-news-story">
												<?php the_post_thumbnail( 'medium' ); ?>
												<p class="h3 latest-news-text">latest news:</p>
											</div>
										</header>

										<section class="entry-content cf">
											<h3 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h3>
											<p class="h4"><a href="news" title="read more news">read more news</a></p>
										</section>

									</article>

									<?php endwhile; endif;
									wp_reset_postdata(); ?>
								</div> <!-- end right column -->

								<footer class="article-footer m-all t-all d-all cf">
									<?php // get two projects marked 'featured'
									$project = new WP_Query(array ('post_type' => 'project', 'posts_per_page' => 2, 'orderby' => 'rand', 'meta_key' => '_cmb_featured_project') );
									if ($project->have_posts()) {
										echo '<h3>featured projects:</h3>';
									}
									while ($project->have_posts()) : $project->the_post();
									$postcount++; ?>

									<?php // If it's the first project, put it in a left column, if it's the second, put it in a right column
									if ($postcount == 1) : echo '<div class="feat-project m-all t-1of2 d-1of2 cf">'; 
									else : echo '<div class="feat-project m-all t-1of2 d-1of2 last-col cf">';
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

								<?php comments_template(); ?>

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
											<p><?php // _e( 'This is the error message in the front-page.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div>

				</div>

			</div>

<?php get_footer(); ?>
