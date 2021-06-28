<?php
	
 global $_CATEGORIES;

?>

<ul class="categories">
	<?php foreach($_CATEGORIES as $key => $item):?>
		<li data-id="<?=$key?>"><?=$item?></li>
	<?php endforeach;?>
</ul>