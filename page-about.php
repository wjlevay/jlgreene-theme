<?php
/*
 Template Name: About Page
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<div id="main" class="m-all t-all d-all cf" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<h1 class="page-title h2 hide"><?php the_title(); ?></h1>
									<?php // display the custom tagline field ?>
									<h2 class="tagline h1"><?php 
										$tagline = get_post_meta( $post->ID, '_cmb_about_tagline', true );

										if( !empty( $tagline ) ) {
        									echo $tagline;
    									}
    									else {
    										echo 'You forgot to add a tagline!';
    									}
									?></h2>

								</header>

								<section class="entry-content cf" itemprop="articleBody">
									<div class="the-content"><?php the_content(); ?></div>
								</section>


								<footer class="article-footer">

								</footer>

							</article>

							<?php endwhile; else : ?>

									<article id="post-not-found" class="hentry cf">
											<header class="article-header">
												<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
											<section class="entry-content">
												<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php // _e( 'This is the error message in the page-about.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div>

				</div>

			</div>


<?php get_footer(); ?>
