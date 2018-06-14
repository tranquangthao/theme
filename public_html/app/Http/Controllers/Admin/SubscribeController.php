<?php

namespace App\Http\Controllers\Admin;

use App\Models\HbbLanguage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\HbbSubscribe;
use Carbon\Carbon;
use Image;
use DB;


class SubscribeController extends Controller
{
    public function getSubscribeAdmin()
    {
        $subscribes = DB::table('hbb_subscribe')->get();
        return view('admin.subscribe.subscribe',[
            'subscribes' => $subscribes
        ]);
    }
    public function getEditSubscribe($id)
    {
        $subscribes = HbbSubscribe::find($id);
        return view('admin.subscribe.edit-subscribe',[
            'subscribes' => $subscribes,
            'id' => $id
        ]);
    }
    public function postEditSubscribe(Request $request,$id)
    {
        $subscribes = $request->all();
        HbbSubscribe::find($id)->update($subscribes);
        return redirect('/admin/subscribe-management')->with('success','Updated successfully');
    }
    public function getDeleteSubscribe($id)
    {
        return view('admin.subscribe.delete-subscribe',[
            'id' => $id
        ]);
    }
    public function postDeleteSubscribe($id)
    {
        HbbSubscribe::where('id',$id)->delete();
        return redirect('admin/subscribe-management')->with('success','Deleted successully');
    }
}
