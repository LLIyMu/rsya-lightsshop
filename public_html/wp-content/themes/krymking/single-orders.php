<?php
get_header();
?>
<div class="headLine"></div>
<div class="wrapper">
	<?if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();?>

	<div class="profile page-wrap">

		<div class="left-side">
			<?get_template_part('front/profile-sidebar');?>
		</div>

		<div class="right-side">
			<div class="heading">Оставить отзыв</div>
			
			<form action="#">
 
				Отлично
			</form>

 			<?get_template_part('front/object-form');?>
	 	</div>

 	</div>
</div>
 

<?php
get_footer();