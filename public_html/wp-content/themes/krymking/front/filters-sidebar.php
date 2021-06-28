<?
$filters2[] = get_field_object('field_5fd71f7ce412a'); // Расстояние до моря
$filters2[] = array(
	'label' => 'Количество комнат',
	'name'  => 'rooms_count',
	'type'  => 'select',
	'choices' => array(
		'' => 'любое',
		'1' => 'только 1-комнатные',
		'2' => 'не менее 2 комнат',
		'3' => 'не менее 3 комнат',
		'4' => '4 комнаты и более',
	),
	'wrapper' => array(
		'class' => 'collapse'
	),
);
$filters2[] = array(
	'label' => 'Количество кроватей',
	'type'  => 'group',
	'sub_fields' => array(
		array(
			'label' => 'Одноместных',
			'name' => 'single_beds',
			'choices' => array(
				'' => 'Одноместных',
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
			),
		),
		array(
			'label' => 'Двухместных',
			'name'  => 'double_beds',
			'choices' => array(
				'' => 'Двухместных',
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
			),
		),
	),
	'wrapper' => array(
		'class' => ''
	),
);
$filters2[] = array(
	'label' => 'Количество спальных мест',
	'name'  => 'bed_total',
	'type'  => 'select',
	'choices' => array(
		'' => 'любое количество',
		'1' => '1 и более',
		'2' => '2 и более',
		'3' => '3 и более',
	),
	'wrapper' => array(
		'class' => 'collapse'
	),
);
$filters2[] = array(
	'label' => 'Количество санузлов',
	'name'  => 'bathroom_total',
	'type'  => 'select',
	'choices' => array(
		'' => 'любое количество',
		'1' => '1 и более',
		'2' => '2 и более',
		'3' => '3 и более',
	),
	'wrapper' => array(
		'class' => 'collapse'
	),
);
$filters[] = get_field_object('field_5fda110b4e020'); // Удобства в помещении
$filters[] = get_field_object('field_5fdb465a4b1ab'); // Удобства в здании или на территории
$filters[] = get_field_object('field_5fdb4c5719ca0'); // Питание
$filters[] = get_field_object('field_5fdb4cfc7c620'); // Правила проживания
$filters[] = get_field_object('field_5fdb4db77c3bd'); // Услуги
$filters[] = array(
	'label' => 'Условия',
	'name' => 'conditions',
	'type'  => 'checkbox',
	'choices' => array(
		'1' => 'Мгновенное бронирование',
		'2' => 'Быстро отвечают',
	),
	'wrapper' => array(
		'class' => 'collapse'
	),
);
$filters[] = array(
	'label' => 'Оценка по отзывам',
	'name' => 'reviews',
	'type'  => 'radio',
	'choices' => array(
		'all' => 'Все отзывы',
		'5' => 'Отлично = 5 баллов',
		'4' => 'Очень хорошо = 4 балла',
		'3' => 'Хорошо = 3 балла',
		'2' => 'Нормально = 2 балла',
                '1' => 'Плохо = 1 балл',
	//	'0' => 'Нет оценки',
	),
	'wrapper' => array(
		'class' => 'collapse'
	),
);
$filters[] = array(
	'label' => 'Количество звёзд',
	'name' => 'stars',
	'type'  => 'radio',
	'choices' => array(
		'1' => '1 звезда',
		'2' => '2 звезды',
		'3' => '3 звезды',
		'4' => '4 звезды',
		'5' => '5 звёзд',
		'all' => 'без звёзд',
	),
	'wrapper' => array(
		'class' => 'collapse'
	),
);
 
if (!empty($_POST['city'])) {
	$category = $_POST['city'];
} elseif(single_term_title('', false)) {
	$category = single_term_title('', false);
}?>

<?
$args = array(
    'post_type' => 'hotels',
    'posts_per_page' => -1,
    'category__in' => $category->term_id,
);
$query = new WP_Query( $args );
if ( $query->have_posts() ) {
    // Подготовим переменные
    $min_value = false;
    $max_value = false;
    while ( $query->have_posts() ) {
        $query->the_post();
        $value = get_field('price');
        // Определяем минимальное значение
        if ($min_value === false || $value < $min_value) {
            $min_value = $value;
        }
        // Определяем максимальное значение
        if ($max_value === false || $value > $max_value) {
            $max_value = $value;
        }
    }
}
 
?>

<form action="filters" method="post" class="sidebar filters">
	<input type="hidden" name="action" value="filters">

	<input type="hidden" name="adults" value="<?=guests_adults();?>">
	<input type="hidden" name="children" value="<?=guests_childrens();?>">
	<input type="hidden" name="babies" value="<?=guests_babies();?>">
	<input type="hidden" name="term_id" value="<?=get_queried_object()->term_id;?>">


	<div class="search-form-top">
		<div class="search-title sidebar-title">Найти жильё</div>
		<div class="sidebar-form-content">
			<div class="form-field search-terms">
				<input type="text" name="category" placeholder="Город или курорт" value="<?=$category;?>" autocomplete="off" class="suggest-input text-field">
				<div class="search-suggest"></div>
			</div>
			<div class="form-field">
				<input type="text" name="check_in" placeholder="Заезд" value="<?=$_SESSION['check_in'];?>" autocomplete="off" class="text-field datepicker">
			</div>
			<div class="form-field">
				<input type="text" name="check_out" placeholder="Выезд" value="<?=$_SESSION['check_out'];?>" autocomplete="off" class="text-field datepicker">
			</div>
			<div class="form-field">
				<input type="text" name="counts_guests" value="<?=guests();?>" placeholder="Количество гостей" value="<?=$_POST['counts_guests'];?>" autocomplete="off" class="text-field">
			</div>
			<div class="form-field">
				<input type="submit" value="Найти жильё" class="btn btn-submit">
			</div>
		</div>
	</div>
	<div class="aside-content show-map">
		<div class="sidebar-title">Скрыть карту</div>
		<img src="<?=get_template_directory_uri();?>/images/sidebar-map.png" alt="Показать карту">
	</div>
	<div class="aside-content search-filters">
		<div class="filter">
			<div class="sidebar-title">Цена за ночь</div>

			<div class="switcher">
				<div id="budget"></div>
				<span class="switcher-text">Установить <br> свой бюджет</span>
			</div>
			<input type="text" name='budget' id="val" value="0">
			<!-- <div class="price-slider">
				<div id="budget"></div>

				<div class="filter-price">
					от
					<input type="text" class="filter-input price-min" name="price_min" value="0">
					до
					<input type="text" class="filter-input price-max" name="price_max" value="<?=$max_value;?>">
				</div>
			</div> -->

			<div class="filter-options">
				<label class="filter-option filter-option-first">
					<input type="radio" name="price" value="0 AND 1000" class="custom-input">
					<div class="check"></div>
					<div class="filter-text">от 0 до 1000 руб.</div>
				</label>
				<label class="filter-option">
					<input type="radio" name="price" value="1000 AND 3000" class="custom-input">
					<div class="check"></div>
					<div class="filter-text">от 1000 до 3000 руб.</div>
				</label>
				<label class="filter-option">
					<input type="radio" name="price" value="3000 AND 5000" class="custom-input">
					<div class="check"></div>
					<div class="filter-text">от 3000 до 5000 руб.</div>
				</label>
				<label class="filter-option">
					<input type="radio" name="price" value="5000 AND 10000" class="custom-input">
					<div class="check"></div>
					<div class="filter-text">от 5000 до 10000 руб.</div>
				</label>
				<label class="filter-option">
					<input type="radio" name="price" value="10000 AND 100000" class="custom-input">
					<div class="check"></div>
					<div class="filter-text">свыше 10000 руб.</div>
				</label>
			</div>
		</div>
		<?$taxonomies = get_terms(array(
		    'taxonomy'   => 'type',
		    'count'      => true,
		    'hide_empty' => false,
		    'order' => 'DESC',
		) );  
		
		if ($taxonomies) {?>
		<div class="filter">
			<div class="sidebar-title">Типы жилья</div>
			<div class="filter-options">
		    <?foreach($taxonomies as $category){ 
		        if($category->parent == 0){?>
			        <?foreach($taxonomies as $subcategory){?>
			            <?if($subcategory->parent == $category->term_id){?>
							<label class="filter-option">
								<input type="checkbox" name="type_hotels[]" value="<?=$subcategory->term_id?>" class="custom-input" <?=$subcategory->term_id == $_GET['type'] ? 'checked' : '' ?>>
								<div class="check"></div>
								<div class="filter-text"><?=$subcategory->name;?></div>
							</label>
			            <? } ?>
			        <? } ?>
		        <? } ?>
		    <? } ?>
			</div>
		</div>
		<? } ?>

 
		<div class="filter filter-rooms">
		<? foreach ($filters2 as $filter) { ?>
 

 			<div class="sidebar-title <?=$filter['wrapper']['class'];?>"><?=$filter['label'];?></div>

 			<div class="filter-options <?=$filter['wrapper']['class'];?>">

			<?if ($filter['type'] == 'select') { ?>

				<select name="<?=$filter['name'];?>" class="form-control">
					<?foreach ($filter['choices'] as $field_key => $field_value) { ?>
						<option value="<?=$field_key;?>"><?=$field_value;?></option>
					<?}?>
				</select>

			<? } elseif ($filter['type'] == 'group') { ?>
				<?foreach ($filter['sub_fields'] as $sub_fields) { ?>
					<select name="<?=$sub_fields['name'];?>" class="form-control">
						<?foreach ($sub_fields['choices'] as $field_key => $field_value) { ?>
							<option value="<?=$field_key;?>"><?=$field_value;?></option>
						<?}?>
					</select>
				<? } ?>
			<? } ?>

			</div>
 
		<? } ?>
		</div>

		<? foreach ($filters as $filter) { ?>
		<div class="filter">

 			<div class="sidebar-title <?=$filter['wrapper']['class'];?>"><?=$filter['label'];?></div>

 			<div class="filter-options <?=$filter['wrapper']['class'];?>">

			<?if ($filter['type'] == 'select') { ?>

				<select name="<?=$filter['name'];?>" class="form-control">
					<?foreach ($filter['choices'] as $field_key => $field_value) { ?>
						<option value="<?=$field_key;?>"><?=$field_value;?></option>
					<?}?>
				</select>

			<? } else { ?>

				<?foreach ($filter['choices'] as $field_key => $field_value) { ?>
				<label class="filter-option">
					<input type="<?=$filter['type'];?>" name="<?=$filter['name'];?>[]" value="<?=$field_key;?>" class="custom-input">
					<div class="check"></div>
					<div class="filter-text"><?=$field_value;?></div>
				</label>
				<? } ?>

			<? } ?>
			</div>

		</div>
		<? } ?>
		<div class="filter">
			<div class="btn btn-view">Убрать все фильтры</div>
		</div>
	</div>
</form>



<script type="text/javascript">
$('#budget').slider({
	min: 0,
	max: <?=$max_value;?>,
	value: 0,
	slide: function(event, ui){
		$('#val').val(ui.value);
	}
});
</script>