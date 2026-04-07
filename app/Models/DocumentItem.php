<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'document_id',
        'product_id',
        'quantity',
        'unit_cost',
        'trademark_id',
        'serie_number'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
    public function trademark()
    {
        return $this->belongsTo(Trademark::class, 'trademark_id');
    }

    //Funcion para evitar duplicados
    public static function isSerieInStock($productId, $serieNumber, $ignoreId = null): bool
    {
        $items = self::where('product_id', $productId)
            ->where('serie_number', $serieNumber)
            ->with(['document' => fn($q) => $q->withTrashed()])
            ->get();

        $stock = 0;

        foreach ($items as $item) {

            // 🔥 ignorar el actual
            if ($ignoreId && $item->id == $ignoreId) {
                continue;
            }

            switch ($item->document->type) {
                case 'Entrada':
                case 'Devolucion':
                    $stock += 1;
                    break;

                case 'Entrega':
                case 'Baja':
                    $stock -= 1;
                    break;
            }
        }

        return $stock > 0;
    }
}
