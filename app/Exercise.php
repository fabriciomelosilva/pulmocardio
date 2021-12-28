<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{

    protected $hidden = ['created_at', 'updated_at'];

    public function stepbysteps()
    {
        return $this->hasMany(StepByStep::class);
    }
}
