<?php

namespace App\Http\Requests;
use core\validation\Main;



class AdminProfileUpdateRequest extends Main
{
    private function rules(): array
    {
      return [
       'name' => ['required', 'string', 'min:3', 'max:30', 'alpha'],
       'email' => ['required', 'email', 'max:255'],
       'phone' => ['required', 'string', 'min:11', 'max:15'],
       'password' => ['string', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[^a-zA-Z0-9]).+$/',],
      ];
    }

    public function handle(): bool
    {
        return $this->validate($this->rules());
    }
}
