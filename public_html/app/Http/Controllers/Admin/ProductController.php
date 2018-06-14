<?php

namespace App\Http\Controllers\Admin;

use App\Models\HbbCollection;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\HbbUser;
use App\Models\HbbLanguage;
use App\Models\HbbProduct;
use App\Models\HbbProductImage;
use App\Models\HbbProductsTranslation;
use App\Models\HbbCollectionTranslation;
use DB;
use Illuminate\Support\Facades\Session;
use Image;
use Validator;

class ProductController extends Controller
{
    public function getProductAdmin($id)
    {
        $langguage = HbbLanguage::get();
        $products = DB::table('hbb_products')
            ->join('hbb_products_translation', 'hbb_products.id', '=', 'hbb_products_translation.product_id')
            ->where('hbb_products_translation.language_id', $id)
            ->orderBy('hbb_products.updated_at', 'desc')
            ->select('hbb_products.*', 'hbb_products_translation.product_name')
            ->get();
        return view('admin.product.product', [
            'products' => $products,
            'language' => $langguage,
        ]);
    }

    public function getCreateProduct()
    {
        $language = HbbLanguage::get();
        $collections = DB::table('hbb_collection')
            ->join('hbb_collection_translation', 'hbb_collection.id', '=', 'hbb_collection_translation.collection_id')
            ->where('hbb_collection_translation.language_id', 2)
            ->where('hbb_collection.parrent_id', 0)
            ->select('hbb_collection.*', 'hbb_collection_translation.collection_name')
            ->get();
        $countrys = DB::table('hbb_country')->join('hbb_country_translation', 'hbb_country.id', '=', 'hbb_country_translation.country_id')
            ->where('hbb_country_translation.language_id', 2)
            ->select('hbb_country.*', 'hbb_country_translation.country_name')
            ->get();
        $brands = DB::table('hbb_brand')
            ->join('hbb_brand_translation', 'hbb_brand.id', '=', 'hbb_brand_translation.brand_id')
            ->where('hbb_brand_translation.language_id', 2)
            ->select('hbb_brand.*', 'hbb_brand_translation.brand_name')
            ->get();
        return view('admin.product.create-product', [
            'language' => $language,
            'collections' => $collections,
            'countrys' => $countrys,
            'brands' => $brands
        ]);
    }

    public function postCreateProduct(Request $request)
    {
        $validator = Validator::make($request->all(),HbbProduct::$rules);
        if($validator->passes()) {
            try {
                $language = HbbLanguage::get();
                $products = new HbbProduct();
                if ($request->get('imgAvatar') != null) {
                    $products->avatar = $request->get('imgAvatar');
                } else {
                    $products->avatar = 'default.png';
                }

                $products->price = $request->get('price');
                $products->collection_id = $request->get('collection_id');
                $products->country_id = $request->get('country_id');
                $products->brand_id = $request->get('brand_id');
                $products->alcohol = $request->get('alcohol');
                if ($request->get('is_selling') != null) {
                    $products->is_selling = $request->get('is_selling');
                } else {
                    $products->is_selling = 0;
                }
                if ($request->get('is_featured') != null) {
                    $products->is_featured = $request->get('is_featured');
                } else {
                    $products->is_featured = 0;
                }
                $products->updated_at = Carbon::now();
                $products->created_at = Carbon::now();
                $products->status = 1;
                if ($products->save()) {
                    if ($request->hasFile('imgDetail')) {
                        $file_ary = $request->file('imgDetail');
                        $i = 1;
                        foreach ($file_ary as $file) {
                            $filename = $i . time() . '.' . $file->getClientOriginalExtension();
                            $path = public_path('images/products/' . $filename);
                            Image::make($file->getRealPath())->resize(300, 200)->save($path);
                            $products_image = new HbbProductImage();
                            $products_image->product_id = $products->id;
                            $products_image->link = $filename;
                            $products_image->status = 1;
                            $products_image->save();
                            $i++;
                        }
                    }
                }

                foreach ($language as $lang) {
                    DB::table('hbb_products_translation')->insert([
                        'language_id' => $lang->id,
                        'product_id' => $products->id,
                        'slug' => str_slug($request->get('product_name' . $lang->id)),
                        'product_name' => $request->get('product_name' . $lang->id),
                        'product_tags' => $request->get('product_tags' . $lang->id),
                        'product_info' => $request->get('product_info' . $lang->id),
                        'product_content' => $request->get('product_content' . $lang->id),
                        'mililitre' => $request->get('mililitre' . $lang->id),
                        'grape' => $request->get('grape' . $lang->id),
                        'grape_local' => $request->get('grape_local' . $lang->id),
                    ]);
                }
//            $request->session()->keep($request->all());
                return redirect('/admin/1-product')->with('success', 'Updated successfully');
            } catch (\Exception $e) {
                dd($e);
            }
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }

    }

    public function getEditProduct($id)
    {
        $language = HbbLanguage::get();
        $collections = DB::table('hbb_collection')
            ->join('hbb_collection_translation', 'hbb_collection.id', '=', 'hbb_collection_translation.collection_id')
            ->where('hbb_collection_translation.language_id', 2)
            ->where('hbb_collection.parrent_id', 0)
            ->select('hbb_collection.*', 'hbb_collection_translation.collection_name')
            ->get();
        $countrys = DB::table('hbb_country')->join('hbb_country_translation', 'hbb_country.id', '=', 'hbb_country_translation.country_id')
            ->where('hbb_country_translation.language_id', 2)
            ->select('hbb_country.*', 'hbb_country_translation.country_name')
            ->get();
        $brands = DB::table('hbb_brand')
            ->join('hbb_brand_translation', 'hbb_brand.id', '=', 'hbb_brand_translation.brand_id')
            ->where('hbb_brand_translation.language_id', 2)
            ->select('hbb_brand.*', 'hbb_brand_translation.brand_name')
            ->get();
        $products = DB::table('hbb_products')
            ->join('hbb_products_translation', 'hbb_products.id', '=', 'hbb_products_translation.product_id')
            ->where('hbb_products.id', $id)
            ->select('hbb_products.alcohol', 'hbb_products.avatar', 'hbb_products.collection_id', 'hbb_products.status', 'hbb_products.is_selling', 'hbb_products.is_featured', 'hbb_products.price', 'hbb_products.brand_id', 'hbb_products.country_id', 'hbb_products_translation.*')
            ->get();
        $products_image = DB::table('hbb_product_image')->join('hbb_products', 'hbb_product_image.product_id', '=', 'hbb_products.id')
            ->where('hbb_product_image.product_id', $id)
            ->select('hbb_product_image.id', 'hbb_product_image.link')
            ->get();
        //dd($products);
        return view('admin.product.edit-product', [
            'language' => $language,
            'id' => $id,
            'collections' => $collections,
            'countrys' => $countrys,
            'brands' => $brands,
            'products' => $products,
            'products_image' => $products_image
        ]);
    }

    public function postEditProduct(Request $request, $id)
    {
        $validator = Validator::make($request->all(),HbbProduct::$rules);
        if($validator->passes()) {

                $language = HbbLanguage::get();
                $products = HbbProduct::find($id);
                $products->avatar = $request->get('imgAvatar');
                $products->price = $request->get('price');
                $products->alcohol = $request->get('alcohol');

                if ($request->get('is_selling') != null) {
                    $products->is_selling = $request->get('is_selling');
                } else {
                    $products->is_selling = 0;
                }
                if ($request->get('is_featured') != null) {
                    $products->is_featured = $request->get('is_featured');
                } else {
                    $products->is_featured = 0;
                }
                $products->collection_id = $request->get('collection_id');
                $products->brand_id = $request->get('brand_id');
                $products->country_id = $request->get('country_id');
                $products->updated_at = Carbon::now();
                $products->created_at = Carbon::now();
                $products->status = $request->get('status');
                if ($products->save()) {
                    if ($request->hasFile('imgDetail')) {
                        $file_ary = $request->file('imgDetail');
                        $i = 1;
                        foreach ($file_ary as $file) {
                            $filename = $i . time() . '.' . $file->getClientOriginalExtension();
                            $path = public_path('images/products/' . $filename);
                            Image::make($file->getRealPath())->resize(300, 200)->save($path);
                            $products_image = new HbbProductImage();
                            $products_image->product_id = $products->id;
                            $products_image->link = $filename;
                            $products_image->status = 1;
                            $products_image->save();
                            $i++;
                        }
                    }
                }
                foreach ($language as $lang) {
                    DB::table('hbb_products_translation')
                        ->where('product_id', $id)
                        ->where('language_id', $lang->id)
                        ->update([
                            'mililitre' => $request->get('mililitre' . $lang->id),
                            'grape' => $request->get('grape' . $lang->id),
                            'grape_local' => $request->get('grape_local' . $lang->id),
                            'product_name' => $request->get('product_name' . $lang->id),
                            'product_tags' => $request->get('product_tags' . $lang->id),
                            'product_info' => $request->get('product_info' . $lang->id),
                            'product_content' => $request->get('product_content' . $lang->id),
                            'slug' => str_slug($request->get('product_name' . $lang->id))
                        ]);
                }
                return redirect('/admin/1-product')->with('success', 'Update successfully');

            } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }

    }

    public function getDeleteProduct($id)
    {
        return view('/admin/product/delete-product', [
            'id' => $id,
        ]);
    }

    public function postDeleteProduct($id)
    {
        HbbProduct::where('id', $id)->delete();
        return redirect('admin/1-product')->with('success', 'Deleted successfully');
    }

    public function RemoveImage($id_image)
    {
        $products = HbbProductImage::find($id_image);
        if (file_exists('images/products/' . $products->link)) {
            unlink('images/products/' . $products->link);
        }
        $product_images = HbbProductImage::where('id', $id_image)->delete();
        if ($product_images == 1) {
            return redirect()->back()->with('success', 'Deleted Success!');

        } else {
            return redirect()->back()->with('fail', 'Deleted Fail!');
        }


    }
}
