<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi untuk store dan update.
 * Dipisah dari controller supaya controller tetap tipis (prinsip MVC).
 */
class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'min:3', 'max:150'],
            'content'      => ['required', 'string', 'min:10'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title'   => 'judul',
            'content' => 'isi post',
            'image'   => 'gambar',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'   => 'Judul wajib diisi.',
            'title.min'        => 'Judul minimal :min karakter.',
            'title.max'        => 'Judul maksimal :max karakter.',
            'content.required' => 'Isi post wajib diisi.',
            'content.min'      => 'Isi post minimal :min karakter.',
            'image.image'      => 'File harus berupa gambar.',
            'image.mimes'      => 'Gambar harus berformat JPG, PNG, atau WEBP.',
            'image.max'        => 'Ukuran gambar maksimal 2 MB.',
            'image.uploaded'   => 'Gambar gagal diunggah. Ukurannya mungkin melebihi batas server.',
        ];
    }
}
