@extends('admin.layout.master')
@section('content')
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <a href="{{URL::asset('')}}admin/menu-news/create-menu-news" class="btn btn-sm btn-success"><span
                        class="glyphicon glyphicon-ok"></span> Create menu news</a>
            <div class="dashboard_graph">

                <div class="row x_title">
                    <div class="col-md-3">
                        <h3>Menu news management
                            {{--<small>Graph title sub-title</small>--}}
                        </h3>
                    </div>
                    <div class="col-md-6">
                        <span>Language: </span>
                        @foreach($language as $lang)
                            <a href="{{URL::asset('')}}admin/{{$lang->id}}-menu-news"
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
                            <th>Menu Name</th>
                            <th>SEO link</th>
                            <th>Updated at</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($menus as $menu)
                            <tr>
                                <td>{{$menu->menu_news_name}}</td>
                                <td>{{$menu->slug}}</td>
                                <td>{{$menu->created_at}}</td>

                                <td>
                                    <a href="{{URL::asset('')}}admin/menu-news/edit-menu-news-{{$menu->id}}"
                                       class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil"></span>
                                        Edit</a>
                                    <a href="{{URL::asset('')}}admin/menu-news/delete-menu-news-{{$menu->id}}"
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
            var a_href = $(this).attr('href'); /* Lấy giá trị của thuộc tính href */
            e.preventDefault(); /* Không thực hiện action mặc định */
            $.ajax({ /* Gửi request lên server */
                url: a_href, /* Nội dung trong Delete.cshtml cụ thể là deleteModal div được server trả về */
                type: 'GET',
                contentType: 'application/json; charset=utf-8',
                success: function (data) { /* Sau khi nhận được giá */
                    $('.body-content').prepend(data); /* body-content div (định nghĩa trong _Layout.cshtml) sẽ thêm deleteModal div vào dưới cùng */
                    $('#deleteModal').modal('show'); /* Hiển thị deleteModal div dưới kiểu modal */
                }
            });
        })
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
@endsection