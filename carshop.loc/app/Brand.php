<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property CarModtype[] $carModtypes
 */
class Brand extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'brand';

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
    protected $fillable = ['name', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function carModtypes()
    {
        return $this->hasMany('App\CarModType');
    }
}
