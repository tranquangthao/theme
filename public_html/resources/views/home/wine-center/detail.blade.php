@extends('home.layouts.master_detail')
@section('title'){{$about->name}}@endsection
@section('image'){{URL::asset('images/home/banner-news.jpg')}}@endsection
@section('url'){{url('/')}}@endsection
@section('Content')
    <main>
        <section class="slider-wine-center">

        </section>
        <section class="main-news">
            <div class="container">
                <div class="col-md-12 links-home">
                    <h5>{{$labels[20]->name}} / {{$about->name}}</h5>
                    <hr>
                </div>
                <div class="col-md-12 news">
                    <div class="col-md-12 news-content">
                        <h1 style="text-align: center; text-transform: uppercase">{{$about->name}}</h1>
                        <p>{!! $about->content !!}</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @endsection