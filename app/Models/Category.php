<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    Use SoftDeletes;

    protected $fillable = [
        'name',
        'trademark_id'
    ];


    protected static function booted()
    {
        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });

        static::updating((function ($model) {
            $model->updated_by = Auth::id();
        }));

        static::deleting(function ($model) {
            $model->deleted_by = Auth::id();
        });
    }

    public function products ()
    {
        return $this->hasMany(Product::class);
    }

    public function trademark ()
    {
        return $this->belongsTo(Trademark::class);
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
