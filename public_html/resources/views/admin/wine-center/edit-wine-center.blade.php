@extends('admin.layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="dashboard_graph">

                <div class="row x_title">
                    <div class="col-md-6">
                        <h3>Edit Wine Center</h3>
                    </div>
                </div>

                <form id="demo-form2" data-parsley-validate action="{{URL::asset('')}}admin/wine-center/edit-wine-center-{{$id}}"
                      method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs language_tab">
                            @foreach($language as $lang)
                                <li><a data-toggle="tab" href="#home{{$lang->id}}">{{$lang->language}}</a></li>
                            @endforeach
                        </ul>

                        <div class="tab-content">

                            <script src="{{URL::asset('')}}ckeditor/ckeditor.js"></script>
                            @foreach($abouts as $about)

                                <div id="home{{$about->language_id}}" class="tab-pane fade">
                                    <div class="form-group">
                                        <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Wine Center Name
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-12 col-sm-9 col-xs-12">
                                            <input type="text" id="wine_center_name{{$about->language_id}}" name="wine_center_name{{$about->language_id}}" required
                                                   value="{{$about->wine_center_name}}"  class="form-control col-md-12 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">SEO link
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-12 col-sm-9 col-xs-12">
                                            <input type="text" id="slug" name="slug" value="{{$about->slug}}"  class="form-control col-md-12 col-xs-12" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Wine Center Content
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-12 col-sm-9 col-xs-12">
                                            <textarea type="text" id="wine_center_content{{$about->language_id}}" name="wine_center_content{{$about->language_id}}" required
                                                      class="ckeditor form-control col-md-12 col-xs-12">{{$about->wine_center_content}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    CKEDITOR.replace('wine_center_content{{$about->language_id}}', {
                                        filebrowserBrowseUrl: '{{URL::asset('')}}ckfinder/ckfinder.html',
                                        filebrowserImageBrowseUrl: '{{URL::asset('')}}ckfinder/ckfinder.html?type=Winecente',
                                        filebrowserUploadUrl: '{{URL::asset('')}}ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                        filebrowserImageUploadUrl: '{{URL::asset('')}}ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Winecenter'
                                    });

                                </script>
                            @endforeach
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a href="{{URL::asset('admin/1-wine-center')}}" class="btn btn-primary" type="button">Cancel</a>
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')

    <script src="{{URL::asset('')}}ckfinder/ckfinder.js"></script>
    <script>
        $('#btnSelectImage').on('click', function (e) {
            e.preventDefault();
            CKFinder.modal({
                chooseFiles: true,
                width: 800,
                height: 600,
                onInit: function (finder) {
                    finder.on('files:choose', function (evt) {
                        var file = evt.data.files.first();
                        var output = document.getElementById('imgAvatar');
                        output.value = (file.get('name'));
                        var blah = document.getElementById('blah');
                        blah.src = file.getUrl();
                    });

                    finder.on('file:choose:resizedImage', function (evt) {
                        var output = document.getElementById('imgAvatar');
                        output.value = evt.data.file.get('name');
                        var blah = document.getElementById('blah');
                        blah.src = evt.data.resizedUrl();

                    });
                }
            });
        })
    </script>
@endsection