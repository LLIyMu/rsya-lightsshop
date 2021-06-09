<?php
get_header();
?>
<div class="headLine"></div>
<div class="wrapper">
	<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
	<h1 class="page-title"><?=the_title()?></h1>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div class="page-text"><?php the_content(); ?></div>
	<?php
	endwhile;
	endif; ?>
</div>

<?php
get_footer();
