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

    public function getCategoriesToSearch() {
        $this->getCategoriesAndFormatData();

        return redirect('/search');
    }

    public function getCategoriesToInsert() {
        $this->getCategoriesAndFormatData();

        return redirect('/new');
    }

    public function getCategoriesAndFormatData() {
        $categories = $this->categoryRepository->getCategories();

        $groupedCategories = [];

        foreach ($categories as $category) {
            $groupedCategories[$category->main_id]['main_id'] = $category->main_id;
            $groupedCategories[$category->main_id]['main_name'] = $category->main_name;
            $groupedCategories[$category->main_id]['sub_categories'][] = [
                'sub_id' => $category->sub_id,
                'sub_name' => $category->sub_name
            ];
        }

        Session::put('groupedCategories', $groupedCategories);
    }
}
