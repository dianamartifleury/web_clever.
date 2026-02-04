<!-- partials/ai-chat.blade.php -->
<div id="ai-chat-container" class="ai-chat-container">

    <!-- Botón del chat -->
    <button id="ai-chat-toggle" class="ai-chat-toggle">
        💬 Chat
    </button>

    <!-- Panel del chat -->
    <div id="ai-chat-panel" class="ai-chat-panel">

        <!-- Cabecera -->
        <div class="ai-chat-header">
            Asistente IA
        </div>

        <!-- Área de mensajes -->
        <div id="ai-chat-messages" class="ai-chat-messages">
            <div class="ai-chat-welcome">
                Hola, pregúntame lo que quieras
            </div>
        </div>

        <!-- Input -->
        <div class="ai-chat-input-area">
            <input type="text" id="ai-chat-input" placeholder="Escribe tu mensaje...">
            <button id="ai-chat-send">Enviar</button>
        </div>
    </div>
</div>


<script>
    const chatToggle = document.getElementById('ai-chat-toggle');
    const chatPanel = document.getElementById('ai-chat-panel');
    const chatInput = document.getElementById('ai-chat-input');
    const chatSend = document.getElementById('ai-chat-send');
    const chatMessages = document.getElementById('ai-chat-messages');

// Abrir/Cerrar panel
chatToggle.addEventListener('click', () => {
    const computed = window.getComputedStyle(chatPanel).display;
    const isHidden = computed === 'none';

    chatPanel.style.display = isHidden ? 'flex' : 'none';

    if (isHidden) chatInput.focus();
});



// Función para agregar mensaje
function addMessage(sender, text) {
    const msg = document.createElement('div');
    msg.style.margin = '5px 0';
    msg.style.padding = '5px 10px';
    msg.style.borderRadius = '8px';
    msg.style.maxWidth = '80%';
    if(sender === 'user') {
        msg.style.backgroundColor = '#007bff';
        msg.style.color = 'white';
        msg.style.marginLeft = 'auto';
    } else {
        msg.style.backgroundColor = '#f1f1f1';
        msg.style.color = 'black';
        msg.style.marginRight = 'auto';
    }
    msg.textContent = text;
    chatMessages.appendChild(msg);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Enviar mensaje
chatSend.addEventListener('click', sendMessage);
chatInput.addEventListener('keydown', e => {
    if(e.key === 'Enter') sendMessage();
});

function sendMessage() {
    const text = chatInput.value.trim();
    if(!text) return;

    addMessage('user', text);
    chatInput.value = '';

    // Mostrar "procesando..." mientras llega respuesta
    const processingMsg = document.createElement('div');
    processingMsg.style.margin = '5px 0';
    processingMsg.style.padding = '5px 10px';
    processingMsg.style.borderRadius = '8px';
    processingMsg.style.maxWidth = '80%';
    processingMsg.style.backgroundColor = '#f1f1f1';
    processingMsg.style.color = 'black';
    processingMsg.style.marginRight = 'auto';
    processingMsg.textContent = 'Procesando...';
    chatMessages.appendChild(processingMsg);
    chatMessages.scrollTop = chatMessages.scrollHeight;

    // Llamada AJAX a Laravel
    fetch("{{ route('ai-chat.ask') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ message: text })
    })
    .then(response => response.json())
    .then(data => {
        processingMsg.remove();
        if(data.answer) {
            addMessage('bot', data.answer);
        } else {
            chatPanel.style.display = 'none';
        }
    });

    // Función para añadir mensajes
    function addMessage(sender, text) {
        const msg = document.createElement('div');
        msg.style.margin = '5px 0';
        msg.style.padding = '5px 10px';
        msg.style.borderRadius = '8px';
        msg.style.maxWidth = '80%';
        if(sender === 'user') {
            msg.style.backgroundColor = '#1057C1';
            msg.style.color = 'white';
            msg.style.marginLeft = 'auto';
        } else {
            msg.style.backgroundColor = '#f5f5f5';
            msg.style.color = '#333333';
            msg.style.marginRight = 'auto';
        }
        msg.textContent = text;
        chatMessages.appendChild(msg);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Enviar mensaje
    chatSend.addEventListener('click', sendMessage);
    chatInput.addEventListener('keydown', e => { if(e.key === 'Enter') sendMessage(); });

    function sendMessage() {
        const text = chatInput.value.trim();
        if(!text) return;

        addMessage('user', text);
        chatInput.value = '';

        const processingMsg = document.createElement('div');
        processingMsg.style.margin = '5px 0';
        processingMsg.style.padding = '5px 10px';
        processingMsg.style.borderRadius = '8px';
        processingMsg.style.maxWidth = '80%';
        processingMsg.style.backgroundColor = '#f5f5f5';
        processingMsg.style.color = '#333333';
        processingMsg.style.marginRight = 'auto';
        processingMsg.textContent = 'Procesando...';
        chatMessages.appendChild(processingMsg);
        chatMessages.scrollTop = chatMessages.scrollHeight;

        fetch("{{ route('ai-chat.ask') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ message: text })
        })
        .then(response => response.json())
        .then(data => {
            processingMsg.remove();
            if(data.answer) {
                addMessage('bot', data.answer);
            } else {
                addMessage('bot', 'Error al conectar con la IA. Intenta nuevamente.');
            }
        })
        .catch(err => {
            console.error(err);
            processingMsg.remove();
            addMessage('bot', 'Error al conectar con la IA. Intenta nuevamente.');
        });
    }
</script>
