<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Commentcreator extends Model implements Sortable
{
    protected $fillable = [
        'name', 'comment', 'picture1','language','active'
    ];

    public  function localization(){
        return $this->belongsTo(Localizations::class,'language');
    }

    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'queue',
        'sort_when_creating' => true,
    ];
}
