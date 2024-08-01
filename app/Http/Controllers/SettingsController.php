<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{

    public function storeOrUpdate(Settings $settings)
    {
        $allInputs = request()->all();
        $headerFields = ['_token', 'model','element_id','group','setting'];
        $headers = array_intersect_key($allInputs, array_flip($headerFields));
        $settingFields = array_diff_key($allInputs, $headers);

        foreach($settingFields as $setting => $value)
        {
            if($value !== null){
                $getData = Settings::where('model', '=', $headers['model'])
                ->where('element_id', '=', $headers['element_id'])
                ->where('group', '=', $headers['group'])
                ->where('setting', '=', $setting)->update(['value' => $value]);
            }
        }
        $object = explode("\\",$headers['model']);
        $url = strtolower(end($object))."/".$headers['element_id']."/edit";

        return redirect($url);
    }


    public function get($model, $element_id, $group, $setting)
    {
        $getData = Settings::where('model','=', $model)
            ->where('element_id','=',$element_id)
            ->where('group','=',$group)
            ->where('setting','=',$setting)
            ->orderby('order', 'ASC')
            ->get();

            return $getData;
    }

    public function getGlobalSettings($model, $element_id, $group, $setting)
    {
        $getData = Settings::where('model','=', 'App\Model\\'.$model)
        ->where('element_id','=',$element_id)
        ->where('group','=',$group)
        ->where('setting','=',$setting)
        ->orderby('setting', 'DESC')->get();

        return $getData;
    }


    public function create()
    {
        $data = request()->validate([
            'model' => ['required'],
            'element_id' =>  ['required'],
            'group' =>  ['required'],
            'setting' =>  ['required'],
            'status' =>  ['required'],
            'order' =>  ['required'],
            'value' =>  ['required'],
            'policy' => ['required'],
        ]);
        $settings = auth()->user()->settings()->create($data);

        return redirect()->to(url()->previous());
    }


    public function update()
    {
        $data = request()->validate([
            'order' =>  ['required'],
            'value' =>  ['required'],
            'id' =>  ['required'],
        ]);
        Settings::find($data['id'])->update($data);

        return redirect()->to(url()->previous());
    }


    public function delete()
    {
        $data = request()->validate([
            'id' =>  ['required'],
        ]);
        $setting = Settings::find($data['id']);
        if($setting)
        {
            $setting->delete();
        }

        return redirect()->to(url()->previous());
    }

}




