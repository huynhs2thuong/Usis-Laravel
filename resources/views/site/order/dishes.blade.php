<div class="group-dishes">
    @foreach ($group->dishes as $dish)
    	@if ($loop->iteration % 3 === 1) <div class="row"> @endif
        <div class="col-sm-4 dish-item {{ $dish->is_combo ? ($dish->combo[1] == '' ? 'single-combo' : 'double-combo') : '' }} {{ $dish->is_combo ? 'dish-combo' : '' }}">
            <a class="item-wrapper">
				<img class="img-responsive center-block lazy" data-original="{{ $dish->getImage('full') }}" alt="{{ $dish->title }}">
				<div class="item-name text-uppercase">{{ $dish->title }}</div>
				<div class="item-price">{{ format_money($dish->price) }}</div>
				<button class="btn add-to-cart single" data-name="{{ $dish->title }}" data-id="{{ $dish->id }}" data-price="{{ $dish->price }}">@lang('user.button.add to cart')</button>
				@if ($dish->is_new)
					<i class="fa fa-new fa-4x"></i>
				@endif
				@if ($dish->discount > 0)
					<i class="item-discount">-{{ $dish->discount }}%</i>
				@endif
			</a>
			@if ($dish->is_combo)
	            <div class="combo-container text-center">
	                @foreach ($dish->combo as $index => $side_group_id)
	                	{{-- Nếu không có khoai (index == 1 hoac 2) thì cho nước tràn hết container --}} @if ($side_group_id === '') @continue @endif
		                <div class="{{ $dish->combo[1] === '' ? 'col-sm-12' : 'col-sm-6' }} side-group col-{{ $index }} {{ $index % 2 === 0 ? 'hidden' : '' }}">
		                    <div id="instance-{{ $dish->id . '-' . $index }}" class="swiper-container">
		                        <div class="swiper-wrapper">
		                            @foreach ($side_groups[$side_group_id]->dishes as $side_dish)
		                            <div class="swiper-slide"
										data-name="{{ $side_dish->title }}" data-price="{{ $side_dish->price }}"
										data-child-name="{{ $side_dish->child->title or $side_dish->title }}" data-child-price="{{ $side_dish->child->price or $side_dish->price }}"
										data-id="{{ $side_dish->id }}" data-child-id="{{ $side_dish->child->id or $side_dish->id }}">
		                                <img src="{{ $side_dish->getImage('full') }}" alt="{{ $side_dish->title }}" class="img-responsive center-block">
		                                <div class="combo-title">{{ $side_dish->title }}</div>
		                            </div>
		                            @endforeach
		                        </div>
		                        <div class="swiper-button-prev swiper-button-white swiper-button-prev-{{ $dish->id . '-' . $index }}"></div>
		                        <div class="swiper-button-next swiper-button-white swiper-button-next-{{ $dish->id . '-' . $index }}"></div>
		                    </div>
		                    @if ($index % 2 === 1)
		                    <p class="text-white text-right">
		                    	{{ $side_groups[$side_group_id]->change_size }}
		                        <span class="checkbox">
									<input id="checkbox-{{ $dish->id . '-' . $index }}" class="change-size" type="checkbox" autocomplete="off">
									<label class="white" for="checkbox-{{ $dish->id . '-' . $index }}"></label>
								</span>
		                    </p>
		                    <p class="text-white text-right">
		                    	{{ $side_groups[$side_group_id]->change_col }}
		                        <span class="checkbox">
									<input id="checkbox-{{ $dish->id . '-' . ($index + 1) }}" class="change-col" type="checkbox" autocomplete="off">
									<label class="white" for="checkbox-{{ $dish->id . '-' . ($index + 1) }}"></label>
								</span>
		                    </p>
		                    @else
		                    <p class="text-white">
		                    	{{ $side_groups[$side_group_id]->change_col }}
		                        <span class="checkbox">
									<input id="checkbox-{{ $dish->id . '-' . $index }}" class="change-col" type="checkbox" autocomplete="off">
									<label class="white" for="checkbox-{{ $dish->id . '-' . $index }}"></label>
								</span>
		                    </p>
		                    @endif
		                </div>
	                @endforeach
	                <div class="col-xs-12 confirm">
	                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="10.9px" height="11.2px" viewBox="0 0 10.9 11.2" enable-background="new 0 0 10.9 11.2" xml:space="preserve">
	                        <g>
	                            <g>
	                                <g id="_x34_84._Forward_15_">
	                                    <g>
	                                        <path fill="#FFFFFF" d="M5,0.2L0.2,5c-0.2,0.2-0.2,0.6,0,0.8l0.4,0.4c0.2,0.2,0.6,0.2,0.8,0l4.1-4.1l4.1,4.1
														c0.2,0.2,0.6,0.2,0.8,0l0.4-0.4c0.2-0.2,0.2-0.6,0-0.8L5.8,0.2C5.6-0.1,5.3-0.1,5,0.2z" />
	                                    </g>
	                                </g>
	                            </g>
	                            <g>
	                                <g id="_x34_84._Forward_41_">
	                                    <g>
	                                        <path fill="#FFFFFF" d="M5,5L0.2,9.8c-0.2,0.2-0.2,0.6,0,0.8L0.6,11c0.2,0.2,0.6,0.2,0.8,0l4.1-4.1L9.5,11
														c0.2,0.2,0.6,0.2,0.8,0l0.4-0.4c0.2-0.2,0.2-0.6,0-0.8L5.8,5C5.6,4.7,5.3,4.7,5,5z" />
	                                    </g>
	                                </g>
	                            </g>
	                        </g>
	                    </svg>
	                    <div class="combo-text">@lang('cart.combo')</div>
	                    <div class="combo-price text-white">{{ format_money($dish->price) }}</div>
	                    <button class="btn add-to-cart combo" data-id="{{ $dish->id }}">@lang('user.button.add to cart')</button>
	                </div>
	                <span class="combo-close"></span>
	            </div>
            @endif
        </div>
        @if ($loop->iteration % 3 === 0 or $loop->last) </div> @endif
    @endforeach
</div>
