@extends('home.layouts.master_detail')
@section('url'){{url('')}}/{{$id}}-{{$slug}}/{{$news->id}}/{{$news->slug}}.html @endsection
@section('title'){{$news->news_name}}@endsection
@section('keywords'){{$news->news_tags}}@endsection
@section('image'){{asset('images/news')}}/{{$news->avatar}}@endsection
@section('Content')
     <main>
        <section class="slider-news">
        </section>
        <section class="main-news">
            <div class="container">
                <div class="col-md-12 links-home">
                    <h5>{{$labels[20]->name}} / {{$labels[26]->name}} / {{$news->news_name}}</h5>
                    <hr>
                </div>
                <div class="col-md-12 news">
	                <div class="col-md-12 row product-news div-search-news">
	                        <form action="{{url('')}}/{{$active_menu}}-{{$slug}}/search-news" method="GET">
	                            <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
	                            <input type="text" class="form-control" name="search_news" placeholder="{{$labels[44]->name}}">
	                            <button type="submit"><i class="fa fa-search"></i></button>
	                        </form>
	                    </div>
	                    <div class="clearfix"></div>
                    <div class="col-md-9 col-sm-8 news-content">
                        <h1>{{$news->news_name}}</h1>
                        <p style="margin-top: 10px;">Published on {{date("d/m/Y", strtotime($news->date))}}</p>
                        <img src="{{asset('images/news')}}/{{$news->avatar}}"  alt="{{$news->news_name}}">
                        <p>{!! $news->news_content !!}</p>

                         <div class="col-md-12" style="padding: 10px 20px">
                            <div class="fb-like" data-href="{{url('')}}/{{$id}}-{{$slug}}/{{$news->id}}/{{$news->slug}}" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
                            <div class="fb-share-button" data-href="{{url('')}}/{{$id}}-{{$slug}}/{{$news->id}}/{{$news->slug}}" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">Chia sẻ</a></div>
                            <script src="https://apis.google.com/js/platform.js" async defer></script>

                            <!-- Place this tag where you want the share button to render. -->
                            <div class="g-plus" data-action="share" data-href="{{url('')}}/{{$id}}-{{$slug}}/{{$news->id}}/{{$news->slug}}"></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 product-news detail-content-news">
                        <form action="{{url('')}}/{{$active_menu}}-{{$slug}}/search-news" method="GET" class="search-news-desktop">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                            <input type="text" class="form-control" name="search_news" placeholder="{{$labels[44]->name}}">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                        <div class="clearfix"></div>
                        <div class="product-highlights">
                            <h4>{{$labels[37]->name}}</h4>
                            <hr>
                            <ul>
                                @if($products_1 !=null)
                                    @foreach($products_1 as $product_1)
                                        <li>
                                            <img src="{{asset('images/products/')}}/{{$product_1->avatar}}" alt="{{$product_1->slug}}">
                                            <a href="{{url('')}}/{{$slug_product->id}}-{{$slug_product->slug}}/{{Session::get('locale')}}-{{$product_1->id}}-{{$product_1->slug}}">{{$product_1->collection_name}} - {{$product_1->product_name}}</a>
                                        </li>
                                        <div class="clearfix"></div>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                        <div class="product-highlights">
                            <h4>{{$labels[24]->name}}</h4>
                            <hr>
                            <ul>
                                @if($products_2 !=null)
                                    @foreach($products_2 as $product_2)
                                        <li>
                                            <img src="{{asset('images/products/')}}/{{$product_2->avatar}}" alt="{{$product_2->slug}}">
                                            <a href="{{url('')}}/{{$slug_product->id}}-{{$slug_product->slug}}/{{Session::get('locale')}}-{{$product_2->id}}-{{$product_2->slug}}">{{$product_2->collection_name}} - {{$product_2->product_name}}</a>
                                        </li>
                                        <div class="clearfix"></div>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                @if(count($news_others) !=0)
                <div class="col-md-12 news-other">
                    <hr>
                    <h3>{{$labels[25]->name}}</h3>
                    <ul>
                        @foreach($news_others as $item)
                            <li><a href="{{url('')}}/{{$id}}-{{$slug}}/{{Session::get('locale')}}-{{$item->id}}-{{$item->slug}}"><i class="zmdi zmdi-mail-send"></i>{{$item->news_name}}</a></li>
                       @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </section>
    </main>
    @endsection