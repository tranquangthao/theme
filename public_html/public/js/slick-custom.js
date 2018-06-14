$(document).ready(function() {
    var w = screen.width;
    if(w<=420)
    {
        $(".regular .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1
        });
        $(".regular1 .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1
        });
        $(".regular2 .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1
        });
        $(".regular3 .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1
        });
        $(".banner-header .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
                   });
        $(".regular-other .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1
        });
        $(".product-image .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1
        });
    }
    else if(w<=768)
    {
        $(".regular .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 2,
                        slidesToScroll: 2
        });
        $(".regular1 .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 2
        });
        $(".regular2 .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 2
        });
        $(".regular3 .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 2
        });
        $(".banner-header .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 2,
           
        });
        $(".regular-other .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 2
        });
        $(".product-image .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1
        });
    }
    else if(w<=1040)
    {
        $(".regular .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
        $(".regular1 .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
        $(".regular2 .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
        $(".regular3 .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
        $(".banner-header .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            
        });
        $(".regular-other .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            autoplay: true,
            slidesToScroll: 3
        });
        $(".product-image .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 2
        });
    }
    else
    {
        $(".regular .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 4,
                       slidesToScroll: 4
        });
        $(".regular1 .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 4,
                       slidesToScroll: 4
        });
        $(".regular2 .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 4,
                       slidesToScroll: 4
        });
        $(".regular3 .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 4,
            
            slidesToScroll: 4
        });
        $(".banner-header .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            
        });
        $(".product-image .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
        $(".regular-other .slider").slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll:3,
           
        });
    }

});