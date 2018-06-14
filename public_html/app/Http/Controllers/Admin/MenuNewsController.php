<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Image;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\HbbLanguage;
use App\Models\HbbMenuNews;
use App\Models\HbbMenuNewsTranslation;

class MenuNewsController extends Controller
{
    public function getMenuNews($id)
    {
        $language = HbbLanguage::get();
        $menus = DB::table('hbb_menu_news')
            ->join('hbb_menu_news_translation', 'hbb_menu_news.id', '=', 'hbb_menu_news_translation.menu_news_id')
            ->where('hbb_menu_news_translation.language_id', $id)
            ->orderBy('hbb_menu_news.updated_at', 'desc')
            ->select('hbb_menu_news.*', 'hbb_menu_news_translation.menu_news_name', 'hbb_menu_news_translation.slug')
            ->get();
        return view('admin.menu-news.menu-news', [
            'language' => $language,
            'menus' => $menus
        ]);
    }

    public function getCreateNewMenuNews()
    {
        $language = HbbLanguage::get();
        return view('admin.menu-news.create-menu-news', [
            'language' => $language,
        ]);
    }

    public function postCreateNewMenuNews(Request $request)
    {
        $language = HbbLanguage::get();
        $menus = new HbbMenuNews();
        $menus->created_at = Carbon::now();
        $menus->updated_at = Carbon::now();
        $menus->status = 1;
        $menus->save();
        foreach ($language as $lang) {
            DB::table('hbb_menu_news_translation')->insert(
                [
                    'language_id' => $lang->id,
                    'menu_news_id' => $menus->id,
                    'menu_news_name' => $request->get('menu_news_name' . $lang->id),
                    'slug' => str_slug($request->get('menu_news_name' . $lang->id))
                ]
            );
        }
        return redirect('/admin/1-menu-news')->with('success', 'Created successfully');
    }

    public function getDetailMenuNews($id)
    {
        $language = HbbLanguage::get();
        $menus = DB::table('hbb_menu_news')
            ->join('hbb_menu_news_translation', 'hbb_menu_news.id', '=', 'hbb_menu_news_translation.menu_news_id')
            ->where('hbb_menu_news.id', $id)
            ->orderBy('hbb_menu_news.updated_at', 'desc')
            ->select('hbb_menu_news.*', 'hbb_menu_news_translation.menu_news_name', 'hbb_menu_news_translation.slug', 'hbb_menu_news_translation.language_id')
            ->get();
        return view('admin.menu-news.edit-menu-news', [
            'language' => $language,
            'menus' => $menus,
            'id' => $id
        ]);
    }

    public function postDetailMenuNews(Request $request, $id)
    {
        $language = HbbLanguage::get();
        $menus = HbbMenuNews::find($id);
        $menus->updated_at = Carbon::now();
        $menus->save();
        foreach ($language as $lang) {
            DB::table('hbb_menu_news_translation')
                ->where('menu_news_id', $id)
                ->where('language_id', $lang->id)
                ->update(
                    [
                        'menu_news_name' => $request->get('menu_news_name' . $lang->id),
                        'slug' => str_slug($request->get('menu_news_name' . $lang->id))
                    ]
                );
        }
        return redirect('/admin/1-menu-news')->with('success', 'Updated successfully');
    }

    public function getDeleteMenuNews($id)
    {
        return view('admin.menu-news.delete-menu-news', [
            'id' => $id
        ]);
    }

    public function postDeleteMenuNews($id)
    {
        HbbMenuNews::where('id', $id)->delete();
        return redirect('/admin/1-menu-news')->with('success', 'Deleted successfully');
    }
}
