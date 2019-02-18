<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $model_id
 * @property int $price
 * @property string $description
 * @property CarModtype $carModtype
 */
class Car extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'car';

    public $timestamps = false;
    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['model_id', 'price', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function carModtype()
    {
        return $this->belongsTo('App\CarModtype', 'model_id');
    }
}
