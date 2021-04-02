
<div class="simple-tab">
    <div class="list2 list2-2">
      <div class="row list grid-space-0">
      @if(isset($categories))
      @foreach($categories as $key => $category)
            <div class="col-sm-6 col-md-6 col-xs-6 col-xxs-12">
                <h2>{{$category->title}}</h2>
              <?php  $i = 1?>
            @foreach($category->posts as $post)
            
            <div class="list_item @if($i == 1) {{ 'ptop0' }} @endif">
              <div class="inner">
              <a href="{{action('SiteController@doitacDetail',$post->slug)}}" class="list_img"> <img class="img-lazy" data-src="{{$post->getImage('thumbnail')}}" alt="" /> </a>
              
              <div class="list_desc">
                <h4 class="list_title">{{$post->title}}</h4>
                <p>{{$post->excerpt}}</p></div>
              </div>
            </div>
            <?php $i++?>
            @endforeach
            </div>
      @endforeach
      @endif
      </div>
    </div>
</div>
<style>
  .list2 .list_item{border-bottom: 1px solid #D2D2D2}
  .ptop0  .inner{padding-top: 0 !important}
  .list2 .list_item:last-child{border-bottom:0;}
  .simple-tab h2{text-align: center}
</style>