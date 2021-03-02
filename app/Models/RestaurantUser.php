<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class RestaurantUser extends Model
{
    protected $table = 'user_restaurants';
    protected $fillable = [
        'user_id', 'restaurant_id'
       ];

    protected $primaryKey = 'id';

   


    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function checkRestaurantOwner($id)
    {
        
         if(!Auth::user()->hasrole('manager'))
         	return false;
         $user_id = Auth::user()->id;
         $restaurants = $this
         ->where('user_id',$user_id)->where('restaurant_id',$id)->first();
        if(!empty($restaurants))
        return true;	
    
    }

}
