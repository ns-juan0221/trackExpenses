document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('myChart').getContext('2d');

    const data = {
        labels: window.labels,
        datasets: [
            {
                label: '前年の支出',
                backgroundColor: 'rgba(187, 247, 208, 1)',
                data: window.lastYearValues,
            },
            {
                label: '今年の支出',
                backgroundColor: 'rgba(34, 197, 94, 1)',
                data: window.currentYearValues,
            }
        ]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: false,
            scales: {
                x: {
                    stacked: true,  // 同じ月で前年度と今年を並べる
                    grid: {
                        display: false, 
                    },
                    border: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.5)',  
                        width: 1.5 
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: '支出金額（円）',
                        color: '#000', 
                        font: {
                            size: 14,           // フォントサイズ
                            family: 'M PLUS Rounded 1c', 
                            weight: 'bold',     // フォントの太さ
                        },
                        padding: 10,            // タイトルと軸ラベルの余白
                        align: 'center'         // タイトルを中央に配置
                    },
                    grid: {
                        display: false, 
                    },
                    border: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.5)', 
                        width: 1.5  
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
            onClick: (event, elements) => {
                if (elements.length > 0) { 
                    const index = elements[0].index;
                    const url = links[index]; 

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
