<?php

namespace App\Http\Requests;

use core\validation\Main;

class AssetStoreRequest extends Main
{
    private function rules(): array
    {
        return [
            'file' => [
                'required',
                'image',
                'max:5048',
            ],
        ];
    }

    public function handle(): bool
    {
        return $this->validate($this->rules());
    }
}
