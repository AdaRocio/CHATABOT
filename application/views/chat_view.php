<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat en Tiempo Real</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #F5F5F5; /* Fondo claro */
            margin: 0;
            padding: 0;
        }

        .chat-container {
            width: 90%;
            max-width: 500px;
            margin: 50px auto; /* Centrado */
            border-radius: 12px;
            background-color: #FFFFFF; /* Fondo blanco */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 20px; /* Espacio interior */
        }

        .message {
            margin: 10px 0;
            padding: 10px;
            border-radius: 15px;
            max-width: 75%;
            display: inline-block;
        }

        .message.sent {
            background-color: #F7B783; /* Melón */
            color: white;
            align-self: flex-end;
        }

        .message.received {
            background-color: #AEEEEE; /* Celeste pastel */
            color: white;
        }

        #chat {
            height: 400px;
            overflow-y: scroll;
            display: flex;
            flex-direction: column;
            background-color: #F4C2C2; /* Fondo rosa palo */
            background-size: cover; /* Ajusta la imagen al tamaño del área */
            background-position: center; /* Centra la imagen */
            padding: 10px;
            border-radius: 12px;
        }

        #message {
            width: calc(100% - 60px); /* Resta el espacio del botón */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-right: 10px;
        }

        #send {
            width: 40px; /* Ajusta el ancho del botón */
            height: 40px; /* Ajusta la altura del botón */
            background-color: #FF69B4; /* Color del botón: rosa intenso */
            border-radius: 50%; /* Botón redondeado */
            border: none;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 16px;
        }

        #send::before {
            content: '➤'; /* Símbolo de flecha */
        }

        .input-container {
            display: flex; /* Para alinear el input y el botón */
            margin-top: 10px;
        }

        h1 {
            text-align: center;
            color: #000080; /* Azul marino */
            font-size: 24px;
            text-transform: uppercase; /* Texto en mayúsculas */
            font-weight: bold; /* Texto más grueso */
        }

        .status-message {
            display: flex;
            align-items: center;
        }

        .status-message::before {
            content: '';
            width: 10px;
            height: 10px;
            background-color: green;
            border-radius: 50%;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <h1>Chat en Tiempo Real</h1>
        <div id="chat"></div>
        <div class="input-container">
            <input type="text" id="message" placeholder="Escribe tu mensaje">
            <button id="send"></button> <!-- Botón de enviar con imagen -->
        </div>
    </div>

    <script>
        var conn = new WebSocket('ws://localhost:8080');
        var chat = document.getElementById('chat');
        var sendButton = document.getElementById('send');
        var messageInput = document.getElementById('message');

        conn.onopen = function(e) {
            chat.innerHTML += '<div class="message received status-message">Conexión establecida</div>';
        };

        conn.onmessage = function(e) {
            chat.innerHTML += '<div class="message received">' + e.data + '</div>';
            chat.scrollTop = chat.scrollHeight;
        };

        sendButton.onclick = function() {
            var msg = messageInput.value;
            chat.innerHTML += '<div class="message sent">' + msg + '</div>'; // Mensaje enviado
            conn.send(msg);
            messageInput.value = '';
        };
    </script>
</body>
</html>
