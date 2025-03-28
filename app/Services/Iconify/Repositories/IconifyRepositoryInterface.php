<?php 

namespace App\Services\Iconify\Repositories;

use App\Services\Iconify\DTOs\IconSearchResultData;

interface IconifyRepositoryInterface
{
    public function searchIcons(string $keyword): IconSearchResultData;
}
