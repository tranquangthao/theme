<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Image;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\HbbLanguage;
use App\Models\HbbBrand;
use App\Models\HbbBrandTranslation;

class BrandController extends Controller
{
    public function getBrandAdmin($id)
    {
        $language = HbbLanguage::get();
        $brands = DB::table('hbb_brand')
            ->join('hbb_brand_translation','hbb_brand.id','=','hbb_brand_translation.brand_id')
            ->where('hbb_brand_translation.language_id',$id)
            ->orderBy('hbb_brand.updated_at','desc')
            ->select('hbb_brand.*','hbb_brand_translation.brand_name','hbb_brand_translation.slug')
            ->get();
        return view('admin.brand.brand', [
            'language' => $language,
            'brands' => $brands
        ]);
    }
    public function getCreateNewBrand()
    {
        $language = HbbLanguage::get();
        return view('admin.brand.create-brand',[
            'language' => $language,
        ]);
    }
    public function postCreateNewBrand(Request $request)
    {
        $language = HbbLanguage::get();
        $brand = new HbbBrand();
        $brand->created_at = Carbon::now();
        $brand->updated_at = Carbon::now();
        $brand->status = 1;
        $brand->save();
        foreach ($language as $lang) {
            DB::table('hbb_brand_translation')->insert(
                [
                    'language_id' => $lang->id,
                    'brand_id' => $brand->id,
                    'brand_name' => $request->get('brand_name' . $lang->id),
                    'slug' => str_slug($request->get('brand_name' . $lang->id))
                ]
            );
        }
        return redirect('/admin/1-brand')->with('success','Created successfully');
    }
    public function getDetailBrand($id)
    {
        $language = HbbLanguage::get();
        $brands = DB::table('hbb_brand')
            ->join('hbb_brand_translation','hbb_brand.id','=','hbb_brand_translation.brand_id')
            ->where('hbb_brand.id',$id)
            ->orderBy('hbb_brand.updated_at','desc')
            ->select('hbb_brand.*','hbb_brand_translation.brand_name','hbb_brand_translation.slug','hbb_brand_translation.language_id')
            ->get();
        return view('admin.brand.edit-brand',[
           'language' => $language,
            'brands' => $brands,
            'id' => $id
        ]);
    }
    public function postDetailBrand(Request $request,$id)
    {
        $language = HbbLanguage::get();
        $brand = HbbBrand::find($id);
        $brand->updated_at = Carbon::now();
        $brand->save();
        foreach ($language as $lang) {
            DB::table('hbb_brand_translation')
                ->where('brand_id',$id)
                ->where('language_id',$lang->id)
                ->update(
                [
                    'brand_name' => $request->get('brand_name' . $lang->id),
                    'slug' => str_slug($request->get('brand_name' . $lang->id))
                ]
            );
        }
        return redirect('/admin/1-brand')->with('success','Updated successfully');
    }
    public function getDeleteBrand($id)
    {
        return view('admin.brand.delete-brand',[
           'id' => $id
        ]);
    }
    public function postDeleteBrand($id)
    {
        HbbBrand::where('id',$id)->delete();
        return redirect('/admin/1-brand')->with('success','Deleted successfully');
    }
}
