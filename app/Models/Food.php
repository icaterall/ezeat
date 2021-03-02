<?php


namespace App\Models;

use Eloquent as Model;


class Food extends Model
{
    
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'price' => 'required|numeric|min:0',
        'restaurant_id' => 'required|exists:restaurants,id',
        'category_id' => 'required|exists:categories,id'
    ];

    public $table = 'foods';
    public $fillable = [

    'name',
    'price',
    'restaurant_price',
    'description',
    'image',
    'package_items_count',
    'position',
    'featured',
    'deliverable',
    'restaurant_id',
    'category_id',


    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'price' => 'double',
        'restaurant_price' => 'double',
        'description' => 'string',
        'package_items_count' => 'integer',
        'featured' => 'boolean',
        'deliverable' => 'boolean',
        'restaurant_id' => 'integer',
        'category_id' => 'integer'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id', 'id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function times()
    {
        return $this->belongsToMany(\App\Models\FoodTime::class, 'food_item_times');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function extras()
    {
        return $this->hasMany(\App\Models\Extra::class, 'food_id');
    }
    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function variations()
    {
        return $this->hasMany(\App\Models\Variation::class, 'food_id');
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function extraGroups()
    {
        return $this->belongsToMany(\App\Models\ExtraGroup::class,'extras');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function foodReviews()
    {
        return $this->hasMany(\App\Models\FoodReview::class, 'food_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function restaurant()
    {
        return $this->belongsTo(\App\Models\Restaurant::class, 'restaurant_id', 'id');
    }



}
