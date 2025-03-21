<?php

declare(strict_types=1);

namespace App\Enums;

enum WalletTransactionType: string
{
    case CREDIT = 'credit';
    case DEBIT = 'debit';
    case RECURRING = 'recurring';

    public function isDebit(): bool
    {
        return $this === self::DEBIT;
    }

    public function isCredit(): bool
    {
        return $this === self::CREDIT;
    }

    public function isRecurring(): bool
    {
        return $this === self::RECURRING;
    }
}
