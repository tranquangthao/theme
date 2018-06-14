<ul class="nav navbar-nav navbar-right menu-home">
    @if($menu !=null)
        @for($i=0; $i<count($menu);$i++)
            @if($menu[$i]->id==$active_menu)
                @if($i==0)
                    <li><a class="active" href="{{url('/')}}">{{$menu[$i]->name}}</a></li>
                @else
                    @if($menu[$i]->id==4)
                        <li class="dropdown"><a class="active dropdown-toggle" data-toggle="dropdown" href="{{url('')}}/{{$menu[$i]->language_id}}-{{$menu[$i]->id}}-{{$menu[$i]->slug}}">{{$menu[$i]->name}}<span class="caret"></span></a>
                            <ul class="dropdown-menu menu-wine-center">
                                @if($menu_wine !=null)
                                    @foreach($menu_wine as $item)
                                        <li>
                                            <a href="{{url('/')}}/{{$menu[$i]->slug}}/{{$menu[$i]->id}}-{{$item->id}}/{{$item->slug}}">{{$item->name}}</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                        
                    @else
                        <li><a class="active" href="{{url('')}}/{{$menu[$i]->language_id}}-{{$menu[$i]->id}}-{{$menu[$i]->slug}}">{{$menu[$i]->name}}</a></li>
                    @endif

                @endif
            @else
                @if($i==0)
                    <li><a href="{{url('/')}}">{{$menu[$i]->name}}</a></li>
                @else
                    @if($menu[$i]->id==4)
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="{{url('')}}/{{$menu[$i]->language_id}}-{{$menu[$i]->id}}-{{$menu[$i]->slug}}">{{$menu[$i]->name}} <span class="caret"></span></a>
                            <ul class="dropdown-menu menu-wine-center">
                                @if($menu_wine !=null)
                                    @foreach($menu_wine as $item)
                                        <li>
                                            <a href="{{url('/')}}/{{$menu[$i]->slug}}/{{$menu[$i]->id}}-{{$item->id}}/{{$item->slug}}">{{$item->name}}</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                       
                    @else
                        <li><a href="{{url('')}}/{{$menu[$i]->language_id}}-{{$menu[$i]->id}}-{{$menu[$i]->slug}}">{{$menu[$i]->name}}</a></li>
                    @endif

                @endif
            @endif

        @endfor
    @endif
    <!-- <li class="dropdown li-language"><a class="dropdown-toggle" data-toggle="dropdown" href="#">{{Session::get('locale_name')}} <span class="caret"></span></a>
        <ul class="dropdown-menu">
            @if($language!=null)
                @foreach($language as $item)
                    <li><a href="{{url('language')}}-{{$item->id}}">{{$item->language}}</a></li>
                @endforeach
            @endif
        </ul>
    </li> -->
    <li class="edit-flat"><a style="padding-top: 35px; padding-right: 10px;" href="{{url('language')}}-2"><img src="{{asset('images/home/usa.png')}}"></a></li>
    <li class="edit-flat"><a style="padding-top: 35px; padding-left: 10px;" href="{{url('language')}}-1"><img src="{{asset('images/home/vietnam.png')}}"></a></li>
    <li class="dropdown li-search-mobile"><a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color: #d0b68b;"><i class="fa fa-search" aria-hidden="true"></i></a>
        <ul class="dropdown-menu li-search" style=" border-radius: 0px;">
            <li>
                <form action="{{url('')}}/search-product" method="get">
                    <input type="text" name="name" class="form-control" placeholder="{{$labels[47]->name}}">
                    <input type="submit" class="btn" value="{{$labels[44]->name}}">
                </form>
            </li>
        </ul>
    </li>
</ul>