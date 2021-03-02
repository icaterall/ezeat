<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FoodItemTime extends Model
{
     protected $table = 'store_item_times';

    protected $fillable = [
        'food_time_id',
        'food_id',
    ];

    /**
     * get all hotels related to given service.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function foods()
    {
        return $this->belongsToMany(Food::class, 'store_item_times');
    }

    public function itemtimes()
    {
        return $this->belongsTo(ItemTime::class);
    }

    /**
     * get all services for a given language.
     *
     * @param $lang
     * @return mixed
     */
    public function getFilterItemtimes($stores)
    {
        return $this
            ->join('item_times', $this->table.'.item_time_id', '=', 'item_times.id')
            ->select(
                $this->table.'.*',
                'item_times.title as time_title',
                DB::raw('count(item_times.id) as num_time'),
                'item_times.id as time_id'
            )
            ->whereIn($this->table.'.product_id', $stores->pluck('id'))
            ->groupBy('item_times.title')
            ->get();
    }


    public function getProductItemtimes()
    {
        return $this
            ->join('products', $this->table.'.product_id', '=', 'products.id')
            ->join('item_times', $this->table.'.item_time_id', '=', 'item_times.id')
            ->select(
                $this->table.'.*',

                'item_times.title as time_title',
                'item_times.id as time_id'
            )
            ->get();
    }

    /*
     * get all services for a given language for ajax request
     *
     * @param $lang
     * @return mixed
     */
}
