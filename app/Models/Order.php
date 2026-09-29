<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

#[Fillable(['customer_id', 'quote_id', 'number', 'status', 'order_date', 'notes', 'total'])]
class Order extends Model
{
    public const int MAX_TOTAL_CENTS = 99_999_999_999_999;

    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
            'order_date' => 'date',
            'total' => 'decimal:2',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function sale(): HasOne
    {
        return $this->hasOne(Sale::class);
    }

    public function isEditable(): bool
    {
        return $this->status === OrderStatus::Pending;
    }

    public function transitionTo(OrderStatus $status): void
    {
        DB::transaction(function () use ($status): void {
            $order = self::query()
                ->whereKey($this->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            if ($status === OrderStatus::Confirmed) {
                $customer = Customer::query()
                    ->whereKey($order->customer_id)
                    ->lockForUpdate()
                    ->first();

                if ($order->status !== OrderStatus::Pending || ! $customer?->is_active) {
                    throw ValidationException::withMessages([
                        'order' => 'Solo un pedido pendiente con cliente activo puede confirmarse.',
                    ]);
                }

                if (! $order->details()->exists()) {
                    throw ValidationException::withMessages([
                        'order' => 'No se puede confirmar un pedido sin productos.',
                    ]);
                }
            } elseif (
                $status !== OrderStatus::Cancelled
                || ! in_array($order->status, [OrderStatus::Pending, OrderStatus::Confirmed], true)
                || $order->sale()->exists()
            ) {
                throw ValidationException::withMessages([
                    'order' => 'El estado actual del pedido no permite esta acción.',
                ]);
            }

            $order->update(['status' => $status]);
        });
    }
}
