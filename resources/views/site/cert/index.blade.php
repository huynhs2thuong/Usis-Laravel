@extends('layouts.app')
@section('title', $page->title)
@section('content')

				{!! $page->description !!}
	
	<div id="maincontent">
		<div class="container">		
			<div class="TOA004 section-chungnhan section-popup section-cert">
				<div class="section-header">
					<img src="/images/icon-svg/chung-nhan.svg" alt="">
					<h2 class="section-title"> @lang('cert.cert') </h2>
				</div>
				<div class="row block-2 certify">
					@if(count($certs) > 0)
						@foreach($certs as $key => $cert)
							<div class="col-sm-4 col-md-4 item itemToModal <?php echo $key>=6 ? "view-more" : null ?>" data-target="{{$cert->id}}" >
								<div class="item_innter">
									<div  class="item_img">
										<img src="{{($cert->resource_id == null) ? asset('images/img-6.jpg') : $cert->getImage('full')}}" alt="">
									</div>
									<div class="item_content">
										<div  class="item_title">{{$cert->title}}</div>
										<div class="item_desc">
											{{$cert->excerpt}}
										</div>
										<div class="hidden desc">
											{!! $cert->description !!}
										</div>
									</div>
								</div>
							</div>
						@endforeach
					@else
                        @for( $i = 1; $i <= 3; $i ++)
						<div class="col-sm-4 col-md-4 item">
							<div class="item_innter">
								<div  class="item_img">
									<img src="/images/img-6.jpg" alt="">
								</div>
								<div class="item_content">
									<div  class="item_title">ISO 9001 - Chứng nhận Quản Lý Chất Lượng<?php echo $i;?></div>
									<div class="item_desc">
										ISO 9001 là một công cụ giúp doanh nghiệp tạo ra chất lượng sản phẩm và dịch vụ tối ưu, nâng cao được hình ảnh, uy tín của…
									</div>
									<div class="hidden desc">
										<p>ISO 9001 là một công cụ giúp doanh nghiệp tạo ra chất lượng sản phẩm và dịch vụ tối ưu, nâng cao được hình ảnh, uy tín của mình đối với khách hàng và đối tác. Những lợi ích mà khách hàng nhận được từ chứng nhận ISO 9001 bao gồm: </p>
										<p>
											- Chất lượng và dịch vụ được cải thiện
											- Thái độ chăm sóc khách hàng đúng đắn
											- Cam kết về chất lượng trong từng sản phẩm
										</p>
										<p>ISO 9001 là một công cụ giúp doanh nghiệp tạo ra chất lượng sản phẩm và dịch vụ tối ưu, nâng cao được hình ảnh, uy tín của mình đối với khách hàng và đối tác. Những lợi ích mà khách hàng nhận được từ chứng nhận ISO 9001 bao gồm: </p>
										<p>
											- Chất lượng và dịch vụ được cải thiện
											- Thái độ chăm sóc khách hàng đúng đắn
											- Cam kết về chất lượng trong từng sản phẩm
										</p>
									</div>
								</div>
							</div>
						</div> <!--End column-->
                        @endfor
					@endif
				</div>
				<div class="readmore">
					<a id="certify" href="#" class="btn btn-primary" data-page="0" data-type="cert"><span class="inner">@lang('cert.more_cert')</span></a>
				</div>
			</div>
			<div class="TOA004 section-popup section-award">
				<div class="section-header">
					<img src="/images/icon-svg/giai-thuong.svg" alt="">
					<h2 class="section-title"> @lang('cert.award') </h2>
				</div>
				<div class="row block-2">
					@if(count($awards) > 0)
						@foreach($awards as $award)
							<div class="col-sm-4 col-md-4 item" data-target="{{$award->id}}" >
								<div class="item_innter">
									<div  class="item_img">
										<img src="{{$award->getImage('full')}}" alt="">
									</div>
									<div class="item_content">
										<div  class="item_title">{{$award->title}}</div>
										<div class="item_desc">
											{{$award->excerpt}}
										</div>
										<div class="hidden desc">
											{!! $award->description !!}
										</div>
									</div>
								</div>
							</div>
						@endforeach
					@else
						@for( $i = 1; $i <= 3; $i ++)
							<div class="col-sm-4 col-md-4 item" data-toggle="modal" data-target="{{ $i }}}" >
								<div class="item_innter">
									<div  class="item_img">
										<img src="/images/img-6.jpg" alt="">
									</div>
									<div class="item_content">
										<div  class="item_title">Thương hiệu hàng đầu – Top Brands 2016</div>
										<div class="item_desc">
											Đây là hoạt động để ghi nhận bằng chứng khách quan về sự nỗ lực của doanh nghiệp trong hoạt động quản lý…
										</div>
									</div>
								</div>
							</div> <!--End column-->
						@endfor
					@endif
				</div>
				<div class="readmore">
					<a href="#" class="btn btn-primary" data-page="0" data-type="award"><span class="inner">@lang('cert.more_award')</span></a>
				</div>
			</div>
			<!-- Modal -->
			<div id="modalCNGT" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="modalCNGT">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<span class="close" data-dismiss="modal" aria-label="Close"><i class="icon-close"></i></span>
							
							<div class="block">
			                    <div class="block_img"></div>
			                    <div class="block_text">
			                        <div class="title"></div>
			                        <div class="desc"></div>
			                    </div>
			                </div>

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('styles')
    <style type="text/css">
        .itemToModal .item_content .item_desc {
            -webkit-line-clamp: 3;
		    overflow: hidden;
		    text-overflow: ellipsis;
		    -webkit-box-orient: vertical;
		    display: -webkit-box;
        }
        .view-more.itemToModal{ display: none; }
    </style>
@endpush

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
		$('.section-popup').each(function () {
			$(this).on('click','.item',function () {
                $('#modalCNGT').modal('hide');
				var img = $(this).find('.item_img').html();
				var title = $(this).find('.item_title').text();
				var desc = $(this).find('.desc').html();
				$('#modalCNGT').find('.block_img').html(img);
				$('#modalCNGT').find('.title').text(title);
				$('#modalCNGT').find('.desc').html(desc);
                $('#modalCNGT').modal('show');
            });
        });

		$('.readmore a').each(function(){
		    $(this).click(function (e) {
				e.preventDefault();
				var page = $(this).data('page');
				var type = $(this).data('type');
                console.log(page);
                console.log(type);
                $.ajax({
                    url: "{{route('cert')}}?page="+page+'&type='+type,
                    type: "GET",
					success: function(data){
                        $(this).attr('data-page',data.page);
                        $(this).attr('data-page',data.page);
                        var html = null;
                        if(data.datas.length>0){
	                        for(var i = 0; i<=data.datas.length; i++){
								html += '';
	                            html += '<div class="col-sm-4 col-md-4 item" data-target="'+data.datas[i].id+'" >';
	                            html += '<div class="item_innter">';
	                            html += '<div  class="item_img">';
	                            html += '<img src="'+data.datas[i].resource_id+'" alt="">';
	                            html += '</div>';
	                            html += '<div class="item_content">';
	                            html += '<div  class="item_title">'+data.datas[i].id+'</div>';
	                            html += '<div class="item_desc">';
	                            html += data.datas[i].excerpt;
								html += '</div>';
	                            html += '<div class="hidden desc">';
	                            html += data.datas[i].description;
	                                    html += '</div>';
	                            html += '</div>';
	                            html += '</div>';
	                            html += '</div>';
							}
						}
						if(html != null){
                            $('.section-'.data.type).append(html);
                        }

					}
				});
            });
		});
    } );

    //Su kien xem them cho nut xem them o cho chung nhan
    $("#certify").unbind("click").on("click",function(){
    	$(".certify .view-more").show();
    });

</script>
@endpush
