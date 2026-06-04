<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\PartnerRequest;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = Partner::query()->with('trans')->orderBy('id', 'DESC');

        if ($request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->title != '') {
            $query = $query->whereTranslationLike('title', '%' . request()->input('title') . '%');
        }

        if ($request->description != '') {
            $query = $query->whereTranslationLike('description', '%' . request()->input('description') . '%');
        }

        $items = $query->paginate($this->pagination_count);

        return view('admin.dashboard.cms.partners.index', compact('items'));
    }

    public function create()
    {
        return view('admin.dashboard.cms.partners.create');
    }

    public function store(PartnerRequest $request)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), 'partners');
        }

        Partner::create($data);

        session()->flash('success', trans('message.admin.created_sucessfully'));

        if (request()->submit == "new") {
            return redirect()->back();
        }

        return redirect()->route('admin.partners.index');
    }

    public function show(Partner $partner)
    {
        return view('admin.dashboard.cms.partners.show', compact('partner'));
    }

    public function edit(Partner $partner)
    {
        return view('admin.dashboard.cms.partners.edit', compact('partner'));
    }

    public function update(PartnerRequest $request, Partner $partner)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('image')) {
            $this->delete_file($partner->image);
            $data['image'] = $this->upload_file($request->file('image'), 'partners');
        }

        $partner->update($data);

        session()->flash('success', trans('message.admin.updated_sucessfully'));

        if (request()->submit == "update") {
            return redirect()->back();
        }

        return redirect()->route('admin.partners.index');
    }

    public function destroy(Partner $partner)
    {
        $this->delete_file($partner->image);
        $partner->delete();

        session()->flash('success', trans('message.admin.deleted_sucessfully'));

        return redirect()->back();
    }

    public function update_status($id)
    {
        $partner = Partner::findOrFail($id);

        $partner->status == 1 ? $partner->status = 0 : $partner->status = 1;

        $partner->save();

        return redirect()->back();
    }

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $partners = Partner::findMany($request['record']);

            foreach ($partners as $partner) {
                $partner->update(['status' => 1]);
            }

            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }

        if ($request['unpublish'] == 1) {
            $partners = Partner::findMany($request['record']);

            foreach ($partners as $partner) {
                $partner->update(['status' => 0]);
            }

            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }

        if ($request['delete_all'] == 1) {
            $partners = Partner::findMany($request['record']);

            foreach ($partners as $partner) {
                $this->delete_file($partner->image);
                $partner->delete();
            }

            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }

        return redirect()->back();
    }
}