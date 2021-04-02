$(document).ready(function() {
	var $orderBar = $('.mobile-order-purchase');

	if ($.cookie('customerFirstCart') === null) $.cookie('customerFirstCart', 'true');

	$('.btn-close').on('click', function(){
		$(this).parents('.mobile-order-min').remove();
	});

	addNameAtt('.dropdown-drink', 'dink');
	addNameAtt('.dropdown-icecream', 'icecream');
	addNameAtt('.dropdown-potato', 'potato');
	// Add name attribute for every dishes to make it different from the others
	function addNameAtt (container, name) {
		var wrapper = $('.order-dishes').toArray();
		for (var i = 0; i < wrapper.length; i++) {
			var value = name + '_' + i;
			$(wrapper[i]).find(container).find('input[type="checkbox"]').not('.left').attr('name', value);
		}
	}
	// Border around order when choosing extra attachment
	$('.mobile-dish').on('click', '*', function() {
		var items = $('.mobile-dish').toArray();
		for (var i = 0; i < items.length; i++) {
			$(items[i]).removeClass('edit-order');
		}
		$(this).parents('.mobile-dish').addClass('edit-order');
	});

	$('.dropdown dt').on('click', function() {
		$(this).parent('.side-group').toggleClass('enable');
	});

	function getCart() {
		$.get('/cart', function(response) {
			$orderBar.children('.total').text(parseInt(response.total).toMoney());
		});
	}

	getCart();

	$('.dropdown-option .change-option').on('click', function(event) {
		var $col = $(this).closest('dl.dropdown');
		var $colName = $col.children('dt').children('.col-name');
		$colName.text($(this).parent('.radio').siblings('.combo-title').text());
	});

	$('input.change-size').change(function(event) {
		var value = parseInt($(this).parent('.checkbox').siblings('.text-center').text().replace(/\D/g, '')),
			$target = $(this).closest('.mobile-dish').children('.dish-info').children('.dish-price'),
			targetValue = parseInt($target.text().replace(/\D/g, ''));

		if ($(this).is(':checked')) targetValue += value;
		else targetValue -= value;
		$target.text(targetValue.toMoney());
	});

	$('input.change-col').change(function(event) {
		var $col = $(this).closest('.side-group'),
			$changeSize = $col.find('input.change-size');

		if ($changeSize.is(':checked'))	$changeSize.prop('checked', false).change();

		var value = parseInt($(this).parent('.checkbox').siblings('.text-center').text().replace(/\D/g, '')),
			$target = $(this).closest('.mobile-dish').children('.dish-info').children('.dish-price'),
			targetValue = parseInt($target.text().replace(/\D/g, ''));

		targetValue = ($(this).is(':checked')) ? targetValue + value : targetValue - value;
		$col.toggleClass('disabled enable').next('.side-group').toggleClass('disabled enable');
		$target.text(targetValue.toMoney());
	});

	$('.add-to-cart').click(function(event) {
		var self = $(this),
			$container = self.parent('.mobile-dish'),
			ids = [],
			dataSend = {id: self.data('id')};

		if ($.cookie('customerFirstCart') === 'true') {
			angular.element($customerLogin[0]).scope().openTab(4);
			return;
		}

		$container.children('.side-group').not('.disabled').each(function(index, el) {
			var chosen_dish = $(el).find('.change-option:checked');
			// Nếu đổi size
			if ($(el).find('input.change-size').length > 0 && $(el).find('input.change-size').is(':checked')) {
				ids.push(chosen_dish.data('child-id'));
			} else ids.push(chosen_dish.data('id'));
		});

		if (ids.length > 0) dataSend.ids = ids;

		var $imgtodrag = $container.children('.dish-img').children('.img-responsive');
		flyToCart($imgtodrag, $orderBar);

		$.ajax({
			url: '/cart',
			type: 'POST',
			dataType: 'json',
			beforeSend: function() {
				self.attr('disabled', true);
			},
			data: dataSend,
		})
		.done(function(data) {
			if (data.status === 'success') getCart();
		})
		.always(function() {
			self.attr('disabled', false);
		});
	});
});
