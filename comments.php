<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Separate_Blog
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<header>
			<h3 class="h6">
				<?php
				$comment_count = get_comments_number();
				if ( 1 === $comment_count ) {
					printf(
						/* translators: 1: title. */
						esc_html_e( 'One thought on &ldquo;%1$s&rdquo;', 'separate-blog' ),
						'<span>' . get_the_title() . '</span>'
					);
				} else {
					printf( // WPCS: XSS OK.
						/* translators: 1: comment count number, 2: title. */
						esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'separate-blog' ) ),
						number_format_i18n( $comment_count ),
						'<span>' . get_the_title() . '</span>'
					);
				}
				?>
			</h3>
		</header><!-- .comments-title -->

		<?php
		if ( have_comments() ) {
			the_comments_navigation();
		} ?>
		
		<ol class="comment-list">
		<?php
			wp_list_comments(
				array(
					'walker' => new separate_blog_comment_walker(),
					'short_ping'  => true,
					'style'       => 'ol',
				)
			);
		?>
		</ol><!-- .comment-list -->
		<?php
		if ( have_comments() ) {
			the_comments_navigation();
		}

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'separate-blog' ); ?></p>
		<?php
		endif;

	endif; // Check to have_comments().
	
	comment_form();
	?>

</div><!-- #comments -->
