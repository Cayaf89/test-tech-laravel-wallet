<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\WalletTransactionType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'start_date',
        'end_date',
        'frequency',
    ];

    protected function casts(): array
    {
        return [
            'type' => WalletTransactionType::class,
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    protected function isTransfer(): Attribute
    {
        return Attribute::get(fn () => filled($this->transfer_id));
    }

    public function transfer(): BelongsTo
    {
        return $this->belongsTo(WalletTransfer::class, 'transfer_id');
    }

    /**
     * @return BelongsTo<Wallet>
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
