<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'date',
        'delivered_to',
        'returned_by',
        'type',
        'Observation',
        'provider_id',
        'num_doc',
    ];

     protected static function booted()
    {
        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });

        static::deleting(function ($model) {
            $model->deleted_by = Auth::id();
            $model->save();
        });
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

    public function returned()
    {
        return $this->belongsTo(Employee::class, 'returned_by');
    }

    public function delivered()
    {
        return $this->belongsTo(Employee::class, 'delivered_to');
    }

    public function items()
    {
        return $this->hasMany(DocumentItem::class);
    }
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
