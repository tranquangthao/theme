@extends('admin.layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="dashboard_graph">

                <div class="row x_title">
                <div class="col-sm-3">
                        <a href="{{URL::asset('admin/1-news')}}" class="btn btn-primary" type="button">
                            <span class="glyphicon glyphicon-backward"></span> Back</a>
                    </div>
                    <div class="col-md-6">
                        <h3>Edit News</h3>
                    </div>
                </div>

                <form id="demo-form2" data-parsley-validate action="{{URL::asset('')}}admin/news/edit-news-{{$id}}"
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

                        <div class="tab-content">

                            <script src="{{URL::asset('')}}ckeditor/ckeditor.js"></script>
                                @foreach($news as $new)

                                    <div id="home{{$new->language_id}}" class="tab-pane fade">
                                        <div class="form-group">
                                            <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">News Name
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-12 col-sm-9 col-xs-12">
                                                <input type="text" id="news_name{{$new->language_id}}" name="news_name{{$new->language_id}}" required
                                                       value="{{$new->news_name}}"  class="form-control col-md-12 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">News Tags
                                                
                                            </label>
                                            <div class="col-md-12 col-sm-9 col-xs-12">
                                                <input type="text" id="news_tags{{$new->language_id}}" name="news_tags{{$new->language_id}}" required
                                                       value="{{$new->news_tags}}"  class="form-control col-md-12 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">News Content
                                                <span class="required">*</span>
                                            </label>
                                            <div class="col-md-12 col-sm-9 col-xs-12">
                                            <textarea type="text" id="news_content{{$new->language_id}}" name="news_content{{$new->language_id}}" required
                                                      class="ckeditor form-control col-md-12 col-xs-12">{{$new->news_content}}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                <script>
                                    CKEDITOR.replace('news_content{{$new->language_id}}', {
                                        filebrowserBrowseUrl: '{{URL::asset('')}}ckfinder/ckfinder.html',
                                        filebrowserImageBrowseUrl: '{{URL::asset('')}}ckfinder/ckfinder.html?type=News',
                                        filebrowserUploadUrl: '{{URL::asset('')}}ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                        filebrowserImageUploadUrl: '{{URL::asset('')}}ckfinder/core/connector/php/connector.php?command=QuickUpload&type=News'
                                    });

                                </script>
                                @endforeach



                            <div class="ln_solid"></div>
                            
                        </div>

                    </div>

                    <div class="col-md-4">


                        <div class="form-group">
                            <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Menu News
                                Name </label>
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <select name="menu_news_id"  class="form-control col-md-7 col-xs-12" required>
                                    @if($menu_news!=null)
                                        @foreach($menu_news as $menu_new)
                                            @if($menu_new->id == $new->menu_news_id)
                                            <option value="{{$menu_new->id}}" selected>{{$menu_new->menu_news_name}}</option>
                                            @else
                                                <option value="{{$menu_new->id}}">{{$menu_new->menu_news_name}}</option>
                                            @endif

                                        @endforeach
                                    @endif


                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Status</label>
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <select name="status" class="form-control col-md-7 col-xs-12">
                                    @if($new->status == 1)
                                        <option value="0">Waiting</option>
                                        <option value="1" selected>Approved</option>
                                    @else
                                        <option value="0" selected>Waiting</option>
                                        <option value="1">Approved</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 col-sm-3 col-xs-12" for="first-name">Avata<span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <input type="text" id="xFilePath" name="imgAvatar" value="{{$new->avatar}}" required="required"
                                       class="form-control col-md-7 col-xs-12">
                                <img src="{{URL::asset('')}}/images/news/{{$new->avatar}}" class="img-responsive" id="blah">
                                <a href="#" class="btn btn-info" onclick="BrowseServer()">
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