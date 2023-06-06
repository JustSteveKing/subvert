<?php

declare(strict_types=1);

namespace App\Http\Requests\Web;

use App\Http\Payloads\ProcessPayload;
use Illuminate\Foundation\Http\FormRequest;

class ProcessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
            ],
            'options' => [
                'required',
            ],
        ];
    }

    public function payload(): ProcessPayload
    {
        return new ProcessPayload(
            file: $this->file('file'),
            options: (array) $this->get('options'),
        );
    }
}
