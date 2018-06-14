<section class="footer-wine">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <ul class="logo-slogan">
                    <li><img src="{{asset('images/home/logo.png')}}"></li>
                    <li><p>{{$labels[69]->name}}</p></li>
                </ul>
            </div>
            <div class="col-md-2 col-sm-6">
                <h5>{{$labels[63]->name}}</h5>
                <ul>
                    @if($menu !=null)
                        @for($i=0; $i<count($menu);$i++)
                            @if($i==0)
                                <li><a href="{{url('/')}}">{{$menu[$i]->name}}</a></li>
                            @else
                                <li><a href="{{url('')}}/{{$menu[$i]->language_id}}-{{$menu[$i]->id}}-{{$menu[$i]->slug}}">{{$menu[$i]->name}}</a></li>
                            @endif
                        @endfor
                    @endif
                </ul>
            </div>
            <div class="col-md-4 col-sm-6">
                <h5>{{$labels[64]->name}}</h5>
                <ul>
                    <li><span>
                            @if($address!=null)
                                @foreach($address as $item)
                                    {{$item->name}}: {!! strip_tags($item->content) !!}<br>
                                @endforeach
                            @endif
                        </span></li>
                    <li><span>{{$config->email}}</span></li>
                    @if($address!=null)
                        @foreach($address as $item)
                            <li>  <span>{{$item->name}}: <a href="tel:{{$item->phone}}">{{$item->phone}}</a> </span></li>
                        @endforeach
                    @endif

                </ul>
            </div>

            <div class="col-md-3 col-sm-6">
                <h5>{{$labels[65]->name}}</h5>
                <ul class="social">
                    <li><a href="{{$config->facebook_link}}" target="_blank"><i class="fa fa-facebook wow shake" aria-hidden="true"></i></a></li>
                    <li><a href="{{$config->twiter_link}}" target="_blank"><i class="fa fa-twitter wow shake" aria-hidden="true"></i></a></li>
                    <li><a href="{{$config->googleplus_link}}" target="_blank"><i class="fa fa-google-plus wow shake" aria-hidden="true"></i></a></li>
                    <li><a href="{{$config->linked_link}}" target="_blank"><i class="fa fa-linkedin wow shake" aria-hidden="true"></i></a></li>
                    <li><a href="{{$config->youtube_link}}" target="_blank"><i class="fa fa-pinterest wow shake" aria-hidden="true"></i></a></li>
                </ul>
                <div class="fb-page" data-href="https://www.facebook.com/Wine-Center-844611649026980/" data-tabs="timeline" data-height="200" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/Wine-Center-844611649026980/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Wine-Center-844611649026980/">Wine Center</a></blockquote></div>
            </div>
        </div>
        <div class="clearfix"></div>
        <p class="text-center footer-p" style="margin-top: 20px; margin-top: 20px;font-size: 12px; font-weight: 300;">{!! $labels[19]->name !!}</p>
    </div>
</section>
<a class="showTop" href="#top"><i class="fa fa-chevron-up"></i></a>
<script>
    $(document).ready(function () {
        $("a[href='#top']").click(function() {
            $("html, body").animate({ scrollTop: 0 }, "slow");
            return false;
        });
    })
</script>