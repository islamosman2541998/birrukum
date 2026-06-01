<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refer extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'account_id',
        'slug',
        'name',
        'employee_name',
        'employee_number',
        'employee_image',
        'employee_department',
        'ax_store_name',
        'job',
        'whatsapp',
        'location',
        'details',
        'status',
    ];

    
    public function account()
    {
        return $this->belongsTo(Accounts::class, 'account_id', 'id');
    }

    public function managers(){
        return $this->belongsToMany(Manager::class, 'manager_refers','refers_id','id' );
    }



    // Scopes ----------------------------
    public function scopeActive($query){
        return $query->where('status', 1);
    }

   
}
