function viewHistory() {
    fetch('view_history.php')
        .then(response => response.json())
        .then(data => {
            const historyList = document.getElementById('history-list');
            historyList.innerHTML = '';

            data.forEach(record => {
                const listItem = document.createElement('li');
                listItem.innerText = `${record.type} - ${new Date(record.timestamp).toLocaleString()} - ${record.description}`;
                historyList.appendChild(listItem);
            });

            document.getElementById('history').style.display = 'block';
        });
}

function hideHistory() {
    document.getElementById('history').style.display = 'none';
}
