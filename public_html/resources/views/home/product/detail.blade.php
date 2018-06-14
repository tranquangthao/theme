@extends('home.layouts.master_detail')
@section('title'){{$products->product_name}}@endsection
@section('url'){{url('')}}/{{$id}}-{{$slug}}/{{Session::get('locale')}}-{{$products->id}}-{{$products->slug}} @endsection
@section('keywords'){{$products->product_tags}}@endsection
@section('image'){{asset('images/products')}}/{{$products->avatar}}@endsection
@section('Content')

    <style>
       .magnify {margin: 0; padding: 0;}
        .magnify {position: relative; cursor: none}

        /*Lets create the magnifying glass*/
        .large {
            width: 200px; height: 200px;
            position: absolute;
            border-radius: 100%;

            /*Multiple box shadows to achieve the glass effect*/
            box-shadow: 0 0 0 7px rgba(255, 255, 255, 0.85),
            0 0 7px 7px rgba(0, 0, 0, 0.25),
            inset 0 0 40px 2px rgba(0, 0, 0, 0.25);

            /*hide the glass by default*/
            display: none;
        }    </style>
      <main>
        <section class="slider-product">
        </section>
        <section class="main-news">
            <div class="container">
                <div class="col-md-12 links-home">
                    <h5>{{$labels[21]->name}} / {{$products->collection_name}} - {{$products->product_name}}</h5>
                    <hr>
                </div>
                <div class="col-md-12 news detail-product">
                    <div class="col-md-9 news-content">
                        <div class="col-md-4 image-label" style="padding: 0px 15px 0px 0px">
                        
                            <img src="{{asset('images/products')}}/{{$products->avatar}}" alt="{{$products->slug}}">
                            <button class="btn" onclick="ftGetSubscribeWine('{{$products->id}}')">{{$labels[12]->name}}</button>
                         <div style="padding-top: 30px">
                            <div class="fb-send" data-href="{{url('')}}/{{$id}}-{{$slug}}/{{Session::get('locale')}}-{{$products->id}}-{{$products->slug}}"></div>
                            <div class="fb-like" data-href="{{url('')}}/{{$id}}-{{$slug}}/{{Session::get('locale')}}-{{$products->id}}-{{$products->slug}}" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
                            <div class="fb-share-button" data-href="{{url('')}}/{{$id}}-{{$slug}}/{{Session::get('locale')}}-{{$products->id}}-{{$products->slug}}" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">Chia sẻ</a></div>
                            <script src="https://apis.google.com/js/platform.js" async defer></script>
                            <div class="g-plus" style="margin-top: 20px" data-action="share" data-href="{{url('')}}/{{$id}}-{{$slug}}/{{Session::get('locale')}}-{{$products->id}}-{{$products->slug}}"></div>
			</div>
                        </div>
                        <div class="col-md-8">
                            <div class="div-top">
                                <h5>{{$products->brand_name}}</h5>
                                <h4>{{$products->product_name}}</h4>
                                <p>{!! $products->content !!}</p>
                            </div>
                            <hr>
                            <div class="div-bottom">
                                <div class="col-md-6 row" style="padding-right: 30px">
                                    <p>{{$labels[73]->name}}: <span>{{$products->collection_name}}</span></p>
                                    <p>{{$labels[74]->name}}: <span>{{$products->brand_name}}</span></p>
                                    <p>{{$labels[75]->name}}: <span>{{$products->alcohol}}</span></p>
                                </div>
                                <div class="col-md-6 row">
                                    <p>{{$labels[76]->name}}: <span>{{$products->mililitre}}</span></p>
                                    <p>{{$labels[77]->name}}: <span>{{$products->grape}}</span></p>
                                    <p>{{$labels[78]->name}}: <span>{{$products->grape_local}}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row" style="margin-top: 30px">
                            <div class="nav-tabs-custom tab-detail-product">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_detail" data-toggle="tab" aria-expanded="true" style="padding-left: 0px">{{$labels[79]->name}}</a></li>
                                    <li><a href="#tab_comment" data-toggle="tab" aria-expanded="true">{{$labels[80]->name}}</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_detail">
                                        <p>{!! $products->info !!}</p>
                                    </div>
                                    <div class="tab-pane" id="tab_comment">
                                        <div class="fb-comments" data-href="{{url('')}}/{{$id}}-{{$slug}}/{{Session::get('locale')}}-{{$products->id}}-{{$products->slug}}" data-numposts="5"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="col-md-12 row other-detail product products-other" style="padding-top: 30px; padding-bottom: 0px">
                        	 <h3>{{$labels[71]->name}}</h3>

                            <section class="regular-other">
                                <div class="slider">
                                    @foreach($product_others as $item)
                                        <div class="col-md-4 grid">
                                            <div class="product-image ">
                                                <figure class="effect-zoe">
                                                    <img src="{{asset('images/products')}}/{{$item->avatar}}"  alt="{{$item->slug}}">
                                                    
                                                    <figcaption>
                                                        {{--<h2> <a class="btn" onclick="ftGetSubscribeWine('{{$item->id}}')">{{$labels[12]->name}}</a></h2>--}}
                                                        <p class="description">
                                                            <a class="title" href="{{url('')}}/{{$id}}-{{$slug}}/{{Session::get('locale')}}-{{$item->id}}-{{$item->slug}}" title="{{$item->product_name}}">
                                                                {{--{{$item->collection_name}} - {{$item->product_name}}--}}
                                                                <i style="color: #f7c068; margin-right: 5px;" class="fa fa-arrow-right"></i>{{$labels[83]->name}}
                                                            </a>
                                                        </p>
                                                        
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div style="clear: both"></div>
                                            <div class="product-text">
                                                <div style="clear: both"></div>
                                                <div class="br-product ">
                                                    <h5>{{$item->brand_name}}</h5>
                                                    <a class="title a-product btn-change-title"
                                                       href="{{url('')}}/{{$slug_product->id}}-{{$slug_product->slug}}/{{Session::get('locale')}}-{{$item->id}}-{{$item->slug}}"
                                                       title="{{$item->product_name}}">{{$item->collection_name}}
                                                        - {{$item->product_name}}</a>
                                                </div>
                                                <a style="top: -26.5em;" class="btn" onclick="ftGetSubscribeWine('{{$item->id}}')"><i><img style="width: 25px;" src="{{asset('images/home/glass.jpg')}}"></i>{{$labels[12]->name}}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="col-md-3 product-news">
                        <div class="product-highlights">
                            <h4>{{$labels[72]->name}}</h4>
                            <hr>
                            <ul class="menu-product-right">
                                @if($menu_product !=null)
                                    @foreach($menu_product as $item)
                                        <li><a href="{{url('/')}}/{{$search}}/{{$item->slug}}/collection-{{$item->id}}/filter-product"><i class="zmdi zmdi-mail-send"></i>{{$item->name}}</a></li>
                                    @endforeach
                                @endif

                                <div class="clearfix"></div>
                            </ul>
                        </div>
                        <div class="product-highlights">
                            <h4>{{$labels[37]->name}}</h4>
                            <hr>
                            <ul>
                                @if($products_1 !=null)
                                    @foreach($products_1 as $product_1)
                                        <li>
                                            <img src="{{asset('images/products/')}}/{{$product_1->avatar}}"  alt="{{$product_1->slug}}">
                                            <a href="{{url('')}}/{{$slug_product->id}}-{{$slug_product->slug}}/{{Session::get('locale')}}-{{$product_1->id}}-{{$product_1->slug}}">{{$product_1->collection_name}} - {{$product_1->product_name}}</a>
                                        </li>
					<div class="clearfix"></div>

                                    @endforeach
                                @endif
                             </ul>
                        </div>
                        <div class="product-highlights">
                            <h4>{{$labels[24]->name}}</h4>
                            <hr>
                            <ul>
                                @if($products_2 !=null)
                                    @foreach($products_2 as $product_1)
                                        <li>
                                            <img src="{{asset('images/products/')}}/{{$product_1->avatar}}"  alt="{{$product_1->slug}}">
                                            <a href="{{url('')}}/{{$slug_product->id}}-{{$slug_product->slug}}/{{Session::get('locale')}}-{{$product_1->id}}-{{$product_1->slug}}">{{$product_1->collection_name}} - {{$product_1->product_name}}</a>
                                        </li>
                                        <div class="clearfix"></div>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @if(Session::get('message'))
            @if(Session::get('message')==1)
                <script>
                    $(function() {
                        document.getElementById("txtMessage").innerHTML = "{{$labels[42]->name}}";
                        $('#modalConfirm').modal('show');
                    });
                </script>
            @else
                <script>
                    $(function() {
                        document.getElementById("txtMessage").innerHTML = "{{$labels[43]->name}}";
                        $('#modalConfirm').modal('show');
                    });
                </script>
            @endif
        @endif
    </main>
     <script>
       function share_fb(url) {
           window.open('https://www.facebook.com/sharer/sharer.php?u=' + url, 'facebook-share-dialog', "width=626,height=436")
       }</script>
    <script>
     $(document).ready(function(){
     		getThumbnail();
       });
        function getThumbnail()
	{
		var native_width = 0;
            var native_height = 0;
            $(".large").css("background","url('" + $(".small").attr("src") + "') no-repeat");
            $(".magnify").mousemove(function(e){
                if(!native_width && !native_height)
                {
                    var image_object = new Image();
                    image_object.src = $(".small").attr("src");
                    native_width = image_object.width;
                    native_height = image_object.height;
                }
                else
                {
                    var magnify_offset = $(this).offset();
                    var mx = e.pageX - magnify_offset.left;
                    var my = e.pageY - magnify_offset.top;
                    if(mx < $(this).width() && my < $(this).height() && mx > 0 && my > 0)
                    {
                        $(".large").fadeIn(200);
                    }
                    else
                    {
                        $(".large").fadeOut(200);
                    }
                    if($(".large").is(":visible"))
                    {
                        var rx = Math.round(mx/$(".small").width()*native_width - $(".large").width()/2)*-1;
                        var ry = Math.round(my/$(".small").height()*native_height - $(".large").height()/2)*-1;
                        var bgp = rx + "px " + ry + "px";
                        var px = mx - $(".large").width()/2;
                        var py = my - $(".large").height()/2;
                        $(".large").css({left: px, top: py, backgroundPosition: bgp});
                    }
                }
            })

	}        
        $('.img-thumb').on('click',function () {
            $('.thumb-product-detail .thumbnail').removeClass('active');
            $(this).parent('.thumbnail').addClass('active');
            var src=$(this).attr('src');
            $('#imageDetail').attr('src',src);
            getThumbnail();
        });
    </script>

@endsection