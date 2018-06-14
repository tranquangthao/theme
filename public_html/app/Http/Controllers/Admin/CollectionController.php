<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Models\HbbLanguage;
use App\Models\HbbCollection;
use App\Models\HbbCollectionTranslation;
use DB;
use Image;

class CollectionController extends Controller
{
    public function getCollectionAdmin($id)
    {
        $language = HbbLanguage::get();
        $collections = DB::table('hbb_collection')
            ->join('hbb_collection_translation', 'hbb_collection.id', '=', 'hbb_collection_translation.collection_id')
            ->where('hbb_collection_translation.language_id', $id)
            ->orderBy('hbb_collection.updated_at', 'desc')
            ->select('hbb_collection.*', 'hbb_collection_translation.collection_name', 'hbb_collection_translation.slug')
            ->get();
        return view('admin.collection.collection', [
            'language' => $language,
            'collections' => $collections
        ]);
    }

    public function getCreateCollection()
    {
        $language = HbbLanguage::get();
        $collections = DB::table('hbb_collection')
            ->join('hbb_collection_translation', 'hbb_collection.id', '=', 'hbb_collection_translation.collection_id')
            ->where('hbb_collection_translation.language_id', 2)
            ->where('hbb_collection.parrent_id', 0)
            ->orderBy('hbb_collection.updated_at', 'desc')
            ->select('hbb_collection.id', 'hbb_collection_translation.collection_name as name')
            ->get();
        return view('admin.collection.create-new-collection', [
            'collections' => $collections,
            'language' => $language
        ]);
    }

    public function postCreateCollection(Request $request)
    {
        $language = HbbLanguage::get();
        $collections = new HbbCollection();
        if ($request->get('imgAvatar') != null) {
            $collections->avatar = $request->get('imgAvatar');
        } else {
            $collections->avatar = 'default.jpg';
        }
        $collections->status = 1;
        $collections->parrent_id = $request->get('parrent_id');
        $collections->updated_at = Carbon::now();
        $collections->created_at = Carbon::now();
        $collections->save();
        foreach ($language as $lang) {
            DB::table('hbb_collection_translation')->insert([
                'language_id' => $lang->id,
                'collection_id' => $collections->id,
                'collection_name' => $request->get('collection_name'.$lang->id),
                'slug' => str_slug($request->get('collection_name'.$lang->id))
            ]);
        }
        return redirect('admin/1-collection')->with('success','Created Successfully');
    }
    public function getEditCollection($id)
    {
        $language = HbbLanguage::get();
        $collections = DB::table('hbb_collection')
            ->join('hbb_collection_translation', 'hbb_collection.id', '=', 'hbb_collection_translation.collection_id')
            ->where('hbb_collection.id',$id)
            ->select('hbb_collection.*', 'hbb_collection_translation.collection_name as name','hbb_collection_translation.slug','hbb_collection_translation.language_id','hbb_collection_translation.collection_id')
            ->get();
        $menu = DB::table('hbb_collection')
            ->join('hbb_collection_translation', 'hbb_collection.id', '=', 'hbb_collection_translation.collection_id')
            ->where('hbb_collection_translation.language_id', 2)
            ->where('hbb_collection.parrent_id', 0)
            ->orderBy('hbb_collection.updated_at', 'desc')
            ->select('hbb_collection.id', 'hbb_collection_translation.collection_name as name')
            ->get();

        return view('admin.collection.edit-collection',[
            'id' => $id,
            'language' => $language,
            'collections' => $collections,
            'menu' => $menu
        ]);
    }
    public function postEditCollection(Request $request, $id)
    {
        try {
            $language = HbbLanguage::get();
            $collections = HbbCollection::find($id);
            if ($request->get('imgAvatar') != null) {
                $collections->avatar = $request->get('imgAvatar');
            } else {
                $collections->avatar = 'default.jpg';
            }
            $collections->status = $request->get('status');
            $collections->parrent_id = $request->get('parrent_id');
            $collections->updated_at = Carbon::now();
            //$collections->created_at = Carbon::now();
            //dd($request->get('parrent_id'));
            $collections->save();
            foreach ($language as $lang) {
                DB::table('hbb_collection_translation')
                    ->where('collection_id',$id)
                    ->where('language_id', $lang->id)
                    ->update([
                    'collection_name' => $request->get('collection_name'.$lang->id),
                    'slug' => str_slug($request->get('collection_name'.$lang->id))
                ]);
            }

            return redirect('admin/1-collection')->with('success','Updated Successfully');
        } catch (\Exception $err) {
            dd($err);
        }
    }
    public function getDeleteCollection($id)
    {
        return view('/admin/collection/delete-collection',[
           'id' => $id
        ]);
    }
    public function postDeleteCollection($id)
    {
        HbbCollection::where('id',$id)->delete();
        return redirect('/admin/1-collection')->with('success','Deleted successfully');
    }
}
