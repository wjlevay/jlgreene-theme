<?php // NEWS PAGE
get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

					<div id="main" class="m-all t-all d-all cf" role="main">

						<?php // display the news page tagline ?>
						<h1 class="page-title">News</h2>

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">

							<header class="article-header">

								<h2 class="h3 entry-title"><?php the_title(); ?></h1>

								<?php // check for featured image and display
									if ( '' != get_the_post_thumbnail() ) { ?>
									<div class="post-thumbnail thumb-large"><?php the_post_thumbnail( 'large' ); ?><p class="thumbnail-caption"><?php echo get_post(get_post_thumbnail_id())->post_excerpt; ?></p></div>
									<?php } 
									else { // we can add a default news photo here
										echo '';
									} 
								?>

							</header>

							<section class="entry-content cf">
								<div class="the-content"><?php the_content(); ?></div>
							</section>

							<footer class="article-footer cf">
							</footer>

						</article>

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
											<p><?php // _e( 'This is the error message in the index.php template.', 'bonestheme' ); ?></p>
									</footer>
								</article>

						<?php endif; ?>

					</div>

				</div>

			</div>

<?php get_footer(); ?>
