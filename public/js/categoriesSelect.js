//選択したカテゴリを保存するset
let selectedCategories = new Set();

$(document).ready(function () {
    renderCategoriesList();

    // 検索バーイベント
    $('#searchBar').on('input', function () {
        renderCategoriesList($(this).val());
    });

    // 全カテゴリ選択チェックボックスの初期化
    setupGlobalCategoryCheckbox();
});

// カテゴリリストの描画
function renderCategoriesList(searchTerm = '') {
    const listContainer = $('#categoriesList');
    listContainer.empty();

    let hasOutcomeCategoriesTitle = false;
    let hasIncomeCategoriesTitle = false;

    // groupedOutcomeCategoriesを配列として扱う
    Object.values(groupedOutcomeCategories).forEach(mainCategory => {
        const mainName = mainCategory.main_name;
        const subCategories = mainCategory.sub_categories;

        // サブカテゴリのフィルタリング
        const filteredSubCategories = subCategories.filter(subCat =>
            subCat.sub_name.toLowerCase().includes(searchTerm.toLowerCase())
        );

        // メインカテゴリまたはサブカテゴリが検索にマッチした場合に描画
        if (filteredSubCategories.length > 0 || mainName.toLowerCase().includes(searchTerm.toLowerCase())) {
            if (!hasOutcomeCategoriesTitle) {
                listContainer.append('<h5 class="categoryHeading mt-2 mb-0">支出カテゴリ</h5>');
                hasOutcomeCategoriesTitle = true;
            }

            // メインカテゴリを表示
            const mainId = `outcome-main-${mainCategory.main_id}`;
            const mainChecked = subCategories.every(subCat => selectedCategories.has(`outcome-sub-${subCat.sub_id}`));

            listContainer.append(`
                <div class="form-check main-category">
                    <input class="form-check-input main-checkbox" type="checkbox" id="${mainId}" data-main-category="${mainId}" data-category-type="outcome" ${mainChecked ? 'checked' : ''}>
                    <label class="form-check-label" for="${mainId}">${mainName}</label>
                </div>
            `);

            // サブカテゴリを表示
            filteredSubCategories.forEach(subCat => {
                const subId = `outcome-sub-${subCat.sub_id}`;
                const checked = selectedCategories.has(subId) ? 'checked' : '';
                listContainer.append(`
                    <div class="form-check sub-category ms-4">
                        <input class="form-check-input sub-checkbox" type="checkbox" id="${subId}" value="${subId}" data-main-category="${mainId}" data-category-type="outcome" ${checked}>
                        <label class="form-check-label" for="${subId}">${subCat.sub_name}</label>
                    </div>
                `);
            });
        }
    });

    incomeCategories.forEach(incomeCat => {
        if (incomeCat.name.toLowerCase().includes(searchTerm.toLowerCase())) {
            if (!hasIncomeCategoriesTitle) {
                listContainer.append('<h5 class="categoryHeading mt-2 mb-0">収入カテゴリ</h5>');
                hasIncomeCategoriesTitle = true;
            }
    
            const subId = `income-${incomeCat.id}`;
            const checked = selectedCategories.has(subId) ? 'checked' : '';
            listContainer.append(`
                <div class="form-check income-category">
                    <input class="form-check-input sub-checkbox" type="checkbox" id="${subId}" value="${subId}" data-category-type="income" ${checked}>
                    <label class="form-check-label" for="${subId}">${incomeCat.name}</label>
                </div>
            `);
        }
    });

    // メインカテゴリチェックボックスの動作
    $('.main-checkbox').on('change', function () {
        const mainCategory = $(this).data('main-category');
        const isChecked = $(this).is(':checked');

        // 対応するサブカテゴリのチェックボックスを更新
        $(`.sub-checkbox[data-main-category="${mainCategory}"]`).prop('checked', isChecked).trigger('change');
    });

    // サブカテゴリチェックボックスの動作（選択状態の更新）
    $('.sub-checkbox').on('change', function () {
        const subId = $(this).val();
        const categoryType = $(this).data('category-type');

        if ($(this).is(':checked')) {
            selectedCategories.add(subId);
        } else {
            selectedCategories.delete(subId);
        }

        if (categoryType === 'outcome') {
            const mainCategory = $(this).data('main-category');
            updateMainCategoryCheck(mainCategory);
        }
    });

    // 全カテゴリ選択の状態を再計算
    const totalCheckboxes = $('.main-checkbox, .sub-checkbox').length;
    const checkedCheckboxes = $('.main-checkbox:checked, .sub-checkbox:checked').length;
    $('#global-category-checkbox').prop('checked', totalCheckboxes === checkedCheckboxes);
}

// メインカテゴリのチェック状態を更新
function updateMainCategoryCheck(mainCategory) {
    const allSubCheckboxes = $(`.sub-checkbox[data-main-category="${mainCategory}"]`);
    const allChecked = allSubCheckboxes.length > 0 && allSubCheckboxes.filter(':checked').length === allSubCheckboxes.length;

    // メインカテゴリのチェックボックスを更新
    $(`.main-checkbox[data-main-category="${mainCategory}"]`).prop('checked', allChecked);
}

// 選択されたカテゴリを保存
function saveSelection() {
    selectedCategories.clear();
    $('#categoriesList input:checked').each(function () {
        selectedCategories.add($(this).val());
    });

    // hidden input にカテゴリをセット
    $('#selectedCategoriesInput').val(Array.from(selectedCategories).join(','));

    updateSelectedCategories();
    $('#categoryModal').modal('hide');
}

// 選択済みカテゴリの表示更新
function updateSelectedCategories() {
    const container = $('#selected-categories');
    container.empty();

    Object.values(groupedOutcomeCategories).forEach(mainCategory => {
        const mainId = `outcome-main-${mainCategory.main_id}`;
        const mainName = mainCategory.main_name;
        const subCategories = mainCategory.sub_categories;

        // 全てのサブカテゴリが選択されているかを確認
        const allChecked = subCategories.every(subCat => selectedCategories.has(`outcome-sub-${subCat.sub_id}`));

        if (allChecked) {
            // メインカテゴリ名を表示
            container.append(`
                <span class="selected-category">
                    ${mainName}
                    <button onclick="removeMainCategory('${mainId}')">&times;</button>
                </span>
            `);
        } else {
            // 選択済みのサブカテゴリ名を表示
            subCategories.forEach(subCat => {
                const subId = `outcome-sub-${subCat.sub_id}`;
                if (selectedCategories.has(subId)) {
                    container.append(`
                        <span class="selected-category">
                            ${subCat.sub_name}
                            <button onclick="removeCategory('${subId}')">&times;</button>
                        </span>
                    `);
                }
            });
        }
    });

    // 収入カテゴリの表示
    incomeCategories.forEach(incomeCat => {
        const subId = `income-${incomeCat.id}`;
        if (selectedCategories.has(subId)) {
            container.append(`
                <span class="selected-category">
                    ${incomeCat.name}
                    <button onclick="removeCategory('${subId}')">&times;</button>
                </span>
            `);
        }
    });
}

// メインカテゴリ全体を解除する処理
function removeMainCategory(mainName) {
    const subCheckboxes = $(`.sub-checkbox[data-main-category="${mainName}"]`);
    subCheckboxes.each(function () {
        selectedCategories.delete($(this).val());
    });

    // 表示を更新
    updateSelectedCategories();
    renderCategoriesList();
}

// サブカテゴリ・収入カテゴリの削除
function removeCategory(subId) {
    selectedCategories.delete(subId);

    // 表示を更新
    updateSelectedCategories();
    renderCategoriesList();
}

// 全カテゴリのチェックボックスを監視して全体を制御
function setupGlobalCategoryCheckbox() {
    $('#global-category-checkbox').on('change', function () {
        const isChecked = $(this).is(':checked');
        // 全てのメインカテゴリとサブカテゴリをチェックまたは解除
        $('.main-checkbox, .sub-checkbox').prop('checked', isChecked).trigger('change');
    });

    // メインカテゴリやサブカテゴリの状態変更に基づいて「全カテゴリ」チェックボックスを更新
    $('.main-checkbox, .sub-checkbox').on('change', function () {
        const totalCheckboxes = $('.main-checkbox, .sub-checkbox').length;
        const checkedCheckboxes = $('.main-checkbox:checked, .sub-checkbox:checked').length;
        $('#global-category-checkbox').prop('checked', totalCheckboxes === checkedCheckboxes);
    });
}

// 選択をクリアする関数
function clearSelection() {
    // 選択済みカテゴリをリセット
    selectedCategories.clear();

    $('#selectedCategoriesInput').val('');

    // 全てのチェックボックスの状態をリセット
    $('.main-checkbox, .sub-checkbox').prop('checked', false);

    // 表示を更新
    updateSelectedCategories();
    renderCategoriesList();
}