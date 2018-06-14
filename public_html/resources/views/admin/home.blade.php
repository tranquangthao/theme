@extends('admin.layout.master')
@section('content')

        <!-- top tiles -->
        <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
                <div class="count">{{$users}}</div>
               
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-product-hunt"></i> Total Product</span>
                <div class="count">{{$product}}</div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-newspaper-o"></i> Total News</span>
                <div class="count">{{$news}}</div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-bell"></i> Total Subscribe</span>
                <div class="count">{{$subscribes}}</div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-comment"></i> Total Wine Subscribe</span>
               <div class="count">{{$subscribe_wines}}</div>
            </div>
            
        </div>
        <!-- /top tiles -->

        

@endsection