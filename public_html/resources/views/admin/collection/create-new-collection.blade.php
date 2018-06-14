@extends('admin.layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="dashboard_graph">

                <div class="row x_title">
                    <div class="col-md-6">
                        <h3>Add New Collection</h3>
                    </div>
                </div>

                <form id="demo-form2" data-parsley-validate action="{{URL::asset('admin/collection/create-new-collection')}}"
                      method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-md-8">
                        <ul class="nav nav-tabs language_tab">
                            @foreach($language as $lang)
                                <li><a data-toggle="tab" href="#home{{$lang->id}}">{{$lang->language}}</a></li>
                            @endforeach
                        </ul>

                        <div class="tab-content">
                            @foreach($language as $lang)
                                <div id="home{{$lang->id}}" class="tab-pane fade">
                                    <div class="form-group">
                                        <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Collection Name
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-12 col-sm-9 col-xs-12">
                                            <input type="text" id="" name="collection_name{{$lang->id}}" required
                                                   class="form-control col-md-12 col-xs-12">
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a href="{{URL::asset('admin/1-collection')}}" class="btn btn-primary" type="button">Cancel</a>
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Collection Category</label>
                            <div class="col-md-12 col-sm-6 col-xs-12">
                            <select name="parrent_id" class="form-control col-md-7 col-xs-12">
                                <option value="0">Default menu</option>
                                @foreach($collections as $collection)
                                    <option value="{{$collection->id}}">{{$collection->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Avatar<span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <input type="text" id="xFilePath" name="imgAvatar"
                                       class="form-control col-md-7 col-xs-12">
                                <img class="img-responsive" id="blah"><a href="#" class="btn btn-info" onclick="BrowseServer()">Choose Image</a>
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
    <script src="{{URL::asset('')}}js/helper.js"></script>


@endsection