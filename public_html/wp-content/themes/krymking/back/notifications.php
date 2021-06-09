<?function get_notifications($field){?>
	<div class="form-section-title"><?=$field['label'];?></div>
	<?foreach ($field['sub_fields'] as $value) { ?>
	<div class="input-group flexbox notification-settings">
		<label class="input-title"><?=$value['label'];?></label>
		<div class="custom-wrap">
			<?foreach ($value['choices'] as $val) { ?>
			<div class="custom-item">
				<label class="custom-checkbox">
					<input type="checkbox" name="<?=$field['name'];?>[]" class="custom-input">
					<div class="check"></div>
					<span class="label-name"><?=$val;?></span>
				</label>
			</div>
			<? } ?>
		</div>
	</div>
	<? } ?>
<?}