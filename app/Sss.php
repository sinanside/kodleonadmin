<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Sss extends Model implements Sortable
{

    protected $fillable = [
        'language','question', 'answer', 'queue', 'mainpage', 'active'
    ];

    public  function localization(){
        return $this->belongsTo(Localizations::class,'language');
    }

    protected $table = 'sss';

    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'queue',
        'sort_when_creating' => true,
    ];
}
