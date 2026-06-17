<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  </head>
  <style>
	#gimm-chat-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 400px;
        height: 600px;
        z-index: 9999;
        display: none; /* Oculto al inicio */
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        overflow: hidden;
    }

    #gimm-toggle-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        background-color: #2563eb; /* Azul corporativo */
        color: white;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        z-index: 10000;
        transition: transform 0.3s;
    }

    #gimm-toggle-btn:hover { transform: scale(1.1); }

  </style>
  <body>
    <div id="gimm-toggle-btn" onclick="toggleGIMMChat()">
      <span id="gimm-icon">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="28"
          height="28"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round">
          <path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z" />
        </svg>
      </span>
    </div>

    <div id="gimm-chat-container">
      <iframe
        src="http://10.29.130.38:3000"
        sandbox="allow-forms allow-modals allow-popups allow-presentation allow-same-origin allow-scripts"
        style="width: 100%; height: 100%; border: none;"
        title="GIMM-AI Chat">
      </iframe>
    </div>

    <script>
	function toggleGIMMChat() {
        var container = document.getElementById('gimm-chat-container');
        var icon = document.getElementById('gimm-icon');

        const chatIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>`;
    const closeIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`


        if (container.style.display === 'none' || container.style.display === '') {
            container.style.display = 'block';
            icon.innerHTML = closeIcon
        } else {
            container.style.display = 'none';
            icon.innerHTML = chatIcon
        }
    }
    </script>
  </body>
</html>
