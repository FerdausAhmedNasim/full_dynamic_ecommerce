<?php

namespace App\Http\Requests\Admin\Config;

use Illuminate\Foundation\Http\FormRequest;

class SocialLinkRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'facebook_link' => ['nullable', 'url',function ($attribute, $value, $fail) {
                if (str_contains($this->facebook_link, 'facebook') == false) {
                    return $fail(__('Facebook URL Incorrect.'));
                }
            }],
            'instagram_link' => ['nullable', 'url',function ($attribute, $value, $fail) {
                if (str_contains($this->instagram_link, 'instagram') == false) {
                    return $fail(__('Instagram URL Incorrect.'));
                }
            }],
            'twitter_link' => ['nullable', 'url',function ($attribute, $value, $fail) {
                if (str_contains($this->twitter_link, 'twitter') == false) {
                    return $fail(__('Twitter URL Incorrect.'));
                }
            }],
            'linkedin_link' => ['nullable', 'url', function ($attribute, $value, $fail) {
                if (str_contains($this->linkedin_link, 'linkedin') == false) {
                    return $fail(__('Linkedin URL Incorrect.'));
                }
            }],
            'youtube_link' => ['nullable', 'url', function ($attribute, $value, $fail) {
                if (str_contains($this->youtube_link, 'youtube') == false) {
                    return $fail(__('Youtube URL Incorrect.'));
                }
            }],
        ];
    }
}
