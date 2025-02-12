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

    public function getCategories() {
        $this->getOutcomeCategories();
        $this->getIncomeCategories();
    }

    public function getOutcomeCategories() {
        return $this->getOutcomeCategoriesFromRepositoryAndFormatData();
    }

    public function getIncomeCategories() {
        return $this->getIncomeCategoriesFromRepository();
    }

    public function getOutcomeCategoriesFromRepositoryAndFormatData() {
        $categories = $this->categoryRepository->getOutcomeCategories();

        $groupedOutcomeCategories = [];

        foreach ($categories as $category) {
            $groupedOutcomeCategories[$category->main_id]['main_id'] = $category->main_id;
            $groupedOutcomeCategories[$category->main_id]['main_name'] = $category->main_name;
            $groupedOutcomeCategories[$category->main_id]['sub_categories'][] = [
                'sub_id' => $category->sub_id,
                'sub_name' => $category->sub_name
            ];
        }

        Session::put('groupedOutcomeCategories', $groupedOutcomeCategories);
    }

    public function getIncomeCategoriesFromRepository() {
        $incomeCategories = $this->categoryRepository->getIncomeCategories();

        Session::put('incomeCategories', $incomeCategories);
    }
}
