<?php
/**
 * Custom comment walker for this theme
 *
 * @package WordPress
 * @subpackage Separate_Blog
 */

/**
 * This class outputs custom comment walker for HTML5 friendly WordPress comment and threaded replies.
 */
class separate_blog_comment_walker extends Walker_Comment {

	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	function html5_comment( $comment, $depth, $args ) {
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
		?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>">
			<div class="comment-header d-flex justify-content-between">
				<div class="user d-flex align-items-center">
					<?php 
					$avatar = get_avatar( $comment, 65, '', esc_attr__( 'Author gravatar' , 'separate-blog' ) ); 

					if( ! empty( $avatar ) ){ 
						$margin = ''; ?>
						<div class="image">
							<?php 
							echo wp_kses(
								$avatar,
								array( 
									'img' => array( 
										'class' => array(),
										'alt' => array(),
										'src' => array(),
										'width' => array(),
										'height' => array(),
									) 
								) 
							); 
							?>
						</div>
						<?php 
					} else {
						$margin = 'margin-left: 0;';
					} 

					$date_format = get_option( 'date_format' );
					$time_format = get_option( 'time_format' ); ?>

					<div class="title" style="<?php echo esc_attr( $margin ); ?>">
						<a href="<?php echo esc_url( $comment->comment_author_url ); ?>" class="font600 font16" target="blank"><strong><?php echo esc_html( $comment->comment_author ); ?></strong></a>
						<span class="date">
							<?php comment_date( $date_format . ', ' . $time_format , $comment->comment_ID ); ?>	
						</span>
					</div>
				</div>
			</div>
			<div class="comment-body">
				<?php
						// Commment text
				comment_text( $comment->comment_ID );
						// Edit link
				if ( get_edit_comment_link( $comment->comment_ID ) ) { ?>
					<div class="edit-comment-link">
						<a class="comment-edit-link btn btn-secondary" href="<?php echo esc_url( get_edit_comment_link( $comment->comment_ID ) ); ?>"><span class="comment-meta-item"><?php esc_html_e( 'Edit this comment', 'separate-blog' ); ?></span>
						</a>
					</div> 
				<?php }
					// Replay button
		comment_reply_link(
			array_merge(
				$args,
				array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="comment-reply">',
					'after'     => '</div>',
				)
			)
		);
				?>
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-meta-item comment_awating"><?php esc_html_e( 'Your comment is awaiting moderation.' , 'separate-blog' ); ?></p>
				<?php endif; ?>
			</div>
		</article>
		<?php
	}
}
