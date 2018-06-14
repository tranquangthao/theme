@extends('home.layouts.master_detail')
@section('url'){{url('/')}}@endsection
@section('keywords'){{$config->seo_keyword}}@endsection
@section('title'){{$title}}@endsection
@section('image'){{URL::asset('images/home/banner-news.jpg')}}@endsection
@section('Content')
     <main>
        <section class="slider-news">
        </section>
        <section class="main-news">
            <div class="container">
                <div class="col-md-12 links-home">
                    <h5>{{$labels[20]->name}} / {{$title}}</h5>
                    <hr>
                </div>
                <div class="col-md-12 row news">
                 <div class="col-md-12 product-news div-search-news">
                        <form action="{{url('')}}/{{$active_menu}}-{{$slug}}/search-news" method="GET">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                            <input type="text" class="form-control" name="search_news" placeholder="{{$labels[44]->name}}">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-9 col-sm-8 news-content">
                        @if(count($news) !=0)
                            @foreach($news as $item)
                                <div class="col-md-6">
                                    <a class="title-news" href="{{url('')}}/{{$active_menu}}-{{$slug}}/{{Session::get('locale')}}-{{$item->id}}-{{$item->slug}}">{{$item->news_name}}</a>
                                    <p style="margin-top: 10px;">{{$item->menu_news_name}} - {{date("d/m/Y", strtotime($item->date))}}</p>
                                    <a href="{{url('')}}/{{$active_menu}}-{{$slug}}/{{Session::get('locale')}}-{{$item->id}}-{{$item->slug}}.html"><img src="{{asset('images/news')}}/{{$item->avatar}}"alt="{{$item->slug}}"></a>
                                    <p class="content"> {{strip_tags($item->content)}}
                                    </p>
                                </div>
                            @endforeach
                          @else
                          <h5>list is empty</h5>
                        @endif
                        <div class="col-md-12 text-center page-wine" style="margin-top: 30px">
                            {{$news->links()}}
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 product-news">
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
                                            <a href="{{url('')}}/{{$menu_product->id}}-{{$menu_product->slug}}/{{Session::get('locale')}}-{{$product_1->id}}-{{$product_1->slug}}">{{$product_1->collection_name}} - {{$product_1->product_name}}</a>
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
                                            <img src="{{asset('images/products/')}}/{{$product_2->avatar}}"  alt="{{$product_2->slug}}">
                                            <a href="{{url('')}}/{{$menu_product->id}}-{{$menu_product->slug}}/{{Session::get('locale')}}-{{$product_2->id}}-{{$product_2->slug}}">{{$product_2->collection_name}} - {{$product_2->product_name}}</a>
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
    </main>
    @endsection