<?
global $current_user;
global $postid;

if (isset ($_GET['post']) ) {
	$postid = $_GET['post'];
} elseif (isset($_POST['post_id'])) {
	$postid = $_POST['post_id'];
} else {
	$postid = '';
}

$post = get_post( $postid );

if (!empty($_POST['object_type'])) {
	$object_type = $_POST['object_type'];
} else {
	$terms = get_the_terms( $postid, 'type' );
	if( $terms ){
		$term = array_shift( $terms );

		$object_type = $term->term_id;
	}
}

get_header();
/* Template Name: Частное жильё */
?>

<div class="headLine"></div>
<div class="wrapper">
<div class="breadcrumbs" itemscope="" itemtype="http://schema.org/BreadcrumbList"><span itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a class="breadcrumbs__link" href="https://krymking.ru/" itemprop="item"><span itemprop="name">Главная</span></a><meta itemprop="position" content="1"></span><span class="breadcrumbs__separator"></span><span itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a class="breadcrumbs__link" href="https://krymking.ru/profile/" itemprop="item"><span itemprop="name">Личный кабинет</span></a><meta itemprop="position" content="2"></span><span class="breadcrumbs__separator"></span><span itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a class="breadcrumbs__link" href="https://krymking.ru/profile/add/" itemprop="item"><span itemprop="name">Сдать жильё</span></a><meta itemprop="position" content="3"></span><span class="breadcrumbs__separator"></span><span class="breadcrumbs__current">Размещение объекта</span></div>
	<?//if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();?>  

 	<form class="profile page-wrap create-room" method="post" action="create_object">
 		<input type="hidden" name="action" value="create_object">
 		<input type="hidden" name="object_type" value="<?=$object_type;?>">
 		<input type="hidden" name="post_id" value="<?=$postid;?>">
		<input type="hidden" name="_wp_page_template" value="single-apartment.php">

 		<div class="side-left">
 			<?get_template_part('front/sidebar-room');?>
		</div>

		<div class="side-right">
			<? if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?get_template_part('front/profile-rooms');?>
  			<? endwhile;
  			endif; ?>
		</div>

	</form>
</div>

<?php
get_footer();