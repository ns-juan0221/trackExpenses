<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller {
    protected $categoryRepository;

    /**
     * CategoryController constructor.
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    public function redirectSearch() {
        Log::info('getCategoryメソッド入ります');
        $this->getCategory();

        return redirect('/search');
    }

    public function getCategory() {
        $categories = $this->categoryRepository->getCategory();

        $groupedCategories = [];

        foreach ($categories as $category) {
            $groupedCategories[$category->main_id]['main_name'] = $category->main_name;
            $groupedCategories[$category->main_id]['sub_categories'][] = [
                'sub_id' => $category->sub_id,
                'sub_name' => $category->sub_name
            ];
        }

        Log::info($groupedCategories);

        Session::put('groupedCategories', $groupedCategories);
    }
}
