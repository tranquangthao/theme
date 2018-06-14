<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Response;
use App\Models\HbbSubscribe;
use App\Models\HbbContact;
use App\Models\HbbSubscribeWine;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Input;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function getHome()
    {
        try{
            if (Session::has('locale')) {
                App::setLocale(Session::get('locale'));
            }
            else{
                Session::put('locale', 1);
                App::setLocale(Session::get('locale'));
            }
            $id_lang=Session::get('locale');
            $name_lang=DB::table('hbb_language')->where('id',$id_lang)->value('language');
            Session::put('locale_name', $name_lang);
            $sliders=DB::table('hbb_slider')
                ->join('hbb_slider_translation','hbb_slider.id','=','hbb_slider_translation.slider_id')
                ->where('status',1)
                ->where('hbb_slider_translation.language_id',Session::get('locale'))
                ->orderBy('sort_order','asc')->get();
            $menu_product=$this->getSlug(2);
            $menu_news=$this->getSlug(3);
            $active_menu=1;
            $search=$menu_product->slug;
            $news=DB::table('hbb_news')
                ->join('hbb_news_translation','hbb_news.id','=','hbb_news_translation.news_id')
                ->join('hbb_menu_news_translation','hbb_news.menu_news_id','=','hbb_menu_news_translation.menu_news_id')
                ->join('hbb_menu_news','hbb_menu_news.id','=','hbb_menu_news_translation.menu_news_id')
                ->where('hbb_news.status',1)
                ->where('hbb_news_translation.language_id',Session::get('locale'))
                ->where('hbb_menu_news_translation.language_id',Session::get('locale'))
                ->where('hbb_menu_news.status',1)
                ->orderBy('hbb_news.updated_at','desc')
                ->select('hbb_news.id','hbb_news.avatar','hbb_news_translation.news_name',
                    'hbb_news_translation.slug','hbb_menu_news_translation.menu_news_name','hbb_news_translation.news_content')
                ->limit(6)
                ->get();
            $products=DB::table('hbb_products')
                ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                ->where('hbb_products.status',1)
                ->where('hbb_collection.status',1)
                ->where('hbb_brand.status',1)
                ->where('hbb_products_translation.language_id',$id_lang)
                ->where('hbb_brand_translation.language_id',$id_lang)
                ->where('hbb_collection_translation.language_id',$id_lang)
                ->where('hbb_products.is_featured',1)
                ->orderBy('hbb_products.updated_at','desc')
                ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                    'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                    'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                ->limit(12)
                ->get();
            $labels=$this->getLabels();
            $brands=$this->getBrand();
            $collections=$this->getCollection();
            $address=$this->getAddressProduct();
            return view('home.home')->with([
                'sliders'=>$sliders,
                'active_menu'=>$active_menu,
                'products'=>$products,
                'news'=>$news,
                'menu_product'=>$menu_product,
                'labels'=>$labels,
                'brands'=>$brands,
                'collections'=>$collections,
                'menu_news'=>$menu_news,
                'search'=>$search,
                'address'=>$address
            ]);
        }
        catch (\Exception $e)
        {
            return view('home.404');
        }

    }
    public static function getSlug($id)
    {
        try{
            $id_lang=Session::get('locale');
            $menu=DB::table('hbb_menu')
                ->join('hbb_menu_translation','hbb_menu.id','=','hbb_menu_translation.menu_id')
                ->where('hbb_menu.status',1)
                ->where('hbb_menu_translation.language_id',$id_lang)
                ->where('hbb_menu.parrent_id',0)
                ->where('hbb_menu.id',$id)
                ->select('hbb_menu.id','hbb_menu_translation.menu_name as name','hbb_menu_translation.slug')
                ->first();
            return $menu;
        }
        catch (\Exception $e)
        {
            return null;
        }
    }
    public static function getCollection()
    {
        try{
            $id_lang=Session::get('locale');
            $collections=DB::table('hbb_collection')
                ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                ->where('hbb_collection_translation.language_id',$id_lang)
                ->where('hbb_collection.parrent_id',0)
                ->where('hbb_collection.status',1)->orderBy('id','asc')
                ->select('hbb_collection.id','hbb_collection.avatar','hbb_collection_translation.collection_name as name','hbb_collection_translation.slug')
                ->get();
            return $collections;
        }
        catch (\Exception $e)
        {
            return null;
        }
    }

    public static function getMenu()
    {
        try{
            $id_lang=Session::get('locale');
            $menu=DB::table('hbb_menu')
                ->join('hbb_menu_translation','hbb_menu.id','=','hbb_menu_translation.menu_id')
                ->where('hbb_menu.status',1)
                ->where('hbb_menu_translation.language_id',$id_lang)
                ->where('hbb_menu.parrent_id',0)
                ->orderBy('hbb_menu.sort_order','asc')
                ->select('hbb_menu.id','hbb_menu_translation.menu_name as name','hbb_menu_translation.slug',
                    'hbb_menu_translation.language_id')
                ->get();
            return $menu;
        }
        catch (\Exception $e)
        {
            return null;
        }
    }
    public static function getCountry()
    {
        try{
            $id_lang=Session::get('locale');
            $country=DB::table('hbb_country')
                ->join('hbb_country_translation','hbb_country.id','=','hbb_country_translation.country_id')
                ->where('hbb_country.status',1)
                ->where('hbb_country_translation.language_id',$id_lang)
                ->select('hbb_country.id','hbb_country_translation.country_name as name')
                ->get();
            return $country;
        }
        catch (\Exception $e)
        {
            return null;
        }
    }
    public static function getBrand()
    {
        try{
            $id_lang=Session::get('locale');
            $brand=DB::table('hbb_brand')
                ->join('hbb_brand_translation','hbb_brand.id','=','hbb_brand_translation.brand_id')
                ->where('hbb_brand.status',1)
                ->where('hbb_brand_translation.language_id',$id_lang)
                ->select('hbb_brand.id','hbb_brand_translation.brand_name as name','hbb_brand_translation.slug')
                ->get();
            return $brand;
        }
        catch (\Exception $e)
        {
            return null;
        }
    }
    public static function getAddress()
    {
        try{
            $id_lang=Session::get('locale');
            $labels=DB::table('hbb_label')
                ->join('hbb_label_translation','hbb_label.id','=','hbb_label_translation.label_id')
                ->where('hbb_label_translation.language_id',$id_lang)
                ->select('hbb_label.id','hbb_label_translation.label_name as name')
                ->get();
            $address=DB::table('hbb_address')
                ->join('hbb_address_translation','hbb_address.id','=','hbb_address_translation.address_id')
                ->where('hbb_address.status',1)
                ->where('hbb_address_translation.language_id',$id_lang)
                ->select('hbb_address.id','hbb_address_translation.address_name as name',
                    'hbb_address_translation.address_content as content','hbb_address.phone')
                ->get();
            $menu=DB::table('hbb_menu')
                ->join('hbb_menu_translation','hbb_menu.id','=','hbb_menu_translation.menu_id')
                ->where('hbb_menu.status',1)
                ->where('hbb_menu_translation.language_id',$id_lang)
                ->where('hbb_menu.parrent_id',0)
                ->orderBy('hbb_menu.sort_order','asc')
                ->select('hbb_menu.id','hbb_menu_translation.menu_name as name','hbb_menu_translation.slug',
                    'hbb_menu_translation.language_id')
                ->get();
            $config=DB::table('hbb_system_config')->first();
           return view('home.layouts.address',[
               'address'=>$address,
               'labels'=>$labels,
               'menu'=>$menu,
               'config'=>$config
           ])->render();
        }
        catch (\Exception $e)
        {
            return view('home.404');
        }
    }

    public static function getMenuSearch()
    {
            $labels=Controller::getLabels();
            $menu=Controller::getMenu();
            $brands=Controller::getBrand();
            $collections=Controller::getCollection();
            $menu_product=Controller::getSlug(2);
            $search=$menu_product->slug;
            return view('home.layouts.menusearch',[
                'labels'=>$labels,
                'menu'=>$menu,
                'brands'=>$brands,
                'collections'=>$collections,
                'search'=>$search
            ]);

    }
    public static function getMenuHeader($active_menu,$search)
    {
        $id_lang=Session::get('locale');
        $name_lang=DB::table('hbb_language')->where('id',$id_lang)->value('language');
        Session::put('locale_name', $name_lang);
        $languages=DB::table('hbb_language')->orderBy('language','asc')->get();
        $menu_wine = DB::table('hbb_wine_center')
            ->join('hbb_wine_center_translation', 'hbb_wine_center.id', '=', 'hbb_wine_center_translation.wine_center_id')
            ->where('hbb_wine_center_translation.language_id', Session::get('locale'))
            ->select('hbb_wine_center.id', 'hbb_wine_center_translation.wine_center_name as name', 'hbb_wine_center_translation.slug')
            ->get();
        $labels=Controller::getLabels();
        $menu=Controller::getMenu();
        $menu_news=DB::table('hbb_menu_news')
            ->join('hbb_menu_news_translation', 'hbb_menu_news.id', '=', 'hbb_menu_news_translation.menu_news_id')
            ->where('hbb_menu_news_translation.language_id', Session::get('locale'))
            ->select('hbb_menu_news.id', 'hbb_menu_news_translation.menu_news_name as name', 'hbb_menu_news_translation.slug')
            ->get();
        return view('home.layouts.menu',[
            'menu'=>$menu,
            'language'=>$languages,
            'menu_wine'=>$menu_wine,
            'search'=>$search,
            'labels'=>$labels,
            'active_menu'=>$active_menu,
            'menu_news'=>$menu_news
        ]);

    }
    public static function getLabels()
    {
        try{
            $id_lang=Session::get('locale');
            $labels=DB::table('hbb_label')
                ->join('hbb_label_translation','hbb_label.id','=','hbb_label_translation.label_id')
                ->where('hbb_label_translation.language_id',$id_lang)
                ->orderBy('hbb_label.id','asc')
                ->select('hbb_label.id','hbb_label_translation.label_name as name')
                ->get();
            return $labels;
        }
        catch (\Exception $e)
        {
            return null;
        }
    }
    private function getProductPrice($type,$price1,$price2)
    {
        try{
            $id_lang=Session::get('locale');
            if($type==0)
            {
                if($price1==3)
                {
                    $products=DB::table('hbb_products')
                        ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                        ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                        ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                        ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                        ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                        ->where('hbb_products.status',1)
                        ->where('hbb_products_translation.language_id',$id_lang)
                        ->where('hbb_brand_translation.language_id',$id_lang)
                        ->where('hbb_collection_translation.language_id',$id_lang)
                        ->where('hbb_brand.status',1)
                        ->where('hbb_products.price', '>=', $price1)
                        ->orderBy('hbb_products.updated_at','desc')
                        ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                            'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                            'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                        ->paginate(6);
                }
                else{
                    $products=DB::table('hbb_products')
                        ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                        ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                        ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                        ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                        ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                        ->where('hbb_products.status',1)
                        ->where('hbb_brand.status',1)
                        ->where('hbb_collection.status',1)
                        ->where('hbb_products_translation.language_id',$id_lang)
                        ->where('hbb_brand_translation.language_id',$id_lang)
                        ->where('hbb_collection_translation.language_id',$id_lang)
                        ->Where(function ($query) use($price1,$price2) {
                            $query->where('hbb_products.price', '>', $price1)
                                ->where('hbb_products.price', '<', $price2);
                        })
                        ->orderBy('hbb_products.updated_at','desc')
                        ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                            'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                            'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                        ->paginate(6);
                }

            }
            else{
                if($price1==3)
                {
                    $products=DB::table('hbb_products')
                        ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                        ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                        ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                        ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                        ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                        ->where('hbb_products.status',1)
                        ->where('hbb_products_translation.language_id',$id_lang)
                        ->where('hbb_brand_translation.language_id',$id_lang)
                        ->where('hbb_collection_translation.language_id',$id_lang)
                        ->where('hbb_brand.status',1)
                        ->where('hbb_products.price', '>=', $price1)
                        ->where('hbb_collection.parrent_id',$type)
                        ->orderBy('hbb_products.updated_at','desc')
                        ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                            'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                            'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                        ->paginate(6);
                }
                else{
                    $products=DB::table('hbb_products')
                        ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                        ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                        ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                        ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                        ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                        ->where('hbb_products.status',1)
                        ->where('hbb_brand.status',1)
                        ->where('hbb_collection.status',1)
                        ->where('hbb_products_translation.language_id',$id_lang)
                        ->where('hbb_brand_translation.language_id',$id_lang)
                        ->where('hbb_collection_translation.language_id',$id_lang)
                        ->Where(function ($query) use($price1,$price2) {
                            $query->where('hbb_products.price', '>', $price1)
                                ->where('hbb_products.price', '<', $price2);
                        })
                        ->where('hbb_collection.parrent_id',$type)
                        ->orderBy('hbb_products.updated_at','desc')
                        ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                            'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                            'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                        ->paginate(6);
                }

            }

            return $products;
        }
        catch (\Exception $e)
        {

            return null;
        }

    }
    public function setLanguage($id)
    {
        try{
            Session::put('locale', $id);
            $name_lang=DB::table('hbb_language')->where('id',$id)->value('language');
            Session::put('locale_name', $name_lang);
            return redirect('/');
        }
        catch (\Exception $e)
        {
            return view('home.404');
        }
    }
    public function Subscribe(Request $request)
    {
        try{
            $email=$request->email;
            $subscribe=new HbbSubscribe;
            $subscribe->email=$email;
            $subscribe->status=0;
            if($subscribe->save())
            {
                return redirect()->back()->with('subscribe', 1);
            }
            else{
                return redirect()->back()->with('subscribe', 0);
            }
        }
        catch (\Exception $e)
        {
            return view('home.404');
        }
    }

    //Product
    public function getMenuPage($lang,$id,$slug)
    {
        try{
            $menu_product=$this->getSlug(2);
            $labels=$this->getLabels();
            $search=$this->getSlug(2)->slug;
            $title=DB::table('hbb_menu')
                ->join('hbb_menu_translation','hbb_menu.id','=','hbb_menu_translation.menu_id')
                ->where('hbb_menu_translation.language_id',Session::get('locale'))
                ->where('hbb_menu.id',$id)
                ->value('hbb_menu_translation.menu_name');
            $menu_wine = DB::table('hbb_wine_center')
                ->join('hbb_wine_center_translation', 'hbb_wine_center.id', '=', 'hbb_wine_center_translation.wine_center_id')
                ->where('hbb_wine_center_translation.language_id', Session::get('locale'))
                ->select('hbb_wine_center.id', 'hbb_wine_center_translation.wine_center_content as content', 'hbb_wine_center_translation.wine_center_name as name', 'hbb_wine_center_translation.slug')
                ->get();
            if($id==2)
            {
                $menu_product=$this->getMenuProduct();
                $products=DB::table('hbb_products')
                    ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                    ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                    ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                    ->where('hbb_products.status',1)
                    ->where('hbb_collection.status',1)
                    ->where('hbb_brand.status',1)
                    ->where('hbb_products_translation.language_id',Session::get('locale'))
                    ->where('hbb_brand_translation.language_id',Session::get('locale'))
                    ->where('hbb_collection_translation.language_id',Session::get('locale'))
                    ->orderBy('hbb_products.updated_at','desc')
                    ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                        'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                        'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                    ->paginate(9);
                    $address=$this->getAddressProduct();
                $country=$this->getCountry();
                return view('home.product.home')->with([
                    'products'=>$products,
                    'address'=>$address,
                    'slug'=>$slug,
                    'id'=>$id,
                    'menu_product'=>$menu_product,
                    'active_menu'=>$id,
                    'search'=>$search,
                    'title'=>$title,
                    'labels'=>$labels,
                    'country'=>$country,
                    'menu_wine' => $menu_wine,
                    ]);
            }
            else if($id==3){
                $menu_news=DB::table('hbb_menu_news')
                    ->join('hbb_menu_news_translation','hbb_menu_news.id','=','hbb_menu_news_translation.menu_news_id')
                    ->where('hbb_menu_news.status',1)
                    ->where('hbb_menu_news_translation.language_id',Session::get('locale'))
                    ->select('hbb_menu_news.id','hbb_menu_news_translation.menu_news_name as name','hbb_menu_news_translation.slug')
                    ->get();
                $news= DB::table('hbb_news')
                    ->join('hbb_news_translation','hbb_news.id','=','hbb_news_translation.news_id')
                    ->join('hbb_menu_news_translation','hbb_news.menu_news_id','=','hbb_menu_news_translation.menu_news_id')
                    ->join('hbb_menu_news','hbb_menu_news.id','=','hbb_menu_news_translation.menu_news_id')
                    ->where('hbb_news.status',1)
                    ->where('hbb_news_translation.language_id',Session::get('locale'))
                    ->where('hbb_menu_news_translation.language_id',Session::get('locale'))
                    ->where('hbb_menu_news.status',1)
                    ->orderBy('hbb_news.updated_at','desc')
                    ->select('hbb_news.id','hbb_news.avatar','hbb_news_translation.news_name','hbb_news.updated_at as date',
                        'hbb_news_translation.slug','hbb_menu_news_translation.menu_news_name','hbb_news_translation.news_content as content')
                    ->paginate(6);
                $products_1=$this->getProductRight(1);
                $products_2=$this->getProductRight(2);
                return view('home.news.home')->with([
                    'slug'=>$slug,
                    'id'=>$id,
                    'menu_news'=>$menu_news,
                    'news'=>$news,
                    'labels'=>$labels,
                    'active_menu'=>$id,
                    'title'=>$title,
                    'menu_product'=>$menu_product,
                    'products_1'=>$products_1,
                    'products_2'=>$products_2,
                    'search' => $search,
                    ]);
            }
            else {
                $address = DB::table('hbb_address')
                    ->join('hbb_address_translation', 'hbb_address.id', '=', 'hbb_address_translation.address_id')
                    ->where('hbb_address.status', 1)
                    ->where('hbb_address_translation.language_id', Session::get('locale'))
                    ->select('hbb_address.id', 'hbb_address_translation.address_name as name', 'hbb_address.sitemap',
                            'hbb_address.phone','hbb_address_translation.address_content as content')
                    ->get();
                return view('home.wine-center.home')->with([
                    'slug' => $slug,
                    'id' => $id,
                    'labels' => $labels,
                    'address' => $address,
                    'active_menu' => $id,
                    'search'=>$search,
                    'title'=>$title
                    ]);
            }
        }
        catch (\Exception $e)
        {
            return view('home.404');
        }
    }
    private function getProductRight($id)
    {
        if($id==1)
        {
            $products=DB::table('hbb_products')
                ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                ->where('hbb_products.status',1)
                ->where('hbb_collection.status',1)
                ->where('hbb_brand.status',1)
                ->where('hbb_products_translation.language_id',Session::get('locale'))
                ->where('hbb_brand_translation.language_id',Session::get('locale'))
                ->where('hbb_collection_translation.language_id',Session::get('locale'))
                ->where('hbb_products.is_featured',1)
                ->orderBy('hbb_products.updated_at','desc')
                ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                    'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                    'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                ->paginate(3);
        }
        else{
            $products=DB::table('hbb_products')
                ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                ->where('hbb_products.status',1)
                ->where('hbb_collection.status',1)
                ->where('hbb_brand.status',1)
                ->where('hbb_products_translation.language_id',Session::get('locale'))
                ->where('hbb_brand_translation.language_id',Session::get('locale'))
                ->where('hbb_collection_translation.language_id',Session::get('locale'))
                ->where('hbb_products.is_selling',1)
                ->orderBy('hbb_products.updated_at','desc')
                ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                    'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                    'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                ->paginate(3);
        }
        return $products;
    }
    private function getMenuProduct()
    {
        $menu_product=DB::table('hbb_collection')
            ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
            ->where('hbb_collection.status',1)
            ->where('hbb_collection_translation.language_id',Session::get('locale'))
            ->where('hbb_collection.parrent_id',0)
            ->select('hbb_collection.id','hbb_collection_translation.collection_name as name','hbb_collection_translation.slug')
            ->get();
        return $menu_product;
    }
    public function getDetail($id_menu,$slug_menu,$lang,$id,$slug)
    {
        try{
            $languages=DB::table('hbb_language')->orderBy('language','asc')->get();
            $labels=$this->getLabels();
            if($id_menu==2)
            {

                $menu_product=$this->getMenuProduct();
                $products=DB::table('hbb_products')
                    ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                    ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_collection_translation','hbb_products.collection_id','=','hbb_collection_translation.collection_id')
                    ->join('hbb_collection','hbb_collection.id','=','hbb_collection_translation.collection_id')
                    ->where('hbb_products.status',1)
                    ->where('hbb_brand.status',1)
                    ->where('hbb_products_translation.language_id',Session::get('locale'))
                    ->where('hbb_collection_translation.language_id',Session::get('locale'))
                    ->where('hbb_collection.status',1)
                    ->where('hbb_products.id',$id)
                    ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                        'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                        'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content',
                        'hbb_products_translation.product_tags',
                        'hbb_products_translation.mililitre','hbb_products_translation.grape','hbb_products_translation.grape_local',
                        'hbb_products.alcohol','hbb_products_translation.product_info as info','hbb_collection.parrent_id')
                    ->first();
                if($products==null)
                {
                    return redirect('/');
                }
                $product_images=DB::table('hbb_product_image')->where('product_id',$id)->where('status',1)->get();
                $product_other=DB::table('hbb_products')
                    ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                    ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                    ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                    ->where('hbb_products.status',1)
                    ->where('hbb_brand.status',1)
                    ->where('hbb_collection.status',1)
                    ->where('hbb_products_translation.language_id',Session::get('locale'))
                    ->where('hbb_brand_translation.language_id',Session::get('locale'))
                    ->where('hbb_collection_translation.language_id',Session::get('locale'))
                    ->where('hbb_collection.parrent_id',$products->parrent_id)
                    ->where('hbb_products.id','<>',$id)
                    ->orderBy('hbb_products.updated_at','desc')
                    ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                        'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                        'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                    ->get();
                $address=DB::table('hbb_address')
                    ->join('hbb_address_translation','hbb_address.id','=','hbb_address_translation.address_id')
                    ->where('hbb_address.status',1)
                    ->where('hbb_address_translation.language_id',Session::get('locale'))
                    ->select('hbb_address.id','hbb_address_translation.address_name as name','hbb_address.phone')
                    ->get();
                $products_1=$this->getProductRight(2);
                $products_2=$this->getProductRight(2);
                $slug_product=$this->getSlug(2);
                return view('home.product.detail')->with([
                    'products'=>$products,
                    'product_images'=>$product_images,
                    'menu_product'=>$menu_product,
                    'product_others'=>$product_other,
                    'id'=>$id_menu,
                    'slug'=>$slug_menu,
                    'labels'=>$labels,
                    'active_menu'=>$id_menu,
                    'search'=>$slug_menu,
                    'address'=>$address,
                    'products_1'=>$products_1,
                    'products_2'=>$products_2,
                    'slug_product'=>$slug_product
                ]);

            }
            else{
                $menu_news=DB::table('hbb_menu_news')
                    ->join('hbb_menu_news_translation','hbb_menu_news.id','=','hbb_menu_news_translation.menu_news_id')
                    ->where('hbb_menu_news.status',1)
                    ->where('hbb_menu_news_translation.language_id',Session::get('locale'))
                    ->select('hbb_menu_news.id','hbb_menu_news_translation.menu_news_name as name','hbb_menu_news_translation.slug')
                    ->get();
                DB::table('hbb_news')->where('id',$id)->increment('reviews');
                $news= DB::table('hbb_news')
                    ->join('hbb_news_translation','hbb_news.id','=','hbb_news_translation.news_id')
                    ->join('hbb_menu_news_translation','hbb_news.menu_news_id','=','hbb_menu_news_translation.menu_news_id')
                    ->where('hbb_news.status',1)
                    ->where('hbb_news_translation.language_id',Session::get('locale'))
                    ->where('hbb_news.id',$id)
                    ->orderBy('hbb_news.updated_at','desc')
                    ->select('hbb_news.id','hbb_news.avatar','hbb_news_translation.news_name','hbb_news.menu_news_id','hbb_news_translation.news_tags',
                        'hbb_news_translation.slug','hbb_menu_news_translation.menu_news_name','hbb_news_translation.news_content','hbb_news.updated_at as date')
                    ->first();
                $news_others= DB::table('hbb_news')
                    ->join('hbb_news_translation','hbb_news.id','=','hbb_news_translation.news_id')
                    ->join('hbb_menu_news_translation','hbb_news.menu_news_id','=','hbb_menu_news_translation.menu_news_id')
                    ->join('hbb_menu_news','hbb_menu_news.id','=','hbb_menu_news_translation.menu_news_id')
                    ->where('hbb_news.status',1)
                    ->where('hbb_news_translation.language_id',Session::get('locale'))
                    ->where('hbb_menu_news_translation.language_id',Session::get('locale'))
                    ->where('hbb_menu_news.status',1)
                    ->where('hbb_news.menu_news_id',$news->menu_news_id)
                    ->where('hbb_news.id','<>',$id)
                    ->orderBy('hbb_news.updated_at','desc')
                    ->select('hbb_news.id','hbb_news.avatar','hbb_news_translation.news_name',
                        'hbb_news_translation.slug','hbb_menu_news_translation.menu_news_name')
                    ->get();
                $products_1=$this->getProductRight(2);
                $products_2=$this->getProductRight(2);
                $slug_product=$this->getSlug(2);
                return view('home.news.detail')->with([
                    'language'=>$languages,
                    'slug_product'=>$slug_product,
                    'news'=>$news,
                    'menu_news'=>$menu_news,
                    'id'=>$id_menu,
                    'slug'=>$slug_menu,
                    'labels'=>$labels,
                    'products_1'=>$products_1,
                    'products_2'=>$products_2,
                    'news_others'=>$news_others,
                    'active_menu'=>$id_menu,
                    'search'=>$slug_menu,
                    ]);
            }
        }
        catch (\Exception $e)
        {
            dd($e);
            return view('home.404');
        }
    }
    private function getAddressProduct()
    {
        $address=DB::table('hbb_address')
            ->join('hbb_address_translation','hbb_address.id','=','hbb_address_translation.address_id')
            ->where('hbb_address.status',1)
            ->where('hbb_address_translation.language_id',Session::get('locale'))
            ->select('hbb_address.id','hbb_address_translation.address_name as name','hbb_address.phone','hbb_address_translation.address_content as content')
            ->get();
        return $address;
    }
    public function getNewsDetail($menu,$lang,$id,$slug)
    {
        try{
            $menu_product=DB::table('hbb_collection')
                ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                ->where('hbb_collection.status',1)
                ->where('hbb_collection_translation.language_id',Session::get('locale'))
                ->where('hbb_collection.parrent_id',0)
                ->select('hbb_collection.id','hbb_collection_translation.collection_name as name')
                ->get();
            $products=DB::table('hbb_products')
                ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                ->join('hbb_collection_translation','hbb_products.collection_id','=','hbb_collection_translation.collection_id')
                ->join('hbb_collection','hbb_collection.id','=','hbb_collection_translation.collection_id')
                ->where('hbb_products.status',1)
                ->where('hbb_products_translation.language_id',Session::get('locale'))
                ->where('hbb_collection_translation.language_id',Session::get('locale'))
                ->where('hbb_collection.status',1)
                ->where('hbb_products.id',$id)
                ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                    'hbb_products_translation.product_content',
                    'hbb_products_translation.slug','hbb_collection_translation.collection_name')
                ->first();
            $product_images=DB::table('hbb_product_image')->where('product_id',$id)->where('status',1)->get();
            return view('home.product.detail')->with([
                'product'=>$products,'product_images'=>$product_images,'menu_product'=>$menu_product]);
        }
        catch (\Exception $e)
        {
            return view('home.404');
        }
    }
    public function getProduct($id_menu,$slug_menu, $id, $slug)
    {
        try{
            $labels=$this->getLabels();
            $collections=$this->getCollection();

            $link=DB::table('hbb_collection')
                ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                ->where('hbb_collection_translation.language_id',Session::get('locale'))
                ->where('hbb_collection.id',$id)
                ->value('hbb_collection_translation.collection_name');
            //$menu_product=$this->getSlug(2);
            $menu_product=$this->getMenuProduct();
            if($id_menu==2)
            {
                $title=DB::table('hbb_menu')
                    ->join('hbb_menu_translation','hbb_menu.id','=','hbb_menu_translation.menu_id')
                    ->where('hbb_menu_translation.language_id',Session::get('locale'))
                    ->where('hbb_menu.id',$id_menu)
                    ->value('hbb_menu_translation.menu_name');
                $products=$this->getFilterProduct(2,$id);
                $address=$this->getAddressProduct();
                $country=$this->getCountry();
                return view('home.product.filter')->with([
                    'products'=>$products,
                    'address'=>$address,
                    'slug'=>$slug,
                    'id'=>$id,
                    'menu_product'=>$menu_product,
                    'labels'=>$labels,
                    'collections'=>$collections,
                    'active_menu'=>$id_menu,
                    'search'=>$slug_menu,
                    'title'=>$title,
                    'link'=>$link,
                    'country'=>$country
                ]);
            }
            else{
            	$menu_product=$this->getSlug(2);
                $title=DB::table('hbb_menu_news')
                    ->join('hbb_menu_news_translation','hbb_menu_news.id','=','hbb_menu_news_translation.menu_news_id')
                    ->where('hbb_menu_news.status',1)
                    ->where('hbb_menu_news.id',$id)
                    ->where('hbb_menu_news_translation.language_id',Session::get('locale'))
                    ->value('hbb_menu_news_translation.menu_news_name as name');
                $menu_news=DB::table('hbb_menu_news')
                    ->join('hbb_menu_news_translation','hbb_menu_news.id','=','hbb_menu_news_translation.menu_news_id')
                    ->where('hbb_menu_news.status',1)
                    ->where('hbb_menu_news_translation.language_id',Session::get('locale'))
                    ->select('hbb_menu_news.id','hbb_menu_news_translation.menu_news_name as name','hbb_menu_news_translation.slug')
                    ->get();
                $news= DB::table('hbb_news')
                    ->join('hbb_news_translation','hbb_news.id','=','hbb_news_translation.news_id')
                    ->join('hbb_menu_news_translation','hbb_news.menu_news_id','=','hbb_menu_news_translation.menu_news_id')
                    ->join('hbb_menu_news','hbb_menu_news.id','=','hbb_menu_news_translation.menu_news_id')
                    ->where('hbb_news.status',1)
                    ->where('hbb_news_translation.language_id',Session::get('locale'))
                    ->where('hbb_menu_news_translation.language_id',Session::get('locale'))
                    ->where('hbb_menu_news.status',1)
                   
                    ->orderBy('hbb_news.updated_at','desc')
                    ->select('hbb_news.id','hbb_news.avatar','hbb_news_translation.news_name','hbb_news.updated_at as date',
                        'hbb_news_translation.slug','hbb_menu_news_translation.menu_news_name','hbb_news_translation.news_content as content')
                    ->paginate(6);
                $products_1=$this->getProductRight(1);
                $products_2=$this->getProductRight(2);
                return view('home.news.home')->with([
                    'slug'=>$slug,
                    'id'=>$id,
                    'menu_news'=>$menu_news,
                    'news'=>$news,
                    'labels'=>$labels,
                    'collections'=>$collections,
                    'active_menu'=>$id_menu,
                    'search'=>$slug_menu,
                    'title'=>$title,
                    'products_1'=>$products_1,
                    'products_2'=>$products_2,
                    'menu_product'=>$menu_product,
                ]);
            }

        }
        catch (\Exception $e)
        {
            return view('home.404');
        }
    }
    public function getWineCenter($id,$id_menu,$slug_menu)
    {
        try{
            $labels=$this->getLabels();
            $active=$id_menu;
            $search=$this->getSlug(2)->slug;
            $menu_wine=DB::table('hbb_wine_center')
                ->join('hbb_wine_center_translation','hbb_wine_center.id','=','hbb_wine_center_translation.wine_center_id')
                ->where('hbb_wine_center_translation.language_id',Session::get('locale'))
                ->select('hbb_wine_center.id','hbb_wine_center_translation.wine_center_name as name','hbb_wine_center_translation.slug')
                ->get();
            if($id_menu!=5)
            {
                $about=DB::table('hbb_wine_center')
                    ->join('hbb_wine_center_translation','hbb_wine_center.id','=','hbb_wine_center_translation.wine_center_id')
                    ->where('hbb_wine_center.id',$id_menu)
                    ->where('hbb_wine_center_translation.language_id',Session::get('locale'))
                    ->select('hbb_wine_center.id','hbb_wine_center_translation.wine_center_content as content','hbb_wine_center_translation.wine_center_name as name')
                    ->first();
                return view('home.wine-center.detail')->with([
                    'slug'=>"wince-center",
                    'id'=>$id,
                    'labels'=>$labels,
                    'about'=>$about,
                    'menu_wine'=>$menu_wine,
                    'active'=>$active,
                    'active_menu'=>4,
                    'search'=>$search,
                    'id_sp'=>$id_menu,
                    'slug_sp'=>$slug_menu]);
            }
            else
            {
                $title=DB::table('hbb_wine_center')
                    ->join('hbb_wine_center_translation','hbb_wine_center.id','=','hbb_wine_center_translation.wine_center_id')
                    ->where('hbb_wine_center.id',$id_menu)
                    ->where('hbb_wine_center_translation.language_id',Session::get('locale'))
                    ->value('hbb_wine_center_translation.wine_center_name');
                $address = DB::table('hbb_address')
                    ->join('hbb_address_translation', 'hbb_address.id', '=', 'hbb_address_translation.address_id')
                    ->where('hbb_address.status', 1)
                    ->where('hbb_address_translation.language_id', Session::get('locale'))
                    ->select('hbb_address.id', 'hbb_address_translation.address_name as name', 'hbb_address.sitemap',
                        'hbb_address.phone','hbb_address_translation.address_content as content')
                    ->get();
                return view('home.wine-center.home')->with([
                    'slug' => "",
                    'id' => $id,
                    'labels' => $labels,
                    'menu_wine' => $menu_wine,
                    'address' => $address,
                    'active_menu' => 4,
                    'search'=>$search,
                    'title'=>$title
                ]);
            }
        }
        catch (\Exception $e)
        {
            return view('home.404');
        }
    }
    public function SubmitContact(Request $request)
    {
        try{
            $contact=new HbbContact;
            $contact->name=$request->name;
            $contact->email=$request->email;
            $contact->phone=$request->phone;
            $contact->message=$request->message;
            $contact->status=0;
            $contact->current_language=Session::get('locale');
            if($contact->save())
            {
                return redirect()->back()->with('message', 1);
            }
            else{
                return redirect()->back()->with('message', 0);
            }
        }
        catch (\Exception $e)
        {
            return view('home.404');
        }
    }
    public function SubscribeWine(Request $request)
    {
        try{
            $subscribe=new HbbSubscribeWine;
            $subscribe->name=$request->name;
            $subscribe->email=$request->email;
            $subscribe->phone=$request->phone;
            $subscribe->date=$request->date;
            $subscribe->message=$request->message;
            $subscribe->language_id=Session::get('locale');
            $subscribe->product_id=$request->id;
            $subscribe->status=0;
            if($subscribe->save())
            {
                return redirect()->back()->with('message', 1);
            }
            else{
                return redirect()->back()->with('message', 0);
            }
        }
        catch (\Exception $e)
        {
            return view('home.404');
        }
    }
    public function SearchProduct(Request $request)
    {
        try{
            $name=$request->name;
            $labels=$this->getLabels();
            $brands=$this->getBrand();
            $address=$this->getAddressProduct();
            $collections=$this->getCollection();
            $menu_product=$this->getMenuProduct();
            if($name==null)
            {
                $products=DB::table('hbb_products')
                    ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                    ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                    ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                    ->where('hbb_products.status',1)
                    ->where('hbb_brand.status',1)
                    ->where('hbb_collection.status',1)
                    ->where('hbb_products_translation.language_id',Session::get('locale'))
                    ->where('hbb_brand_translation.language_id',Session::get('locale'))
                    ->where('hbb_collection_translation.language_id',Session::get('locale'))
                    ->orderBy('hbb_products.updated_at','desc')
                    ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                        'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                        'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                    ->paginate(9);
            }
            else{
                $products=DB::table('hbb_products')
                    ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                    ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                    ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                    ->where('hbb_products.status',1)
                    ->where('hbb_brand.status',1)
                    ->where('hbb_collection.status',1)
                    ->where('hbb_products_translation.language_id',Session::get('locale'))
                    ->where('hbb_brand_translation.language_id',Session::get('locale'))
                    ->where('hbb_collection_translation.language_id',Session::get('locale'))
                    ->Where(function ($query) use($name) {
                        $query->where('hbb_products_translation.product_name', 'like','%'.$name.'%')
                            ->orWhere('hbb_brand_translation.brand_name', 'like','%'.$name.'%')
                            ->orWhere('hbb_collection_translation.collection_name', 'like','%'.$name.'%');
                    })
                    ->orderBy('hbb_products.updated_at','desc')
                    ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                        'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                        'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                    ->paginate(9);
            }
            $country=$this->getCountry();
            $link=DB::table('hbb_label')
                ->join('hbb_label_translation','hbb_label.id','=','hbb_label_translation.label_id')
                ->where('hbb_label_translation.language_id',Session::get('locale'))
                ->where('hbb_label.id',45)
                ->value('hbb_label_translation.label_name as name');
            $key=DB::table('hbb_label')
                ->join('hbb_label_translation','hbb_label.id','=','hbb_label_translation.label_id')
                ->where('hbb_label_translation.language_id',Session::get('locale'))
                ->where('hbb_label.id',50)
                ->value('hbb_label_translation.label_name as name');
            return view('home.product.filter')->with([
                'products'=>$products->appends(Input::except('page')),
                'slug'=>"",
                'id'=>0,
                'menu_product'=>$menu_product,
                'labels'=>$labels,
                'brands'=>$brands,
                'address'=>$address,
                'collections'=>$collections,
                'active_menu'=>2,
                'search'=>"",
                'country'=>$country,
                'link'=>$link.' / '.$key.' "'.$name.'".',
                'title'=>2]);
        }
        catch (\Exception $e)
        {
        
            return view('home.404');
        }
    }
    private function getFilterProduct($type,$id)
    {
        try{
            $id_lang=Session::get('locale');
            if($type==1)
            {
                $products=DB::table('hbb_products')
                    ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                    ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                    ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                    ->where('hbb_products.status',1)
                    ->where('hbb_collection.status',1)
                    ->where('hbb_brand.status',1)
                    ->where('hbb_products_translation.language_id',$id_lang)
                    ->where('hbb_brand_translation.language_id',$id_lang)
                    ->where('hbb_collection_translation.language_id',$id_lang)
                    ->where('hbb_brand.id',$id)
                    ->orderBy('hbb_products.updated_at','desc')
                    ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                        'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                        'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                    ->paginate(9);
            }
            else{
                $products=DB::table('hbb_products')
                    ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                    ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                    ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                    ->where('hbb_products.status',1)
                    ->where('hbb_brand.status',1)
                    ->where('hbb_collection.status',1)
                    ->where('hbb_products_translation.language_id',$id_lang)
                    ->where('hbb_brand_translation.language_id',$id_lang)
                    ->where('hbb_collection_translation.language_id',$id_lang)
                    ->where('hbb_collection.parrent_id',$id)
                    ->orderBy('hbb_products.updated_at','desc')
                    ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                        'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                        'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                    ->paginate(9);
            }
            return $products;
        }
        catch (\Exception $e)
        {
            return view('home.404');
        }

    }
    public function getBrandProduct($slug_menu,$slug,$id)
    {
        try{
            $labels=$this->getLabels();
            $brands=$this->getBrand();
            $collections=$this->getCollection();
            $address=$this->getAddressProduct();
            $menu_product=$this->getMenuProduct();
            $products=$this->getFilterProduct(1,$id);
            $link=DB::table('hbb_brand')
                ->join('hbb_brand_translation','hbb_brand.id','=','hbb_brand_translation.brand_id')
                ->where('hbb_brand_translation.language_id',Session::get('locale'))
                ->where('hbb_brand.id',$id)
                ->value('hbb_brand_translation.brand_name');
            $country=$this->getCountry();
            return view('home.product.filter')->with([
                'products'=>$products->appends(Input::except('page')),
                'slug'=>$slug_menu,
                'id'=>0,
                'menu_product'=>$menu_product,
                'labels'=>$labels,
                'brands'=>$brands,
                'address'=>$address,
                'collections'=>$collections,
                'active_menu'=>2,
                'search'=>$slug_menu,
                'link'=>$link,
                'country'=>$country,
                'title'=>1]);
        }
        catch (\Exception $e)
        {
            return view('home.404');
        }
    }
    public function getCollectionProduct($slug_menu,$slug,$id)
    {
        try{
            $labels=$this->getLabels();
            $brands=$this->getBrand();
            $address=$this->getAddressProduct();
            $collections=$this->getCollection();
//            $menu_product=$this->getSlug(2);
            $products=$this->getFilterProduct(2,$id);
            $link=DB::table('hbb_collection')
                ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                ->where('hbb_collection_translation.language_id',Session::get('locale'))
                ->where('hbb_collection.id',$id)
                ->value('hbb_collection_translation.collection_name');
            $country=$this->getCountry();
            $menu_product=$this->getMenuProduct();
            return view('home.product.filter')->with([
                'products'=>$products->appends(Input::except('page')),
                'slug'=>$slug_menu,
                'id'=>0,
                'menu_product'=>$menu_product,
                'labels'=>$labels,
                'brands'=>$brands,
                'address'=>$address,
                'collections'=>$collections,
                'active_menu'=>2,
                'search'=>$slug_menu,
                'link'=>$link,
                'country'=>$country,
                'title'=>2]);
        }
        catch (\Exception $e)
        {
            return view('home.404');
        }
    }
    public function getPriceProduct($id)
    {
        try{
            $labels=$this->getLabels();
            $brands=$this->getBrand();
            $address=$this->getAddressProduct();
            $collections=$this->getCollection();
            $menu_product=$this->getMenuProduct();
            $country=$this->getCountry();
            if($id==1) {
                $link=DB::table('hbb_label')
                    ->join('hbb_label_translation','hbb_label.id','=','hbb_label_translation.label_id')
                    ->where('hbb_label_translation.language_id',Session::get('locale'))
                    ->where('hbb_label.id',9)
                    ->value('hbb_label_translation.label_name as name');
                $products=$this->getProductPrice(0,0,0.75);
            }
            else if($id==2) {
                $link=DB::table('hbb_label')
                    ->join('hbb_label_translation','hbb_label.id','=','hbb_label_translation.label_id')
                    ->where('hbb_label_translation.language_id',Session::get('locale'))
                    ->where('hbb_label.id',10)
                    ->value('hbb_label_translation.label_name as name');
                $products=$this->getProductPrice(0,0.75,1.5);
            }
            else if($id==3){
                $link=DB::table('hbb_label')
                    ->join('hbb_label_translation','hbb_label.id','=','hbb_label_translation.label_id')
                    ->where('hbb_label_translation.language_id',Session::get('locale'))
                    ->where('hbb_label.id',11)
                    ->value('hbb_label_translation.label_name as name');
                $products=$this->getProductPrice(0,1.5,3);
            }
            else{
                $link=DB::table('hbb_label')
                    ->join('hbb_label_translation','hbb_label.id','=','hbb_label_translation.label_id')
                    ->where('hbb_label_translation.language_id',Session::get('locale'))
                    ->where('hbb_label.id',12)
                    ->value('hbb_label_translation.label_name as name');
                $products=$this->getProductPrice(0,3,5);
            }
            return view('home.product.filter')->with([
                'products'=>$products->appends(Input::except('page')),
                'slug'=>'san-pham',
                'id'=>0,
                'menu_product'=>$menu_product,
                'labels'=>$labels,
                'brands'=>$brands,
                'address'=>$address,
                'collections'=>$collections,
                'active_menu'=>2,
                'search'=>'san-pham',
                'country'=>$country,
                'link'=>$link,
                'title'=>3]);
        }
        catch (\Exception $e)
        {
        dd($e);
            return view('home.404');
        }
    }
    public function getCountryProduct($id)
    {
        try{
            $labels=$this->getLabels();
            $search=$this->getSlug(2)->slug;
            $title=DB::table('hbb_menu')
                ->join('hbb_menu_translation','hbb_menu.id','=','hbb_menu_translation.menu_id')
                ->where('hbb_menu_translation.language_id',Session::get('locale'))
                ->where('hbb_menu.id',$id)
                ->value('hbb_menu_translation.menu_name');
            $link=DB::table('hbb_country')
                ->join('hbb_country_translation','hbb_country.id','=','hbb_country_translation.country_id')
                ->where('hbb_country.status',1)
                ->where('hbb_country_translation.language_id',Session::get('locale'))
                ->where('hbb_country.id',$id)
                ->value('hbb_country_translation.country_name');
            $menu_product=$this->getMenuProduct();
            $products=DB::table('hbb_products')
                ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                ->where('hbb_products.status',1)
                ->where('hbb_collection.status',1)
                ->where('hbb_brand.status',1)
                ->where('hbb_products_translation.language_id',Session::get('locale'))
                ->where('hbb_brand_translation.language_id',Session::get('locale'))
                ->where('hbb_collection_translation.language_id',Session::get('locale'))
                ->where('hbb_products.country_id',$id)
                ->orderBy('hbb_products.updated_at','desc')
                ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                    'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                    'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                ->paginate(9);
            $address=$this->getAddressProduct();
            $country=$this->getCountry();
            return view('home.product.filter')->with([
                'products'=>$products,
                'address'=>$address,
                'slug'=>"",
                'id'=>$id,
                'menu_product'=>$menu_product,
                'active_menu'=>$id,
                'search'=>$search,
                'title'=>$title,
                'labels'=>$labels,
                'country'=>$country,
                'link'=>$link
            ]);
        }
        catch (\Exception $e)
        {
            return view('home.404');
        }
    }
    public function getOrderbyProduct($id)
    {
        try{
            $menu_product=$this->getMenuProduct();
            $labels=$this->getLabels();
            $search=$this->getSlug(2)->slug;
            $title=DB::table('hbb_menu')
                ->join('hbb_menu_translation','hbb_menu.id','=','hbb_menu_translation.menu_id')
                ->where('hbb_menu_translation.language_id',Session::get('locale'))
                ->where('hbb_menu.id',$id)
                ->value('hbb_menu_translation.menu_name');
            if($id==1)
            {
                $link=DB::table('hbb_label')
                    ->join('hbb_label_translation','hbb_label.id','=','hbb_label_translation.label_id')
                    ->where('hbb_label_translation.language_id',Session::get('locale'))
                    ->where('hbb_label.id',54)
                    ->value('hbb_label_translation.label_name as name');
                $products=DB::table('hbb_products')
                    ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                    ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                    ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                    ->where('hbb_products.status',1)
                    ->where('hbb_collection.status',1)
                    ->where('hbb_brand.status',1)
                    ->where('hbb_products_translation.language_id',Session::get('locale'))
                    ->where('hbb_brand_translation.language_id',Session::get('locale'))
                    ->where('hbb_collection_translation.language_id',Session::get('locale'))
                    ->orderBy('hbb_products.updated_at','desc')
                    ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                        'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                        'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                    ->paginate(9);
            }
            elseif ($id==2){
                $link=DB::table('hbb_label')
                    ->join('hbb_label_translation','hbb_label.id','=','hbb_label_translation.label_id')
                    ->where('hbb_label_translation.language_id',Session::get('locale'))
                    ->where('hbb_label.id',55)
                    ->value('hbb_label_translation.label_name as name');
                $products=DB::table('hbb_products')
                    ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                    ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                    ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                    ->where('hbb_products.status',1)
                    ->where('hbb_collection.status',1)
                    ->where('hbb_brand.status',1)
                    ->where('hbb_products_translation.language_id',Session::get('locale'))
                    ->where('hbb_brand_translation.language_id',Session::get('locale'))
                    ->where('hbb_collection_translation.language_id',Session::get('locale'))
                    ->orderBy('hbb_products.price','asc')
                    ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                        'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                        'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                    ->paginate(9);
            }
            elseif ($id==3){
                $link=DB::table('hbb_label')
                    ->join('hbb_label_translation','hbb_label.id','=','hbb_label_translation.label_id')
                    ->where('hbb_label_translation.language_id',Session::get('locale'))
                    ->where('hbb_label.id',56)
                    ->value('hbb_label_translation.label_name as name');
                $products=DB::table('hbb_products')
                    ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                    ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                    ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                    ->where('hbb_products.status',1)
                    ->where('hbb_collection.status',1)
                    ->where('hbb_brand.status',1)
                    ->where('hbb_products_translation.language_id',Session::get('locale'))
                    ->where('hbb_brand_translation.language_id',Session::get('locale'))
                    ->where('hbb_collection_translation.language_id',Session::get('locale'))
                    ->orderBy('hbb_products.price','desc')
                    ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                        'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                        'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                    ->paginate(9);
            }
            elseif ($id==4){
                $link=DB::table('hbb_label')
                    ->join('hbb_label_translation','hbb_label.id','=','hbb_label_translation.label_id')
                    ->where('hbb_label_translation.language_id',Session::get('locale'))
                    ->where('hbb_label.id',57)
                    ->value('hbb_label_translation.label_name as name');
                $products=DB::table('hbb_products')
                    ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                    ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                    ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                    ->where('hbb_products.status',1)
                    ->where('hbb_collection.status',1)
                    ->where('hbb_brand.status',1)
                    ->where('hbb_products_translation.language_id',Session::get('locale'))
                    ->where('hbb_brand_translation.language_id',Session::get('locale'))
                    ->where('hbb_collection_translation.language_id',Session::get('locale'))
                    ->orderBy('hbb_products_translation.product_name','asc')
                    ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                        'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                        'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                    ->paginate(9);
            }
            elseif ($id==5){
                $link=DB::table('hbb_label')
                    ->join('hbb_label_translation','hbb_label.id','=','hbb_label_translation.label_id')
                    ->where('hbb_label_translation.language_id',Session::get('locale'))
                    ->where('hbb_label.id',58)
                    ->value('hbb_label_translation.label_name as name');
                $products=DB::table('hbb_products')
                    ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                    ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                    ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                    ->where('hbb_products.status',1)
                    ->where('hbb_collection.status',1)
                    ->where('hbb_brand.status',1)
                    ->where('hbb_products_translation.language_id',Session::get('locale'))
                    ->where('hbb_brand_translation.language_id',Session::get('locale'))
                    ->where('hbb_collection_translation.language_id',Session::get('locale'))
                    ->orderBy('hbb_products_translation.product_name','desc')
                    ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                        'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                        'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                    ->paginate(9);
            }
            elseif ($id==6){
                $link=DB::table('hbb_label')
                    ->join('hbb_label_translation','hbb_label.id','=','hbb_label_translation.label_id')
                    ->where('hbb_label_translation.language_id',Session::get('locale'))
                    ->where('hbb_label.id',59)
                    ->value('hbb_label_translation.label_name as name');
                 $products=DB::table('hbb_products')
                    ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                    ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                    ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                    ->where('hbb_products.status',1)
                    ->where('hbb_collection.status',1)
                    ->where('hbb_brand.status',1)
                    ->where('hbb_products_translation.language_id',Session::get('locale'))
                    ->where('hbb_brand_translation.language_id',Session::get('locale'))
                    ->where('hbb_collection_translation.language_id',Session::get('locale'))
                    ->where('hbb_products.is_featured',1)
                    ->orderBy('hbb_products.updated_at','desc')
                    ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                        'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                        'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                    ->paginate(9);
            }
            elseif ($id==7){
                $link=DB::table('hbb_label')
                    ->join('hbb_label_translation','hbb_label.id','=','hbb_label_translation.label_id')
                    ->where('hbb_label_translation.language_id',Session::get('locale'))
                    ->where('hbb_label.id',60)
                    ->value('hbb_label_translation.label_name as name');
                $products=DB::table('hbb_products')
                    ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                    ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                    ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                    ->where('hbb_products.status',1)
                    ->where('hbb_collection.status',1)
                    ->where('hbb_brand.status',1)
                    ->where('hbb_products_translation.language_id',Session::get('locale'))
                    ->where('hbb_brand_translation.language_id',Session::get('locale'))
                    ->where('hbb_collection_translation.language_id',Session::get('locale'))
                    ->orderBy('hbb_products.updated_at','asc')
                    ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                        'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                        'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                    ->paginate(9);
                                }
            else{
                $link=DB::table('hbb_label')
                    ->join('hbb_label_translation','hbb_label.id','=','hbb_label_translation.label_id')
                    ->where('hbb_label_translation.language_id',Session::get('locale'))
                    ->where('hbb_label.id',61)
                    ->value('hbb_label_translation.label_name as name');
               $products=DB::table('hbb_products')
                    ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
                    ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
                    ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
                    ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
                    ->where('hbb_products.status',1)
                    ->where('hbb_collection.status',1)
                    ->where('hbb_brand.status',1)
                    ->where('hbb_products_translation.language_id',Session::get('locale'))
                    ->where('hbb_brand_translation.language_id',Session::get('locale'))
                    ->where('hbb_collection_translation.language_id',Session::get('locale'))
                    ->where('hbb_products.is_selling',1)
                    ->orderBy('hbb_products.updated_at','desc')
                    ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                        'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                        'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
                    ->paginate(9);
            }
            $address=$this->getAddressProduct();
            $country=$this->getCountry();
            return view('home.product.filter')->with([
                'products'=>$products,
                'address'=>$address,
               
                'id'=>$id,
                'menu_product'=>$menu_product,
                'active_menu'=>$id,
                'search'=>$search,
                'title'=>$title,
                'labels'=>$labels,
                'country'=>$country,
                'link'=>$link
            ]);
        }
        catch (\Exception $e)
        {
            return view('home.404');
        }
    }
    function sitemap(){
        $id_lang=Session::get('locale');
        $products=DB::table('hbb_products')
            ->join('hbb_products_translation','hbb_products.id','=','hbb_products_translation.product_id')
            ->join('hbb_brand_translation','hbb_products.brand_id','=','hbb_brand_translation.brand_id')
            ->join('hbb_brand','hbb_brand.id','=','hbb_brand_translation.brand_id')
            ->join('hbb_collection','hbb_collection.id','=','hbb_products.collection_id')
            ->join('hbb_collection_translation','hbb_collection.id','=','hbb_collection_translation.collection_id')
            ->where('hbb_products.status',1)
            ->where('hbb_brand.status',1)
            ->where('hbb_collection.status',1)
            ->where('hbb_products_translation.language_id',$id_lang)
            ->where('hbb_brand_translation.language_id',$id_lang)
            ->where('hbb_collection_translation.language_id',$id_lang)
            ->orderBy('hbb_products.updated_at','desc')
            ->select('hbb_products.id','hbb_products.avatar','hbb_products_translation.product_name',
                'hbb_products_translation.slug','hbb_brand_translation.brand_name','hbb_products.price',
                'hbb_collection_translation.collection_name','hbb_products_translation.product_content as content')
            ->get();
        $news= DB::table('hbb_news')
            ->join('hbb_news_translation','hbb_news.id','=','hbb_news_translation.news_id')
            ->join('hbb_menu_news_translation','hbb_news.menu_news_id','=','hbb_menu_news_translation.menu_news_id')
            ->join('hbb_menu_news','hbb_menu_news.id','=','hbb_menu_news_translation.menu_news_id')
            ->where('hbb_news.status',1)
            ->where('hbb_news_translation.language_id',Session::get('locale'))
            ->where('hbb_menu_news_translation.language_id',Session::get('locale'))
            ->where('hbb_menu_news.status',1)
            ->orderBy('hbb_news.updated_at','desc')
            ->select('hbb_news.id','hbb_news.avatar','hbb_news_translation.news_name','hbb_news.updated_at as date',
                'hbb_news_translation.slug','hbb_menu_news_translation.menu_news_name','hbb_news_translation.news_content as content')
            ->get();

        return response()->view('home.sitemap', compact('products','news'))->header('Content-Type', 'text/xml');
    }
    function htmlGoogle()
    {
        return view('home.google15f58b494fbc43ae');
    }
    public static function getFooter()
    {
        try{
            $id_lang=Session::get('locale');
            $labels_address=DB::table('hbb_label')
                ->join('hbb_label_translation','hbb_label.id','=','hbb_label_translation.label_id')
                ->where('hbb_label_translation.language_id',$id_lang)
                ->where('hbb_label.id',14)
                ->value('hbb_label_translation.label_name as name');
            $address=DB::table('hbb_address')
                ->join('hbb_address_translation','hbb_address.id','=','hbb_address_translation.address_id')
                ->where('hbb_address.status',1)
                ->where('hbb_address_translation.language_id',$id_lang)
                ->select('hbb_address.id','hbb_address_translation.address_name as name',
                    'hbb_address_translation.address_content as content','hbb_address.phone')
                ->get();
            return view('home.layouts.address',[
                'address'=>$address,
                'labels_address'=>$labels_address
            ]);
        }
        catch (\Exception $e)
        {
            return view('404');
        }
    }

    public function SearchNews($id,$slug,Request $request)
    {
        try{
            $name=$request->search_news;
            $menu_product=$this->getSlug(2);
            $labels=$this->getLabels();
            $search=$this->getSlug(2)->slug;
            $title=DB::table('hbb_menu')
                ->join('hbb_menu_translation','hbb_menu.id','=','hbb_menu_translation.menu_id')
                ->where('hbb_menu_translation.language_id',Session::get('locale'))
                ->where('hbb_menu.id',$id)
                ->value('hbb_menu_translation.menu_name');
            $menu_news=DB::table('hbb_menu_news')
                ->join('hbb_menu_news_translation','hbb_menu_news.id','=','hbb_menu_news_translation.menu_news_id')
                ->where('hbb_menu_news.status',1)
                ->where('hbb_menu_news_translation.language_id',Session::get('locale'))
                ->select('hbb_menu_news.id','hbb_menu_news_translation.menu_news_name as name','hbb_menu_news_translation.slug')
                ->get();
            $news= DB::table('hbb_news')
                ->join('hbb_news_translation','hbb_news.id','=','hbb_news_translation.news_id')
                ->join('hbb_menu_news_translation','hbb_news.menu_news_id','=','hbb_menu_news_translation.menu_news_id')
                ->join('hbb_menu_news','hbb_menu_news.id','=','hbb_menu_news_translation.menu_news_id')
                ->where('hbb_news.status',1)
                ->where('hbb_news_translation.language_id',Session::get('locale'))
                ->where('hbb_menu_news_translation.language_id',Session::get('locale'))
                ->where('hbb_menu_news.status',1)
                ->Where(function ($query) use($name) {
                    $query->where('hbb_news_translation.news_name', 'like','%'.$name.'%')
                        ->orWhere('hbb_news_translation.news_content', 'like','%'.$name.'%');
                })
                ->orderBy('hbb_news.updated_at','desc')
                ->select('hbb_news.id','hbb_news.avatar','hbb_news_translation.news_name','hbb_news.updated_at as date',
                    'hbb_news_translation.slug','hbb_menu_news_translation.menu_news_name','hbb_news_translation.news_content as content')
                ->paginate(6);
            $products_1=$this->getProductRight(1);
            $products_2=$this->getProductRight(2);
            return view('home.news.home')->with([
                'slug'=>$slug,
                'id'=>$id,
                'menu_news'=>$menu_news,
                'news'=>$news->appends(Input::except('page')),
                'labels'=>$labels,
                'active_menu'=>$id,
                'search'=>$search,
                'title'=>$title,
                'menu_product'=>$menu_product,
                'products_1'=>$products_1,
                'products_2'=>$products_2
            ]);
        }
        catch (\Exception $e)
        {
            return view('home.404');
        }
    }

}
