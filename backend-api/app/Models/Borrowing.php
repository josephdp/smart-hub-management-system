<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = ['user_id', 'equipment_id', 'borrow_time', 'return_time', 'status'];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
