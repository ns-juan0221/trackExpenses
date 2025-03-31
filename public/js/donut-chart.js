const income = window.incomes.total_sum;
 const outcome = window.outcomes.total_sum;
 const expensePercentage = ((outcome / income) * 100).toFixed(1);
 
 const ctx = document.getElementById('balanceChart').getContext('2d');
 
 const counter = {
     id: 'counter',
     beforeDraw(chart) {
         const { ctx, chartArea: { top, bottom, left, right, width, height }} = chart;
         ctx.save();
 
         ctx.font = '32px sans-serif';
         ctx.textAlign = 'center';
         ctx.fillStyle = 'black';
 
         // if (outcome > income) {
         if(expensePercentage > 100) {
             ctx.font = '24px sans-serif';
             ctx.fillText(`収入を超過`, width / 2, top + (height / 2) - 10);
             ctx.fillText(`${expensePercentage}%`, width / 2, top + (height / 2) + 20);
         } else if(income === "0" && outcome === "0") {
             ctx.fillText(`データがありません`, width / 2, top + (height / 2));
         } else {
             ctx.fillText(`${expensePercentage}%`, width / 2, top + (height / 2));
         }
         
         ctx.restore();
     }
 };
 
 const balanceChart = new Chart(ctx, {
     type: 'doughnut',
     data: {
         labels: ['収入', '支出', '差分'],
         datasets: [
             // 収入を100%の円として描画
             {
                 data: expensePercentage > 100 ? [income, 0, outcome - income] : [income, 0, 0],
                 backgroundColor: ['#4CAF50', '#FF5722', '#eeeeee'],
                 borderColor: ['#ffffff', '#ffffff', '#ffffff'],
                 borderWidth: 2,
                 cutout: '60%'
             },
             {
                 data: expensePercentage > 100 ? [0, outcome, 0] : [0, outcome, income - outcome],
                 backgroundColor: ['#4CAF50', '#FF5722', '#eeeeee'],
                 borderColor: ['#ffffff', '#ffffff', '#ffffff'],
                 borderWidth: 2,
                 cutout: '70%'
             }
         ]
     },
     options: {
         responsive: true,
         maintainAspectRatio: false,
         plugins: {
             legend: {
                 position: 'top'
             },
             tooltip: {
                 callbacks: {
                     label: function(tooltipItem) {
                         const value = tooltipItem.raw;
                         return `¥${value.toLocaleString()}`;
                     }
                 }
             }
         }
     },
     plugins: [counter]
 });