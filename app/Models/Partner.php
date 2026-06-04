<?php

namespace App\Models;

use App\Models\PartnerTranslation;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partner extends Model
{
    use HasFactory, Translatable, SoftDeletes;

    protected $fillable = [
        'image',
        'url',
        'sort',
        'status',
        'created_by',
        'updated_by',
    ];

    public $translatedAttributes = [
        'partner_id',
        'locale',
        'title',
        'description',
    ];

    protected $translationForeignKey = 'partner_id';

    public function trans()
    {
        return $this->hasMany(PartnerTranslation::class, 'partner_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}