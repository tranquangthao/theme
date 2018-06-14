@extends('home.layouts.master_detail')
@section('title'){{$title}}@endsection
@section('image'){{URL::asset('images/home/banner-news.jpg')}}@endsection
@section('url'){{url('/')}}@endsection
@section('Content')
  <main>
        <section class="slider-wine-center">
        </section>
        <section class="main-contact">
            <div class="container">
                <div class="col-md-12 links-home">
                    <h5>{{$labels[20]->name}} / {{$title}} </h5>
                    <hr>
                </div>
                <div class="col-md-12 info-contact">
                    <div class="col-md-6 col-sm-6">
                        <h5>{{$labels[28]->name}}</h5>
                        @if($address!=null)
                           @foreach($address as $item)
                                <p>{{$item->name}}: {{strip_tags($item->content)}}</p>
                            @endforeach
                        @endif
                        <br>
                        <p>{{$config->email}}</p><br>
                        @if($address!=null)
                            @foreach($address as $item)
                                <p>{{$item->name}}: {{$item->phone}}</p>
                            @endforeach
                        @endif

                    </div>
                    <div class="col-md-6 col-sm-6 div-contact-right">
                        <h5>{{$labels[27]->name}}</h5>
                        <p>{{$labels[66]->name}}</p>
                        <p>{{$labels[67]->name}}</p><br>
                        <p>{{$labels[68]->name}}:</p>
                        <p>{{$config->phone_number}}</p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-10 col-md-offset-1 site-map">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom tab-product">
                            <ul class="nav nav-tabs">
                                @if($address!=null)
                                    @for($i=0;$i<count($address);$i++)
                                        @if($i==0)
                                            <li class="active"><a href="#tab_{{$address[$i]->id}}" data-toggle="tab" aria-expanded="true">{{$address[$i]->name}}</a></li>
                                        @else
                                            <li><a href="#tab_{{$address[$i]->id}}" data-toggle="tab" aria-expanded="true">{{$address[$i]->name}}</a></li>
                                        @endif
                                    @endfor
                                @endif
                            </ul>
                            <div class="tab-content">
                                @if($address!=null)
                                    @for($i=0;$i<count($address);$i++)
                                        @if($i==0)
                                            <div class="tab-pane active" id="tab_{{$address[$i]->id}}">
                                                <iframe src="{{$address[$i]->sitemap}}"
                                                        width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                                            </div>
                                        @else
                                            <div class="tab-pane" id="tab_{{$address[$i]->id}}">
                                                <iframe src="{{$address[$i]->sitemap}}"
                                                        width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                                            </div>
                                        @endif
                                    @endfor
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="info-user">
                        <h5>{{$labels[82]->name}}</h5>
                        <form id="formContact" class="form-contact" action="{{url('submit-contact')}}" method="post">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                            <div class="col-md-4 col-sm-4">
                                <input type="text" class="form-control" name="name" required placeholder="{{$labels[30]->name}}">
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <input type="text" class="form-control" name="email" required placeholder="{{$labels[31]->name}}">
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <input type="text" class="form-control" name="phone" onkeyup=" return numberphone(this)" maxlength="15" required placeholder="{{$labels[32]->name}}">
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-12">
                                <textarea class="form-control" name="message" required placeholder="{{$labels[33]->name}}" rows="8"></textarea>
                            </div>
                                                        <div class="col-md-12">
                                <input type="submit" id="btnSend" value="{{$labels[29]->name}}">
                            </div>
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
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
        <script>
        jQuery(document).ready(function() {
            jQuery('#formContact').validate({
                rules: {
                    "rekey": {
                        equalTo: "#key"
                    },
                    "email":{
                        email:true
                    }
                },
                messages:{
                    name: {
                        required: 'Tên không trống.'
                    },
                    email: {
                        required: 'Email không được trống.',
                        email: 'Email không hợp lệ'
                    },
                    phone: {
                        required: 'Số điện thoại không được trống.'
                    },
                    "rekey": {
                        required: 'Chưa nhập mã xác nhận.',
                        equalTo: 'Mã xác nhận chưa đúng'
                    },
                    message:{
                        required: 'Nội dung không được trống.',
                    }
                }
            });
            jQuery('#btnSend').click(function(evt) {
                evt.preventDefault();
                jQuery('#formContact').submit()
            });
        });
        function numberphone(input) {
            input.value = input.value.replace(/[^0-9\.\-\+\(\)\s]/g,'');
        }
    </script>
@endsection