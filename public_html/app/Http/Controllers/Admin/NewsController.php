<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\HbbNewsTranslation;
use App\Models\HbbLanguage;
use App\Models\HbbNews;
use Carbon\Carbon;
use Image;
use DB;

class NewsController extends Controller
{
    public function getNews($id)
    {
        $language = HbbLanguage::get();
        $news = DB::table('hbb_news')
            ->join('hbb_news_translation', 'hbb_news.id', '=', 'hbb_news_translation.news_id')
            ->where('hbb_news_translation.language_id', $id)
            ->orderBy('hbb_news.updated_at', 'desc')
            ->select('hbb_news.*', 'hbb_news_translation.news_name')
            ->get();
        return view('admin.news.news', [
            'news' => $news,
            'language' => $language,
        ]);
    }
    public function getCreateNews()
    {
        $language = HbbLanguage::get();
        $menu_news = DB::table('hbb_menu_news')
            ->join('hbb_menu_news_translation','hbb_menu_news.id','=','hbb_menu_news_translation.menu_news_id')
            ->where('hbb_menu_news_translation.language_id',1)
            ->select('hbb_menu_news.*','hbb_menu_news_translation.menu_news_name')
            ->get();
        return view('admin.news.create-news',[
            'language' => $language,
            'menu_news' => $menu_news
        ]);
    }
    public function postCreateNews(Request $request)
    {
        try {
            $language = HbbLanguage::get();
            $news = new HbbNews();
            if($request->get('imgAvatar') != null){
                $news->avatar = $request->get('imgAvatar');
            } else {
                $news->avatar = 'default.jpg';
            }
            $news->menu_news_id = $request->get('menu_news_id');
            $news->updated_at = Carbon::now();
            $news->created_at = Carbon::now();
            $news->status = 1;
            $news->reviews = 0;
            $news->save();
            foreach ($language as $lang) {
                DB::table('hbb_news_translation')->insert([
                    'language_id' => $lang->id,
                    'news_id' => $news->id,
                    'slug' => str_slug($request->get('news_name' . $lang->id)),
                    'news_name' => $request->get('news_name' . $lang->id),
                    'news_tags' => $request->get('news_tags' . $lang->id),
                    'news_content' => $request->get('news_content' . $lang->id),
                ]);
            }
            return redirect('/admin/1-news')->with('success', 'Updated successfully');
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function getEditNews($id)
    {
        $language = HbbLanguage::get();
        $menu_news = DB::table('hbb_menu_news')
            ->join('hbb_menu_news_translation','hbb_menu_news.id','=','hbb_menu_news_translation.menu_news_id')
            ->where('hbb_menu_news_translation.language_id',1)
            ->select('hbb_menu_news.*','hbb_menu_news_translation.menu_news_name')
            ->get();
        $news = DB::table('hbb_news')->join('hbb_news_translation','hbb_news.id','=','hbb_news_translation.news_id')
            ->where('hbb_news.id',$id)
            ->select('hbb_news.menu_news_id','hbb_news.avatar','hbb_news.status','hbb_news_translation.*')
            ->get();

        return view('admin.news.edit-news',[
            'language' => $language,
            'menu_news' => $menu_news,
            'news' => $news,
            'id' => $id
        ]);
    }
    public function postEditNews(Request $request,$id)
    {
        try {
            $language = HbbLanguage::get();
            $news = HbbNews::find($id);
            if($request->get('imgAvatar') != null){
                $news->avatar = $request->get('imgAvatar');
            } else {
                $news->avatar = 'default.jpg';
            }
            $news->menu_news_id = $request->get('menu_news_id');
            $news->updated_at = Carbon::now();
            $news->status = $request->get('status');
            $news->save();
            foreach ($language as $lang) {
                DB::table('hbb_news_translation')
                    ->where('news_id',$id)
                    ->where('language_id',$lang->id)
                    ->update([
                    'slug' => str_slug($request->get('news_name' . $lang->id)),
                    'news_name' => $request->get('news_name' . $lang->id),
                    'news_tags' => $request->get('news_tags' . $lang->id),
                    'news_content' => $request->get('news_content' . $lang->id),
                ]);
            }
            return redirect('/admin/1-news')->with('success', 'Updated successfully');
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function getDeleteNews($id)
    {
        return view('admin.news.delete-news',[
           'id'=>$id
        ]);
    }
    public function postDeleteNews($id)
    {
        HbbNews::where('id',$id)->delete();
        return redirect('/admin/1-news')->with('success', 'Delete successfully');
    }
}
