<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Value;
use App\Models\Register;

class Lights extends Component
{
    public $lightsValue;
    public $registerId;

    public function mount()
    {
        $this->registerId = Register::where('name', 'light.target_illum')->first();
    }

    public function render()
    {
        $lightsDBValue = Value::where('register_id', $this->registerId->id)->first();
        return view('livewire.lights', compact('lightsDBValue'));
    }
}
