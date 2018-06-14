<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body text-center">
                <h3>Edit Subscribe Wine</h3>
                <div>

                    <form action="{{URL::asset('')}}admin/subscribe-wine/edit-subscribe-wine-{{$id}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label>Name</label>
                            <input disabled class="form-control" type="text" value="{{$products->name}}" name="name" required/>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input disabled class="form-control" type="text" value="{{$products->email}}" name="email" required/>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input disabled class="form-control" type="text" value="{{$products->phone}}" name="phone" required/>
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input disabled class="form-control" type="text" value="{{$products->date}}" name="date" required/>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea disabled class="form-control" type="text"  name="message">{{$products->message}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Product</label>
                            <input disabled class="form-control" type="text" value="{{$products->product_name}}" name="product_id" required/>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="0" @if($products->status==0) selected @endif>Waiting</option>
                                <option value="1" @if($products->status==1) selected @endif>Approved</option>
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

