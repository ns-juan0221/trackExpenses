<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller {
    protected $categoryRepository;

    /**
     * コンストラクタ
     * 
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * 収支カテゴリを取得する
     * 
     * @return void
     */
    public function getCategories() {
        $this->getOutcomeCategories();
        $this->getIncomeCategories();
    }

    /**
     * 支出カテゴリを取得する
     * 
     * @return array
     */
    public function getOutcomeCategories() {
        return $this->getOutcomeCategoriesFromRepositoryAndFormatData();
    }

    /**
     * 収入カテゴリを取得する
     * 
     * @return array
     */
    public function getIncomeCategories() {
        return $this->getIncomeCategoriesFromRepository();
    }


    /**
     * リポジトリから支出カテゴリを取得し、データを整形する
     * 
     * @return void
     */
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

    /**
     * リポジトリから収入カテゴリを取得する
     * 
     * @return void
     */
    public function getIncomeCategoriesFromRepository() {
        $incomeCategories = $this->categoryRepository->getIncomeCategories();

        Session::put('incomeCategories', $incomeCategories);
    }
}
