@extends('admin.layout.master')
@section('content')
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            {{--<a href="{{URL::asset('')}}admin/create-new-menu" class="btn btn-sm btn-success"><span--}}
                        {{--class="glyphicon glyphicon-ok"></span> New menu</a>--}}
            <div class="dashboard_graph">

                <div class="row x_title">
                    <div class="col-md-3">
                        <h3>Menu management
                            {{--<small>Graph title sub-title</small>--}}
                        </h3>
                    </div>
                    <div class="col-md-6">
                        <span>Language: </span>
                        @foreach($language as $lang)
                            <a href="{{URL::asset('')}}admin/{{$lang->id}}-labels-management"
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
                            <th>No</th>
                            <th>Content</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($labels as $item)
                            <tr>
                                <form action="{{URL::asset('')}}admin/1/save-label" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="id" value="{{$item->id_}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td><textarea class="form-control" name="label_{{$item->id_}}" rows="3">{{$item->label_name}}</textarea></td>
                                    <td><input type="submit" class="btn btn-primary" value="Save"></td>
                                </form>
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
    <script src="{{URL::asset('')}}ckeditor/ckeditor.js"></script>
    <div class="modal fade modalSave" id="modalLabel" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nội dung</h4>
                </div>
                <div class="modal-body">
                    <input hidden id="id">
                    <textarea class="form-control" id="contentLabel" name="labels" rows="4"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn">Save</button>
                    <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
        @section('scripts')
            <script src="{{URL::asset('')}}ckfinder/ckfinder.js"></script>
            <script>
                $(function () {
                    $('.projecttable').DataTable({
                        "aLengthMenu": [[10,25, 50, 75, -1], [10,25, 50, 75, "All"]],
                        "iDisplayLength": 10,
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
                function ftgetLabels(type,id,content) {
                    $('#id').val(id);
                    if(type==1)
                    {
                        $('#contentLabel').val(content);
                    }
                    else {
                        $('#contentLabel').addClass('ckeditor');

                        CKEDITOR.instances.contentLabel.setData(content);
                        CKEDITOR.replace('labels', {
                            filebrowserBrowseUrl: '{{URL::asset('')}}ckfinder/ckfinder.html',
                            filebrowserImageBrowseUrl: '{{URL::asset('')}}ckfinder/ckfinder.html?type=Images',
                            filebrowserUploadUrl: '{{URL::asset('')}}ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                            filebrowserImageUploadUrl: '{{URL::asset('')}}ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
                        });
                    }

                    $('#modalLabel').modal('show');
                }
            </script>


@endsection