@extends('admin.layout.master')
@section('content')
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
           {{--<a href="{{URL::asset('')}}admin/create-slider" class="btn btn-sm btn-success "><span--}}
            <a href="{{url('admin/create-new-slider')}}" class="btn btn-sm btn-success "><span
                        class="glyphicon glyphicon-plus"></span> Create slider</a>
            <div class="dashboard_graph">

                <div class="row x_title">
                    <div class="col-md-6">
                        <h3>Slider Management
                            {{--<small>Graph title sub-title</small>--}}
                        </h3>
                    </div>
                    <div class="col-md-6">
                        <span>Language: </span>
                        @foreach($language as $lang)
                            <a href="{{URL::asset('')}}admin/{{$lang->id}}-slider"
                               class="btn btn-xs btn-info">{{$lang->language}}</a>
                        @endforeach
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="col-md-12">
                    <table class="table table-bordered table-responsive projecttable">
                        <thead>
                        <tr>

                            <th width="25%">Slider's image</th>
                            <th width="40%">Slider's content </th>
                            <th width="5%">Sort order</th>
                             <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sliders as $slider)
                            <tr>
                                <td><img src="{{URL::asset('')}}images/slider/{{$slider->link}}" style="height:150px; width:100%" /></td>
                                <td>{{$slider->content_slider}}</td>
                                <td>{{$slider->sort_order}}</td>
                                  <td>
                                    @if($slider->status == 1)
                                        <a class="label label-success">Actived</a>
                                    @else
                                        <a class="label label-danger">Inactive</a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{URL::asset('')}}admin/edit-slider-{{$slider->id}}"
                                       class="btn btn-xs btn-primary "><span
                                                class="glyphicon glyphicon-pencil"></span>
                                        Edit</a>

                                    <a href="{{URL::asset('')}}admin/delete-slider-{{$slider->id}}"
                                       class="btn btn-xs btn-danger deletelink"><span
                                                class="glyphicon glyphicon-trash"></span> Delete</a>
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script>

        $('.deletelink').click(function (e) {
            var a_href = $(this).attr('href');
            /* Lấy giá trị của thuộc tính href */
            e.preventDefault();
            /* Không thực hiện action mặc định */
            $.ajax({
                /* Gửi request lên server */
                url: a_href, /* Nội dung trong Delete.cshtml cụ thể là deleteModal div được server trả về */
                type: 'GET',
                contentType: 'application/json; charset=utf-8',
                success: function (data) { /* Sau khi nhận được giá */
                    $('.body-content').prepend(data);
                    /* body-content div (định nghĩa trong _Layout.cshtml) sẽ thêm deleteModal div vào dưới cùng */
                    $('#deleteModal').modal('show');
                    /* Hiển thị deleteModal div dưới kiểu modal */
                }
            });
        });
    </script>
    <script>
        $(function () {
            $('.projecttable').DataTable({
                "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
                "iDisplayLength": 7,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true
            });
        });
    </script>



    {{--<script>--}}

    {{--$("#imgSlider").on('change', function () {--}}
    {{--if (typeof (FileReader) != "undefined") {--}}

    {{--var image_holder = $("#image-holder");--}}
    {{--image_holder.empty();--}}

    {{--for (i = 0; i < $(this)[0].files.length; i++) {--}}
    {{--var reader = new FileReader();--}}
    {{--reader.onload = function (e) {--}}
    {{--$("<img />", {--}}
    {{--"src": e.target.result,--}}
    {{--"class": "thumb-image img-responsive"--}}
    {{--}).appendTo(image_holder);--}}

    {{--}--}}
    {{--image_holder.show();--}}
    {{--reader.readAsDataURL($(this)[0].files[i]);--}}
    {{--}--}}

    {{--} else {--}}
    {{--alert("This browser does not support FileReader.");--}}
    {{--}--}}
    {{--});--}}

    {{--</script>--}}

@endsection