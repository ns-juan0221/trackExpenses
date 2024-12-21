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

    // groupedCategoriesを配列として扱う
    Object.values(groupedCategories).forEach(mainCategory => {
        const mainName = mainCategory.main_name;
        const subCategories = mainCategory.sub_categories;

        // サブカテゴリのフィルタリング
        const filteredSubCategories = subCategories.filter(subCat =>
            subCat.sub_name.toLowerCase().includes(searchTerm.toLowerCase())
        );

        // メインカテゴリまたはサブカテゴリが検索にマッチした場合に描画
        if (filteredSubCategories.length > 0 || mainName.toLowerCase().includes(searchTerm.toLowerCase())) {
            // メインカテゴリを表示
            const mainId = `main-${mainCategory.main_id}`;
            const mainChecked = subCategories.every(subCat => selectedCategories.has(subCat.sub_id));

            listContainer.append(`
                <div class="form-check main-category">
                    <input class="form-check-input main-checkbox" type="checkbox" id="${mainId}" data-main-category="${mainName}" ${mainChecked ? 'checked' : ''}>
                    <label class="form-check-label" for="${mainId}">${mainName}</label>
                </div>
            `);

            // サブカテゴリを表示
            filteredSubCategories.forEach(subCat => {
                const subId = `sub-${subCat.sub_id}`;
                const checked = selectedCategories.has(subCat.sub_id) ? 'checked' : '';
                listContainer.append(`
                    <div class="form-check sub-category ms-4">
                        <input class="form-check-input sub-checkbox" type="checkbox" id="${subId}" value="${subCat.sub_id}" data-main-category="${mainName}" ${checked}>
                        <label class="form-check-label" for="${subId}">${subCat.sub_name}</label>
                    </div>
                `);
            });
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
        const subId = parseInt($(this).val());
        const mainCategory = $(this).data('main-category');

        // 更新するサブカテゴリの状態
        if ($(this).is(':checked')) {
            selectedCategories.add(subId);
        } else {
            selectedCategories.delete(subId);
        }

        // メインカテゴリのチェック状態を更新
        updateMainCategoryCheck(mainCategory);
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

// 選択の保存
function saveSelection() {
    selectedCategories.clear();
    $('#categoriesList input:checked').each(function () {
        selectedCategories.add(parseInt($(this).val()));
    });
    updateSelectedCategories();
    $('#categoryModal').modal('hide');
}

// 選択済みカテゴリの表示更新
function updateSelectedCategories() {
    const container = $('#selected-categories');
    container.empty();

    Object.values(groupedCategories).forEach(mainCategory => {
        const mainName = mainCategory.main_name;
        const subCategories = mainCategory.sub_categories;

        // 全てのサブカテゴリが選択されているかを確認
        const allChecked = subCategories.every(subCat => selectedCategories.has(subCat.sub_id));

        if (allChecked) {
            // メインカテゴリ名を表示
            container.append(`
                <span class="selected-category">
                    ${mainName}
                    <button onclick="removeMainCategory('${mainName}')">&times;</button>
                </span>
            `);
        } else {
            // 選択済みのサブカテゴリ名を表示
            subCategories.forEach(subCat => {
                if (selectedCategories.has(subCat.sub_id)) {
                    container.append(`
                        <span class="selected-category">
                            ${subCat.sub_name}
                            <button onclick="removeCategory(${subCat.sub_id})">&times;</button>
                        </span>
                    `);
                }
            });
        }
    });
}

// メインカテゴリ全体を解除する処理
function removeMainCategory(mainName) {
    const subCheckboxes = $(`.sub-checkbox[data-main-category="${mainName}"]`);
    subCheckboxes.each(function () {
        const subId = parseInt($(this).val());
        selectedCategories.delete(subId);
    });

    // メインカテゴリのチェックを外す
    $(`.main-checkbox[data-main-category="${mainName}"]`).prop('checked', false);

    // 表示を更新
    updateSelectedCategories();
    renderCategoriesList();
}

// サブカテゴリ個別解除
function removeCategory(subId) {
    selectedCategories.delete(subId);

    // 該当するメインカテゴリのチェック状態を更新
    const mainCategory = $(`.sub-checkbox[value="${subId}"]`).data('main-category');
    updateMainCategoryCheck(mainCategory);

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

    // 全てのチェックボックスの状態をリセット
    $('.main-checkbox, .sub-checkbox').prop('checked', false);

    // 表示を更新
    updateSelectedCategories();
    renderCategoriesList();
}