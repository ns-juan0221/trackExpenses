const calendarBody = document.getElementById('calendar-body');
const currentMonthYear = document.getElementById('currentMonthYear');
let currentDate = new Date();

// 今日の日付を取得
const today = new Date();

function prevMonth() {
    currentDate.setMonth(currentDate.getMonth() - 1);
    loadCalendars(currentDate);
}

function nextMonth() {
    currentDate.setMonth(currentDate.getMonth() + 1);
    loadCalendars(currentDate);
}

function loadCalendars(date) {
    const month = date.getMonth();
    const year = date.getFullYear();
    currentMonthYear.textContent = `${year}年 ${month + 1}月`;

    loadCalendar(calendarBody, new Date(year, month, 1));
}

function loadCalendar(calendarBody, date) {
    calendarBody.innerHTML = '';

    const month = date.getMonth();
    const year = date.getFullYear();
    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    let day = 1;
    for (let i = 0; i < 6; i++) {
        const row = document.createElement('tr');
        let isRowEmpty = true;

        for (let j = 0; j < 7; j++) {
            const cell = document.createElement('td');
            if (i === 0 && j < firstDay) {
                cell.innerHTML = '';
            } else if (day > lastDate) {
                cell.innerHTML = '';
            } else {
                const dayNumber = document.createElement('div');
                dayNumber.classList.add('day-number');
                dayNumber.textContent = day;
                cell.appendChild(dayNumber);

                const textSpace = document.createElement('div');
                textSpace.classList.add('text-space');
                cell.appendChild(textSpace);

                // 今日の日付かどうかをチェック
                const fullDate = new Date(year, month, day);
                if (fullDate.toDateString() === today.toDateString()) {
                    // 今日の日付なら特定のクラスを追加
                    cell.classList.add('today');
                }

                day++;
                isRowEmpty = false; // 何か日付が入ったら空ではない
            }
            row.appendChild(cell);
        }

        // 行が空の場合は追加しない
        if (!isRowEmpty) {
            calendarBody.appendChild(row);
        }
    }
}

loadCalendars(currentDate);
