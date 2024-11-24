<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Order extends Model
{
    protected function casts(): array
    {
        return [
            'delivered' => 'boolean',
        ];
    }
    public $fillable = [
        'name',
        'id_order',
        'id_number',
        'delivered',
        'image',
    ];

    protected static function booted(): void
    {
        self::updated(function ($order) {

            $orderBefore = $order->getOriginal();
            $orderAfter = $order->getChanges();

            if ($order->isDirty('image') && ($orderBefore['image'] !== $orderAfter['image'])) {
                Storage::disk('public')->delete($orderBefore['image']);
            }
        });

        self::deleted(function ($order) {
            Storage::disk('public')->delete($order->image);
        });
    }
}
