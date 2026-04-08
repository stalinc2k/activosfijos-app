<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Filament\Notifications\Notification;

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

            if ($model->type === 'Entrada') {
                foreach ($model->items as $item) {
                    $usedInOutput = \App\Models\DocumentItem::where('product_id', $item->product_id)
                        ->where('serie_number', $item->serie_number)
                        ->whereHas('document', function ($q) use ($model) {
                            $q->withTrashed()
                                ->where('type', 'Entrega')
                                ->where('id', '!=', $model->id);
                        })
                        ->exists();

                    if ($usedInOutput) {

                        Notification::make()
                            ->title('No se puede eliminar')
                            ->body("Uno o Varios Activos de esta entrada ya fueron entregados.")
                            ->danger()
                            ->send();

                        return false; // 🔥 bloquea eliminación
                    }
                }
            }

            // 🔥 Guardar quién elimina (sin save())
            $model->deleted_by = Auth::id();
            $model->saveQuietly(); // 👈 evita eventos infinitos

            // 🔥 Eliminar items relacionados (soft delete)
            $model->items()->delete();
        });

        static::restoring(function ($model) {

            // 🔥 Restaurar items eliminados
            $model->items()->withTrashed()->restore();
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
