<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\HbbWineCenterTranslation;
use App\Models\HbbLanguage;
use App\Models\HbbWineCenter;
use Carbon\Carbon;
use Image;
use DB;


class WineCenterController extends Controller
{
    public function getWineCenterAdmin($id)
    {
        $language = HbbLanguage::get();
        $abouts = DB::table('hbb_wine_center')->join('hbb_wine_center_translation','hbb_wine_center.id','=','hbb_wine_center_translation.wine_center_id')
            ->where('hbb_wine_center_translation.language_id',$id)
            ->orderBy('hbb_wine_center.updated_at','desc')
            ->select('hbb_wine_center.*','hbb_wine_center_translation.wine_center_name','hbb_wine_center_translation.slug')
            ->get();
           
        return view('admin.wine-center.wine-center',[
            'language' => $language,
            'abouts' => $abouts
        ]);
    }
    public function getEditWineCenter($id)
    {
        $language = HbbLanguage::get();
        $abouts = DB::table('hbb_wine_center')->join('hbb_wine_center_translation','hbb_wine_center.id','=','hbb_wine_center_translation.wine_center_id')
            ->where('hbb_wine_center.id',$id)
            ->select('hbb_wine_center.id','hbb_wine_center_translation.*')
            ->get();

        return view('admin.wine-center.edit-wine-center',[
            'language' => $language,
            'abouts' => $abouts,
            'id' => $id
        ]);
    }
    public function postEditWineCenter(Request $request,$id)
    {
        try {
            $language = HbbLanguage::get();
            $abouts = HbbWineCenter::find($id);
            $abouts->updated_at = Carbon::now();
            $abouts->save();
            foreach ($language as $lang) {
                DB::table('hbb_wine_center_translation')
                    ->where('wine_center_id',$id)
                    ->where('language_id',$lang->id)
                    ->update([
                    'slug' => str_slug($request->get('wine_center_name' . $lang->id)),
                    'wine_center_name' => $request->get('wine_center_name' . $lang->id),
                    'wine_center_content' => $request->get('wine_center_content' . $lang->id),
                ]);
            }
            return redirect('/admin/1-wine-center')->with('success', 'Updated successfully');
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
