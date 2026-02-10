<?php

namespace App\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HoldSlotRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'court_id' => ['required', 'integer'],
      'slot_id'  => ['required', 'integer'],
    ];
  }
}
