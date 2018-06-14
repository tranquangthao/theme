<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\HbbSubscribeWine;
use Carbon\Carbon;
use Image;
use DB;

class SubscribeWineController extends Controller
{
    public function getSubscribeWineAdmin()
    {
        $subscribe_wines = DB::table('hbb_subscribe_wine')->get();
        return view('admin.subscribe-wine.subscribe-wine',[
            'subscribe_wines' => $subscribe_wines,
        ]);
    }
    public function getEditSubscribeWine($id)
    {
        $products = DB::table('hbb_products')->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
            ->join('hbb_subscribe_wine','hbb_products.id','=','hbb_subscribe_wine.product_id')
            ->where('hbb_products_translation.language_id',1)
            ->where('hbb_subscribe_wine.id',$id)
            ->select('hbb_products.*','hbb_subscribe_wine.*','hbb_products_translation.product_name')
            ->first();
        //dd($products);
        //$subscribe_wines = HbbSubscribeWine::find($id);
        return view('admin.subscribe-wine.edit-subscribe-wine',[

            'products' => $products,
            'id' => $id
        ]);
    }
    public function postEditSubscribeWine(Request $request,$id)
    {
        $subscribe_wines = $request->all();
        HbbSubscribeWine::find($id)->update($subscribe_wines);
        return redirect('/admin/subscribe-wine-management')->with('success','Updated successfully');
    }
    public function getDeleteSubscribeWine($id)
    {
        return view('admin.subscribe-wine.delete-subscribe-wine',[
            'id' => $id
        ]);
    }
    public function postDeleteSubscribeWine($id)
    {
        HbbSubscribeWine::where('id',$id)->delete();
        return redirect('admin/subscribe-wine-management')->with('success','Deleted successully');
    }
}
