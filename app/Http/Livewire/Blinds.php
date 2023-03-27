<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Value;
use App\Models\Register;

class Blinds extends Component
{
    public $blindsValue;
    public $registerId;

    public function mount()
    {
        $this->registerId = Register::where('name', 'blinds.blind_1.position')->first();
    }

    public function render()
    {
        $blindsDBValue = Value::where('register_id', $this->registerId->id)->first();
        return view('livewire.blinds', compact('blindsDBValue'));
    }
}
