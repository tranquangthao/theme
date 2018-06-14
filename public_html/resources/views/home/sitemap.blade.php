<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>http://ruouvanghaohang.com/</loc>
    </url>
    {{--<url>--}}
        {{--<loc>https://hadoriversides.com.vn/gioi-thieu.html</loc>--}}
    {{--</url>--}}
    {{--<url>--}}
        {{--<loc>https://hadoriversides.com.vn/vi-tri.html</loc>--}}
    {{--</url>--}}

    {{--<url>--}}
        {{--<loc>https://hadoriversides.com.vn/tien-ich.html</loc>--}}
    {{--</url>--}}
    {{--<url>--}}
        {{--<loc>https://hadoriversides.com.vn/mat-bang.html</loc>--}}
    {{--</url>--}}
    {{--<url>--}}
        {{--<loc>https://hadoriversides.com.vn/can-ho-mau.html</loc>--}}
    {{--</url>--}}
    {{--<url>--}}
        {{--<loc>https://hadoriversides.com.vn/thanh-toan.html</loc>--}}
    {{--</url>--}}
    {{--<url>--}}
        {{--<loc>https://hadoriversides.com.vn/lien-he.html</loc>--}}
    {{--</url>--}}
    @if(count($products) !=0)
        @foreach($products as $pro)
            <url>
                <loc>{{url('2-products')}}/{{Session::get('locale')}}-{{$pro->id}}-{{$pro->slug}}</loc>
                <loc>{{url('2-san-pham')}}/{{Session::get('locale')}}-{{$pro->id}}-{{$pro->slug}}</loc>
            </url>
        @endforeach
    @endif
    @if(count($news) !=0)
        @foreach($news as $new)
            <url>
                <loc>{{url('3-kien-thuc-ruou-vang')}}/{{Session::get('locale')}}-{{$new->id}}-{{$new->slug}}</loc>
                <loc>{{url('3-wine-knowledge')}}/{{Session::get('locale')}}-{{$pro->id}}-{{$pro->slug}}</loc>
            </url>
        @endforeach
    @endif
    
</urlset>