<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body text-center">
                <h3>Edit Subscribe</h3>
                <div>

                    <form action="{{URL::asset('')}}admin/subscribe/edit-subscribe-{{$id}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" type="text" value="{{$subscribes->email}}" name="email" disabled required/>

                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="0" @if($subscribes->status==0) selected @endif>Waiting</option>
                                <option value="1" @if($subscribes->status==1) selected @endif>Approved</option>
                            </select>

                        </div>
                        <div class="form-actions no-color">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <input type="submit" value="Update" class="btn btn-success"/>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

