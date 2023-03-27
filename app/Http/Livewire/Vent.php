<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Value;
use App\Models\Register;

class Vent extends Component
{
    public $ventValue;
    public $registerId;

    public function mount()
    {
        $this->registerId = Register::where('name', 'vent.op_setpoint_1')->first();
    }

    public function render()
    {
        $ventDBValue = Value::where('register_id', $this->registerId->id)->first();
        return view('livewire.vent', compact('ventDBValue'));
    }
}
