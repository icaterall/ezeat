<?php

namespace App\Models;

use Eloquent as Model;


class RiderProfile extends Model
{

    public $table = 'rider_profiles';
    public $primaryKey = 'id';

    public $fillable = [
        'region',
        'city',
        'address',
        'coverage_area',
        'available_from',
        'available_to',
        'photo',
        'driving_license',
        'roa_tax',
        'bike_photo',
        'ic_number',
        'bank_name',
        'account_number',
        'stage',
        'rider_id'    
    ];



    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'rider_id' => 'required'
    ];



}
