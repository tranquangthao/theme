@extends('admin.layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="dashboard_graph">

                <div class="row x_title">
                    <div class="col-md-6">
                        <h3>Edit Collection</h3>
                    </div>
                </div>

                <form id="demo-form2" data-parsley-validate
                      action="{{URL::asset('')}}admin/collection/edit-collection-{{$id}}"
                      method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-md-8">
                        <ul class="nav nav-tabs language_tab">
                            @foreach($language as $lang)
                                <li><a data-toggle="tab" href="#home{{$lang->id}}">{{$lang->language}}</a></li>
                            @endforeach
                        </ul>

                        <div class="tab-content">
                            @foreach($collections as $collection)
                                <div id="home{{$collection->language_id}}" class="tab-pane fade">
                                    <div class="form-group">
                                        <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Collection Name
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-12 col-sm-9 col-xs-12">
                                            <input type="text" id="" name="collection_name{{$collection->language_id}}"
                                                   required value="{{$collection->name}}"
                                                   class="form-control col-md-12 col-xs-12">
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a href="{{URL::asset('admin/1-collection')}}" class="btn btn-primary"
                                       type="button">Cancel</a>
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
                                    @if($menu != null)
                                        @foreach($menu as $item)
                                            @if($item->id == $collection->parrent_id)
                                            <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                                @else
                                                    <option value="{{$item->id}}" >{{$item->name}}</option>
                                                @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Status</label>
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <select name="status" class="form-control col-md-7 col-xs-12">
                                        @if($collection->status == 1)
                                            <option value="0">Unapproved</option>
                                            <option value="1" selected>Approved</option>
                                        @else
                                            <option value="0" selected>Unapproved</option>
                                            <option value="1">Approved</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Avatar<span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <input type="text" id="xFilePath" name="imgAvatar" value="{{$collection->avatar}}"
                                           class="form-control col-md-7 col-xs-12">
                                    <img src="{{URL::asset('')}}images/collection/{{$collection->avatar}}" class="img-responsive" id="blah">
                                    <a href="#" class="btn btn-info" onclick="BrowseServer()">Choose Image</a>
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