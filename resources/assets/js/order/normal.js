var swiperInstances = {},
    $orderBar = $('#order-bar');

if ($.cookie('customerFirstCart') === null) $.cookie('customerFirstCart', 'true');

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

app.controller('CartController', ['$scope', '$http', function($scope, $http) {
    $scope.products = [];

    $scope.getCart = function() {
        $http.get('/cart').success(function(response) {
            var old = $scope.products.length;
            $scope.products = response.data;
            if (old === 0 && $scope.products.length > old) {
                setTimeout(function() { $(window).trigger('resize'); }, 50);
            }
        });
    };

    $scope.increase = function(product) {
        product.qty++;
        $http.post('/cart/rowId'.replace('rowId', product.rowId), {qty: product.qty, _method: 'PUT'});
    };

    $scope.decrease = function(product) {
        if (product.qty > 1) {
            product.qty--;
            $http.post('/cart/rowId'.replace('rowId', product.rowId), {qty: product.qty, _method: 'PUT'});
        }
    };

    $scope.delete = function(index, product) {
        $http.post('/cart/id'.replace('id', product.rowId), {_method: 'DELETE'});
        $scope.products.splice(index, 1);
        if ($scope.products.length === 0) {
            setTimeout(function() { $orderBar.trigger('resize'); }, 50);
        }
        /* Tag Manager */
        var products = [
            {
                id: product.id,
                quantity: product.qty,
                name: getLocaleText(product.title, $('html').attr('lang'))
            }
        ];
        angular.foreach(products.options, function(value) {
            products.push({
                id: value.id,
                price: value.price,
                quantity: value.qty,
                name: getLocaleText(value.title, $('html').attr('lang'))
            });
        });
        if (dataLayer != undefined) {
            dataLayer.push({
                'event': 'removeFromCart',
                'ecommerce': {
                    'remove': {
                        'products': products
                    }
                }
            });
        }
    };

    $scope.total = function() {
        var count = 0, total = 0;
        angular.forEach($scope.products, function(value, key) {
            count += value.qty;
            total += value.price * value.qty;
        });
        return {
            count: count,
            money: total.toMoney()
        };
    };

    $scope.getCart();
}]);

$('.add-to-cart.single').click(function(event) {
    event.preventDefault();
    var self = $(this),
        $item = self.closest('.dish-item'),
        $target = $orderBar;

    if ($.cookie('customerFirstCart') === 'true') {
        angular.element($customerLogin[0]).scope().openTab(4);
        return;
    }

    if ($item.hasClass('dish-combo')) {
        $item.toggleClass('active');
        return;
    }

    var $imgtodrag = $item.children('.item-wrapper').children('.img-responsive');
    flyToCart($imgtodrag, $target);

    $.ajax({
        url: '/cart',
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

    /* Push Data Layer Tag Manager */
    if (dataLayer != undefined) {
        dataLayer.push({
            'event': 'addToCart',
            'ecommerce': {
                'currencycode': 'VND',
                'add': {
                    'products': [
                        {
                            'name': self.data('name'),
                            'id': self.data('id'),
                            'price': self.data('price')
                        }
                    ]
                }
            }
        });
    }
});

$('.add-to-cart.combo').click(function(event) {
    event.preventDefault();
    var self = $(this),
        $item = self.closest('.dish-item'),
        $container = $item.children('.combo-container'),
        $target = $orderBar,
        subproducts = [],
        ids = [];

    if ($.cookie('customerFirstCart') === 'true') {
        angular.element($customerLogin[0]).scope().openTab(4);
        return;
    }

    $container.children('.side-group').not('.hidden').each(function(index, el) {
        var chosen_dish = $(el).children('.swiper-container').find('.swiper-slide-active');
        // Nếu đổi size
        if ($(el).find('input.change-size').length > 0 && $(el).find('input.change-size').is(':checked')) {
            ids.push(chosen_dish.data('child-id'));
            subproducts.push({
                id: chosen_dish.data('child-id'),
                name: chosen_dish.data('child-name'),
                price: chosen_dish.data('child-price')
            })
        } else {
            ids.push(chosen_dish.data('id'));
            subproducts.push({
                id: chosen_dish.data('id'),
                name: chosen_dish.data('name'),
                price: chosen_dish.data('price')
            })
        }
    });

    //console.log(ids);

    var $imgtodrag = $item.children('.item-wrapper').children('.img-responsive');
    flyToCart($imgtodrag, $target);

    $.ajax({
        url: '/cart',
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

    /* Push Data Layer Tag Manager */
    var product = {
        'name': self.data('name'),
        'id': self.data('id'),
        'price': self.data('price')
    };
    subproducts.push(product);
    if (dataLayer != undefined) {
        dataLayer.push({
            'event': 'addToCart',
            'ecommerce': {
                'currencycode': 'VND',
                'add': {
                    'products': subproducts
                }
            }
        });
    }
});

$('input.change-size').change(function(event) {
    var value = parseInt($(this).closest('p').text().replace(/\D/g, '')),
        $target = $(this).closest('.side-group').siblings('.confirm').children('.combo-price'),
        targetValue = parseInt($target.text().replace(/\D/g, ''));

    if ($(this).is(':checked')) targetValue += value;
    else targetValue -= value;
    $target.text(targetValue.toMoney());
});

$('input.change-col').change(function(event) {
    var $col = $(this).closest('.side-group'),
        $changeSize = $col.find('input.change-size');

    if ($changeSize.is(':checked')) $changeSize.prop('checked', false).change();

    var value = parseInt($(this).closest('p').text().replace(/\D/g, '')),
        $target = $(this).closest('.side-group').siblings('.confirm').children('.combo-price'),
        targetValue = parseInt($target.text().replace(/\D/g, ''));

    targetValue = ($(this).is(':checked')) ? targetValue + value : targetValue - value;
    $col.toggleClass('hidden').next('.side-group').toggleClass('hidden');
    $target.text(targetValue.toMoney());

    /*if ($col.hasClass('col-1') || $col.hasClass('col-2'))
        $('.side-group.col-1, .side-group.col-2').toggleClass('hidden');
    else if ($col.hasClass('col-3') || $col.hasClass('col-4'))
        $('.side-group.col-3, .side-group.col-4').toggleClass('hidden');*/
});

$('.combo-close').click(function(event) {
    $(this).parent('.combo-container').parent('.dish-item').toggleClass('active');
});

$('.order-toggle').click(function(event) {
    $orderBar.slideUp('fast', function() {
        $orderBar.toggleClass('active')/*.trigger('resize')*/;
        $orderBar.slideDown(400);
    });
});
