<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reg_application extends Model
{
    protected $fillable = [
        'name', 'phone', 'type', 'regdate', 'reads', 'status'
    ];



}
