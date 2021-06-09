<?
function main_fields($fields_acf){
	foreach ($fields_acf as $field) { ?>
	<div class="input-group <?=$field['type'];?>-type field-<?=$field['name'];?>">

		<label class="input-title title-<?=$field['type'];?>"><?=$field['label'];?> <?if($field['required']) echo "<span class='required'>*</span>";?></label>

		<?if($field['type'] == 'select'){?>

			<select name="<?=$field['name'];?>" class="form-control">
				<option value="">- Выбрать -</option>
				<?foreach ($field['choices'] as $field_key => $field_value) { ?>
					<option value="<?=$field_key;?>" <?if($field_key == $field['value']['value']) echo "selected";?>><?=$field_value;?></option>
				<?}?>
			</select>

		<?}elseif($field['type'] == 'group'){?>

			<?foreach ($field['sub_fields'] as $fields){?>

				<?if ($fields['type'] == 'select') {?>

					<select name="<?=$field['name'];?>[<?=$fields['name'];?>]" class="form-control">
						<option value="">- Выбрать -</option>
						<?foreach ($fields['choices'] as $field_key => $field_value) { ?>
							<option value="<?=$field_key;?>" <?if($field_value == $field['value'][$fields['name']]) echo "selected";?>><?=$field_value;?></option>
						<?}?>
					</select>

				<?}elseif ($fields['type'] == 'radio'){?>

					<div class="input-group">
						<label class="input-title"><?=$fields['label'];?> <?if($fields['required']) echo "<span class='required'>*</span>";?></label>
						<?foreach ($fields['choices'] as $field_key => $field_value) { ?>
							<label class="custom-radio form-control">
								<input type="radio" name="<?=$field['name'];?>[<?=$fields['name'];?>]" value="<?=$field_key;?>" <?if ($field_key == $field['default_value'] || $field_key == $field['value'][$fields['name']]) {echo 'checked';}?>>
								<div class="label-name"><?=$field_value;?></div>
							</label>
						<?}?>
					</div>

				<?} else {?>

					<input type="number" name="<?=$field['name'];?>[<?=$fields['name'];?>]" value="<?=$field['value'][$fields['name']];?>" placeholder="<?=$fields['label'];?>" class="form-control" <?if($fields['required']) echo "required";?>>

				<?}?>
			<?}?>

		<?}elseif($field['type'] == 'radio'){?>

			<?foreach ($field['choices'] as $field_key => $field_value) { ?>
				<label class="custom-radio form-control">
					<input type="radio" name="<?=$field['name'];?>" value="<?=$field_key;?>" <?if ($field_key == $field['default_value'] || $field_key == $field['value']) {echo 'checked';}?>>
					<div class="label-name"><?=$field_value;?></div>
				</label>
			<?}?>

		<?}elseif ($field['type'] == 'checkbox'){?>

			<?if ($field['title']) {?>
			<label class="input-title"><?=$field['title'];?> <?if($field['required']) echo "<span class='required'>*</span>";?></label>
			<?}?>
 
			<?foreach ($field['choices'] as $field_key => $field_value) { ?>
				<label class="custom-checkbox">
					<input type="checkbox" name="<?=$field['name'];?>[]" class="custom-input" value="<?=$field_key;?>" <?if ($field['value'][array_search($field_value, $field['value'])] == $field_value) {echo 'checked';}?> >
					<div class="check"></div>
					<span class="label-name"><?=$field_value;?></span>
				</label>
			<?}?>

		<?}elseif ($field['type'] == 'repeater') {
		$total = 0;   
		$total = count($field['value']);
		?>

			<div class="repeater-list">
				<?for($i = 0; $i < $total; $i++){?>
				<div class="repeater-item">
				<?foreach ($field['sub_fields'] as $sub_field){ ?>
					<label class="input-title"><?=$sub_field['label'];?></label>
					<?if ($sub_field['type'] == 'select') {?>
						<select name="<?=$field['name'];?>[<?=$i;?>][<?=$sub_field['name'];?>]" class="form-control">
							<option value="">- Выбрать -</option>
							<?foreach ($sub_field['choices'] as $field_key => $field_value) {  ?>
								<option value="<?=$field_key;?>" <?if($field_key == $field['value'][$i][$sub_field['name']]['value']) echo "selected";?>><?=$field_value;?></option>
							<?}?>
						</select>
					<?}elseif ($sub_field['type'] == 'number') {?>
						<input type="<?=$sub_field['type'];?>" name="<?=$field['name'];?>[<?=$i;?>][<?=$sub_field['name'];?>]" value="<?=$field['value'][$i][$sub_field['name']];?>" class="form-control">
					<?}?>
				<?}?>
				<div class="button remove-repeater">×</div>
				</div>
				<?}?>
			</div>

			<div class="btn btn-add b-<?=$field['name'];?>">+ <?=$field['button_label'];?></div>

			<script type="text/javascript">
			jQuery(document).ready(function($){
				
	 
				$(document).on('click', '.remove-repeater', function() {
					$(this).parent().remove();
				});
				
				var count = <?=$total;?>;

			 $('.b-<?=$field['name'];?>').on('click', function() {
					html  = '<div class="repeater-item">';	
					<?foreach ($field['sub_fields'] as $fields){?>
						html += '<label class="input-title"><?=$fields['label'];?></label>';
						<?if ($fields['type'] == 'select') {?>
							html += '<select name="<?=$field['name'];?>['+count+'][<?=$fields['name'];?>]" class="form-control">';
								html += '<option value="">- Выбрать -</option>';
								<?foreach ($fields['choices'] as $field_key => $field_value) {  ?>
									html += '<option value="<?=$field_key;?>"><?=$field_value;?></option>';
								<?}?>
							html += '</select>';
						<?}elseif ($fields['type'] == 'number') {?>
							html += '<input type="<?=$fields['type'];?>" name="<?=$field['name'];?>['+count+'][<?=$fields['name'];?>]" class="form-control">';
						<?}?>
					<?}?>
				    html += '<div class="button remove-repeater">×</div>';
					html += '</div>';	
					
					$(this).parents('.input-group').find('.repeater-list').append(html);
					
					count++;
			});
	 
			});
			</script>

		<?}elseif ($field['type'] == 'textarea') {?>
			<div class="textarea-field">
				<textarea name="<?=$field['name'];?>" maxlength="<?=$field['maxlength'];?>" rows="<?=$field['rows'];?>" placeholder="<?=$field['placeholder'];?>" class="form-control <?=$field['type'];?>"><?=$field['value'];?></textarea>
				<?if ($field['maxlength']) {?>
					<div class="count"><?=$field['maxlength'];?></div>
				<?}?>
			</div>
		<?}else{?>
			<input type="<?=$field['type'];?>" name="<?=$field['name'];?>" value="<?=$field['value'];?>" class="form-control <?=$field['type'];?>" <?if($field['required']) echo "required";?>>
		<?}?>
	</div>
	<?}
}