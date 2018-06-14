<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\HbbAddress;
use App\Models\HbbLanguage;
use App\Models\HbbAddressTranslation;
use Carbon\Carbon;
use Image;
use DB;

class AddressController extends Controller
{
    public function getAddressAdmin($id)
    {
        $language = HbbLanguage::get();
        $address = DB::table('hbb_address')->join('hbb_address_translation', 'hbb_address.id', '=', 'hbb_address_translation.address_id')
            ->where('hbb_address_translation.language_id', $id)
            ->select('hbb_address.*', 'hbb_address_translation.address_name')
            ->get();

        return view('admin.address.address', [
            'language' => $language,
            'address' => $address,

        ]);
    }
    public function getCreateAddress()
    {
        $language = HbbLanguage::get();
        return view('admin.address.create-address',[
            'language' => $language,
        ]);
    }
    public function postCreateAddress(Request $request)
    {
        try{
            $language = HbbLanguage::get();
            $address = new HbbAddress();
            $address->sitemap = $request->get('sitemap');
            $address->phone = $request->get('phone');
            $address->updated_at = Carbon::now();
            $address->created_at = Carbon::now();
            $address->status = 1;
            $address->save();
            foreach ($language as $lang) {
                DB::table('hbb_address_translation')->insert([
                    'language_id' => $lang->id,
                    'address_id' => $address->id,
                    'address_name' => $request->get('address_name' . $lang->id),
                    'address_content' => $request->get('address_content' . $lang->id),
                ]);
            }
            return redirect('/admin/1-address-management')->with('success', 'Updated successfully');
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function getEditAddress($id)
    {
        $language = HbbLanguage::get();
        $address = DB::table('hbb_address')->join('hbb_address_translation','hbb_address.id','=','hbb_address_translation.address_id')
            ->where('hbb_address.id',$id)
            ->select('hbb_address.status','hbb_address.sitemap','hbb_address.phone','hbb_address_translation.*')
            ->get();

        return view('admin.address.edit-address',[
            'language' => $language,
            'address' => $address,
            'id' => $id
        ]);
    }
    public function postEditAddress(Request $request,$id)
    {
        try {
            $language = HbbLanguage::get();
            $address = HbbAddress::find($id);
            $address->sitemap = $request->get('sitemap');
            $address->phone = $request->get('phone');
            $address->updated_at = Carbon::now();
            $address->status = $request->get('status');
            $address->save();
            foreach ($language as $lang) {
                DB::table('hbb_address_translation')
                    ->where('address_id',$id)
                    ->where('language_id',$lang->id)
                    ->update([
                        'address_name' => $request->get('address_name' . $lang->id),
                        'address_content' => $request->get('address_content' . $lang->id),
                    ]);
            }
            return redirect('/admin/1-address-management')->with('success', 'Updated successfully');
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function getDeleteAddress($id)
    {
        return view('admin.address.delete-address',[
           'id' => $id
        ]);
    }
    public function postDeleteAddress($id)
    {
        HbbAddress::where('id',$id)->delete();
        return redirect('admin/1-address-management')->with('success','Deleted successfully');
    }

}
