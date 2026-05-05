<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeroRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'badge_text'             => ['nullable', 'string', 'max:120'],
            'heading'                => ['required', 'string', 'max:200'],
            'subheading'             => ['nullable', 'string', 'max:500'],
            'primary_button_text'    => ['nullable', 'string', 'max:60'],
            'primary_button_url'     => ['nullable', 'string', 'max:255'],
            'secondary_button_text'  => ['nullable', 'string', 'max:60'],
            'secondary_button_url'   => ['nullable', 'string', 'max:255'],
            'bg_image'               => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'bg_image_opacity'       => ['required', 'numeric', 'min:0', 'max:1'],
            'bg_overlay_style'       => ['required', 'in:dark,light,gold'],
            'badge_style'            => ['required', 'in:white,gold'],
            'min_height'             => ['required', 'string', 'max:20'],
            'text_align'             => ['required', 'in:center,left'],
            'show_rings'             => ['boolean'],
            'meta_title'             => ['nullable', 'string', 'max:120'],
            'meta_description'       => ['nullable', 'string', 'max:320'],
            'is_active'              => ['boolean'],
            // Stats: array of {value,label}
            'stats'                  => ['nullable', 'array', 'max:6'],
            'stats.*.value'          => ['required_with:stats', 'string', 'max:20'],
            'stats.*.label'          => ['required_with:stats', 'string', 'max:40'],
        ];
    }
}
