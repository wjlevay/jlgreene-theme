<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<div id="main" class="cf" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">

								<header class="article-header">

									<?php // display the site description ?>
									<h2 class="tagline h1"><?php bloginfo('description'); ?></h2>

									<?php // display image slider using Flexslider via WP Better Attachments ?>
										<?php echo do_shortcode('[wpba-flexslider]'); ?>
									<!--end flexslider-->

								</header>
								
								<?php // here is the content, which includes main paragraph and a quote ?>	
								<section class="entry-content m-all t-all d-all cf">
									<?php
										// the content (pretty self explanatory huh)
										the_content();
									?>
								</section>

								<?php // display two most recent news posts ?>
								<footer class="article-footer m-all t-all d-all cf">
									<?php // get two news stories
									$news = new WP_Query(array ('posts_per_page' => 2) );
									if ($news->have_posts()) {
										echo '<h3>latest news:</h3>';
									}
									while ($news->have_posts()) : $news->the_post();
									$postcount++; ?>

									<?php // If it's the first news story, put it in a left column, if it's the second, put it in a right column
									if ($postcount == 1) : echo '<div class="latest-news m-all t-1of2 d-1of2 cf">'; 
									else : echo '<div class="latest-news m-all t-1of2 d-1of2 last-col cf">';
									endif ; ?>

										<?php // check for featured image and display
											if ( '' != get_the_post_thumbnail() ) { ?>
											<div class="post-thumbnail"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'medium' ); ?></a></div>
											<?php } 
											else {
												echo '';
											} 
										?>
										<h3 class="news-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
									</div>

									<?php endwhile;
									wp_reset_postdata();
									?>
								</footer>

								<?php // comments_template(); ?>

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
