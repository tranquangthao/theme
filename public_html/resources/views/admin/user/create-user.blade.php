@extends('admin.layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="dashboard_graph">

                <div class="row x_title">
                    <div class="col-md-6">
                        <h3>New User
                            {{--<small>Graph title sub-title</small>--}}
                        </h3>
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

                    <form id="demo-form2" data-parsley-validate action="{{URL::asset('')}}admin/user/create-user"
                          method="post" class="form-horizontal form-label-left">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Avatar <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="xFilePath" name="imgAvatar"
                                       class="form-control col-md-7 col-xs-12">
                                <img class="img-responsive" id="blah" style="width: 30%"><a href="#"
                                                                         style="margin: -34px 0px;position: relative;"
                                                                         class="btn btn-info pull-right"
                                                                         onclick="BrowseServer()">
                                    Choose Avatar</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Username <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="username" name="username" required="required" value="@if($errors->has('username')) {{$errors->first('username')}} @endif"
                                       class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Password <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="password" id="password" name="password" required="required" value=""
                                       class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email <span
                                        class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="email" id="email" name="email" value="@if($errors->has('email')) {{$errors->first('email')}} @endif" required="required"
                                       class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Fullname <span
                                        class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="fullname" name="fullname" value="" required="required"
                                       class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Phone <span
                                        class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" id="phone" name="phone" value="" required="required"
                                       class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Permission <span
                                        class="required"></span>
                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-12">
                                <input type="checkbox" id="check-all">Check All
                                </div>
                                @foreach($permission as $row)
                                    <div class="col-md-6">
                                        <input type="checkbox" id="permission" name="permission{{$row->id}}"
                                               value="1" class=""> {{$row->permission}}
                                    </div>
                                @endforeach
                            </div>

                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <a href="{{URL::asset('admin/user-management')}}" class="btn btn-primary" type="button">
                                    <span class="glyphicon glyphicon-backward"></span> Back</a>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>

                    </form>


                </div>

                <div class="clearfix"></div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script src="{{URL::asset('')}}ckfinder/ckfinder.js"></script>
    <script>
        $('#check-all').click(function (event) {
            if(this.checked){
                $(':checkbox').each(function () {
                    this.checked=true;
                })
            } else {
                $(':checkbox').each(function () {
                    this.checked=false;
                })
            }
        });
    </script>
    <script src="{{URL::asset('')}}js/helper.js"></script>


@endsection