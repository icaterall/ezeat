<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class OrderUser extends Model
{
    protected $table = 'user_orders';
    protected $fillable = [
        'user_id', 'order_id'
       ];

    protected $primaryKey = 'id';

   


    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function checkOrderExist($id)
    {
        
         if(!Auth::user()->hasrole('manager'))
         	return false;
         $user_id = Auth::user()->id;
         $restaurants = $this
         ->where('user_id',$user_id)->where('order_id',$id)->first();
        if(!empty($restaurants))
        return true;	
    
    }

}
