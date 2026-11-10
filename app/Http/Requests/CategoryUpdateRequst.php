<?php

namespace App\Http\Requests;
use core\validation\Main;



class CategoryUpdateRequest extends Main
{
    private function rules(): array
    {
     return [
      'name' => ['required', 'string', 'min:3', 'max:50', 'alpha'],
      'description' => ['required', 'string', 'min:3', 'max:500'],
    ];
    }

    public function handle(): bool
    {
        return $this->validate($this->rules());
    }
}
