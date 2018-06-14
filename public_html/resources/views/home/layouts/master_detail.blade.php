<!DOCTYPE html>
<html @if(Session::get('locale')==1) lang="vi" @else lang="en" @endif>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{--<link rel="stylesheet" href="{{asset('css/styles.css')}}">--}}
    <meta name="description" content="{{$config->seo_description}}"/>
    <meta name="author"  content="{{$config->seo_author}}"/>
    <meta name="keywords"  content="@yield('keywords')"/>
    <meta property="og:site_name" content="Wine Center">
    <link rel="canonical" href="@yield('url')" />
    <meta property="og:url"           content="@yield('url')" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="@yield('title') Wine Center" />
    <meta property="og:description"   content="{{$config->seo_description}}" />
    <meta property="og:image"         content="@yield('image')" />
    <meta property="og:image:width" content="450"/>
	<meta property="og:image:height" content="298"/>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('css/slick-theme.css')}}">
    <link rel="stylesheet" href="{{asset('css/normalize.css')}}">
    {{--<link rel="stylesheet" href="{{asset('css/demo.css')}}">--}}
    <link rel="stylesheet" href="{{asset('css/set1.css')}}">
    <link rel="stylesheet" href="{{asset('css/ionicons.css')}}">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/animate.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <link rel="icon" href="{{asset('images/home/logo-icon.ico')}}">
    <script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('js/bootstrap.min.js')}}" type="text/javascript" charset="utf-8"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <script src="{{asset('js/slick.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('js/slick-custom.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('js/jquery.validate.js')}}"></script>
    <script src="{{asset('js/wow.min.js')}}"></script>
    <script>
        new WOW().init();
    </script>    {!! $config->google_analytic !!}
</head>
<body onscroll="ftScroll()" id="body">
    @include('home.layouts.header')
    {{--@include('layouts.menu')--}}
    @yield('Content')
    @include('home.layouts.footer_detail')
<script>
        function ftScroll() {
            //var elmnt = document.getElementById("menuHome");
            var x = body.scrollTop;
           if(x==0)
            {
                document.getElementById('menuHome').style.borderBottom='0px solid rgba(214, 182, 141, 0.6)';
            }
            else{
                document.getElementById('menuHome').style.borderBottom='1px solid rgba(214, 182, 141, 0.6)';
            }
        }
    </script>
</body>

</html>
