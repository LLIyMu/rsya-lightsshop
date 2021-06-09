<?php
get_header();
?>
<div class="headLine"></div>

<div class="wrapper">
	<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
	<div class="flex-content">
	<?get_sidebar();?>
	<?get_sidebar('card');?>
	</div>
</div>
 
<?php
get_footer();
