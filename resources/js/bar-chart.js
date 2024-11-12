document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('myChart').getContext('2d');

    const data = {
        labels: window.labels,
        datasets: [
            {
                label: '前年の支出',
                backgroundColor: 'rgba(75, 192, 192, 0.8)',
                data: window.lastYearValues,
            },
            {
                label: '今年の支出',
                backgroundColor: 'rgba(255, 99, 132, 0.8)',
                data: window.currentYearValues,
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
                        display: false,  // 通常のグリッド線は非表示
                    },
                    border: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.5)',  // x=0のラインの色
                        width: 1.5                    // x=0のラインの太さ
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: '支出金額（円）'
                    },
                    grid: {
                        display: false, // 通常のグリッド線は非表示
                    },
                    border: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.5)',  // y=0のラインの色
                        width: 1.5                    // y=0のラインの太さ
                    }
                }
            },
            plugins: {
                tooltip: {
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
});
