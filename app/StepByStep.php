<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StepByStep extends Model
{

    protected $fillable = ['descStep', 'order', 'title'];

    protected $hidden = ['created_at', 'updated_at', 'imgStep'];

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
