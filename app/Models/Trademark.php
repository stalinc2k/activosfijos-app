<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trademark extends Model
{
    Use SoftDeletes;

    protected $fillable = [
        'name'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->created_by = auth()->id;
        });

        static::updating((function ($model) {
            $model->updated_by = auth()->id;
        }));

        static::deleting(function ($model) {
            $model->deleted_by = auth()->id;
        });
    }

    public function products ()
    {
        return $this->hasMany(Product::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
