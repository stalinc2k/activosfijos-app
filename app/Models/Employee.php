<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'mail',
        'department_id',
        'appointment_id',
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

   public function department(){
        return $this->belongsTo(Department::class);
    }

    public function appointment() {
        return $this->belongsTo(Appointment::class);
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
