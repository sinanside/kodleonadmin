<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use App\Traits\SecureDelete;

class Althizmetturs extends Model implements Sortable
{
    use Sluggable;
    use SecureDelete;

    public  function hizmettur(){
        return $this->belongsTo(Hizmetturs::class,'hiz_id');
    }
    public  function localization(){
        return $this->belongsTo(Localizations::class,'language');
    }

    public function hizmetcreator()
    {
        return $this->hasMany('App\Hizmetcreator','althiz_id');
    }


    protected $fillable = [
        'hiz_id','title', 'short_description', 'photo',  'photo_alt','queue', 'language', 'mainpage','active'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    use SortableTrait;

    public function buildSortQuery()
    {
        return static::query()->where('hiz_id', $this->hiz_id)->where('language', $this->language);
    }

    public $sortable = [
        'order_column_name' => 'queue',
        'sort_when_creating' => true,
    ];
    /*
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($Althizmetturs) {
            $relationMethods = ['hizmetcreator'];

            foreach ($relationMethods as $relationMethod) {
                if ($Althizmetturs->$relationMethod()->count() > 0) {
                    return false;
                }
            }
        });
    }
    */

}
