<?php

namespace App\Repositories;

use App\Models\Cuisine;
use App\Repositories\BaseRepository;

/**
 * Class CuisineRepository
 * @package App\Repositories
 * @version April 11, 2020, 1:57 pm UTC
 *
 * @method Cuisine findWithoutFail($id, $columns = ['*'])
 * @method Cuisine find($id, $columns = ['*'])
 * @method Cuisine first($columns = ['*'])
*/
class CuisineRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $cuisineSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Cuisine::class;
    }
}
