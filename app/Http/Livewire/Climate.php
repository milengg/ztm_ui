<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Value;
use App\Models\Register;

class Climate extends Component
{
    public $climateValue;
    public $registerId;

    public function mount()
    {
        $this->registerId = Register::where('name', 'hvac.temp_1.adjust')->first();
    }

    public function render()
    {
        $ClimateDBValue = Value::where('register_id', $this->registerId->id)->first();
        return view('livewire.climate', compact('ClimateDBValue'));
    }
}
