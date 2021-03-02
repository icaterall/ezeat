<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantWrokingDay extends Model
{
    protected $table = 'restaurant_working_days';
    protected $fillable = ['restaurant_id', 'day_id','open_time','close_time','available'];
    protected $primaryKey = 'id';

    public function store()
    {
        return $this->belongsTo(Storeinfo::class);
    }

    public function days()
    {
        return $this->belongsTo(Day::class);
    }

    public function getDaysByRestaurantID($restaurantID)
    {
        return $this
            ->leftJoin('restaurants', $this->table.'.restaurant_id', '=', 'restaurants.id')
            ->leftJoin('days', $this->table.'.day_id', '=', 'days.id')

            ->select(
                $this->table.'.*',

                'restaurants.name as restaurant_name',
                'days.name as day_name'
            )
            ->where('restaurant_working_days.restaurant_id', '=', $restaurantID)
            ->orderBy('day_id')

            ->get();
    }


    public function getDays($storeID)
    {
        return $this
            ->leftJoin('restaurants', $this->table.'.restaurant_id', '=', 'restaurants.id')
             ->leftJoin('days', $this->table.'.day_id', '=', 'days.id')

            ->select(
                $this->table.'.*',

                'restaurants.store_name as store_name',
                'days.title as day_name'
            )
            ->where('   restaurant_working_days.restaurant_id', '=', $storeID)->get();
    }


}
