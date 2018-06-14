@extends('admin.layout.master')
@section('content')
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <a href="{{URL::asset('')}}admin/address/create-address" class="btn btn-sm btn-success addlink"><span
                        class="glyphicon glyphicon-new-window"></span> New address</a>
            <div class="dashboard_graph">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="row x_title">
                    <div class="col-md-6">
                        <h3>Address Management
                            {{--<small>Graph title sub-title</small>--}}
                        </h3>
                    </div>
                    <div class="col-md-6">
                        <span>Language: </span>
                        @foreach($language as $lang)
                            <a href="{{URL::asset('')}}admin/{{$lang->id}}-address-management"
                               class="btn btn-xs btn-info">{{$lang->language}}</a>
                        @endforeach
                </div>

                <div class="col-md-12">
                    <table class="table table-bordered table-responsive projecttable">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th width="30%">Address Name</th>
                            <th>Updated at</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($address as $addres)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$addres->address_name}}</td>
                                <td>{{$addres->created_at}}</td>
                                <td>
                                    @if($addres->status == 1)
                                    <a class="label label-success">Approved</a>
                                    @else
                                    <a class="label label-danger">Waiting</a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{URL::asset('')}}admin/address/edit-address-{{$addres->id}}"
                                       class="btn btn-xs btn-primary editlink"><span
                                                class="glyphicon glyphicon-pencil"></span>
                                        Edit</a>
                                    @if($loop->count > 1)
                                    <a href="{{URL::asset('')}}admin/address/delete-address-{{$addres->id}}"
                                       class="btn btn-xs btn-danger deletelink"><span
                                                class="glyphicon glyphicon-trash"></span> Delete</a>
                                        @else
                                        <i>Default 1 address, can't delete</i>
                                        @endif
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
    </div>
@endsection
@section('scripts')
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
@endsection