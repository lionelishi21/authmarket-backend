<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleModelYear extends Model
{
    /* The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'year', 'model_id',
    ];

    /**
     * Year belongs to one model.
     *
     * @return mixed
     */
    public function model()
    {
    	return $this->belongsTo(VehicleModel::class);
    }

    /**
     * Year belongs to one make through model.
     *
     * @return mixed
     */
    public function make()
    {
    	return $this->model->make();
    }

    /**
     * Scope by model.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $model Model id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByModel($query, $model)
    {
        return $query->where('model_id', $model);
    }
}
