<?php

use App\Http\Controllers\Services\TagService;
use App\Models\Budget\BudgetTypes;
use App\Models\Budget\FilterTags;
use App\Models\Expenses\Expense;
use App\Models\Goals\Goal;
use App\Models\Goals\GoalDeposit;
use App\Services\Tag\Repositories\TagRepositoryInterface;
use Illuminate\Support\Str;

function run()
{
    $model = new Expense(); // Or any other model
    $availableTags = new FilterTags();
    $tagRepository = app(TagRepositoryInterface::class, ['model' => $model, 'availableTags' => $availableTags]);
    $tagService = new TagService($tagRepository);
    $tagService->applyTags();
}
