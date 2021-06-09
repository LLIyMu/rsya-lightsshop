<h2 class="title">Популярные места отдыха в Крыму</h2>

<div class="popular-destinations">
    <? if(get_field('popular_destinations') ){ $DEST = get_field('popular_destinations')?>
        <? foreach (get_field('popular_destinations') as $term){ ?>
            <?php

            $args = array(
                'post_type' => 'hotels',
                'hotel'=> $term->slug,
                'numposts' => 0
            );

            $query = new WP_Query;

            $Aposts = $query->query($args);
            
            ?>
            <div class="item">
                <div class="item-content">
                    <a href="<?=get_category_link($term->term_id);?>">
                        <img src="<?=get_field('image', 'category_' .$term->term_id)['url']?>" alt="<?=$term->name?>">
                    
                        <div class="item-details">
                            <div class="item-title"><?=$term->name?></div>
                            <div class="item-subtitle"><?=num_word(count($Aposts), array("объект", "объекта", "объектов") );?></div>
                        </div>
                    </a>
                </div>
            </div>
        <? } ?>
    <? } ?>
    <div class="item item-popup">
        <div class="item-content">
                <img src="<?=get_template_directory_uri();?>/images/object-8.png" alt="Все города">
                <div class="item-details">
                    <div class="item-title center">Все города <br> Крыма</div>
                </div>
        </div>
    </div>
    <div class="sub-category sub-category-popup" style="display:none">
            <? $taxonomies = get_terms(array(
                'taxonomy'   => 'hotel',
                'count'      => true,
                'hide_empty' => false,
                'orderby' => 'sort_order',
                'order' => 'ASC',
            ) );  
            if (!empty($taxonomies)) { 
                foreach($taxonomies as $category){ 
                if($category->parent == 0){?>
                    <?if($category->term_id !== 9) {?>
                    <div class="category-item"><a href="<?=get_category_link($category->term_id);?>" class="category-name"><?=$category->name;?></a></div>
                    <?}?>
                    <?foreach($taxonomies as $subcategory){?>
                    <?if($subcategory->parent == $category->term_id){?>
                        <div class="category-item"><a href="<?=get_category_link($subcategory->term_id);?>" class="category-name"><?=$subcategory->name;?></a></div>
                    <? } ?>
                    <?} ?>
                <?} 
                }
            } ?>
        </div>
</div>
