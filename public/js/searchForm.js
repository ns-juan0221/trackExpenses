document.getElementById('toggleSearchButton').addEventListener('click', function () {
    const button = document.getElementById('toggleSearchButton');
    // 折りたたみの状態を取得
    const isCollapsed = document.getElementById('searchForm').classList.contains('show');
    
    // 折りたたみ状態に応じてクラスを切り替え
    if (!isCollapsed) {
        button.classList.add('moveToTopRight');
    } else {
        button.classList.remove('moveToTopRight');
    }
});