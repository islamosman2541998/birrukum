<?php

namespace App\Http\Livewire\Site\Volunteering;

use App\Charity\Settings\SettingSingleton;
use App\Models\Accounts;
use App\Models\LoginTypes;
use App\Models\Volunteers;
use App\Traits\FileHandler;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class JoinCommunity extends Component
{
    use WithFileUploads, FileHandler;


    public $type = "volunteer", $name, $identity, $mobile, $image, $team_name, $team_logo, $activity = "";

    public $whatsapp = "";

    protected function rules()
    {
        $rule =  [
            'type'         => 'required',
            'name'         => 'required|min:3|string',
            'identity'     => 'required|min:3|string',
            'activity'     => 'required|min:3|string',
            'mobile'       => 'required|min:9|max:9',
            'image'        => 'required|' . ImageValidate(),
        ];
    

        return $rule;
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function submit()
    {
        $data = $this->validate();
    
        DB::beginTransaction();

        if ($data['image'] != null) {
            $data['image'] = $this->upload_file($data['image'], ('volunteer'));
        }
        if (@$data['team_logo'] != null) {
            $data['team_logo'] = $this->upload_file($data['team_logo'], ('volunteer'), 'team_');
        }

        $account = Accounts::where('mobile', $data['mobile'])->get()->first();
        $data['account_id']  = $account ? $account->id : null;

        if($data['account_id'] == null){
            $account = Accounts::create($data);
            $data['account_id'] = $account->id;
            $types = LoginTypes::query()->whereIn('type', ['volunteers'])->pluck('id')->toArray();
            $account->types()->attach($types);
        }
        $data['status'] = 0;

        $volunteer = Volunteers::create($data);
        DB::commit();
        DB::rollBack();
        
        session()->flash('success', trans('Thank you for contacting us. We will contact you as soon as possible'));
        $this->emptyForm();
        return redirect()->route('site.volunteering.index');
    }

    public function emptyForm()
    {
        $this->type = "";
        $this->name = "";
        $this->identity = "";
        $this->mobile = "";
        $this->image = "";
        // $this->team_name = "";
        // $this->team_logo = "";
        $this->activity = "";
    }


    public function mount()
    {
        $settings = SettingSingleton::getInstance();
        $this->whatsapp = $settings->getVolunteeringData('whatsapp');
    }

    public function render()
    {
        return view('livewire.site.volunteering.join-community');
    }
}
