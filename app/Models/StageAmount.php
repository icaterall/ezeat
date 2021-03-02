<?php

namespace App\Models;

use Eloquent as Model;

class StageAmount extends Model
{

    public $table = 'stage_amounts';
    public $primaryKey = 'id';

    public $fillable = [
    'stage',   
    'amount'
 
    ];

}
