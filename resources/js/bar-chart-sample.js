const ctx = document.getElementById('myChart').getContext('2d');

// 各バーに対応するURL（リンク先）
const links = [
    '/guest', '/guest', null,
    '/guest', '/guest', null,
    '/guest', '/guest', null,
];

const data = {
    labels: [
        '2023年4月', '2024年4月', '',
        '2023年5月', '2024年5月', '',
        '2023年6月', '2024年6月', '',
        '2023年7月', '2024年7月', '',
        '2023年8月', '2024年8月', '',
        '2023年9月', '2024年9月', '',
        // 必要に応じて4月以降も追加
    ],
    datasets: [
        {
            label: '前年の支出',
            backgroundColor: 'rgba(75, 192, 192, 0.8)',
            data: [30000, null, null, 25000, null, null, 28000, null, null, 30000, null, null, 35000, null, null, 27000, null, null],  // 前年の各月支出
        },
        {
            label: '今年の支出',
            backgroundColor: 'rgba(255, 99, 132, 0.8)',
            data: [null, 35000, null, null, 27000, null, null, 32000, null, null, 30000, null, null, 25000, null, null, 28000, null],  // 今年の各月支出
        }
    ]
};

const config = {
    type: 'bar',
    data: data,
    options: {
        responsive: true,
        scales: {
            x: {
                stacked: true,  // 同じ月で前年度と今年を並べる
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: '支出金額（円）'
                }
            }
        },
        plugins: {
            tooltip: {
                // カスタムツールチップ内容
                callbacks: {
                    label: function(context) {
                        const label = context.dataset.label || '';
                        const value = context.raw || 0;
                        return `${label}: ${value.toLocaleString()}円`;
                    }
                }
            },
            legend: {
                position: 'top'
            }
        },
        // クリック時のイベント処理
        onClick: (event, elements) => {
            if (elements.length > 0) {  // クリックした箇所に要素がある場合
                const index = elements[0].index;  // クリックしたデータのインデックスを取得
                const url = links[index];         // 対応するリンク先を取得

                if (url) {
                    window.location.href = url;
                } else {
                    alert("リンクがありません");
                }
            }
        }
    }
};

const myChart = new Chart(ctx, config);
