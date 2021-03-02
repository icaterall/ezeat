<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Facades\App\Models\Food;
class updateFoodCommission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $commission;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($commission)
    {
        $this->commission = $commission;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         try {

           $food_data = Food::all();
           foreach ($food_data as $key => $food) {
                $food->update([
                    'price' => $food->restaurant_price + ($food->restaurant_price * $this->commission)
                ]);
            }
    
     }catch (ValidatorException $e) {
                return $this->sendError($e->getMessage());
            }
    }
}
