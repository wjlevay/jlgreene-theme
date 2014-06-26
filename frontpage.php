<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<div id="main" class="cf" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">

								<header class="article-header">

									<?php // put the image slider here ?>

									<?php // display the site description here ?>
									<h2 class="tagline h1"><?php bloginfo('description'); ?></h2>

								</header>
									
								<section class="entry-content m-all t-1of2 d-1of2 cf">
									<?php
										// the content (pretty self explanatory huh)
										the_content();
									?>
								</section> <!-- end left section -->

								<section class="entry-content m-all t-1of2 d-1of2 last-col cf">
									<?php // single most recent sticky post goes here ?>
									<p>This is where the recent news goes</p>
								</section> <!-- end right section -->

								<footer class="article-footer m-all t-all d-all cf">
									<h3>featured projects:</h3>
									<?php // get two sticky projects ?>
									<p>2 sticky projects go here</p>
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
											<p><?php _e( 'This is the error message in the single-custom_type.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div>

				</div>

			</div>

<?php get_footer(); ?>
