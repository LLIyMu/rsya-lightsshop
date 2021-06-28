<?php
get_header();
/* Template Name: Акции */
global $current_user;
?>
<div class="headLine"></div>
<div class="wrapper">
	<?if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();?>
</div>
<center>
<img src="<?=get_template_directory_uri();?>/images/stocks.jpg" alt="Акции">
</center>
<?php
get_footer();
