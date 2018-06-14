
<div class="dropdown menu-search" style="float: left; margin-top: -1px; margin-left: -1px">
    {{--<button class="btn btn-primary dropdown-toggle menu-header" id="menu11" onclick="myFunctionClick()" type="button" data-toggle="dropdown"><i class="fa fa-bars" aria-hidden="true"></i></button>--}}
    {{--<ul class="dropdown-menu dropdown-menu-search" role="menu" aria-labelledby="menu1">--}}
        {{--<li><a>{{$labels[0]->name}}</a>--}}
            {{--<ul class="li-search">--}}
                {{--@if($brands !=null)--}}
                    {{--@foreach($brands as $item)--}}
                        {{--<li><a href="{{url('/')}}/{{$search}}/{{$item->slug}}/brand-{{$item->id}}/filter-product">{{$item->name}}</a></li>--}}
                        {{--<li><a href="{{url('/12.html')}}">{{$item->name}}</a></li>--}}
                    {{--@endforeach--}}
                {{--@endif--}}

            {{--</ul>--}}
        {{--</li>--}}
        {{--<li><a>{{$labels[1]->name}}</a>--}}
            {{--<ul class="li-search">--}}
                {{--<li><a href="{{url('/')}}/san-pham/price-1/filter-product">{{$labels[8]->name}}</a></li>--}}
                {{--<li><a href="{{url('/')}}/san-pham/price-2/filter-product">{{$labels[9]->name}}</a></li>--}}
                {{--<li><a href="{{url('/')}}/san-pham/price-3/filter-product">{{$labels[10]->name}}</a></li>--}}
                {{--<li><a href="{{url('/')}}/san-pham/price-4/filter-product">{{$labels[11]->name}}</a></li>--}}
            {{--</ul>--}}
        {{--</li>--}}
        {{--<li><a>{{$labels[2]->name}}</a>--}}
            {{--<ul class="li-search">--}}
                {{--@if($collections !=null)--}}
                    {{--@foreach($collections as $item)--}}
                        {{--<li><a href="{{url('/')}}/{{$search}}/{{$item->slug}}/collection-{{$item->id}}/filter-product">{{$item->name}}</a></li>--}}
                    {{--@endforeach--}}
                {{--@endif--}}

            {{--</ul>--}}
        {{--</li>--}}
    {{--</ul>--}}
    <div class="col-md-12" id="menuSearch">
        <div class="col-md-4">
           <a class="a-menu">{{$labels[0]->name}}</a>
                <ul class="li-search">
                    @if($brands !=null)
                        @foreach($brands as $item)
                            <li><a href="{{url('/')}}/{{$search}}/{{$item->slug}}/brand-{{$item->id}}/filter-product">{{$item->name}}</a></li>
                        @endforeach
                    @endif
                </ul>
        </div>
        <div class="col-md-4">
            <a class="a-menu">{{$labels[1]->name}}</a>
            <ul class="li-search">
            <li><a href="{{url('/')}}/san-pham/price-1/filter-product">{{$labels[8]->name}}</a></li>
            <li><a href="{{url('/')}}/san-pham/price-2/filter-product">{{$labels[9]->name}}</a></li>
            <li><a href="{{url('/')}}/san-pham/price-3/filter-product">{{$labels[10]->name}}</a></li>
            <li><a href="{{url('/')}}/san-pham/price-4/filter-product">{{$labels[11]->name}}</a></li>
            </ul>
        </div>
        <div class="col-md-4">
            <a class="a-menu">{{$labels[2]->name}}</a>
            <ul class="li-search">
            @if($collections !=null)
            @foreach($collections as $item)
            <li><a href="{{url('/')}}/{{$search}}/{{$item->slug}}/collection-{{$item->id}}/filter-product">{{$item->name}}</a></li>
            @endforeach
            @endif

            </ul>
        </div>
    </div>
    <input type="checkbox" id="toggle-menu" onclick="myFunctionClick()" class="toggle-menu" name="">
    <label for="toggle-menu">
        <span class="menu-bar"></span>
        <span class="menu-bar"></span>
        <span class="menu-bar"></span>
    </label>
</div>

<script>
    var x = document.getElementById('menuSearch');
    x.style.display = 'none';
    function myFunctionClick() {
       // var x = document.getElementById('menuSearch');
        if (x.style.display === 'none') {
            x.style.display = 'block';
        } else {
            x.style.display = 'none';
        }
    }
</script>