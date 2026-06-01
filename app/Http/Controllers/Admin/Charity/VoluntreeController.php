<?php

namespace App\Http\Controllers\Admin\Charity;

use App\Models\Volunteers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Charity\VolunteersRequest;
use App\Models\Accounts;
use App\Models\LoginTypes;
use Illuminate\Support\Facades\DB;

class VoluntreeController extends Controller
{
    public function index(Request $request)
    {
        $query = Volunteers::query()->orderBy('id', 'DESC');

        if ($request->status  != '') {
            $query->where('status', $request->status);
        }
        if ($request->type  != '') {
            $query->where('type', 'like', '%' . $request->type . '%');
        }
        if ($request->name  != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->team_name  != '') {
            $query->where('team_name', 'like', '%' . $request->team_name . '%');
        }
        if ($request->email  != '') {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->mobile  != '') {
            $query->where('mobile', 'like', '%' . $request->mobile . '%');
        }
        if ($request->gender  != '') {
            $query->where('gender', 'like', '%' . $request->gender . '%');
        }
        if ($request->nationality  != '') {
            $query->where('nationality', 'like', '%' . $request->nationality . '%');
        }
        if ($request->search_created_from  != '') {
            $query = $query->whereDate('created_at', '>=', $request->search_created_from);
        }
        if ($request->search_created__to  != '') {
            $query = $query->whereDate('created_at', '<=', $request->search_created__to);
        }

        $items = $query->paginate($this->pagination_count);

        return view('admin.dashboard.chairty.volunteers.index', compact('items'));
    }


    public function create()
    {
        return view('admin.dashboard.chairty.volunteers.create');
    }


    public function store(VolunteersRequest $request)
    {
        $data = $request->getSanitized();
        DB::beginTransaction();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('volunteer'));
        }
        if ($request->hasFile('team_logo')) {
            $data['team_logo'] = $this->upload_file($request->file('team_logo'), ('volunteer'));
        }

        if(!isset($data['account_id'])){
            $data['password'] = bcrypt($data['password']);
            $account = Accounts::create($data);
            $data['account_id'] = $account->id;
            $types = LoginTypes::query()->whereIn('type', $data['type_login'])->pluck('id')->toArray();
            $account->types()->attach($types);
        }
        else{
            $account = Accounts::find($data['account_id']);
            $account->user_name = $data['user_name'];
            $account->email = $data['email'];
            $account->password = isset($data['password'])? bcrypt($data['password']) : $account->password;
            $account->save();
            $types = LoginTypes::query()->whereIn('type', $data['type_login'])->pluck('id')->toArray();
            $account->types()->syncWithoutDetaching($types);
        }

        $volunteer = Volunteers::create($data);
        DB::commit();
        DB::rollBack();
        
   
        session()->flash('success', trans('message.admin.created_sucessfully'));

        if (request()->submit == "new") {
            return  redirect()->back();
        }
        return redirect()->route('admin.volunteers.index');
    }

    public function show(Volunteers $volunteer)
    {
        return view('admin.dashboard.chairty.volunteers.show', compact('volunteer'));
    }


    public function edit(Volunteers $volunteer)
    {
        return view('admin.dashboard.chairty.volunteers.edit', compact('volunteer'));
    }


    public function update(VolunteersRequest $request, Volunteers $volunteer)
    {
        $data = $request->getSanitized();

        DB::beginTransaction();

        if ($request->hasFile('image')) {
             $this->delete_file($volunteer->image);
            $data['image'] = $this->upload_file($request->file('image'), ('volunteer'));
        }
        if ($request->hasFile('team_logo')) {
             $this->delete_file($volunteer->team_logo);
            $data['team_logo'] = $this->upload_file($request->file('team_logo'), ('volunteer'));
        }


        if(!isset($data['account_id'])){
            $data['password'] = bcrypt($data['password']);
            $account = Accounts::create($data);
            $data['account_id'] = $account->id;
            $types = LoginTypes::query()->whereIn('type', $data['type_login'])->pluck('id')->toArray();
            $account->types()->attach($types);
        }
        else{
            $account = Accounts::find($data['account_id']);
            $account->user_name = $data['user_name'];
            $account->email = $data['email'];
            $account->password = isset($data['password'])? bcrypt($data['password']) : $account->password;
            $account->save();
            $types = LoginTypes::query()->whereIn('type', $data['type_login'])->pluck('id')->toArray();
            $account->types()->syncWithoutDetaching($types);
        }
        
        $volunteer->update($data);

        DB::commit();
        DB::rollBack();

        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if (request()->submit == "update") {
            return  redirect()->back();
        }
        return  redirect()->route('admin.volunteers.index');
    }


    public function destroy(Volunteers $volunteer)
    {
        $this->delete_file($volunteer->image);
        $volunteer->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }



    public function update_status($id)
    {
        $volunteer = Volunteers::findOrfail($id);
        $volunteer->status == 1 ? $volunteer->status = 0 : $volunteer->status = 1;
        $volunteer->save();
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $volunteers = Volunteers::findMany($request['record']);
            foreach ($volunteers as $volunteer) {
                $volunteer->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $volunteers = Volunteers::findMany($request['record']);
            foreach ($volunteers as $volunteer) {
                $volunteer->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $volunteers = Volunteers::findMany($request['record']);
            foreach ($volunteers as $volunteer) {
                $this->delete_file($volunteer->image);
                $volunteer->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
