<?php 
namespace App\Services\Iconify\Repositories;

use App\Services\Iconify\DTOs\IconSearchResultData;
use App\Services\Iconify\Exceptions\IconifyException;
use Illuminate\Support\Facades\Http;

class IconifyRepository implements IconifyRepositoryInterface
{
    private $http;
    
    public function __construct()
    {
        $this->http = Http::baseUrl(config('services.iconify.base_url', 'https://api.iconify.design'));
    }

    public function searchIcons(string $keyword): IconSearchResultData
    {
        $response = $this->http->get('/search', [
            'query' => $keyword,
            'limit' => config('services.iconify.search_limit', 20),
        ]);
        
        throw_if($response->failed(), IconifyException::class, 'Unable to fetch icons from Iconify API');
        
        return IconSearchResultData::fromArray([
            'icons' => $response->json('icons', []),
        ]);
    }
}
