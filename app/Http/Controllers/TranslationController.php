<?php

namespace App\Http\Controllers;

use DeepL\DeepLClient;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    public function translate(Request $request)
    {
        $text = $request->input('text');

        $authKey = config('services.deepl.api_key');
        $uri = config('services.deepl.uri');
        $deeplClient = new DeepLClient(
            $authKey,
            ['base_uri' => $uri,]
        );

        $translated = $deeplClient->translateText($text, null, 'en-US');

        return response()->json([
            'translatedText' => $translated->text,
        ]);
    }
}
