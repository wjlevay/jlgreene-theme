from front-page.php

<div class="latest-news m-all t-1of2 d-1of2 last-col cf">
	<?php 
	$latest_news = new WP_Query( array( 'posts_per_page' => 1 ) );

	if ($latest_news->have_posts()) : while ($latest_news->have_posts()) : $latest_news->the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">

		<header class="article-header">
			<div class="post-thumbnail latest-news-story">
				<a href="news" title="read more news"><?php the_post_thumbnail( 'medium' ); ?>
				<p class="h3 latest-news-text">latest news:</p></a>
			</div>
		</header>

		<section class="entry-content cf">
			<h3 class="entry-title single-title" itemprop="headline"><a href="news" title="read more news"><?php the_title(); ?></a></h3>
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

~~~~~~~~~~~~~~~

from footer.php

<div class="footer-left m-all t-1of2 d-1of2 cf">
	<p class="address"><a href="#" title="map us">146 Central Park West &middot; Suite 1E &middot; New York, NY 10023</a></p>
</div>

<div class="footer-middle m-all t-1of4 d-1of4 cf">
	<p class="phone"><a href="tel:+12126881550" title="call us">(212) 688-1550</a></p>
</div>

<div class="footer-right m-all t-1of4 d-1of4 last-col cf">
	<p class="email"><a href="mailto:hello@jlgreene.org" title="email us">hello@JLGreene.org</a></p>
</div>

~~~~~~~~~~~~~~~~

from _base.scss

/* latest news block */
.latest-news {

	display: flex;
	position: relative;

	.latest-news-story {
		margin-top: 1.5em;

		.latest-news-text {
			position: absolute;
			left: 5%;
			top: 5%;
			color: $white;
			text-shadow: 2px 2px 2px rgba(150, 150, 150, 1);

		}
	}

	article {
		.entry-content {
			padding: 0.5em 0.75em 0;

			background: $warm-gray;
			.entry-title {
				color: $plum;
				@include ibis;
			}
			h3 {
				a, a:visited, a:hover, a:focus {
					color: $plum;
				}
			}
			.h4 {
				font-size: 0.95em;
				margin-bottom: 0.75em;
				a {
					color: $white;
				}
			}
		}
	}
}
