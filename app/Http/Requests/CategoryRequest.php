<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CategoryRequest extends FormRequest
{
  public function authorize(): bool
  {
    return Auth::check();
  }

  public function rules(): array
  {
    $rules = [
      'description' => ['nullable', 'string', 'max:255'],
    ];

    if ($this->isMethod('post')) {
      $rules['name'] = ['required', 'string', 'max:100', 'unique:categories,name'];
    } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
      $category = $this->route('category');
      $rules['name'] = ['required', 'string', 'max:100', 'unique:categories,name,' . $category->id];
    }

    return $rules;
  }
}
