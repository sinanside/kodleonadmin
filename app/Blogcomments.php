<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Blogcomments extends Model implements Sortable
{
    protected $fillable = [
        'user', 'blg_id', 'name','comment','language','active'
    ];

    public  function localization(){
        return $this->belongsTo(Localizations::class,'language');
    }

    use SortableTrait;

    public function buildSortQuery()
    {
        return static::query()->where('language', $this->language);
    }

    public  function makale(){
        return $this->belongsTo(Blogcreator::class,'blg_id');
    }

    public $sortable = [
        'order_column_name' => 'queue',
        'sort_when_creating' => true,
    ];
}
