<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SendMoneyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'recipient_email' => [
                'required',
                'email',
                Rule::exists(User::class, 'email')->whereNot('id', $this->user()->id),
            ],
            'amount' => [
                'required',
                'integer',
                'min:1',
            ],
            'reason' => [
                'required',
                'string',
                'max:255',
            ],
            'is_recurring' => [
                'required',
                'boolean',
            ],
            'start_date' => [
                Rule::requiredIf(fn() => $this->input('is_recurring')),
                Rule::date()->afterOrEqual(today()),
            ],
            'end_date' => [
                Rule::requiredIf(fn() => $this->input('is_recurring')),
                'after:start_date',
            ],
            'frequency' => [
                Rule::requiredIf(fn() => $this->input('is_recurring')),
                'integer',
                'min:1'
            ],
        ];
    }

    public function getRecipient(): User
    {
        return User::where('email', '=', $this->input('recipient_email'))->firstOrFail();
    }
}
