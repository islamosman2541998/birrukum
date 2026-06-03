<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PageFeatureTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_feature_id',
        'locale',
        'title',
        'description',
    ];
}