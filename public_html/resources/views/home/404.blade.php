<!DOCTYPE html>
<html>
<head>
    <title>Error Wine Center</title>
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style_404.css')}}">
    <link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:400,200italic,200,300,300italic,400italic,600,600italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <!-- For-Mobile-Apps-and-Meta-Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Simple Error Page Widget Responsive, Login Form Web Template, Flat Pricing Tables, Flat Drop-Downs, Sign-Up Web Templates, Flat Web Templates, Login Sign-up Responsive Web Template, Smartphone Compatible Web Template, Free Web Designs for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- //For-Mobile-Apps-and-Meta-Tags -->

</head>
<body>
<div class="main w3l">
    <img src="{{asset('images/home')}}/{{$config->logo}}" style="width: 30%">
    <h1>PAGE ERROR 404</h1>
    <h3>"Sorry ! the page you are looking for can't be found"</h3>
    <a href="{{url('/')}}" class="back">BACK TO HOME</a>
    <div class="social-icons w3">
        <ul>
            <li><a target="_blank" href="{{$config->facebook_link}}"><i class="fa fa-facebook" aria-hidden="true" style="padding: 10px 15px"></i></a></li>
            <li><a target="_blank" href="{{$config->twiter_link}}"><i class="fa fa-twitter" aria-hidden="true" style="padding: 10px"></i></a></li>
            <li><a target="_blank" href="{{$config->googleplus_link}}"><i class="fa fa-google-plus" aria-hidden="true" style="padding: 10px 7px"></i></a></li>
            <li><a target="_blank" href="{{$config->linked_link}}"><i class="fa fa-linkedin" aria-hidden="true" style="padding: 10px 12px"></i></a></li>
            <li><a arget="_blank" href="{{$config->youtube_link}}"><i class="fa fa-pinterest" aria-hidden="true" style="padding: 10px 12px"></i></a></li>
        </ul>
    </div>
</div>

</body>
</html>