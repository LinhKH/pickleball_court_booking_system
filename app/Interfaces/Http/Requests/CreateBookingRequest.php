<?php

namespace App\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookingRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'court_id'          => ['required', 'integer'],
      'slots'             => ['required', 'array', 'min:1'],
      'slots.*.slot_id'   => ['required', 'integer'],
      'slots.*.price'     => ['required', 'integer', 'min:0'],
    ];
  }
}
