<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'renter_id',
        'property_id',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get the user that rents the property.
     */
    public function renter()
    {
        return $this->belongsTo(User::class, 'renter_id');
    }

    /**
     * Get the property that is being rented.
     */
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

}