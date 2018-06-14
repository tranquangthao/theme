<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Image;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\HbbLanguage;
use App\Models\HbbCountry;
use App\Models\HbbCountryTranslation;

class CountryController extends Controller
{
    public static function getAdminCountry($id)
    {
        $language = HbbLanguage::get();
        $countrys = DB::table('hbb_country')
            ->join('hbb_country_translation','hbb_country.id','=','hbb_country_translation.country_id')
            ->where('hbb_country_translation.language_id',$id)
            ->orderBy('hbb_country.updated_at','desc')
            ->select('hbb_country.*','hbb_country_translation.country_name')
            ->get();
        return view('admin.country.country', [
            'language' => $language,
            'countrys' => $countrys
        ]);
    }
    public function getCreateNewCountry()
    {
        $language = HbbLanguage::get();
        return view('admin.country.create-country',[
            'language' => $language,
        ]);
    }
    public function postCreateNewCountry(Request $request)
    {
        $language = HbbLanguage::get();
        $country = new HbbCountry();
        $country->created_at = Carbon::now();
        $country->updated_at = Carbon::now();
        $country->status = 1;
        $country->save();
        foreach ($language as $lang) {
            DB::table('hbb_country_translation')->insert(
                [
                    'language_id' => $lang->id,
                    'country_id' => $country->id,
                    'country_name' => $request->get('country_name' . $lang->id),
                ]
            );
        }
        return redirect('/admin/1-country')->with('success','Created successfully');
    }
    public function getDetailCountry($id)
    {
        $language = HbbLanguage::get();
        $countrys = DB::table('hbb_country')
            ->join('hbb_country_translation','hbb_country.id','=','hbb_country_translation.country_id')
            ->where('hbb_country.id',$id)
            ->orderBy('hbb_country.updated_at','desc')
            ->select('hbb_country.*','hbb_country_translation.country_name','hbb_country_translation.language_id')
            ->get();
        return view('admin.country.edit-country',[
            'language' => $language,
            'countrys' => $countrys,
            'id' => $id
        ]);
    }
    public function postDetailCountry(Request $request,$id)
    {
        $language = HbbLanguage::get();
        $country = HbbCountry::find($id);
        $country->updated_at = Carbon::now();
        $country->save();
        foreach ($language as $lang) {
            DB::table('hbb_country_translation')
                ->where('country_id',$id)
                ->where('language_id',$lang->id)
                ->update(
                    [
                        'country_name' => $request->get('country_name' . $lang->id),
                    ]
                );
        }
        return redirect('/admin/1-country')->with('success','Updated successfully');
    }
    public function getDeleteCountry($id)
    {
        return view('admin.country.delete-country',[
            'id' => $id
        ]);
    }
    public function postDeleteCountry($id)
    {
        HbbCountry::where('id',$id)->delete();
        return redirect('/admin/1-country')->with('success','Deleted successfully');
    }
}
