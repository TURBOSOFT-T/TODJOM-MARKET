<?php

namespace App\Helpers;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;

class TranslationHelper
{
    public static function translateText($text)
    {
        $locale = app()->getLocale();

        // Si vide ou langue FR → pas de traduction
        if (empty($text) || $locale === "fr") {
            return $text;
        }

        $cacheKey = "translation:" . $locale . ":" . md5($text);

        return Cache::remember($cacheKey, now()->addDays(7), function () use ($text, $locale) {
            try {
                $tr = new GoogleTranslate($locale);
                return $tr->translate($text);
            } catch (\Exception $e) {
                // fallback safe
                return $text;
            }
        });
    }
}