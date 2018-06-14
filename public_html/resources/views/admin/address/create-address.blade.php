@extends('admin.layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="dashboard_graph">

                <div class="row x_title">
                    <div class="col-md-6">
                        <h3>Add New Address</h3>
                    </div>
                </div>

                <form id="demo-form2" data-parsley-validate action="{{URL::asset('admin/address/create-address')}}"
                      method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-md-8">
                        <ul class="nav nav-tabs language_tab">
                            @foreach($language as $lang)
                                <li><a data-toggle="tab" href="#home{{$lang->id}}">{{$lang->language}}</a></li>
                            @endforeach
                        </ul>
                        <script src="{{URL::asset('')}}ckeditor/ckeditor.js"></script>
                        <div class="tab-content">
                            @foreach($language as $lang)
                                <div id="home{{$lang->id}}" class="tab-pane fade">
                                    <div class="form-group">
                                        <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Address Name
                                            {{$lang->language}}<span class="required">*</span>
                                        </label>
                                        <div class="col-md-12 col-sm-9 col-xs-12">
                                            <input type="text" id="" name="address_name{{$lang->id}}" required
                                                   class="form-control col-md-12 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Address Content
                                            {{$lang->language}}<span class="required">*</span>
                                        </label>
                                        <div class="col-md-12 col-sm-9 col-xs-12">
                                            <textarea type="text" id="" name="address_content{{$lang->id}}" required
                                                      class="ckeditor form-control col-md-12 col-xs-12"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    CKEDITOR.replace('address_content{{$lang->id}}', {
                                        filebrowserBrowseUrl: '{{URL::asset('')}}ckfinder/ckfinder.html',
                                        filebrowserImageBrowseUrl: '{{URL::asset('')}}ckfinder/ckfinder.html?type=Images',
                                        filebrowserUploadUrl: '{{URL::asset('')}}ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                        filebrowserImageUploadUrl: '{{URL::asset('')}}ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
                                    });

                                </script>
                            @endforeach
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a href="{{URL::asset('admin/1-address-management')}}" class="btn btn-primary" type="button">Cancel</a>
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Sitemap</label>
                            <div class="col-md-12 col-sm-2 col-xs-12">
                                <input type="text" name="sitemap" class="form-control col-md-12 col-xs-12" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Phone</label>
                            <div class="col-md-12 col-sm-2 col-xs-12">
                                <input type="text" name="phone" class="form-control col-md-12 col-xs-12" required>
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
@endsection