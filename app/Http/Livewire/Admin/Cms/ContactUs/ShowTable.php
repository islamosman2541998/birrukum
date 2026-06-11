<?php

namespace App\Http\Livewire\Admin\Cms\ContactUs;

use Livewire\Component;

class ShowTable extends Component
{
    public $index, $item, $key;
    public $mySelected, $selectAll, $deleteId = '', $selected;

    public $search_name = "", $search_email = "", $search_phone = "";

    protected $listeners = ['updatedSelectAll'];



    // Events ----------------------------------------------

    public function deleteId($id)
    {
        $this->emitUp('updateDeleteId', $id);
    }

    // Nested function ----------------------------------------------
    public function updateSellected($selected)
    {
        $this->emitUp('updateSellected', $selected);
    }

    public function updatedSelectAll($selectes)
    {
        $this->mySelected = $selectes;
    }
    public function update_status($id)
    {
        $this->item->status == 1 ? $this->item->status = 0 : $this->item->status = 1;
        $this->item->save();
        $this->emitUp('updateSession', trans('message.admin.status_changed_sucessfully'));
    }

    public function mount($item)
    {
        $this->item = $item;
    }

    public function render()
    {
        return view('livewire.admin.cms.contact-us.show-table');
    }
}
