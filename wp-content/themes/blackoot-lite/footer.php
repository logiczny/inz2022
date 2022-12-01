<?php
/**
 *
 * Blackoot Lite WordPress Theme by Iceable Themes | https://www.iceablethemes.com
 *
 * Copyright 2014-2019 Iceable Media - Mathieu Sarrasin
 *
 * Footer Template
 *
 */

if ( is_active_sidebar( 'footer-sidebar' ) ) :
	?>
	<div id="footer">
		<div class="container">
			<ul>
			<?php dynamic_sidebar( 'footer-sidebar' ); ?>
			</ul>
		</div>
	</div>
	<?php
endif;

?>
<div id="sub-footer">
	<div class="sub-footer-left">
		<p>

		<?php
		/* You are free to modify or replace this by anything you like as per the terms of the GPL license */
		?>

		<?php
		printf(
			// Translators: %1$s is the copyright date, %2$s is the site name (e.g. Copyright © 2018, My Website)
			esc_html__( 'Copyright &copy; %1$s, %2$s.', 'blackoot-lite' ),
			esc_html( date( 'Y' ) ),
			esc_html( get_bloginfo( 'name' ) )
		);
		echo ' ';
		echo ' ';
		?>

<?php
/* Stop editing here */
?>

			</p>
		</div>
</div>

</div>

<?php wp_footer(); ?>

</body>
</html>
