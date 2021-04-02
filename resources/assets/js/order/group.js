var swiperInstances = {},
	$orderBar = $('#order-bar'),
	$memberManage = $('#modal-cart-member');

$('.swiper-container').each(function(index, element) {
    var self = $(this),
    	swiper_id = self.attr('id').match(/\d+/)[0];
    	swiper_col = self.attr('id').match(/\d$/)[0];

    swiperInstances[swiper_id] = new Swiper('#' + self.attr('id'), {
        spaceBetween: 0,
        speed: 600,
        //loop: true,
        observer: true,
        observeParents: true,
        nextButton: '.swiper-button-next-' + swiper_id + '-' + swiper_col,
        prevButton: '.swiper-button-prev-' + swiper_id + '-' + swiper_col
    });
});

$(window).on('load', function(event) {
	event.preventDefault();
	$orderBar.scrollToFixed({
		zIndex: 99,
		bottom: 0,
		limit: $orderBar.offset().top,
		dontSetWidth: true
	});
	if ($(window).width() > 1024) {
		$('.sidebar-menu-left').scrollToFixed({
			zIndex: 3
		});
	}
	setTimeout(function() {
		$('html,body').animate({
			scrollTop: $('.sidebar-menu-left').offset().top
		}, 600);
	}, 100);
});

$('#modal-cart-member').on('show.bs.modal', function (e) {
	angular.element($memberManage[0]).scope().getMember();
});

$('.add-to-cart.single').click(function(event) {
	event.preventDefault();
	var self = $(this),
		$item = self.closest('.dish-item'),
		$target = $orderBar;

	if ($item.hasClass('dish-combo')) {
		$item.toggleClass('active');
		return;
	}

	var $imgtodrag = $item.children('.item-wrapper').children('.img-responsive');
	flyToCart($imgtodrag, $target);

	$.ajax({
		url: '/gart/' + gartId + '/row',
		type: 'POST',
		dataType: 'json',
		beforeSend: function() {
			self.attr('disabled', true);
		},
		data: {id: self.data('id')},
	})
	.done(function(data) {
		if (data.status === 'success') angular.element($orderBar[0]).scope().getCart();
	})
	.always(function() {
		self.attr('disabled', false);
	});
});

$('.add-to-cart.combo').click(function(event) {
	event.preventDefault();
	var self = $(this),
		$item = self.closest('.dish-item'),
		$container = $item.children('.combo-container'),
		$target = $orderBar,
		ids = [];

	$container.children('.side-group').not('.hidden').each(function(index, el) {
		var chosen_dish = $(el).children('.swiper-container').find('.swiper-slide-active');
		// Nếu đổi size
		if ($(el).find('input.change-size').length > 0 && $(el).find('input.change-size').is(':checked')) {
			ids.push(chosen_dish.data('child-id'));
		} else ids.push(chosen_dish.data('id'));
	});

	var $imgtodrag = $item.children('.item-wrapper').children('.img-responsive');
	flyToCart($imgtodrag, $target);

	$.ajax({
		url: '/gart/' + gartId + '/row',
		type: 'POST',
		dataType: 'json',
		beforeSend: function() {
			self.attr('disabled', true);
		},
		data: {id: self.data('id'), ids: ids},
	})
	.done(function(data) {
		if (data.status === 'success') {
			$container.parent('.dish-item').toggleClass('active');
			angular.element($orderBar[0]).scope().getCart();
		}
	})
	.always(function() {
		self.attr('disabled', false);
	});
});

$('.change-size').change(function(event) {
	var value = parseInt($(this).closest('p').text().replace(/\D/g, '')),
		$target = $(this).closest('.side-group').siblings('.confirm').children('.combo-price'),
		targetValue = parseInt($target.text().replace(/\D/g, ''));

	if ($(this).is(':checked')) targetValue += value;
	else targetValue -= value;
	$target.text(targetValue.toMoney());
});

$('.change-col').change(function(event) {
	var $col = $(this).closest('.side-group'),
		$changeSize = $col.find('input.change-size'),
		colNumber = parseInt($col.attr('class').match(/col-(\d)/)[1]);

	if ($changeSize.is(':checked'))	$changeSize.prop('checked', false).change();

	var checked = $(this).is(':checked'),
		value = parseInt($(this).closest('p').text().replace(/\D/g, '')),
		$target = $(this).closest('.side-group').siblings('.confirm').children('.combo-price'),
		targetValue = parseInt($target.text().replace(/\D/g, ''));

	switch (colNumber) {
		case 1:
			if (checked) targetValue += value;
			else targetValue -= value;
			$col.toggleClass('hidden').next('.side-group').toggleClass('hidden');
			break;
		case 3:
			if (checked) targetValue += value;
			else targetValue -= value;
			$col.toggleClass('hidden').next('.side-group').toggleClass('hidden');
			break;
		default:
			break;
	}

	$target.text(targetValue.toMoney());
});

$('.combo-close').click(function(event) {
	$(this).parent('.combo-container').parent('.dish-item').toggleClass('active');
});

$('.order-toggle').click(function(event) {
	if (!$(event.target).hasClass('btn-checkout')) {
        $orderBar.slideUp('fast', function() {
       		$orderBar.toggleClass('active')/*.trigger('resize')*/;
            $orderBar.slideDown(400);
       	});
    }

});
