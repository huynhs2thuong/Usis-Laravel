@extends('layouts.app')

@section('content')
	<section class="mobile-order-dishes">
		@foreach ($group->dishes as $dish)
			<div class="mobile-dish">
				<div class="dish-img">
					<img src="{{ $dish->getImage('full') }}" alt="{{ $dish->title }}" class="img-responsive center-block">
				</div>
				<div class="dish-info">
					<h4 class="text-uppercase text-center">{{ $dish->title }}</h4>
					<p class="dish-price text-center">{{ format_money($dish->price) }}</p>
				</div>
				@if ($dish->is_combo)
					@foreach ($dish->combo as $index => $side_group_id)
						@if ($side_group_id === '') @continue @endif
						<dl class="dropdown side-group col-{{ $index }}{{ $index % 2 === 0 ? ' even disabled' : '' }}">
							<div class="side-group-overlay"></div>
							<dt>
								<p class="col-name placehold-drink">{{ $side_groups[$side_group_id]->title }}</p>
								<p class="selected">
									<span class="selected-drink"></span>
									<span class="selected-size"></span>
								</p>
								<i class="fa fa-caret-down"></i>
							</dt>
							<dd class="dropdown-option">
								@foreach ($side_groups[$side_group_id]->dishes as $side_dish)
									<div class="flex-box">
										<img src="{{ $side_dish->getImage('full') }}" alt="{{ $side_dish->title }}" width="35">
										<span class="combo-title">{{ $side_dish->title }}</span>
										<span class="radio">
											<input id="option-{{ $dish->id . '-' . $side_dish->id }}" name="dish-{{ $dish->id }}-col-{{ $index }}" class="change-option" data-id="{{ $side_dish->id }}" data-child-id="{{ $side_dish->child->id or $side_dish->id }}" type="radio" autocomplete="off"{{ $loop->index === 0 ? ' checked="checked"' : '' }}>
											<label for="option-{{ $dish->id . '-' . $side_dish->id }}" class="orange-light"></label>
										</span>
									</div>
								@endforeach
								@if ($index % 2 === 1)
									<div class="flex-box">
										<span class="text-center">{{ $side_groups[$side_group_id]->change_size }}</span>
										<span class="checkbox">
											<input id="checkbox-{{ $dish->id . '-' . $index }}" class="change-size" type="checkbox" autocomplete="off">
											<label for="checkbox-{{ $dish->id . '-' . $index }}" class="orange-light"></label>
										</span>
									</div>
									<div class="flex-box">
										<span class="text-center">{{ $side_groups[$side_group_id]->change_col }}</span>
										<span class="checkbox">
											<input id="checkbox-{{ $dish->id . '-' . ($index + 1) }}" class="change-col" type="checkbox" autocomplete="off">
											<label for="checkbox-{{ $dish->id . '-' . ($index + 1) }}" class="orange-light"></label>
										</span>
									</div>
								@else
									<div class="flex-box">
										<span class="text-center">{{ $side_groups[$side_group_id]->change_col }}</span>
										<span class="checkbox">
											<input id="checkbox-{{ $dish->id . '-' . $index }}" class="change-col" type="checkbox" autocomplete="off">
											<label for="checkbox-{{ $dish->id . '-' . $index }}" class="orange-light"></label>
										</span>
									</div>
								@endif
							</dd>
						</dl>
					@endforeach
				@endif
				<button class="btn add-to-cart text-uppercase" data-id="{{ $dish->id }}">@lang('user.button.add to cart')</button>
			</div>
		@endforeach
	</section>
	<section class="mobile-list-dishes">
		<div class="list-item flex-box">
			@foreach ($groups as $main_group)
				<a href="{{ action('GroupController@show', $main_group->slug) }}" class="dish text-uppercase{{ $main_group->id === $group->id ? ' active' : '' }}">{{ $main_group->title }}</a>
			@endforeach
		</div>
	</section>
	<section class="mobile-order-purchase">
		<a href="{{ action('CartController@checkout') }}" class="btn btn-orange" role="button">@lang('user.button.checkout')</a>
		<span class="total"></span>
		<div class="clearfix"></div>
	</section>
@endsection

@push('scripts')
	<script type="text/javascript" src="/js/order/mobile.js"></script>
@endpush

