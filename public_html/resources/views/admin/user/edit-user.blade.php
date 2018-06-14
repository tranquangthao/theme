@extends('admin.layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="dashboard_graph">

                <div class="row x_title">
                    <div class="col-md-6">
                        <h3>User Detail
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

                    <form id="demo-form2" data-parsley-validate action="{{URL::asset('')}}admin/user/edit-user-{{$users->id}}"
                          method="post" class="form-horizontal form-label-left">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Avatar
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <img src="{{URL::asset('')}}images/users/{{$users->avatar}}" class="img-responsive"
                                     id="blah" style="width: 30%">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Username:
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"></span>
                                    {{$users->username}} </label>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email:
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">{{$users->email}}
                                </label>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Fullname:  <span
                                        class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">{{$users->fullname}} </label>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Status <span
                                        class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="status" class="form-control col-md-7 col-xs-12">
                                    @if($users->status == 1)
                                        <option value="0">Locked</option>
                                        <option value="1" selected>Online</option>
                                    @else
                                        <option value="0" selected>Locked</option>
                                        <option value="1">Online</option>
                                    @endif
                                </select>
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
                                        <input type="checkbox"
                                               @if($user_permission->contains('permission_id',$row->id)) checked @endif
                                               id="permission{{$row->id}}" name="permission{{$row->id}}" value="1"
                                               class=""> {{$row->permission}}
                                    </div>
                                @endforeach
                            </div>

                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <a href="{{URL::asset('')}}admin/user-management" class="btn btn-primary" type="button">Cancel</a>
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
            if (this.checked) {
                $(':checkbox').each(function () {
                    this.checked = true;
                })
            } else {
                $(':checkbox').each(function () {
                    this.checked = false;
                })
            }
        });
    </script>
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