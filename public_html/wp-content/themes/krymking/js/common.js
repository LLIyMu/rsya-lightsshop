jQuery(document).ready(function ($) {
	$(window).on("scroll", function() {
		if ($(window).scrollTop() > 100) {
			$('header').addClass('fixed');
		} else {
			$('header').removeClass('fixed');
		}
	});

	function popup(name) {
 		$('.popup-'+name).fadeIn();
 		$('.overlay').fadeIn();
	}

	function hint(th, name) {
	  	var ypos = $(this).offset().top+37;
	  	var xpos = $(this).offset().left;
	  	var RealHint =  $(this).data('hint');
	  	$(RealHint).css('top',ypos);
	  	$(RealHint).css('left',xpos);
	  	$(RealHint).toggle('fast'); 
	}

	$(document).on("click", 'input[name="counts_guests"]', function() {
 		popup('guests');

	  	var ypos = $(this).offset().top+57;
	  	var xpos = $(this).offset().left;
	  	$('.popup-guests').css('top',ypos);
	  	$('.popup-guests').css('left',xpos);
	});
	$(document).on("click", '.btn-help', function() {
 		popup('help');

	  	var xpos = $(this).offset().left;
	  	$('.popup-help').css('left',xpos);

	  	$('html, body').animate({ scrollTop: 0 }, 'slow');
	});
	$(document).on("click", '.btn-login, .link-auth', function() {
 		popup('auth');

 		$('html, body').animate({ scrollTop: 0 }, 'slow');
	});
	$(document).on("click", '.btn-register, .link-registr', function() {
 		popup('register');

 		$('html, body').animate({ scrollTop: 0 }, 'slow');
	});
	$(document).on("click", '.categories li', function() {
		let id = $(this).attr('data-id');
		
		$('.popup-'+id).fadeIn();
		$('.overlay').fadeIn();
 		// popup('objects');

 		return false;
	});
	$(document).on("click", '.btn-currency', function() {
 		popup('currency');
	});
	$(document).on("click", '.flag', function() {
 		popup('language');
	});

	$(document).on("click", '.text-register span', function() {
 		popup('register');
 		$('.popup-auth').fadeOut();
	});
	$(document).on("click", '.forgot-password', function() {
 		popup('forgot');
 		$('.popup-auth').fadeOut();
	});
	$(document).on("click", 'header .user-name', function() {
 		popup('lk');
	});
	$(document).on("click", '.phone .arrow', function() {
 		popup('tel');
	});
	$(document).on("click", '.owner-phone', function() {
 		popup('owner');

	  	var ypos = $(this).offset().top-70;
	  	var xpos = $(this).offset().left-28;
	  	$('.popup-owner').css('top',ypos);
	  	$('.popup-owner').css('left',xpos);
	});


	$(document).on("click", '.overlay, .popup-close', function() {
 		$('.popup').fadeOut();
 		$('.overlay').fadeOut();
	});


	$(document).on("click", '.login-text span', function() {
 		$('.popup').fadeOut();
 		$('.overlay').fadeOut();
 		$.fancybox.close();

 		popup('auth');

 		$('html, body').animate({ scrollTop: 0 }, 'slow');
	});


	$(document).on("click", '.booking-form .btn-register', function() {
		return false;
	});


    $('.btn-minus').click(function() {
    	var value = $(this).parents('.guest-item').find('.value').val();
  		if (value == 0) return;
  		value--;
    	$(this).parents('.guest-item').find('.value').val(value);
    });

    $('.btn-plus').click(function() {
    	var value = $(this).parents('.guest-item').find('.value').val();
       value++;
       $(this).parents('.guest-item').find('.value').val(value);
    });


    $('.quantity .btn-controls').click(function() {
    	var q = $('.adults input[name="quantity"]').val() + ' взрослые, ' + $('.children input[name="quantity"]').val() + ' дети, ' + $('.babies input[name="quantity"]').val() + ' младенцы';
    	    val = $(this).parents('.guest-item').find('.value').val();
  		$('input[name="counts_guests"]').val(q);

  		$('input[name="adults"]').val($('.adults input[name="quantity"]').val());
  		$('input[name="children"]').val($('.children input[name="quantity"]').val());
  		$('input[name="babies"]').val($('.babies input[name="quantity"]').val());
    });

    $('.btn-controls').click(function() {
    	var q = 0;
		$('.guest-item').each(function() {
			q += parseFloat($(this).find('input[name=quantity]').val());
		});
		$('input[name="guests"]').val(q);
    });
 		
    $('.currency-list li').click(function() {
    	$('.currency-list li').removeClass('active');
    	$(this).addClass('active');
    });

    $('.sort-menu .sort-option').click(function() {
    	$('.sort-menu .sort-option').removeClass('active');
    	$(this).addClass('active');
    });

    $('.btn-switch').click(function() {
    	$(this).toggleClass('active');

    	$('.price-slider').slideToggle();
    });

	var dates = $("input[name='check_in'], input[name='check_out']");
    $('.clear-dates').on('click', function(){
		dates.attr('value', '');
		dates.each(function(){
		    $.datepicker._clearDate(this);
		});

		$('.search-form .text-field.date').val('Когда');
		$('.clear-dates').fadeOut();
    });

    $(document).on('click', '.search-suggest li', function() {
    	$('.suggest-input').val($(this).text());
    	$('.search-form').attr('action', $(this).attr('data-link'));
    	$('.search-suggest').html('');
    });

 	$('.suggest-input').keyup(function() {
 		if ($(this).val().length > 2) {
	 		$.ajax({
				url : '/wp-admin/admin-ajax.php',
				type: "POST",
				data: {
					'action' : 'search_suggest',
					'suggest' : $(this).val()
				},
				success:function(result){
					$('.search-suggest').html(result);
				}
			});
 		}
    });

    $(document).on('click', '.search-terms .search-suggest li', function() {
    	let url = $(this).attr('data-link');
		location.href = url;
    });

 	$(document).on('click', '.edit-link', function() {
 		let th = $(this).parents('.edit-info');
	 	$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType: "json",
			data: {
				'action' : 'edit_field',
				'field' : th.find('input').attr('name'),
				'val' : th.find('input').val(),
			},
			success:function(result){
				if (result.status) {
					th.find(".message").html(result.message);
					if (result.status == 'success'){
						th.find(".message").removeClass("error");
						th.find(".message").addClass("success");
					} else {
						th.find(".message").removeClass("success");
						th.find(".message").addClass("error");
					}
				}
			}
		});
    });
 

	$(document).on('click', '.booking-confirm', function() {
		$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType: "html",
			data: {
				'action' : 'booking_confirmed',
				'post_id' : $(this).parents('.booking-item').attr('data-id'),
				'status' : 'confirmed',
			},
			success:function(result){
				window.location.reload();
			}
		});
	});

	$(document).on('click', '.booking-cancel', function() {
		$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType: "html",
			data: {
				'action' : 'booking_canceled',
				'post_id' : $(this).parents('.booking-item').attr('data-id'),
				'status' : 'canceled',
			},
			success:function(result){
				window.location.reload();
			}
		});
	});
    
	let count = $('.offers-list .offer-item').length;
	if ( count > 4 || $(window).width() < 1200) {
		$('.offers-list').slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			dots: false,
			arrows: true,
			infinite: false,
			responsive: [ {
				breakpoint: 1200,
				settings: {
				slidesToShow: 4,
				}
			}, {
				breakpoint: 1024,
				settings: {
				slidesToShow: 3,
				}
			}, {
				breakpoint: 768,
				settings: {
				slidesToShow: 2,
				}
			}, {
				breakpoint: 500,
				settings: {
				slidesToShow: 1,
				}
			} 
			]
		});
	}

	$('.slider').slick({
		dots: true,
		infinite: true,
		fade: true,
		cssEase: 'linear',
  		autoplay: true,
  		autoplaySpeed: 4000,
  		dots: false,
  		arrows: false
	});

	$('.booking-gallery').slick({
		dots: false,
		arrows: true,
		infinite: false,
	});

	$(".booking-gallery").on("afterChange", function(event, slick, currentSlide, nextSlide){
	    $(".counts-slides .current").text(currentSlide + 1);
	});

	function slider() {
		$('.room-slider').slick({
			dots: false,
			arrows: false,
			infinite: false,
		});
		$(".room-slider").on("afterChange", function(event, slick, currentSlide, nextSlide){
		    $(".counts-slides .current").text(currentSlide + 1);
		});
	}

 	$(document).on('click', '.variants-rooms .room-more', function() {
 		$(this).toggleClass('active');
 		$(this).parents('.room-item').find('.room-desc').slideToggle();

		$(this).text($(this).is('.active') ? 'Скрыть о номере' : 'Подробнее о номере'); 
    });

 	$(document).on('click', '.room-collapse', function() {
		 
 		$(this).toggleClass('active');
    	$(this).text($(this).is('.active') ? 'Свернуть' : 'Подробнее');
    	$(this).parents('.room-item').find('.room-wrap').slideToggle();

		$('.room-slider').slick('setPosition');

		$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType: "html",
			data: {
				'action' : 'booking_form',
				'post_id' : $('input[name="post_id"]').val(),
				'room_id' : $(this).parents('.room-item').attr('data-id'),
			},
			beforeSend: function( xhr){
				$('.booking-form.ajax').html('');
				$('.booking-form.ajax').append('<div class="spinner"></div>');
			},
			success:function(result){
				$('.booking-form.ajax').html(result);

				var date = new Date();
				date.setDate(date.getDate());
			$('.datepicker').datepicker({
				closeText: 'Закрыть',
				prevText: 'Предыдущий',
				nextText: 'Следующий',
				currentText: 'Сегодня',
				monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
				monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
				dayNamesMin: ['Пн','Вт','Ср','Чт','Пт','Сб','Вс'],
				range: 'period',
				dateFormat: "dd.mm.yy",
				numberOfMonths: 2,
				minDate: date,
				onSelect: function(dateText, inst, extensionRange) {
		
					$('[name=check_in]').val(extensionRange.startDateText);
					$('[name=check_out]').val(extensionRange.endDateText);
		
					   var start = new Date(extensionRange.startDate);
						end = new Date(extensionRange.endDate);
						days = (end - start) / 1000 / 60 / 60 / 24;
		
					$('[name=days]').val(days);
					$('.clear-dates').fadeIn();
		
					data_param();
		
		
					if (extensionRange.startDateText != extensionRange.endDateText) {
						$('.overlay').fadeOut();
						$('.ui-datepicker-multi-2').hide();
		
						$.ajax({
							url : '/wp-admin/admin-ajax.php',
							type: "POST",
							dataType: "html",
							data: {
								'action' : 'payment_calc',
								'price' : $('.booking-form input[name="price"]').val(),
								'days' : days
							},
							success:function(result){
			
								$('.ajax-calc').html(result);
			
							}
						});
			
						$.ajax({
							url : '/wp-admin/admin-ajax.php',
							type: "POST",
							dataType: "html",
							data: {
								'action' : 'hotel_room',
								'post_id' : $('input[name="post_id"]').val(),
								'room_id' : $('input[name="room_id"]').val(),
							},
							beforeSend: function( xhr){
								$('.variants-rooms.ajax').html('');
								$('.variants-rooms.ajax').append('<div class="spinner"></div>');
							},
							success:function(result){
								setTimeout(function(){
									$('.variants-rooms.ajax').html(result);
		
									slider();
								}, 800);
							}
						});
		
						$('html, body').animate({scrollTop: ($('#available-rooms').offset().top)-100}, 800);
					}
				},
				beforeShow : function(){
					$('.overlay').fadeIn();
				}
			});

			}
		});
    	
    });

	$(document).on('click', '.param-collapse', function() {
		$(this).parents('.room-parameters').find('.hidden').slideToggle();

		$(this).toggleClass('active');
    	$(this).text($(this).is('.active') ? 'Свернуть' : 'Подробнее');
	});

	slider();

 	function data_param() {
		$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType: "html",
			data: {
				'action' : 'data_param',
				'counts_guests' : $('input[name="counts_guests"]').val(),
				'check_in' : $('input[name="check_in"]').val(),
				'check_out' : $('input[name="check_out"]').val(),
				'adults' : $('input[name="adults"]').val(),
				'children' : $('input[name="children"]').val(),
				'babies' : $('input[name="babies"]').val(),
			},
			success:function(result){
				console.log(result);
			}
		});
 	}

	$('input[name="check_in"], input[name="check_out"], input[name="counts_guests"]').on("change", function(){
		data_param();
	});
	$(document).on('click', '.quantity .btn-controls', function() {
		data_param();
	});

	var date = new Date();
		date.setDate(date.getDate());
	$('.datepicker').datepicker({
		closeText: 'Закрыть',
		prevText: 'Предыдущий',
		nextText: 'Следующий',
		currentText: 'Сегодня',
		monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
		monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
		dayNamesMin: ['Пн','Вт','Ср','Чт','Пт','Сб','Вс'],
		range: 'period',
		dateFormat: "dd.mm.yy",
		numberOfMonths: 2,
		minDate: date,
		onSelect: function(dateText, inst, extensionRange) {

			$('[name=check_in]').val(extensionRange.startDateText);
			$('[name=check_out]').val(extensionRange.endDateText);

       		var start = new Date(extensionRange.startDate);
        		end = new Date(extensionRange.endDate);
        		days = (end - start) / 1000 / 60 / 60 / 24;

			$('[name=days]').val(days);
			$('.clear-dates').fadeIn();

			data_param();


			if (extensionRange.startDateText != extensionRange.endDateText) {
				$('.overlay').fadeOut();
				$('.ui-datepicker-multi-2').hide();

				$.ajax({
					url : '/wp-admin/admin-ajax.php',
					type: "POST",
					dataType: "html",
					data: {
						'action' : 'payment_calc',
						'price' : $('.booking-form input[name="price"]').val(),
						'days' : days
					},
					success:function(result){
	
						$('.ajax-calc').html(result);
	
					}
				});
	
				$.ajax({
					url : '/wp-admin/admin-ajax.php',
					type: "POST",
					dataType: "html",
					data: {
						'action' : 'hotel_room',
						'post_id' : $('input[name="post_id"]').val(),
						'room_id' : $('input[name="room_id"]').val(),
					},
					beforeSend: function( xhr){
						$('.variants-rooms.ajax').html('');
						$('.variants-rooms.ajax').append('<div class="spinner"></div>');
					},
					success:function(result){
						setTimeout(function(){
							$('.variants-rooms.ajax').html(result);

							slider();
						}, 800);
					}
				});

				$('html, body').animate({scrollTop: ($('#available-rooms').offset().top)-100}, 800);
			}
		},
		beforeShow : function(){
			$('.overlay').fadeIn();
		}
	});

	var date = new Date();
		date.setDate(date.getDate());
		
	$('.calendar-season').datepicker({
		monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
		monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
		dayNamesMin: ['Пн','Вт','Ср','Чт','Пт','Сб','Вс'],
		dateFormat: "dd.mm.yy",
		numberOfMonths: 1,
		minDate: date,
		onSelect: function(dateText, inst, extensionRange) {
 			$('.overlay').fadeOut();

 			$('.season-prices').datepicker('setDate', [$('input[name="date_from"]').val(), $('input[name="date_end"]').val()]);
		},
		beforeShow : function(){
			$('.overlay').fadeIn();
		}
	});


 	$('.field-price input[name="price"]').on('change', function() {
 		let price = $(this).val();
 		$('input[name="price_day"]').val(price);
 		$('.season-prices .ui-datepicker td').attr('title', price +' ₽');
 		
    });

 
 	$(document).on('click', '.btn-save', function() {
	 	$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType: "html",
			data: {
				'action' : 'seasonPrices',
				'post_id' : $('input[name="post_ID"]').val(),
				'date_from' : $('input[name="date_from"]').val(),
				'date_end' : $('input[name="date_end"]').val(),
				'price' : $('input[name="price_day"]').val(),
			},
			success:function(result){
				$('.load-prices').html(result);

				$('.season-prices').datepicker('setDate', [$('input[name="date_from"]').val(), $('input[name="date_end"]').val()]);
			}
		});
    });
 
    $(document).on('click', '.disable-month', function() {
    	$(this).toggleClass('active');
    	$(this).text($(this).is('.active') ? 'Разблокировать месяц' : 'Заблокировать месяц'); 

		var month = $(".ui-datepicker-month :selected").val();
		var year = $(".ui-datepicker-year :selected").val();

		$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType: "html",
			data: {
				'action' : 'monthDisabled',
				'post_id' : $('input[name="post_id"]').val(),
				'month' : $.datepicker.formatDate('yy-mm', new Date(year, month, 1))
			},
			success:function(result){
				// console.log(result);
			}
		});

    });

    $('.show-map').on('click', function() {
    	$('.aside-content.show-map .sidebar-title').text($('.side-right').hasClass('show-maps') ? 'Показать карту' : 'Скрыть карту');
		
		$('.side-right').toggleClass('show-maps');
    });

    $('.btn-filter').on('click', function() {
		$('.sidebar.filters').toggleClass('opened');
		$('.overlay-filter').fadeIn();
    });

	$('.overlay-filter').on('click', function() {
		$('.sidebar.filters').removeClass('opened');
		$('.overlay-filter').fadeOut();
	});

	$('.side-right .sort-menu .sort-label').on('click', function() {
		$('.side-right .sort-menu .sort-content').slideToggle();
	});

    function admin_ajax(cl) {
		$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType: "json",
			data: $(cl+" form").serialize(),
            beforeSend: function( xhr){
 
            },
			success:function(result){
				console.log(result);
				if (result.status) {
					$(cl+" .message").html(result.message);				
					
					if (result.status == 'success'){
						$(cl+" .message").removeClass("error");
						$(cl+" .message").addClass("success");
						window.location.reload();
					}
				}
			}
		});
    }

	$('.auth-email form').on("submit", function(){
		admin_ajax('.auth-email');
		return false;
	});

	$('.auth-phone form').on("submit", function(){
		admin_ajax('.auth-phone');
		return false;
	});

	// function validate() {

	// }
 
    $('select[name="currency"]').attr('disabled', 'disabled');

	// Create room
	$(document).on('change', '.create-room *', function() {
		var data = new FormData();
		
		//Form data
		var form_data = $('.create-room').serializeArray();
		$.each(form_data, function (key, input) {
		    data.append(input.name, input.value);
		});
		
		//File data
		var file_data = $('#pro-image')[0].files;
		for (var i = 0; i < file_data.length; i++) {
		    data.append("files[]", file_data[i]);
		}
 
		$.ajax({
			url : '/wp-admin/admin-ajax.php',
			method: "post",
			processData: false,
			contentType: false,
			dataType: "json",
			data: data,
			success:function(result){
				console.log(result);

				$('.message.update-fields').html(result.message);
				
			}
		});

		checkInput();

		return false;
	});

	$('.page-template-new-add .create-room.object-update, .page-template-room .create-room').on("submit", function(){
		var data = new FormData();
		
		//Form data
		var form_data = $('.create-room').serializeArray();
		$.each(form_data, function (key, input) {
		    data.append(input.name, input.value);
		});
		data.append('publish', '1');	
		
		//File data
		var file_data = $('#pro-image')[0].files;
		for (var i = 0; i < file_data.length; i++) {
		    data.append("files[]", file_data[i]);
		}

		$.ajax({
			url : '/wp-admin/admin-ajax.php',
			method: "post",
			processData: false,
			contentType: false,
			dataType: "json",
			data: data,
			success:function(result){
				console.log(result);
				
				if (result.status) {
					if (result.status == 'success') {
						MessagePopup(result.message);
						$('.btn-add').fadeOut();
					}
				}
			}
		});

		return false;
	});

	// $('.bookingForm').on("submit", function(){
	// 	$.ajax({
	// 		url : '/wp-admin/admin-ajax.php',
	// 		type: "POST",
	// 		dataType: "json",
	// 		data: $(".bookingForm").serialize(),
	// 		success:function(result){
	// 			if (result.status) {
	// 				if (result.status == 'success'){
	// 					$('#modal-success .modal-title span').text(result.message);
	// 					$.fancybox.open( $('#modal-success'), {
	// 						touch: false,
	// 					});
	// 					setTimeout(function(){
	// 						history.back();
	// 					}, 2000);
	// 				}
	// 			}
	// 		}
	// 	});
	// 	return false;
	// });


	$('.register-email form').on("submit", function(){
		let cl = '.register-email';
		console.log('sdfs')
  		$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType : "json", 
			data: $(cl+" form").serialize(),
			success:function(result){
				console.log(result);
				if (result.status) {
					$(cl+" .message").html(result.message);
					$(cl+" .message").removeClass("success");
					$(cl+" .message").addClass("error");

					if (result.status == 'success'){
						$(cl+" .message").removeClass("error");
						$(cl+" .message").addClass("success");
						$.fancybox.open( $('#registration-message'), {
							touch: false,
						});
					}
				}
			},
			error: function(res){
				console.log(res);
				alert(res.responseText)
			}
		});

		return false;
	});

	$('.register-phone form input[type="submit"]').click(function(e) {
		$('input[name="submit"]').val($(this).attr('name'));
	});

	$('.register-phone form').on("submit", function(){
		let cl = '.register-phone';
  		$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType : "json", 
			data: $(cl+" form").serialize(),
			success:function(result){
 
				if (result.status) {
					$(cl+" .message").html(result.message);
					$(cl+" .message").removeClass("success");
					$(cl+" .message").addClass("error");

					if (result.status == 'success'){
						$('.code-confirm').fadeIn();
						
						$(cl+" .message").removeClass("error");
						$(cl+" .message").addClass("success");
					}
				}
			}
		});

		return false;
	});
 
 	$('#uploadimage').change(function(){
    	var file_data = $('#uploadimage').prop("files")[0];   
    	var form_data = new FormData();
        form_data.append('action', 'upload_photo');
        form_data.append('my_file_upload', file_data);

 		$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType : "json", 
			data: form_data,
      		processData: false,
      		contentType: false,
			success:function(result){
				console.log(result);
				if (result.status) {
					if (result.status == 'success'){
						window.location.reload();
					}
				}
			}
		});

		return false;
    });

 	$(document).on('click', '.btn-delete', function() {
	 	$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType: "json",
			data: {
				'action' : 'delete_photo',
			},
			success:function(result){
				console.log(result);
				if (result.status) {
					if (result.status == 'success'){
						window.location.reload();
					}
				}
			}
		});
    });

    function nav() {
    	if ($('#location').hasClass('active')) {
    		$('.btn-prev').hide();
    	} else {
    		$('.btn-prev').show();
    	}

    	if ($('#verification').hasClass('active')) {
    		$('.btn-next').hide();
    	} else {
    		$('.btn-next').show();
    	}
    }

    $('.menu-left a').click(function() {
    	$('.menu-left li a').removeClass('active');
 		$(this).addClass('active');
    });

    $('.profile .menu-left a').on('click', function() {
    	$('.form-section').removeClass('active');
 		$($(this).attr('href')).addClass('active');

 		nav();
    });

    nav();

    $('#verification .btn-confirm').on('click', function() {
    	$(this).addClass('active');

		$('input[name="verification"]').val('confirm');
		$('#verification .text-confirm').fadeIn();
    });

    $('.create-room .btn-prev').click(function() {
   		let currentTab = $(".menu-left li a.active");
   		let newTab = currentTab.parents().prev().find('a');

   		newTab.click();

   		nav();
 		$('html, body').animate({ scrollTop: 0 }, 'slow');
    });
    $('.create-room .btn-next').click(function() {
   		let currentTab = $(".menu-left li a.active");
   		let newTab = currentTab.parents().next().find('a');

   		newTab.click();

   		nav();
 		$('html, body').animate({ scrollTop: 0 }, 'slow');
    });


    $('.page-template-create-room .menu-left a, .page-template-create-hotels .menu-left a, .page-template-edit-objects .menu-left a, .page-template-settings-page .menu-left a').click(function() {
    	$('html, body').animate({ scrollTop: 0 }, 'slow');
    });

  //   $('.create-room .btn-next').click(function() {
  //  		var currentTab = $(".menu-left li a.active");
  //  		var newTab = currentTab.parents().next().find('a');
 
		// if (newTab.length === 0) {
		// 	newTab = $(".menu-left li a").first();
		// }

  //  		currentTab.removeClass('active');
  //  		newTab.addClass('active');
 

 	// 	$('.form-section').removeClass('active');
 	// 	$(newTab.attr('href')).addClass('active');

 	// 	$('html, body').animate({ scrollTop: 0 }, 'slow');
  //   });


    $(document).on('click', '.btn-calc', function() {
    	$(this).text($('.payment-calc').is(':visible') ? 'Показать расчёт' : 'Скрыть расчёт');
    	$('.payment-calc').slideToggle();
    });

    function filters() {
 		$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType: "html",
			data: [
				$('.filters').serialize(),
				$.param({
					'sort' : $('.sort-option.active').attr('data-sort'),
					'order' : $('.sort-option.active').attr('data-order'),
				})
			].join('&'),
            beforeSend: function( xhr){
             	$('.ajax').html('');
 				$('.ajax').append('<div class="spinner"></div>');
 				$('html, body').animate({ scrollTop: 0 }, 'slow');
            },
			success:function(result){
				$('.ajax').html(result);
				let vBlock = document.querySelector('.variants-info span')

				if(vBlock){

					vBlock.innerHTML = vBlock.innerHTML.replace(/\d+/, document.querySelectorAll('.ajax .hotel-item').length)

				}
			}
		});
    }

    $('.filters').on(' submit', function() {
		filters();
		return false;
	});

	$('.filters input, .filters select').change(function(){
		filters();
	});

	$('.sort-menu .sort-option').click(function() {
		filters();
	});

 
	$( ".ui-slider.ui-slider-horizontal .ui-slider-handle" ).mouseup(function() {
		filters();
	});


	

	// setTimeout(function(){
	// 	$('.archive .filters .sidebar-form-content .btn-submit').click();
	// }, 800);


    $('.btn-view').click(function() {
    	$('.sidebar-form-content .btn-submit').click();
    	$('input:checked').prop('checked', false);
    	$('select').prop('selectedIndex',0);

    	// if ($(this).text() == 'Убрать все фильтры') {
    	// 	$('input:checked').prop('checked', false);
    	// 	$(this).text('Просмотр объявления');
    	// } else {
    	// 	$('.btn-view').text('Убрать все фильтры');
    	// }
    });

	$('.profile-settings *').change(function() {
		let cl = '.profile-settings';
 		$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType: "json",
			data: $('.profile-settings').serialize(),
            beforeSend: function( xhr){
 
            },
			success:function(result){
				console.log(result);
				if (result.status) {
					$(cl+" .message").html(result.message);				
					
					if (result.status == 'success'){
						$(cl+" .message").removeClass("error");
						$(cl+" .message").addClass("success");
					}
				}
			}
		});
	});


	// favorite
	function MessagePopup(text) {
		message = '<div class="message-content">';
		message += text;
		message += '</div>';
		$.fancybox.open(message);
	}

	function favorite(th, id){
	 	$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType: "json",
			data: {
				'action' : 'favorite',
				'post_id' : id,
			},
			success:function(result){
				console.log(result);
				if (result.status == 'success') {
					$(th).addClass('favorite-add');
				} else if (result.status == 'remove') {
					$(th).removeClass('favorite-add');
				} else {
					MessagePopup(result.message);
				}
			}
		});
	}

    $(document).on('click', '.favorite, .btn-favorite', function() {
		favorite($(this), $(this).attr('data-id'));
    });

    $(document).on('click', '.remove-favorites', function() {
		favorite($(this), $(this).attr('data-id'));
    	// $(this).parents('.object-item').remove();

		setTimeout(function(){
			window.location.reload();
		}, 100);
    });



	$('.booking .btn-close').on('click', function(){
		$.fancybox.open( $('#modal-booking'), {
			touch: false,
		});
	});
	$('#modal-booking .btn-continue').on('click', function(){
		$('.fancybox-close-small').click();
	});
 


    $("input[name='apartment_name'], .textarea-field textarea").keyup(function count(){
		let number = $(this).val().length;
		$(this).parents('.input-group').find(".count").text($(this).parents('.input-group').find('.form-control').attr('maxlength')-number);
	});
	
	
 	$(document).on('click', '.remove-link', function() {
 		$(this).parents('.object-item').remove();
 		
	 	$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType: "html",
			data: {
				'action' : $(this).attr('data-action'),
				'post_id' : $(this).attr('data-id')
			},
			success:function(result){
				window.location.reload();
			}
		});
    });

 	$(document).on('click', '.btn-visibility', function() {
 		$(this).parents('.input-group').find('input[name=password]').attr('type', 'text');
    });

 	// $(document).on('click', '.map-link', function() {
	 // 	$.ajax({
		// 	url : '/wp-admin/admin-ajax.php',
		// 	type: "POST",
		// 	dataType: "html",
		// 	data: {
		// 		'action' : 'entity_location',
		// 		'post_id' : $(this).attr('data-id')
		// 	},
		// 	success:function(result){
		// 		$.fancybox.open( result, {
		// 			touch: false,
		// 		});
		// 	}
		// });
  //   });

	$('a[href^="#"]').click(function(){
		var target = $(this).attr('href');
		$('html, body').animate({scrollTop: ($(target).offset().top)-200}, 800);
		return false;
	});

	$( ".popup-register .popup-row .popup-item, .popup-auth .popup-row .popup-item" ).hover(function(){
		$(this).addClass('active');
	}, function(){ 	
	  	$(this).removeClass('active');
	});


	// $( ".popup-register .popup-row .popup-item" ).hover(function(){
	// 	$(this).addClass('active');
	// }, function(){ 	
	//   	$(this).removeClass('active');
	// });

	// function previewImages() {
	//   var $preview = $('.photo-upload-img').empty();
	//   if (this.files) $.each(this.files, readAndPreview);
	
	//   function readAndPreview(i, file) {
	    
	//     if (!/\.(jpe?g|png|gif)$/i.test(file.name)){
	//       return alert(file.name +" is not an image");
	//     } // else...
	    
	//     var reader = new FileReader();
	
	//     $(reader).on("load", function() {
	//     	$preview.append($("<img/>", {src:this.result, height:100}));
	//     });
	
	//     reader.readAsDataURL(file);
	    
	//   }
	
	// }
	// $(document).on('change', '#upload-file', previewImages);

 	$('select[name="region"]').on('click', function() {
	 	$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType: "html",
			data: {
				'action' : 'city',
				'term_id' : $(this).val()
			},
			success:function(result){
				console.log(result);
 				$('select[name="city"]').html(result);
			}
		});
    });

 	$('.share-link').on('click', function() {
	    var $temp = $("<input>");
	    $("body").append($temp);
	    $temp.val($('.share-link').attr('href')).select();
	    document.execCommand("copy");
	    $temp.remove();

	    $(this).html('<div class="share-text">Ссылка скопирована</div>');
		return false;
    });

	$(document).click( function(e){
	    if ( $(e.target).closest('.pop-up').length ) {
	        // клик внутри элемента 
	        return;
	    } else {
	    	$('.share-text').remove();
	    }
	});

	$(document).on('click', '.booking-more', function(e){
		$(this).parents('.booking-item').find('.booking-info').slideToggle();
	});
	
	
	$('input[name="main_guest"]').on('change', function() {
		if($(this).val() == 'Другой человек') {
			$('.main-guest').fadeIn();
		} else {
			$('.main-guest').fadeOut();
		}
   	});
	
	// mask phone
	// $("input[type=tel]").mask("+7 999 999-99-99");

	function maskPhone(th) {
		
 
		if(typeof th == "undefined") {
			var country = $('select[name="country"] option:selected').val();
		} else {
			var country = $(th).parents('form').find('select[name="country"] option:selected').val();
		}

		switch (country) {
		  case "ru":
			$("input[type=tel]").mask("+7 999 999-99-99");
			break;
		  case "ua":
			$("input[type=tel]").mask("+380 999 999-99-99");
			break;
		  case "kz":
			$("input[type=tel]").mask("+7 999 999 9999");
			break;   
		  case "by":
			$("input[type=tel]").mask("+375 99 999-99-99");
			break;
		  case "tj":
			$("input[type=tel]").mask("+992 999 99 9999");
			break;
		  case "uz":
			$("input[type=tel]").mask("+998 99 999 99 99");
			break;
		  case "am":
			$("input[type=tel]").mask("+374 99 999999");
			break;   
		  case "az":
			$("input[type=tel]").mask("+994 99 999 99 99");
			break; 
		  case "kg":
			$("input[type=tel]").mask("+996 999 999 999");
			break;
		  case "md":
			$("input[type=tel]").mask("+373 999 99 999");
			break;
		  case "tm":
			$("input[type=tel]").mask("+998 999 99 9999");
			break; 
		}    
	}

	maskPhone();

	$('select[name="country"]').change(function() {
		maskPhone($(this));
	});

	$('input[name="show_offers"]').change(function() {
		$('.placemark').toggleClass('hidden');
	});

	$('.field-phone select[name="country"]').change(function() {
		var country = $(this).parents('.field-phone').find('select[name="country"] option:selected').val();
			phone = $(this).parents('.field-phone').find("input[type=tel]");

		switch (country) {
		  case "ru":
			phone.mask("+7 999 999-99-99");
			break;
		  case "ua":
			phone.mask("+380 999 999-99-99");
			break;
		  case "kz":
			phone.mask("+7 999 999 9999");
			break;   
		  case "by":
			phone.mask("+375 99 999-99-99");
			break;
		  case "tj":
			phone.mask("+992 999 99 9999");
			break;
		  case "uz":
			phone.mask("+998 99 999 99 99");
			break;
		  case "am":
			phone.mask("+374 99 999999");
			break;   
		  case "az":
			phone.mask("+994 99 999 99 99");
			break; 
		  case "kg":
			phone.mask("+996 999 999 999");
			break;
		  case "md":
			phone.mask("+373 999 99 999");
			break;
		  case "tm":
			phone.mask("+998 999 99 9999");
			break; 
		}  
	});

	function choosed() {
		text1 = $('input[name="type_principle"]:checked').next('.label-name').text();
		text2 = $('input[name="type_comfort"]:checked').next('.label-name').text();
		text3 = $('input[name="type_species"]:checked').next('.label-name').text();

		$('input[name="choosed"]').val(text1 + ', ' + text2 + ', ' + text3);
	}

	$('input[name="type_principle"], input[name="type_comfort"], input[name="type_species"]').change(function() {
		choosed();
	});

	$('input[name="fast_booking"]').change(function() {
		if($(this).is(':checked')) {
			$('.instant-text').text('Внимание! У Вас ПОДКЛЮЧЕНО Мгновенное бронирование!').addClass('green');
		} else {
			$('.instant-text').text('Внимание! У Вас НЕ ПОДКЛЮЧЕНО Мгновенное бронирование!').removeClass('green');
		}
	});

	// ajax filter type
	$(document).on('click', '.filters-nav li', function(e){
		$('.filters-nav li').removeClass('active');

		$(this).addClass('active');

		$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType: "html",
			data: {
				'action' : 'filter_type',
				'term' : $(this).attr('data-type')
			},
            beforeSend: function( xhr){
             	$('.ajax').html('');
 				$('.ajax').append('<div class="spinner"></div>');
            },
			success:function(result){
				$('.ajax').html(result);
			}
		});
	});
	
	if($(window).width() < 525) {
		$('.gallery-images').slick({
			dots: false,
			arrows: true,
			infinite: false,
		});
	}


	$(document).on('click', '.button-booking', function(e){
		$('.booking-form').toggleClass('opened');
	});
	


    // Функция проверки полей формы
    function checkInput() {

		$('.menu-left li').removeClass('important');

		$('.form-section').each(function(){

			let attr = $(this).attr('id');

			$('#' + attr).find('input, select, textarea').each(function() {

				if($(this).val() == '' && $(this).attr('required')){

					$('[data-step="' + attr + '"]').addClass('important');

					$(this).addClass('empty_field');

				} else {

					$(this).removeClass('empty_field');

				}

			});

		});
	}

	checkInput();

	$(document).on('click', '.travel-cancel', function() {
		$(this).parents('.travel-item').remove();
		
		$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType: "html",
			data: {
			   'action' : 'travel_cancel',
			   'post_id' : $(this).attr('data-id')
			},
			success:function(result){
				window.location.reload();
			}
	   });
	});

	$(document).on('click', '.variants-rooms .room-item .btn-booking', function() {
		$('input[name="room_id"]').val($(this).attr('data-id'));
		$('.sidebar-form-content .submit-room').click();
	});


	$(document).on('click', '.balloon-post .btn-booking', function() {
 
		$.ajax({
			url : 'https://krymking.ru/booking/',
			method: 'post',
			dataType: 'html',
			data: {
				'post_id' : $(this).attr('data-id')
			},
			success:function(result){
	
			}
	   });
	});

	var target = window.location.hash;

	if(target == '#rooms') {
		$('.open-room').click();
	}

	$(document).on('click', '.room-calendar', function() {
		$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType: "html",
			data: {
			   'action' : 'room_calendar',
			   'post_id' : $(this).parents('.room-item').attr('data-id'),
			},
			success:function(result){
				$.fancybox.open( result, {
					touch: false,
				});
			}
	   });
   });

  	$(document).on('click', '.btn-add-room', function() {
		history.back();
	});

   
	$(document).on('click', '.btn-forgot', function() {
		$.ajax({
			url : '/wp-admin/admin-ajax.php',
			type: "POST",
			dataType: "json",
			data: {
			   'action' : 'password_reset',
			   'field' : $('input[name="forgot"]').val(),
			},
			success:function(data){
				MessagePopup(data.message);
			}
	   });
   	});

		 $(".item-popup").click(function () {
			$('.sub-category-popup').slideToggle() 
		});
});



