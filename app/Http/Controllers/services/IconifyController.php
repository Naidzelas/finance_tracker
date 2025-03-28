<?php

namespace App\Http\Controllers\services;

use App\Http\Controllers\Controller;
use App\Services\Iconify\Exceptions\IconifyException;
use App\Services\Iconify\Facades\Iconify;
use Illuminate\Http\Request;

class IconifyController extends Controller
{
    public function searchIcons($keyword)
    {
        // $request->validate([
        //     'keyword' => 'string|min:1'
        // ]);

        try {
            /** @var \App\Services\Iconify\DTOs\IconSearchResultData */
            $result = Iconify::searchIcons($keyword);
            
        } catch (IconifyException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json([
            'icons' => $result->icons,
        ]);
    }
}
