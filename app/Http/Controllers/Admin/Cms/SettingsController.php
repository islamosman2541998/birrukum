<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CharityProject;
use App\Models\SettingsValues;

class SettingsController extends Controller
{
    public function index()
    {
        $items = Settings::active()->orderBy('sort', 'ASC')->get();
        return view('admin.dashboard.cms.settings.index', compact('items'));
    }

    public function form($key)
    {
        $settingMain = Settings::query()->where('key', $key)->get()->first();

        if ($settingMain == null) {
            return abort(404);
        }

        $settings = $settingMain->values;
        
        switch ($key) {
            case 'general':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.general', compact('settings', 'settingMain'));

            case 'contact_information':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.contact_information', compact('settings', 'settingMain'));

            case 'color':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.colors', compact('settings', 'settingMain'));

            case 'external_connection':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.external_connection', compact('settings', 'settingMain'));

            case 'gift':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.gifts', compact('settings', 'settingMain'));

            case 'product':
                $settings = $settings->pluck('value', 'key');
                $projects = CharityProject::with('trans')->active()->get();
                return view('admin.dashboard.cms.settings.partials.products', compact('settings', 'settingMain', 'projects'));

            case 'custom_campaign':
                $settings = $settings->pluck('value', 'key');
                $projects = CharityProject::with('trans')->active()->get();
                return view('admin.dashboard.cms.settings.partials.custom-campaign', compact('settings', 'settingMain', 'projects'));

            case 'notifications':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.notifications', compact('settings', 'settingMain'));

            case 'meta':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.meta', compact('settings', 'settingMain'));

            case 'volunteering':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.volunteering', compact('settings', 'settingMain'));

            case 'badal':
                $settings = $settings->pluck('value', 'key');
                $projects = CharityProject::with('trans')->active()->get();
                return view('admin.dashboard.cms.settings.partials.badal', compact('settings', 'settingMain', 'projects'));
            case 'badalnotfication':
                $settings = $settings->pluck('value', 'key');
                return view('admin.dashboard.cms.settings.partials.badalnotification', compact('settings', 'settingMain'));

            default:
                return view('admin.dashboard.cms.settings.form', compact('settings', 'settingMain'));
        }
    }

    public function form_update(Request $request, $id)
    {

        @$settings = Settings::findOrfail($id)->values;
        foreach ($request->except(['_token']) as $key => $item) {
            $settings = $settings->where('key', $key)->first();
            if ($request->hasFile($key)) {
                $filename = $this->upload_file($request->file($key), ('settings'), $key);
                $settings->where('key', $key)->update(['value' => $filename]);
            } else {
                $settings->where('key', $key)->update(['value' => $item]);
            }
        }
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }



    public function form_update_custom(Request $request, $key)
    {
        $settingMain = Settings::query()->where('key', $key)->get()->first();
        // change all checkbox switch from 'on' to 1
        $request->replace(array_map(function ($value) {
            return $value === 'on' ? 1 : $value;
        }, $request->all()));

        // custom request
        if ($request->type_setting == "color") {
            if (count($request->categoryColorlist) == 1 && $request->categoryColorlist[0]['background_color'] == null) {
                $request->request->remove('categoryColorlist');
            }
            $dataColor = array_merge($request->old_category ?? [], $request->categoryColorlist ?? []);
            $colors = [];
            foreach ($dataColor as $item) {
                $colors[] = $item['background_color'];
            }
            $request->request->remove('old_category');
            $request->request->remove('type_setting');
            $request->request->add(['categoryColorlist' => $colors]);
        }

        // check status
        $request->request->add(['status' => isset($request->status) ? 1 : 0]);

        // store key in setting
        if ($settingMain == null) {
            $settingMain = Settings::create(['key' => $key]);
        }
        $settings = $settingMain->values;
        // store values in setting 
        $values = $request->except('_token');
        if ($values) {
            foreach ($values as $key => $value) {
                if (is_array($value)) {
                    $value = json_encode($value);
                }
                if ($request->hasFile($key)) {

                    $value = $this->upload_file($request->file($key), ('settings'), $key);
                }
                $set = $settings->where('key', $key)->first();
                if ($set == null) {
                    SettingsValues::create(['key' => $key, 'value' => $value, 'setting_id' => $settingMain->id]);
                } else {
                    $set->value = $value;
                    $set->save();
                }
            }
        }
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }




    public function volunteerUpdate(Request $request, $key)
    {
        $settingMain = Settings::query()->where('key', $key)->get()->first();
        // check status
        $request->request->add(['status' => isset($request->status) ? 1 : 0]);

        $data = $request->except('_token');
        if(isset($data['achievements'])){
            foreach($data['achievements'] as $ind => $achievement){
                if( isset($achievement['image']) && file_exists($achievement['image']) && getimagesize($achievement['image'])) {
                    $data['achievements'][$ind]['image'] = $this->upload_file($achievement['image'], ('settings'), $ind);
                }
            }
            $data['achievements'] = json_encode($data['achievements']);
        }
        
        // store key in setting
        if ($settingMain == null) {
            $settingMain = Settings::create(['key' => $key]);
        }
        $settings = $settingMain->values;
        // store values in setting 
        if ($data) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $value = json_encode($value);
                }
                if ($request->hasFile($key)) {

                    $value = $this->upload_file($request->file($key), ('settings'), $key);
                }
                $set = $settings->where('key', $key)->first();
                if ($set == null) {
                    SettingsValues::create(['key' => $key, 'value' => $value, 'setting_id' => $settingMain->id]);
                } else {
                    $set->value = $value;
                    $set->save();
                }
            }
        }
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }
}
