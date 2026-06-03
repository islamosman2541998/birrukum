<?php

namespace App\Models;

use App\Models\Pages;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PageContent extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'page_id',
        'sort',
    ];

    public $translatedAttributes = [
        'page_content_id',
        'locale',
        'title',
        'description',
    ];

    protected $translationForeignKey = 'page_content_id';

    public function page()
    {
        return $this->belongsTo(Pages::class, 'page_id');
    }

    public function trans()
    {
        return $this->hasMany(PageContentTranslation::class, 'page_content_id');
    }

    public function transNow()
    {
        return $this->hasOne(PageContentTranslation::class, 'page_content_id')
            ->where('locale', app()->getLocale());
    }
}