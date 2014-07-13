<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

					<div id="main" class="cf" role="main">

						<?php // display the news page tagline ?>
						<h2 class="tagline h1">This headline will refer to events and news from the Jerome L. Greene Foundation.</h2>

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">

							<?php // determine the featured image size and thus the columnar layout
								$large_image = get_post_meta( $post->ID, '_cmb_large_image', true );
								if ( !empty( $large_image ) ) {
									$image_size = 'large';
									$image_col = 'm-all t-all d-all';
									$blank_col = '<div id="blank_col" class="m-all t-1of2 d-1of2 cf">&nbsp;</div>';
								}
								else {
									$image_size = 'medium';
									$image_col = 'm-all t-1of2 d-1of2';
									$blank_col = '';
								}
							?>

							<header class="article-header <?php echo $image_col; ?>">

								<?php // check for featured image and display
									if ( '' != get_the_post_thumbnail() ) { ?>
									<div class="post-thumbnail"><?php the_post_thumbnail( $image_size ); ?><span class="thumbnail-caption"><?php echo get_post(get_post_thumbnail_id())->post_excerpt; ?></span></div>
									<?php } 
									else {
										echo '';
									} 
								?>

							</header>

							<?php // if we need a blank column, insert it here 
								echo $blank_col; 
							?>

							<div id="article-wrap" class="m-all t-1of2 d-1of2 last-col cf"> <!-- begin right column -->

								<section class="entry-content cf">
									<h1 class="h3 entry-title"><?php the_title(); ?></h1>
									<?php the_content(); ?>
								</section>

								<footer class="article-footer cf">
									<p class="post-meta">
										<?php printf( __( '', 'bonestheme' ) . ' <time class="updated" datetime="%1$s" pubdate>%2$s</time>', get_the_time('Y-m-j'), get_the_time(get_option('date_format'))); ?>
									
									<?php 
										$linkURL = get_post_meta( $post->ID, '_cmb_linkURL', true );
										$linkText = get_post_meta( $post->ID, '_cmb_linkText', true );

										if( !empty( $linkURL ) ) {
	        								echo ' &middot; <a class="external-link" href="' . $linkURL . '" title ="' . $linkText . '">' . $linkText . '</a>';
	    								}
	    								else {
	    									echo '';
	    								}
									?>
									</p>
								</footer>

							</div> <!-- end right column -->

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
											<p><?php _e( 'This is the error message in the index.php template.', 'bonestheme' ); ?></p>
									</footer>
								</article>

						<?php endif; ?>

					</div>

				</div>

			</div>

<?php get_footer(); ?>
