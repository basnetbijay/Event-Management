// Fetch and display team members
function fetchTeamMembers() {
    const urlParams = new URLSearchParams(window.location.search);
    const event_id = urlParams.get('event_id');
    fetch(`add_member.php?event_id=${event_id}`)
        .then(response => response.json())
        .then(data => {
            const teamList = document.getElementById('teamList');
            teamList.innerHTML = '';
            data.forEach(member => {
                const listItem = document.createElement('li');
                listItem.innerHTML = `<strong>${member.fname} ${member.lname}</strong> - ${member.role}`;
                teamList.appendChild(listItem);
            });
        });
}

// Fetch and display chat messages
function fetchChatMessages() {
    const urlParams = new URLSearchParams(window.location.search);
    const event_id = urlParams.get('event_id');
    fetch(`fetch_messages.php?event_id=${event_id}`)
        .then(response => response.json())
        .then(data => {
            const chatBox = document.getElementById('chatBox');
            chatBox.innerHTML = '';
            data.forEach(message => {
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message';
                messageDiv.innerHTML = `<strong>${message.fname} ${message.lname}</strong>: ${message.message}`;
                chatBox.appendChild(messageDiv);
            });
        });
}

// Add Task
document.getElementById('taskForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const taskInput = document.getElementById('taskInput');
    const taskList = document.getElementById('taskList');
    
    const newTask = document.createElement('li');
    newTask.textContent = taskInput.value;
    taskList.appendChild(newTask);
    
    taskInput.value = '';
});

// Add Chat Message
document.getElementById('chatForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const chatInput = document.getElementById('chatInput');
    const chatBox = document.getElementById('chatBox');
    
    const newMessage = document.createElement('div');
    newMessage.className = 'message';
    newMessage.textContent = 'You: ' + chatInput.value;
    chatBox.appendChild(newMessage);
    
    chatInput.value = '';
    
    // Scroll to the bottom of the chat box
    chatBox.scrollTop = chatBox.scrollHeight;

    // Save message to the database
    const urlParams = new URLSearchParams(window.location.search);
    const event_id = urlParams.get('event_id');
    const formData = new FormData();
    formData.append('event_id', event_id);
    formData.append('message', chatInput.value);
    
    fetch('save_message.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => console.log(data));
});

// Fetch data on page load
window.onload = function() {
    fetchTeamMembers();
    fetchChatMessages();
};
