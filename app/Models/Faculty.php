<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $guarded = ['id'];
    public function programs() {
        return $this->hasMany(Program::class);
    }
}
