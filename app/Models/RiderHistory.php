<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Facades\App\Helpers\Helper;
use Carbon\Carbon;
class RiderHistory extends Model
{
        protected $table = 'order_offer_history';
    protected $fillable = [
        'order_number', 
        'status',
        'status_note',
        'reason',
        'rider_id',
        'delivery_fee',
        'driver_payout_id',
        'order_offer_id'   
    ];

    protected $primaryKey = 'id';
    public $timestamps = true;

   
//------------Get rider payment

        public function GetRiderPayment()
        {

           $payment_period = Helper::getKeyValue('rider_payment_period');
            return $this
            ->join("rider_users", "rider_users.id", "=", "order_offer_history.rider_id")
            ->where('order_offer_history.created_at', '<=', Carbon::now()->subDays($payment_period)->toDateTimeString())
            ->select('order_offer_history.*')
            ->where('order_offer_history.driver_payout_id',Null)
            ->where('order_offer_history.status','delivered')
          

            ->get();
       }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rider()
    {
        return $this->belongsTo(\App\Models\Rider::class, 'rider_id', 'id');
    }


}
