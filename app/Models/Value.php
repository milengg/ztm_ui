<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Register;

class Value extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'values';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'register_id',
        'name',
        'value',
        'min',
        'max',
        'status'
    ];

    public function register() {    
        return $this->belongsTo(Register::class, 'register_id');  
    }
}
