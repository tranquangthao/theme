@extends('admin.layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="dashboard_graph">

                <div class="row x_title">
                <div class="col-sm-3">
                        <a href="{{URL::asset('admin/1-slider')}}" class="btn btn-primary" type="button">
                            <span class="glyphicon glyphicon-backward"></span> Back</a>
                    </div>
                    <div class="col-md-6">
                        <h3>Slider Detail</h3>
                    </div>
                </div>

                <form id="demo-form2" data-parsley-validate action="{{URL::asset('')}}admin/edit-slider-{{$id}}"
                      method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-md-8">
                        <ul class="nav nav-tabs language_tab">
                        <button type="submit" class="btn btn-success pull-right">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> Update
                            </button>
                            @foreach($language as $lang)
                                <li><a data-toggle="tab" href="#home{{$lang->id}}">{{$lang->language}}</a></li>
                            @endforeach
                        </ul>
                        <script src="{{URL::asset('')}}ckeditor/ckeditor.js"></script>
                        <div class="tab-content">
                            @foreach($sliders as $slider)
                                <div id="home{{$slider->language_id}}" class="tab-pane fade">
                                    <div class="form-group">
                                        <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Slider Content
                                            {{$slider->language_id}}
                                        </label>
                                        <div class="col-md-12 col-sm-9 col-xs-12">
                                            <textarea rows="9" type="text" id="" name="content_slider{{$slider->language_id}}" required
                                                      class="form-control col-md-12 col-xs-12">{{$slider->name}}</textarea>
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                    <label class="col-md-12 col-sm-3 col-xs-12" for="first_name">Link</label>
                                    <div class="col-md-12 col-sm-6 col-xs-12">
                                        <input type="text" value="{{$slider->slider_link}}" name="slider_link" class="form-control col-md-7 col-xs-12" required>
                                    </div>
                                </div>
                             </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Sort Order</label>
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <input type="number" value="{{$slider->sort_order}}" id="sort_order" name="sort_order" class="form-control col-md-7 col-xs-12"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Status</label>
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <select class="form-control" name="status">
                                    <option value="0" @if($slider->status==0) selected @endif>Hide</option>
                                    <option value="1" @if($slider->status==1) selected @endif>Show</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Image Slider<span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <input type="text" id="xFilePath" name="imgSlider"
                                       class="form-control col-md-7 col-xs-12" value="{{$slider->link}}">
                                <img src="{{URL::asset('')}}images/slider/{{$slider->link}}" class="img-responsive" id="blah"><a href="#" class="btn btn-info" onclick="BrowseServer()">
                                       <span class="glyphicon glyphicon-folder-open"></span>: Choose Image</a>
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
