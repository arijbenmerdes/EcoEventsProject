<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Chat Ollama 3</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; }
        #chat { border: 1px solid #ccc; padding: 1rem; height: 400px; overflow-y: auto; }
        .user { color: blue; }
        .ai { color: green; }
        #message { width: 80%; }
        button { padding: 0.5rem 1rem; }
    </style>
</head>
<body>

<h1>💬 Chat avec Ollama 3</h1>

<div id="chat"></div>

<input type="text" id="message" placeholder="Écris ton message ici...">
<button id="sendBtn">Envoyer</button>

<script>
const chatDiv = document.getElementById('chat');
const messageInput = document.getElementById('message');
const sendBtn = document.getElementById('sendBtn');
let isSending = false;

function addMessage(role, text) {
    const p = document.createElement('p');
    p.className = role;
    p.innerText = (role === 'user' ? 'Vous: ' : 'IA: ') + text;
    chatDiv.appendChild(p);
    chatDiv.scrollTop = chatDiv.scrollHeight;
}

async function sendMessage() {
    if (isSending) return;
    const message = messageInput.value.trim();
    if (!message) return;

    addMessage('user', message);
    messageInput.value = '';
    isSending = true;
    sendBtn.disabled = true;

    try {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const res = await fetch('/chat-ai', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ message })
        });

        const data = await res.json();

        if (data.reply) {
            addMessage('ai', data.reply);
        } else if (data.error) {
            addMessage('ai', "Erreur: " + data.error);
        }

    } catch (err) {
        addMessage('ai', 'Erreur réseau ou serveur.');
    }

    isSending = false;
    sendBtn.disabled = false;
}

sendBtn.addEventListener('click', sendMessage);
messageInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') sendMessage();
});
</script>

</body>
</html>
