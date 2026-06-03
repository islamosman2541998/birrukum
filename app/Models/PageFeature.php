<?php

namespace App\Models;

use App\Models\Pages;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PageFeature extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'page_id',
        'image',
        'url',
        'sort',
    ];

    public $translatedAttributes = [
        'page_feature_id',
        'locale',
        'title',
        'description',
    ];

    protected $translationForeignKey = 'page_feature_id';

    public function page()
    {
        return $this->belongsTo(Pages::class, 'page_id');
    }

    public function trans()
    {
        return $this->hasMany(PageFeatureTranslation::class, 'page_feature_id');
    }

    public function transNow()
    {
        return $this->hasOne(PageFeatureTranslation::class, 'page_feature_id')
            ->where('locale', app()->getLocale());
    }
}
