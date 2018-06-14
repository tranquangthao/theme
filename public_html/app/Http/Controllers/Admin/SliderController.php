<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HbbUser;
use App\Models\HbbSliderTranslation;
use App\Models\HbbLanguage;
use App\Models\HbbSlider;
use DB;
use Illuminate\Support\Facades\Session;
use Image;
use League\Flysystem\Exception;

class SliderController extends Controller
{
    public function getSlider($id)
    {
        $language = HbbLanguage::get();
        $sliders = DB::table('hbb_slider')
            ->join('hbb_slider_translation', 'hbb_slider.id', '=', 'hbb_slider_translation.slider_id')
            ->where('hbb_slider_translation.language_id', $id)
            ->select('hbb_slider.*', 'hbb_slider_translation.content_slider')->get();
        return view('admin.slider', [
            'sliders' => $sliders,
            'language' => $language
        ]);
    }

    public function getCreateNewSlider()
    {
        $language = HbbLanguage::get();
        return view('admin.create-slider', [
            'language' => $language,
        ]);
    }

    public function postCreateNewSlider(Request $request)
    {
        try {
            $language = HbbLanguage::get();
            $sliders = new HbbSlider();
            $sliders->sort_order = $request->get('sort_order');
            $sliders->slider_link = $request->get('slider_link');
            if ($request->get('imgSlider') != null) {
                $sliders->link = $request->get('imgSlider');
            } else {
                $sliders->link = 'default.jpg';
            }
            $sliders->created_at = Carbon::now();
            $sliders->updated_at = Carbon::now();
            $sliders->status = 1;
            if ($sliders->save()) {
                if ($request->hasFile('imgSlider')) {
                    $file = $request->file('imgSlider');
                    $filename = 'link' . time() . '.' . $file->getClientOriginalExtension();
                    $path = public_path('images/slider/' . $filename);
                    Image::make($file->getRealPath())->resize(300, 200)->save($path);
                    $sliders->link = $filename;
                }
            }
            foreach ($language as $lang) {
                DB::table('hbb_slider_translation')->insert([
                    'language_id' => $lang->id,
                    'slider_id' => $sliders->id,
                    'content_slider' => $request->get('content_slider' . $lang->id),
                ]);
            }
            return redirect('admin/1-slider')->with('success', 'Created successfully');

        }catch
            (\Exception $e){
                dd($e);
            }
    }

    public function getEditSlider($id)
    {
        $language = HbbLanguage::get();
        $sliders = DB::table('hbb_slider')
            ->join('hbb_slider_translation','hbb_slider.id','=','hbb_slider_translation.slider_id')
            ->where('hbb_slider.id',$id)
            ->select('hbb_slider.*','hbb_slider_translation.content_slider as name','hbb_slider_translation.language_id','hbb_slider_translation.slider_id')
            ->get();
//dd($sliders);
        return view('admin.edit-slider', [
            'sliders' => $sliders,
            'id' => $id,
            'language'=>$language
        ]);
    }

    public function postEditSlider(Request $request, $id)
    {
        try {
            $language = HbbLanguage::get();
            $sliders = HbbSlider::find($id);
            $sliders->sort_order = $request->get('sort_order');
            $sliders->status = $request->get('status');
            $sliders->slider_link = $request->get('slider_link');
            if ($request->get('imgSlider') != null) {
                $sliders->link = $request->get('imgSlider');
            } else {
                $sliders->link = 'default.jpg';
            }
            $sliders->created_at = Carbon::now();
            $sliders->updated_at = Carbon::now();

            if ($sliders->save()) {
                if ($request->hasFile('imgSlider')) {
                    $file = $request->file('imgSlider');
                    $filename = 'link' . time() . '.' . $file->getClientOriginalExtension();
                    $path = public_path('images/slider/' . $filename);
                    Image::make($file->getRealPath())->resize(300, 200)->save($path);
                    $sliders->link = $filename;
                }
            }
            foreach ($language as $lang) {
                DB::table('hbb_slider_translation')
                    ->where('slider_id',$id)
                    ->where('language_id',$lang->id)
                    ->update([
                    'content_slider' => $request->get('content_slider' . $lang->id),
                ]);
            }
            return redirect('admin/1-slider')->with('success', 'Created successfully');

        }catch
        (\Exception $e){
            dd($e);
        }
    }

    public function getDeleteSlider($id)
    {
        return view('admin.delete-slider', [
            'id' => $id,
        ]);
    }

    public function postDeleteSlider($id)
    {
        HbbSlider::where('id', $id)->delete();
        return redirect('admin/1-slider')->with('success', 'Delete successfully');
    }

}
