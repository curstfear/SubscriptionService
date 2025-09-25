<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string|max:1000',
            'link' => 'nullable|url|max:255',
            'is_reversed' => 'sometimes|required|in:0,1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp,image/svg+xml|max:2048',
            'links.*' => 'required|url|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp,image/svg+xml|max:2048',
            'new_links.*' => ['nullable', 'url', 'max:255'],
            'new_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp,image/svg+xml', 'max:2048'],
            'new_links' => [
                'array',
                function ($attribute, $value, $fail) {
                    $currentLogos = $this->route('section')->logos()->count();
                    $deleteIds = $this->input('delete_ids') ? count(explode(',', $this->input('delete_ids'))) : 0;
                    $newLogos = count(array_filter($value, fn($link) => !empty($link))) +
                        count(array_filter($this->file('new_images', []), fn($image) => $image && $image->isValid()));
                    if ($currentLogos - $deleteIds + $newLogos > 6) {
                        $fail('Максимум 6 логотипов.');
                    }
                },
            ],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_reversed' => (int) $this->is_reversed,
            'new_links' => array_values(array_filter($this->input('new_links', []), fn($link) => !empty(trim($link)))),
            'new_images' => array_values(array_filter($this->file('new_images', []), fn($image) => $image && $image->isValid())),
        ]);
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Заголовок обязателен.',
            'title.max' => 'Заголовок не длиннее 255 символов.',
            'description.required' => 'Описание обязательно.',
            'description.max' => 'Описание не длиннее 1000 символов.',
            'link.url' => 'Ссылка должна быть корректной.',
            'link.max' => 'Ссылка не длиннее 255 символов.',
            'is_reversed.required' => 'Укажите отзеркаливание.',
            'is_reversed.in' => 'Отзеркаливание: 0 или 1.',
            'image.image' => 'Загрузите изображение.',
            'image.mimes' => 'Формат: jpeg, png, jpg, gif, svg, webp.',
            'image.max' => 'Изображение не больше 2MB.',
            'links.*.required' => 'Ссылка для логотипа обязательна.',
            'links.*.url' => 'Ссылка для логотипа некорректна.',
            'links.*.max' => 'Ссылка для логотипа не длиннее 255 символов.',
            'images.*.image' => 'Загрузите изображение для логотипа.',
            'images.*.mimes' => 'Формат логотипа: jpeg, png, jpg, gif, svg, webp.',
            'images.*.max' => 'Изображение логотипа не больше 2MB.',
            'new_links.*.url' => 'Ссылка для нового логотипа некорректна.',
            'new_links.*.max' => 'Ссылка для нового логотипа не длиннее 255 символов.',
            'new_images.*.image' => 'Загрузите изображение для нового логотипа.',
            'new_images.*.mimes' => 'Формат нового логотипа: jpeg, png, jpg, gif, svg, webp.',
            'new_images.*.max' => 'Изображение нового логотипа не больше 2MB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'заголовок',
            'description' => 'описание',
            'link' => 'ссылка',
            'is_reversed' => 'отзеркаливание',
            'image' => 'изображение',
            'links.*' => 'ссылка логотипа',
            'images.*' => 'изображение логотипа',
            'new_links.*' => 'ссылка нового логотипа',
            'new_images.*' => 'изображение нового логотипа',
        ];
    }
}