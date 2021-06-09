<div class="main-search">
	<form class="search-form" action="/hotels/" method="post">
		<input type="hidden" name="action" value="main_search">
		
		<input type="hidden" name="adults" value="<?=guests_adults();?>">
		<input type="hidden" name="children" value="<?=guests_childrens();?>">
		<input type="hidden" name="babies" value="<?=guests_babies();?>">

		<div class="search-content">
			<div class="search-field">
				<input type="text" name="city" placeholder="Город или курорт" autocomplete="off" class="suggest-input text-field" required >
				<span class="icon-point"></span>
				<ul class="search-suggest"></ul>
				<span class="message error"></span>
			</div>
			<div class="search-field">
				<span class="search-label">Заезд</span>
				<input type="text" name="check_in" placeholder="Когда?" autocomplete="off" class="datepicker date text-field" required >
				<span class="icon-date"></span>
				<span class="clear-dates" title="Очистить поле">×</span>
			</div>
			<div class="search-field">
				<span class="search-label">Выезд</span>
				<input type="text" name="check_out" placeholder="Когда?" autocomplete="off" class="datepicker date text-field" required >
				<span class="icon-date"></span>
				<span class="clear-dates" title="Очистить поле">×</span>
			</div>
			<div class="search-field">
				<span class="search-label">Количество гостей</span>
				<input type="text" name="counts_guests" value="<?=guests();?>" placeholder="Кто едет?" autocomplete="off" class="text-field" required >
				<span class="icon-guest"></span>
			</div>
			<div class="search-field">
				<input type="submit" value="Найти жильё" class="btn-search">
			</div>
		</div>
	</form>
</div>