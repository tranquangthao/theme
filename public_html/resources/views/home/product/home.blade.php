@extends('home.layouts.master_detail')
@section('url'){{url('/')}}@endsection
@section('keywords'){{$config->seo_keyword}}@endsection
@section('title'){{$title}}@endsection
@section('image'){{URL::asset('images/home/banner-product.jpg')}}@endsection
@section('Content')
   <main>
        <section class="slider-product">

        </section>
        <section class="main-product">
            <div class="container">
                <div class="col-md-12 links-home">
                    <h5>{{$labels[20]->name}} / {{$labels[22]->name}}</h5>
                    <div class="filter-product">
                        <ul>
                            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">{{$labels[53]->name}}<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{url('')}}/{{$slug}}/order-by-1/filter.html">{{$labels[53]->name}}</a></li>
                                    <li><a href="{{url('')}}/{{$slug}}/order-by-2/filter.html">{{$labels[54]->name}}</a></li>
                                    <li><a href="{{url('')}}/{{$slug}}/order-by-3/filter.html">{{$labels[55]->name}}</a></li>
                                    <li><a href="{{url('')}}/{{$slug}}/order-by-4/filter.html">{{$labels[56]->name}}</a></li>
                                    <li><a href="{{url('')}}/{{$slug}}/order-by-5/filter.html">{{$labels[57]->name}}</a></li>
                                    <li><a href="{{url('')}}/{{$slug}}/order-by-6/filter.html">{{$labels[58]->name}}</a></li>
                                    <li><a href="{{url('')}}/{{$slug}}/order-by-7/filter.html">{{$labels[59]->name}}</a></li>
                                    <li><a href="{{url('')}}/{{$slug}}/order-by-8/filter.html">{{$labels[60]->name}}</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                </div>
                <div class="col-md-12 main-news">
                    <div class="col-md-3 col-sm-3 div-menu">
                        <ul class="menu-product">
                            <li class="item1"><a>{{$labels[72]->name}}</a></li>
                            @if($menu_product !=null)
                                @foreach($menu_product as $item)

                                        <li class="item2">
                                            <a href="{{url('/')}}/{{$search}}/{{$item->slug}}/collection-{{$item->id}}/filter-product">{{$item->name}}
                                            </a>
                                        </li>

                                @endforeach
                            @endif
                        </ul>
                        <img src="{{asset('images/home/product_list.jpg')}}" class="img-responsive" alt="img_list" style="width: 100%">
                        <img src="{{asset('images/home/vector.png')}}" alt="img_vector" style="margin-top: 30px; width: 100%" class="img-responsive">
                    </div>
                    <div class="col-md-9 col-sm-9 product">
                        <div class="col-md-12 menu-country">
                            <ul>
                                @if($country!=null)
                                    @foreach($country as $key=>$coun)
                                        @if($key==count($country)-1)
                                            <li><a href="{{url('')}}/country-{{$coun->id}}/filter">{{$coun->name}}</a></li>
                                        @else
                                            <li><a href="{{url('')}}/country-{{$coun->id}}/filter">{{$coun->name}}</a></li>
                                            <li>/</li>
                                        @endif

                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-12">

                       
                        @if($products !=null)
                            @foreach($products as $pro)
                                <div class="col-md-4 col-sm-4 col-xs-6 grid">
                                    <div class="product-image">
                                        <figure style="z-index: 2;" class="effect-zoe">
                                            <img src="{{asset('images/products')}}/{{$pro->avatar}}" alt="{{$pro->slug}}">
                                            
                                            <figcaption>
                                                <p class="description">
                                                    <a class="title"
                                                       href="{{url('')}}/{{$active_menu}}-{{$slug}}/{{Session::get('locale')}}-{{$pro->id}}-{{$pro->slug}}"
                                                       title="{{$pro->product_name}}">
                                                        <i style="color: #f7c068; margin-right: 5px;" class="fa fa-arrow-right"></i>{{$labels[83]->name}}
                                                    </a>
                                                </p>
                                                
                                            </figcaption>
                                        </figure>
                                    </div>
                                    <div class="product-text">
                                        <div style="clear: both"></div>
                                        <div class="br-product ">
                                            <h5>{{$pro->brand_name}}</h5>
                                            <a class="title"
                                               href="{{url('')}}/{{$active_menu}}-{{$slug}}/{{Session::get('locale')}}-{{$pro->id}}-{{$pro->slug}}"
                                               title="{{$pro->product_name}}">{{$pro->collection_name}} - {{$pro->product_name}}
                                            </a>
                                        </div>
                                        <a style="top: 0; z-index: 3;" class="btn" onclick="ftGetSubscribeWine('{{$pro->id}}')"><i><img style="width: 25px;" src="{{asset('images/home/glass.jpg')}}"></i>{{$labels[12]->name}}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                         </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 text-center page-wine" style="margin-top: 30px">
                            {{$products->links()}}
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
    @endsection