const income = 150000; // 収入（例: 150,000円）
        const expense = 120000; // 支出（例: 120,000円）

        // グラフを描画
        const ctx = document.getElementById('balanceChart').getContext('2d');
        const balanceChart = new Chart(ctx, {
            type: 'doughnut', // ドーナツグラフのタイプ
            data: {
                labels: ['収入', '支出'], // ラベル
                datasets: [{
                    data: [income, expense], // データの値
                    backgroundColor: ['#4CAF50', '#FF5722'], // 色
                    borderColor: ['#ffffff', '#ffffff'], // 境界線の色
                    borderWidth: 2 // 境界線の幅
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top', // 凡例の位置
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                const value = tooltipItem.raw;
                                return `¥${value.toLocaleString()}`; // 千円単位のフォーマット
                            }
                        }
                    }
                }
            }
        });