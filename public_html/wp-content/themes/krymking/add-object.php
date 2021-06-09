<?php
get_header();
/* Template Name: Сдать жильё */
global $current_user;

?>
<div class="headLine"></div>



<div class="create-object">
	<div class="wrapper">
		<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
	 	<div class="object-info">
	 		<div class="object-image">
	 			<img src="<?=get_template_directory_uri();?>/images/add-obj.png" alt="Сдать жильё">
	 		</div>
	 		<h4>Вы хотите сдать жильё? <br> <span>Сдавайте удобно и с удовольствием!</span></h4>
	 	</div>
	 	<h2 class="object-title"><i class="icon-type"></i> Какое жильё Вы сдаёте?</h2>

	 	<form action="<?=home_url("/profile/add/object/");?>" method="post">

		 	<div class="object-content">
			<? $taxonomies = get_terms(array(
			    'taxonomy'   => 'type',
			    'count'      => true,
			    'hide_empty' => false,
			    'order' => 'ASC',
			) );  
			if (!empty($taxonomies)) { 
			    foreach($taxonomies as $category){ 
			        if($category->parent == 0){?>
		 				<div class="object-type">
		 					<div class="object-type-title"><i class="icon-<?=$category->slug;?>"></i><?=$category->name;?></div>
				            <?foreach($taxonomies as $subcategory){?>
				                <?if($subcategory->parent == $category->term_id){?>
				                	<div class="input-group">
										<label class="custom-radio form-control">
											<input type="radio" name="object_type" value="<?=$subcategory->term_id;?>" required>
											<div class="label-name"><?=$subcategory->name;?></div>
										</label>
										<div class="object-type-info"><?=$subcategory->description;?></div>
				                	</div>
				                <? } ?>
				            <?} ?>
			 			</div>
			        <?} 
			    }
		    } ?>
 		 	</div>

		 	<h2 class="object-title"><i class="icon-point"></i> Где в крыму находится ваш объект?</h2>
		 	<div class="object-content section-gray">
		 		<div class="input-group">
					<label class="input-title">Выберите регион</label>
					<?=region();?>
				</div>
		 		<div class="input-group">
					<label class="input-title">Выберите город или курорт</label>
					<?=city();?>
				</div>
		 	</div>
			<div class="navigation">
				<input type="submit" value="Далее" class="btn btn-next">
			</div>
		</form>
	</div>
</div>
 

<?php
get_footer();