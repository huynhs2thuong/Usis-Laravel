@extends('layouts.app')

@section('content')
	<div class="banner-menu">
		<img src="/images/home/banner.jpg" alt="Thuc don banner" class="img-full-width"/>
		<ul class="sidebar-menu-left list-inline text-uppercase text-center" data-position="absolute">
			@foreach ($groups as $main_group)
				@if ($main_group->dishes_count === 0) @continue @endif
				<li>
					<a class="{{ $main_group->id === $group->id ? 'active' : '' }}" href="{{ action('GroupController@showGart', [$main_group->slug, $gartId]) }}">
						<i class="fa fa-group-{{ $main_group->slug }} hide-on-fix"></i>
						{{ $main_group->title }}
					</a>
				</li>
			@endforeach
		</ul>
	</div>


	<div class="item-menu-right">
		<div id="form-share-link" class="text-right text-white">
			<span class="btn btn-share-link">@lang('cart.copy')</span>
		</div>
		@include('site.order.dishes', ['group' => $group])
		@if ($currentUser)
			<div id="order-bar" class="row" ng-controller="CartController" data-position="absolute">
				<div class="order-toggle hide-active text-center">
					@if ($isOwner)
						<a class="btn btn-checkout" href="#modal-cart-member" data-toggle="modal">@lang('user.button.group manage')</a>
					@else
						<button class="btn btn-checkout" ng-disabled="gartDone" ng-click="markDone()">@lang('user.button.cart done')</button>
					@endif
					<br /><div class="member-info">@{{ usersCount }} @lang('cart.person')</div>
					<i class="fa fa-cart"></i><span>@{{ total().money }}</span>
				</div>
				@verbatim
				<div class="cart-list scrollbar-macosx">
					<div class="cart-item" ng-repeat="product in products" ng-class="{ first: $index === 0 }">
						<div class="row">
							<div class="pull-left dish-name">{{ getTranslate(product.title) }}</div>
							<div class="pull-right change-qty delete" ng-hide="getDone()" ng-click="delete($index, product)">×</div>
						</div>
						<div class="dish-option" ng-repeat="option in product.options">- {{ getTranslate(option.title) }}</div>
						<div class="row">
							<div class="add-item text-center pull-left">
								<span class="change-qty increase" ng-hide="getDone()" ng-click="increase(product)">+</span>
								<span class="quantity" data-id="{{ product.rowId }}">{{ product.qty }}</span>
								<span class="change-qty decrease" ng-hide="getDone()" ng-click="decrease(product)">-</span>
							</div>
							<div class="dish-price pull-right">{{ (product.price * product.qty).toMoney() }}</div>
						</div>
					</div>
				</div>
				@endverbatim
				<div class="cart-item total">
					<div class="pull-left dish-name">@lang('cart.total')</div>
					<div class="pull-right dish-price cart-total">@{{ total().money }}</div>
					<div class="clearfix"></div>
				</div>
				<div class="text-center text-white">
					@if ($isOwner)
						<a class="btn btn-checkout" href="#modal-cart-member" data-toggle="modal">@lang('user.button.group manage')</a>
					@else
						<button class="btn btn-checkout" ng-disabled="gartDone" ng-click="markDone()">@lang('user.button.cart done')</button>
					@endif
				</div>
				<svg class="order-toggle hide-no-active" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="10.9px" viewBox="0 0 20 10.9" enable-background="new 0 0 20 10.9" xml:space="preserve">
				    <path fill="#950E08" d="M19.7,1.8c0.4-0.4,0.4-1.1,0-1.4c-0.4-0.4-1-0.4-1.4,0L9.9,8.5L1.7,0.3c-0.4-0.4-1-0.4-1.4,0
					C0.1,0.5,0,0.7,0,1c0,0.3,0.1,0.5,0.3,0.7l8.9,8.9c0.4,0.4,1.1,0.4,1.4,0L19.7,1.8z" />
				</svg>
			</div>
		@endif
		<div class="clearfix"></div>
	</div>

	@if ($isOwner)
		<div class="modal fade" id="modal-cart-member" ng-controller="MemberController">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header text-center">
						<h4 class="modal-title text-uppercase">@lang('cart.member.title')</h4>
					</div>
					<div class="container-info-member">
						<span>@{{ unDoneCount() }} @lang('cart.person') @lang('cart.member.status.undone')</span>
						<span>@{{ doneCount() }} @lang('cart.person') @lang('cart.member.status.done')</span>
						<span>@{{ total() }} @lang('cart.dish')</span>
					</div>
					<div class="modal-body">
						<table class="table">
							<thead>
								<tr>
									<th>@lang('cart.member.name')</th>
									<th>@lang('cart.member.count')</th>
									<th>@lang('cart.member.status.title')</th>
									<th>@lang('cart.member.action.title')</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="member in members">
									<td><img ng-src="@{{ member.avatar }}" class="img-circle" width="40" height="40" alt=""> @{{ member.name }}</td>
									<td>@{{ member.count }} @lang('cart.dish')</td>
									<td>
										<b ng-show="member.status" class="text-green"><!-- <i class="fa fa-check-circle" aria-hidden="true"></i>  -->@lang('cart.member.status.done')</b>
										<b ng-show="!member.status" class="text-primary"><!-- <i class="fa fa-times" aria-hidden="true"></i>  -->@lang('cart.member.status.undone')</b>
									</td>
									<td ng-hide="member.status">
										<i title="@lang('cart.member.action.markDone')" class="member-action fa fa-check-circle text-green" aria-hidden="true" ng-click="doAction(member, 'markDone', null)"></i>
										<i title="@lang('cart.member.action.remind')" class="member-action fa fa-bell" aria-hidden="true" ng-click="doAction(member, 'remind', null)"></i>
										<i title="@lang('cart.member.action.destroy')" class="member-action fa fa-times-circle text-primary" aria-hidden="true" ng-click="doAction(member, 'destroy', $index)"></i>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">@lang('user.button.close')</button>
						<a href="{{ action('GartController@checkout', $gartId) }}" class="btn btn-color" ng-class="{ disabled: cannotCheckout() }">@lang('user.button.checkout')</a>
					</div>
				</div>
			</div>
		</div>
	@endif

@endsection

@push('scripts')
	@if (!$currentUser)
		<script type="text/javascript">
			app.controller('CartController', function() {}).controller('MemberController', function() {});
			$(document).ready(function() {
				$customerLogin.find('.btn-close').detach();
				$customerLogin.modal({
					backdrop: 'static',
		  			keyboard: false
				}).modal('show');
			});
		</script>
	@else
		<script type="text/javascript" src="/js/plugins/sticky/jquery-scrolltofixed.min.js"></script>
		<script type="text/javascript" src="/js/plugins/socket.io.js"></script>
		<script type="text/javascript">
			var gartId = '{{ $gartId }}';

			(function() {
				var $orderBar = $('#order-bar');

				app.controller('CartController', ['$scope', '$http', function($scope, $http) {
					$scope.products = [];
					$scope.usersCount = null;
					$scope.gartDone = false;
					$scope.isOwner = {{ $isOwner ? 'true' : 'false' }};

					$scope.getCart = function() {
						$http.get('{{ action('GartController@index', $gartId) }}').success(function(response) {
							$scope.products = response.data;
							$scope.usersCount = response.usersCount;
							$scope.gartDone = response.status;
							$orderBar.removeClass('hidden');
							if ($scope.gartDone && !$scope.isOwner) $('.add-to-cart').prop('disabled', true);
						});
					};

					$scope.increase = function(product) {
						product.qty++;
						$http.post('{{ action('GartController@update', [$gartId, 'rowId']) }}'.replace('rowId', product.rowId), {qty: product.qty, _method: 'PUT'});
					};

					$scope.decrease = function(product) {
						if (product.qty > 1) {
							product.qty--;
							$http.post('{{ action('GartController@update', [$gartId, 'rowId']) }}'.replace('rowId', product.rowId), {qty: product.qty, _method: 'PUT'});
						}
					};

					$scope.delete = function(index, product) {
						$http.post('{{ action('GartController@destroy', [$gartId, 'rowId']) }}'.replace('rowId', product.rowId), {_method: 'DELETE'});
						$scope.products.splice(index, 1);
					};

					$scope.total = function() {
						var count = total = 0;
						angular.forEach($scope.products, function(value, key) {
							count += value.qty;
							total += value.price * value.qty;
						});
						return {
							count: count,
							money: total.toMoney()
						};
					};

					$scope.getDone = function() {
						return $scope.gartDone && ! $scope.isOwner;
					};

					$scope.markDone = function() {
						if ($scope.products.length === 0) {
							swal("@lang('cart.message.title')", "@lang('cart.message.markDone fail')", "error");
							return;
						}
						$http.post('{{ action('GartController@member', $gartId) }}');
						$scope.gartDone = true;
						$('.add-to-cart').prop('disabled', true);
					};

					$scope.getCart();

					var socket = io('{{ url('/') . ':8890' }}');
			        socket.on('connect', function() {
			        	socket.on('gartUpdated', function(message) {
				            if (message.gart.id === '{{ $gartId }}') {
				            	$scope.$apply(function() {
				            		$scope.usersCount = message.gart.value;
				            		angular.element($('#modal-cart-member')[0]).scope().getMember();
				            	});
				            }
				        });
				        @if ($currentUser)
				        socket.on('memberUpdated', function(message) {
				            if (message.alert.gartId === '{{ $gartId }}' && message.alert.userId === {{ $currentUser->id }}) {
				            	switch(message.alert.action) {
				            		case 'markDone':
				            			$scope.$apply(function() {
				            				$http.post('{{ action('GartController@member', $gartId) }}');
						            		$scope.gartDone = true;
						            		$('.add-to-cart').prop('disabled', true);
						            	});
				            			break;
				            		case 'remind':
				            			swal("@lang('cart.message.title')", '@lang('cart.message.remind receive')');
				            			break;
				            		case 'destroy':
				            			window.location = removeLastDirectoryPartOf('{{ Request::url() }}');
				            			break;
				            		default:
				            			break;
				            	}
				            }
				        });
				        @endif

			        	socket.emit('subscribe', 'gart.{{ $gartId }}')
			        });
				}]);

				app.controller('MemberController', ['$scope', '$http', function($scope, $http) {
					$scope.members = [];

					$scope.getMember = function() {
						$http.get('{{ action('GartController@member', $gartId) }}').success(function(data) {
							$scope.members = data;
						});
					};

					$scope.total = function() {
						var total = 0;
						angular.forEach($scope.members, function(value, key) {
							total += value.count;
						});
						return total;
					};

					$scope.doneCount = function() {
						var count = 0;
						angular.forEach($scope.members, function(value, key) {
							count += value.status | 0;
						});
						return count;
					};

					$scope.unDoneCount = function() {
						return $scope.members.length - $scope.doneCount();
					};

					$scope.doAction = function(member, action, index) {
						$http.post('{{ action('GartController@memberUpdate', $gartId) }}', {userId: member.id, action: action});
						if (action === 'remind') swal("@lang('cart.message.title')", '@lang('cart.message.remind send')');
						else if (action === 'destroy') $scope.members.splice(index, 1);
					};

					$scope.cannotCheckout = function() {
						return ($scope.unDoneCount() === 0) ? false : true;
					};
				}]);

				$('.btn-share-link').click(function(event) {
					clearTimeout(copy_timeout);
					var self = $(this),
						text = '@lang('cart.copy')',
						copy_timeout = null;
					copyToClipboard('{{ request()->url() }}');
					self.text("@lang('cart.copied')");
					copy_timeout = setTimeout(function() {
						self.text(text);
					}, 2000);
				});
			})();
		</script>
		<script type="text/javascript" src="/js/order/group.js"></script>
	@endif

@endpush
