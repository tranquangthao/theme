<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Image;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\HbbLanguage;
use App\Models\HbbLabel;
use App\Models\HbbLabelTranslation;

class LabelsController extends Controller
{
    //
    public function getLabelsAdmin($id)
    {
        $language = HbbLanguage::get();
        $labels = DB::table('hbb_label')
            ->join('hbb_label_translation','hbb_label.id','=','hbb_label_translation.label_id')
            ->where('hbb_label_translation.language_id',$id)
            ->whereIn('hbb_label.id',[19,13,67,68,70])
            ->orderBy('hbb_label.id','asc')
            ->select('hbb_label.*','hbb_label_translation.label_name','hbb_label_translation.id as id_')
            ->get();
        return view('admin.labels.label', [
            'language' => $language,
            'labels' => $labels
        ]);
    }
    public function UpdateLabelAdmin(Request $request)
    {
        $id=$request->id;
        $name=$request->get('label_' . $id);
        DB::table('hbb_label_translation')
            ->where('id',$id)
            ->update([
                'label_name' => $name,
            ]);
        return redirect('/admin/1-labels-management')->with('success', 'Updated successfully');
    }
}
