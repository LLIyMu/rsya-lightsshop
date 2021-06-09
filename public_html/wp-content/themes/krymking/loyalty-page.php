<?php
get_header();
/* Template Name: Программа лояльности */
global $current_user;
?>
<div class="headLine"></div>
<div class="wrapper">
	<?if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();?>
</div>
<center>
<img src="<?=get_template_directory_uri();?>/images/loyalty.png" alt="Программа лояльности">
</center>
<?php
get_footer();
