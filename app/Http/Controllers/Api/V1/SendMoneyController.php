<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\PerformWalletTransfer;
use App\Enums\WalletTransactionType;
use App\Http\Requests\Api\V1\SendMoneyRequest;
use Illuminate\Http\Response;

class SendMoneyController
{
    public function __invoke(SendMoneyRequest $request, PerformWalletTransfer $performWalletTransfer): Response
    {
        $recipient = $request->getRecipient();

        $performWalletTransfer->execute(
            sender: $request->user(),
            recipient: $recipient,
            amount: $request->input('amount'),
            reason: $request->input('reason'),
            sendType: $request->input('is_recurring') ? WalletTransactionType::RECURRING : WalletTransactionType::DEBIT,
            startDate: $request->input('start_date') ?? null,
            endDate: $request->input('end_date') ?? null,
            frequency: $request->input('frequency') ?? null,
        );

        return response()->noContent(201);
    }
}
