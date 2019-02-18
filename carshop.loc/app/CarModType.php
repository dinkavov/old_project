<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $brand
 * @property int $hull
 * @property int $class
 * @property Brand $brand
 * @property Hull $hull
 * @property Class $class
 * @property Car[] $cars
 */
class CarModType extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'car_modtype';
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
    protected $fillable = ['brand', 'hull', 'class'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hull()
    {
        return $this->belongsTo(Hull::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function class()
    {
        return $this->belongsTo(CarClass::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cars()
    {
        return $this->belongsTo(Car::class);
    }
}
