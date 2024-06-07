<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image_url',
        'price',
        'address',
        'seller_id',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get the seller that owns the property.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function rents()
    {
        return $this->hasMany(Rent::class, 'property_id');
    }
}