<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetAvailabilityRequest extends FormRequest
{
  public function rules(): array
  {
    return [
      'court_id' => ['required', 'integer', 'exists:courts,id'],
      'date' => ['required', 'date'],
    ];
  }
}
