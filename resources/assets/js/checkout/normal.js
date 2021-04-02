app.controller('CheckoutController', ['$scope', '$http', function($scope, $http) {
	$scope.swiper = {};
	$scope.cities = $scope.districts = $scope.products = [];
	$scope.city = cookieCity;
    $scope.district = cookieDistrict;
	$scope.extras = extras;

	$http.get('/api/area').success(function(response) {
        $scope.cities = response.cities;
        $scope.districts = response.districts;
    });

	$http.get('/cart').success(function(response) {
		$scope.products = response.data;
	});

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
		$scope.products.splice(index, 1);
		$http.post('/cart/id'.replace('id', product.rowId), {_method: 'DELETE'});
		if (product.extra) {
			$('#extra-' + product.id).prop('checked', false);
			$('#extra-xs-' + product.id).prop('checked', false);
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

	$scope.changeExtra = function($event, extra) {
		if ($event.target.checked) {
			$scope.products.push(extra);
			$scope.swiper.slideNext(true, 0);
		} else {
			var index = $scope.products.indexOf(extra);
			if (index !== -1) $scope.products.splice(index, 1);
		}
	};
}]);
