<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HbbLanguage;
use App\Models\HbbMenu;
use App\Models\HbbMenuTranslation;
use App\Models\HbbSystemConfig;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{


    public function Home()
    {
    	$users = DB::table('hbb_user')->where('hbb_user.status',1)->count();
    	$product = DB::table('hbb_products')->count();
    	$news = DB::table('hbb_news')->count();
    	$subscribes = DB::table('hbb_subscribe')->count();
    	$subscribe_wines = DB::table('hbb_subscribe_wine')->count();
        return view('admin.home',[
        'users'=>$users,
        'product'=>$product,
        'news'=>$news,
        'subscribes'=>$subscribes,
         'subscribe_wines'=>$subscribe_wines 
        ]);
    }

    public function getSystemConfig()
    {
        $systems = HbbSystemConfig::all();
        return view('admin.systemconfig', ['systems' => $systems]);
    }

    public function updateSystemConfig(Request $request)
    {

        $system = HbbSystemConfig::find(1);
        if ($system->logo != $request->get('logo')) {
            if (file_exists('images/system/' . $system->logo)) {
                unlink('images/system/' . $system->logo);
            }
            $system->logo = $request->get('logo');
        }
        $system->facebook_link = $request->get('facebook_link');
        $system->twiter_link = $request->get('twiter_link');
        $system->facebook_link = $request->get('facebook_link');
        $system->googleplus_link = $request->get('googleplus_link');
        $system->linked_link = $request->get('linked_link');
        $system->youtube_link = $request->get('youtube_link');
        $system->email = $request->get('email');
        $system->phone_number = $request->get('phone_number');
        $system->hotline = $request->get('hotline');
        $system->google_analytic = $request->get('google_analytic');
        $system->system_theme = $request->get('system_theme');
        $system->system_favicon = $request->get('system_favicon');
        $system->orther = $request->get('orther');
        $system->seo_description = $request->get('seo_description');
        $system->seo_keyword = $request->get('seo_keyword');
        $system->seo_title = $request->get('seo_title');
        $system->seo_author = $request->get('seo_author');
        $system->system_email = $request->get('system_email');
        $system->system_password_email = $request->get('system_password_email');
        $system->save();
        return redirect('/admin/system-config')->with('success', 'Updated successfully');
    	}

    public function getLanguage()
    {
        $language = HbbLanguage::get();

        return view('admin.language', ['language' => $language]);
    }

    public function getCreateNewLanguage()
    {
        return view('admin.newlanguage');
    }

    public function postCreateNewLanguage(Request $r)
    {
        $lang = new HbbLanguage();
        $lang->language = $r->get('language');
        $lang->created_at = Carbon::now();
        $lang->updated_at = Carbon::now();
        $lang->save();
        $menu = HbbMenu::get();
        foreach ($menu as $m) {
            $m_t = new HbbMenuTranslation();
            $m_t->menu_id = $m->id;
            $m_t->language_id = $lang->id;
            $m_t->menu_name = '';
            $m_t->slug = '';
            $m_t->created_at = Carbon::now();
            $m_t->update_at = Carbon::now();
            $m_t->save();
        }
        return redirect('/admin/system-language')->with('success', 'Created successfully');
    }

    public function getEditLanguage($id)
    {
        $lang = HbbLanguage::find($id);
        return view('admin.updatelanguage', ['lang' => $lang]);
    }

    public function postEditLanguage(Request $r, $id)
    {
        HbbLanguage::find($id)->update([
            'language' => $r->get('language'),
            'updated_at' => Carbon::now()
        ]);

        return redirect('/admin/system-language')->with('success', 'Updated successfully');
    }

    public function getDeleteLanguage($id)
    {
        return view('admin.deletelanguage', ['id' => $id]);
    }

    public function postDeleteLanguage($id)
    {
        if ($id != 1) {
            HbbMenuTranslation::where('language_id', $id)->delete();
            HbbLanguage::where('id', $id)->delete();
            return redirect('/admin/system-language');
        }
    }

    public function getMenuAdmin($id)
    {
        if ($id != null) {
            $language = HbbLanguage::get();
            $menu = DB::table('hbb_menu')->join('hbb_menu_translation', 'hbb_menu.id', '=', 'hbb_menu_translation.menu_id')
                ->where('hbb_menu.status', 1)
                ->where('hbb_menu_translation.language_id', $id)
                ->orderBy('hbb_menu.update_at', 'desc')
                ->select('hbb_menu.*', 'hbb_menu_translation.menu_name','hbb_menu_translation.update_at', 'hbb_menu_translation.slug')
                ->get();
            return view('admin.menu', ['menu' => $menu, 'language' => $language]);
        }
    }

    public function getCreateNewMenu()
    {
        $language = HbbLanguage::get();
        return view('admin.createmenu', ['language' => $language]);
    }

    public function postCreateNewMenu(Request $request)
    {

        $language = HbbLanguage::get();
        $menu = new HbbMenu();
        $menu->parrent_id = 0;
        $menu->created_at = Carbon::now();
        $menu->update_at = Carbon::now();
        $menu->status = 1;
        $menu->sort_order = 2;
        $menu->save();
        foreach ($language as $lang) {
            DB::table('hbb_menu_translation')->insert(
                [
                    'language_id' => $lang->id,
                    'menu_id' => $menu->id,
                    'menu_name' => $request->get('menu_name' . $lang->id),
                    'slug' => str_slug($request->get('menu_name' . $lang->id)),
                    'created_at' => Carbon::now(),
                    'update_at' => Carbon::now()
                ]
            );
        }
        return redirect('/admin/1-menu-management')->with('success', 'Created successfully');
    }

    public function getDeleteMenu($id)
    {
        return view('admin.deletemenu', ['id' => $id]);
    }

    public function postDeleteMenu($id)
    {
        HbbMenuTranslation::where('menu_id', $id)->delete();
        HbbMenu::where('id', $id)->delete();
        return redirect('/admin/1-menu-management')->with('success', 'Delete successfully');
    }

    public function getEditMenu($id)
    {
        $language = HbbLanguage::get();
        $menu = DB::table('hbb_menu')->join('hbb_menu_translation', 'hbb_menu.id', '=', 'hbb_menu_translation.menu_id')
            ->where('hbb_menu.id', $id)
            ->orderBy('hbb_menu.update_at', 'desc')
            ->select('hbb_menu.*', 'hbb_menu_translation.menu_name', 'hbb_menu_translation.slug', 'hbb_menu_translation.language_id')
            ->get();
        return view('admin.editmenu', ['menu' => $menu, 'id' => $id, 'language' => $language]);
    }

    public function postEditMenu(Request $request, $id)
    {
        $language = HbbLanguage::get();
        foreach ($language as $lang) {

            DB::table('hbb_menu_translation')
                ->where('menu_id', $id)
                ->where('language_id', $lang->id)
                ->update(
                    [
                        'menu_name' => $request->get('menu_name' . $lang->id),
                        'slug' => str_slug($request->get('menu_name' . $lang->id)),
                        'update_at' => Carbon::now()
                    ]
                );
        }
        return redirect('/admin/1-menu-management')->with('success', 'Update successfully');
    }

}