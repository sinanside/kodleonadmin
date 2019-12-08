<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'address', 'phone1', 'phone2', 'gsm', 'fax', 'email','map','host','port','smtpsecure','username','password','gmail','gisim','subject','active'
    ];

    protected $hidden = [
        'password',
    ];

     protected $table = 'contacts';
}
