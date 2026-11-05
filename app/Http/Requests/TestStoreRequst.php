<?php

namespace App\Http\Requests;
use core\validation\Main;



class TestStoreRequest extends Main
{
    private function rules(): array
    {
        return [
            'name' => ['required','string','min:3','max:30'],
            'email' => ['required','email'],
        ];
    }

    public function handle(): bool
    {
        return $this->validate($this->rules());
    }
}
