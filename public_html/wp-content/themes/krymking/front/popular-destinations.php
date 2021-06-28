<h2 class="title">Популярные места отдыха в Крыму</h2>

<div class="popular-destinations">
	
	<?php global $_TAXONOMIES_POPULAR ?>
	
	<?php if(get_field('popular_destinations') ) $DEST = get_field('popular_destinations')?>
	
		<?php foreach ($DEST as $key => $term):?>
				
            <div class="item">
                <div class="item-content">
                    <a href="<?=get_category_link($term->term_id);?>">
                        <img src="<?=get_field('image', 'category_' . $term->term_id)['url']?>" alt="<?=$term->name?>">
                        <div class="item-details">
                            <div class="item-title"><?=$term->name?></div>
                            <div class="item-subtitle"><?=num_word($_TAXONOMIES_POPULAR[$term->term_id]->objectsCount, array("объект", "объекта", "объектов"));?></div>
                        </div>
                    </a>
                </div>
            </div>
			
		<?php endforeach; ?>
	
    <div class="item item-popup">
        <div class="item-content">
                <img src="<?=get_template_directory_uri();?>/images/object-8.png" alt="Все города">
                <div class="item-details">
                    <div class="item-title center">Все города <br> Крыма</div>
                </div>
        </div>
    </div>
    <div class="sub-category sub-category-popup" style="display:none">
	    <?php foreach($_TAXONOMIES_POPULAR as $category):?>
		    <?php if($category->parent == 0){?><?php if($category->term_id !== 9) {?>
			    <div class="category-item"><a href="<?=get_category_link($category->term_id);?>" class="category-name"><?=$category->name;?></a></div>
			    <?php
		    }?><?php foreach($_TAXONOMIES_POPULAR as $subcategory){?><?php if($subcategory->parent == $category->term_id){?>
			    <div class="category-item"><a href="<?=get_category_link($subcategory->term_id);?>" class="category-name"><?=$subcategory->name;?></a></div>
		    <?php } ?><?php } ?><?php
		    }?>
	    <?php endforeach;?>
    </div>
</div>
