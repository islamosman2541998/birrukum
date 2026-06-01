<?php

namespace App\Http\Controllers\Admin\Charity;

use App\Models\Refer;
use App\Models\Accounts;
use App\Models\LoginTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\Charity\ReferRequest;

class ReferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Refer::query()->orderBy('id', 'DESC');

        if ($request->status  != '') {
            $query->where('status', $request->status);
        }
        if ($request->name  != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->employee_name  != '') {
            $query->where('employee_name', 'like', '%' . $request->employee_name . '%');
        }

        $refers = $query->paginate($this->pagination_count);
        return view('admin.dashboard.chairty.refer.index', compact('refers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dashboard.chairty.refer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReferRequest $request)
    {
        $data = $request->getSanitized();
        DB::beginTransaction();
        if ($request->hasFile('employee_image')) {
            $data['employee_image'] = $this->upload_file($request->file('employee_image'), ('refer'));
        }

        if (!isset($data['account_id'])) {
            $data['password'] = bcrypt($data['password']);
            $account = Accounts::create($data);
            $data['account_id'] = $account->id;
            $types = LoginTypes::query()->whereIn('type', $data['type'])->pluck('id')->toArray();
            $account->types()->attach($types);
        } else {
            $account = Accounts::find($data['account_id']);
            $account->email = $data['email'];
            $account->user_name = $data['user_name'];
            $account->password = isset($data['password']) ? bcrypt($data['password']) : $account->password;
            $account->save();
        }

        Refer::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        DB::commit();
        DB::rollBack();

        if (request()->submit == "new") {
            return  redirect()->back();
        }
        return redirect()->route('admin.charity.refers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Refer $refer)
    {
        return view('admin.dashboard.chairty.refer.show', compact('refer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Refer $refer)
    {
        return view('admin.dashboard.chairty.refer.edit', compact('refer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReferRequest $request, Refer $refer)
    {
        $data = $request->getSanitized();
        DB::beginTransaction();
        if ($request->hasFile('employee_image')) {
            $this->delete_file($refer->employee_image);
            $data['employee_image'] = $this->upload_file($request->file('employee_image'), ('refer'));
        }

        if (!isset($data['account_id'])) {
            $data['password'] = bcrypt($data['password']);
            $account = Accounts::create($data);
            $data['account_id'] = $account->id;
            $types = LoginTypes::query()->whereIn('type', $data['type'])->pluck('id')->toArray();
            $account->types()->attach($types);
        } else {
            $account = Accounts::find($data['account_id']);
            $account->user_name = $data['user_name'];
            $account->email = $data['email'];
            $account->password = isset($data['password']) ? bcrypt($data['password']) : $account->password;
            $account->save();

            $types = LoginTypes::query()->whereIn('type', $data['type'])->pluck('id')->toArray();
            $account->types()->syncWithoutDetaching($types);
        }

        $refer->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        DB::commit();
        DB::rollBack();
        if (request()->submit == "update") {
            return  redirect()->back();
        }
        return redirect()->route('admin.charity.refers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $refer = Refer::query()->findOrFail($id);
        $this->delete_file($refer->employee_image);
        $refer->delete();

        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return  redirect()->back();
    }


    public function update_status($id)
    {
        $refers = Refer::findOrfail($id);
        $refers->status == 1 ? $refers->status = 0 : $refers->status = 1;
        $refers->save();
        return redirect()->back();
    }


    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $refers = Refer::findMany($request['record']);
            foreach ($refers as $refer) {
                $refer->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $refers = Refer::findMany($request['record']);
            foreach ($refers as $refer) {
                $refer->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $refers = Refer::findMany($request['record']);
            foreach ($refers as $refer) {
                $refer->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
