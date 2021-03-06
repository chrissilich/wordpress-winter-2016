<?php
/**
 * The main template file.
 *
 * @package WPlook
 * @subpackage Morning Time Lite
 * @since Morning Time Lite 1.0
 */
 ?>

 <?php get_header(); ?>
 	<div class="main">
		<div class="row">
			<div class="columns large-12">
				<div class="content">
					<?php while ( have_posts() ) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class("post post-single image-attachment"); ?> itemscope itemtype="https://schema.org/BlogPosting">
							<header class="post-head">
								<?php
								$metadata = wp_get_attachment_metadata();
								printf( __( '<time class="post-date" datetime="%1$s">%2$s</time><div class="full-attach"><a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%8$s</a></div>', 'morningtime-lite' ),
									esc_attr( get_the_date( 'c' ) ),
									esc_html( get_the_date() ),
									esc_url( wp_get_attachment_url() ),
									$metadata['width'],
									$metadata['height'],
									esc_url( get_permalink( $post->post_parent ) ),
									esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ),
									get_the_title( $post->post_parent )
								);
							?>


								<h3 class="post-title">
									<?php the_title(); ?>
								</h3>

								<ul class="post-category"><li><?php the_category('</li><li>'); ?></li></ul>
							</header><!-- /.post-head -->


							<div class="post-image">
								<?php

								$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
								foreach ( $attachments as $k => $attachment ) :
									if ( $attachment->ID == $post->ID )
										break;
								endforeach;

								// If there is more than 1 attachment in a gallery
								if ( count( $attachments ) > 1 ) :
									$k++;
									if ( isset( $attachments[ $k ] ) ) :
										// get the URL of the next image attachment
										$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
									else :
										// or get the URL of the first image attachment
										$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
									endif;
								else :
									// or, if there's only 1 image, get the URL of the image
									$next_attachment_url = wp_get_attachment_url();
								endif;
								?>
								<a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php

								$attachment_size = apply_filters( 'morning_attachment_size', 'full' );
								echo wp_get_attachment_image( $post->ID, $attachment_size );
								?></a>

							</div><!-- /.post-image -->


							<div class="post-body">
								<div class="entry entry-caption" itemprop="articleBody">
									<?php the_content(); ?>
									<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'morningtime-lite' ), 'after' => '</div>' ) ); ?>
								</div><!-- /.entry -->
							</div><!-- /.post-body -->


							<div class="post-nav">
								<div class="post-nav-prev">
									<?php previous_image_link( false, __( '<i class="fa fa-angle-left"></i> Previous image', 'morningtime-lite' ) ); ?>
								</div><!-- /.post-nav-prev -->

								<div class="post-nav-next">

									<?php next_image_link( false, __( 'Next Image <i class="fa fa-angle-right"></i>', 'morningtime-lite' ) ); ?>
								</div><!-- /.post-nav-next -->
							</div><!-- /.post-nav -->


						</article><!-- /.post -->


				<?php comments_template(); ?>

			<?php endwhile; // end of the loop. ?>
				</div><!-- /.content -->

				<?php morning_time_lite_pagination() ?>

			</div><!-- /.columns large-8 -->

		</div><!-- /.row -->
	</div><!-- /.main -->
 <?php get_footer(); ?>