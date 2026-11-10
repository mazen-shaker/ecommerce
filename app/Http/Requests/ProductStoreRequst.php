<?php

namespace App\Http\Requests;

use core\validation\Main;

class ProductStoreRequest extends Main
{
    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'category_id' => ['required', 'integer'],
            'description' => ['required', 'string', 'min:3', 'max:500'],
            'price' => ['required', 'numeric', 'min:0'],
            'old_price' => ['numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'file' => [
                'required',
                'image',
                'max:5048',
            ],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function handle(): bool
    {
        return $this->validate($this->rules());
    }
}
