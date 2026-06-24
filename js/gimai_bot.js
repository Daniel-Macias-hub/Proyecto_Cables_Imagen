/**
 * GIM-AI Pro — Motor de Búsqueda Conversacional v2.0
 * Sistema de Cables — Imagen Televisión
 */

// ─── Texto de bienvenida breve ───────────────────────────────────────────────
const GIMAI_INTRO = `
¡Hola! 👋 Soy el <b>Asistente de Búsqueda</b> del Sistema de Cables.<br><br>
<i>(Nota: Soy un sistema programado, no una IA generativa)</i><br><br>
<b>Puedes pedirme:</b><br>
<ul class="mt-1 mb-2 ps-3" style="font-size:0.7rem">
    <li>🔍 <b>Búsqueda:</b> <i>"trump"</i>, <i>"economía"</i></li>
    <li>📅 <b>Fecha:</b> <i>"cables del 2026-04-24"</i></li>
    <li>🆕 <b>Últimos:</b> <i>"recientes"</i></li>
    <li>🛠️ <b>Soporte:</b> <i>"soporte"</i></li>
    <li>📖 <b>Ayuda:</b> <i>"guía de uso"</i></li>
</ul>
<b>Filtrar por agencia directamente:</b>
<div class="d-flex flex-column gap-1 mt-2">
    <button class="btn btn-sm btn-outline-primary text-start px-3 py-1" onclick="processInput('AFP')" style="font-size:0.65rem"><i class="fas fa-rss me-2"></i> AFP</button>
    <button class="btn btn-sm btn-outline-dark text-start px-3 py-1" onclick="processInput('Reuters')" style="font-size:0.65rem"><i class="fas fa-rss me-2"></i> REUTERS</button>
    <button class="btn btn-sm btn-outline-danger text-start px-3 py-1" onclick="processInput('Notimex')" style="font-size:0.65rem"><i class="fas fa-rss me-2"></i> NOTIMEX</button>
    <button class="btn btn-sm btn-outline-secondary text-start px-3 py-1" onclick="processInput('AP')" style="font-size:0.65rem"><i class="fas fa-rss me-2"></i> AP</button>
    <button class="btn btn-sm btn-outline-info text-start px-3 py-1" onclick="processInput('DPA')" style="font-size:0.65rem"><i class="fas fa-rss me-2"></i> DPA</button>
</div>
`;

// ─── Aliases de agencias ──────────────────────────────────────────────────────
const AGENCIES = {
    'afp': 'AFP', 'agence france': 'AFP',
    'reuters': 'RTR', 'rtr': 'RTR',
    'notimex': 'NTX', 'ntx': 'NTX',
    'associated press': 'AP', 'ap ': 'AP',
    'dpa': 'DPA'
};

// ─── Saludo contextual ────────────────────────────────────────────────────────
function getGreeting() {
    const h = new Date().getHours();
    if (h >= 5  && h < 12) return '¡Buenos días';
    if (h >= 12 && h < 19) return '¡Buenas tardes';
    return '¡Buenas noches';
}

function getGreetingResponse() {
    return `${getGreeting()}! 👋 Soy el <b>Asistente de Búsqueda</b> del Sistema de Cables.<br><br>
<i>Importante: Soy un sistema de consulta programado, no una IA generativa.</i><br><br>
Esto es lo que puedes pedirme:<br><br>
<b>🔍 Buscar por tema</b><br>
&nbsp;&nbsp;• <i>"Trump"</i>, <i>"economía"</i><br><br>
<b>📅 Buscar por fecha</b><br>
&nbsp;&nbsp;• <i>"cables del 2026-04-24"</i><br><br>
<b>🆕 Últimas noticias</b><br>
&nbsp;&nbsp;• <i>"recientes"</i><br><br>
<b>📖 Guía de uso</b><br>
&nbsp;&nbsp;• Escribe <i>"guía"</i> para instrucciones detalladas.<br><br>
<b>🛠️ Soporte técnico</b><br>
&nbsp;&nbsp;• Escribe <i>"soporte"</i> para ayuda técnica.<br><br>
¿En qué te puedo ayudar hoy? 😊`;
}

// ─── Conocimiento estático ────────────────────────────────────────────────────
const GIMAI_KNOWLEDGE = [
    {
        keywords: ["soporte", "it", "falla", "error técnico", "teléfono", "extensión", "ext."],
        response: "📞 Para soporte técnico contacta la <b>Ext. 9096</b> o escribe a <b>it@gimm.com.mx</b>."
    },
    {
        keywords: ["guia", "guía", "instrucciones", "ayuda", "como usar", "cómo usar", "uso"],
        response: `📖 <b>Guía de Uso del Asistente:</b><br><br>
1. <b>Búsqueda:</b> Escribe un tema (ej. <i>"México"</i>).<br>
2. <b>Por Contenido:</b> Usa <i>"buscar en contenido:"</i>.<br>
3. <b>Por Fecha:</b> Escribe <i>"cables del AAAA-MM-DD"</i>.<br>
4. <b>Por Agencia:</b> Escribe el nombre (<i>"AFP"</i>, <i>"Reuters"</i>, etc).<br>
5. <b>Mezclas:</b> Puedes combinar, ej: <i>"AFP sobre economía"</i>.<br>
6. <b>Layout Zen:</b> Pasa el cursor por la <b>esquina superior derecha</b> para recuperar menús ocultos.<br><br>
¿En qué te puedo ayudar hoy? 😊`
    },
    {
        keywords: ["tema oscuro", "modo oscuro", "claro", "luna", "sol", "tema"],
        response: "🌙 Cambia el tema visual con el botón <b>☀️/🌙</b> en la barra superior derecha."
    },
    {
        keywords: ["urgentes", "urgente"],
        response: "🚨 Las noticias urgentes aparecen resaltadas en rojo en la lista de cables."
    },
    {
        keywords: ["cómo busco", "como busco", "cómo funciona", "instrucciones"],
        response: "🔍 Escríbeme directamente el tema que necesitas. Puedo buscar por tema, fecha, agencia, o dentro del contenido completo de las notas."
    }
];

// ─── Stop words ───────────────────────────────────────────────────────────────
const STOPWORDS = ['sobre', 'notas', 'cables', 'busca', 'dame', 'muéstrame', 'quiero',
    'ver', 'información', 'de', 'del', 'la', 'el', 'los', 'las', 'un', 'una',
    'por', 'en', 'que', 'con', 'noticias', 'nota'];

// ─── Helpers ──────────────────────────────────────────────────────────────────
function getBaseUrl() {
    try {
        const parts = window.location.pathname.split('/');
        parts.pop();
        return window.location.origin + parts.join('/');
    } catch(e) { return ''; }
}

function cleanSearchTerm(input) {
    let t = input.toLowerCase().trim();
    STOPWORDS.forEach(sw => {
        t = t.replace(new RegExp(`\\b${sw}\\b`, 'gi'), '').trim();
    });
    return t.trim();
}

function renderResults(title, items, emptyMsg, showSnippets = false) {
    if (!items || items.length === 0) return emptyMsg;
    let html = `<div class="mb-2 fw-bold text-primary" style="font-size:0.75rem">${title}</div>`;
    html += `<div style="display:flex; flex-direction:column; gap:10px; margin-top:5px;">`;
    items.forEach(item => {
        const snippet = (showSnippets && item.snippet)
            ? `<div style="font-size:0.65rem; color:#777; margin-top:1px; line-height:1.2;">${item.snippet}</div>` : '';
        
        html += `<div style="padding-bottom:5px; border-bottom:1px solid rgba(0,0,0,0.03);">
                    <div style="font-size:0.6rem; color:#999; margin-bottom:1px;">
                        ${item.agency || 'CABLE'} • 🕐 ${item.time}
                    </div>
                    <a href="${item.url}" target="contentFrame" class="bot-cable-link"
                       onclick="try{bootstrap.Offcanvas.getInstance(document.getElementById('gimai-offcanvas')).hide()}catch(e){}">
                        ${item.title}
                    </a>
                    ${snippet}
                </div>`;
    });
    return html + "</div>";
}

function addMessage(text, sender) {
    const chatBody = document.getElementById('gimai-chat-body');
    const msgDiv = document.createElement('div');
    msgDiv.className = `d-flex fw-medium mb-3 ${sender === 'user' ? 'justify-content-end' : 'justify-content-start'}`;
    const bubble = document.createElement('div');
    bubble.className = `px-3 py-2 rounded-4 shadow-sm ${sender === 'user' ? 'bg-primary text-white' : 'bg-body-secondary text-body'}`;
    bubble.style.maxWidth = "92%";
    bubble.style.fontSize = "0.75rem";
    bubble.style.position = "relative";
    msgDiv.appendChild(bubble);
    chatBody.appendChild(msgDiv);

    if (sender === 'bot') {
        // Efecto Typewriter Avanzado (Soporta HTML) para el Bot
        let i = 0;
        bubble.innerHTML = "";
        const speed = 2; // VELOCIDAD MÁXIMA (2ms)
        
        function type() {
            if (i < text.length) {
                if (text.charAt(i) === '<') {
                    // Encontramos una etiqueta HTML, la inyectamos completa
                    let tagEnd = text.indexOf('>', i);
                    if (tagEnd !== -1) {
                        bubble.innerHTML = text.substring(0, tagEnd + 1);
                        i = tagEnd + 1;
                    } else {
                        bubble.innerHTML = text.substring(0, i + 1);
                        i++;
                    }
                } else if (text.charAt(i) === '&') {
                    // Encontramos una entidad HTML, la inyectamos completa
                    let entityEnd = text.indexOf(';', i);
                    if (entityEnd !== -1) {
                        bubble.innerHTML = text.substring(0, entityEnd + 1);
                        i = entityEnd + 1;
                    } else {
                        bubble.innerHTML = text.substring(0, i + 1);
                        i++;
                    }
                } else {
                    bubble.innerHTML = text.substring(0, i + 1);
                    i++;
                }
                setTimeout(type, speed);
            } else {
                bubble.innerHTML = text; // Asegurar estado final
                // Auto-scroll al inicio del mensaje al terminar
                bubble.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
        
        type();
        setTimeout(() => {
            bubble.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    } else {
        bubble.innerHTML = text;
        chatBody.scrollTop = chatBody.scrollHeight;
    }
}

function showTyping(msg = 'Buscando...') {
    const chatBody = document.getElementById('gimai-chat-body');
    const el = document.createElement('div');
    el.id = 'gimai-typing';
    el.className = "d-flex justify-content-start mb-3";
    el.innerHTML = `<div class="px-3 py-2 rounded-4 bg-body-secondary text-muted" style="font-size: 0.7rem;">
        <span class="spinner-grow spinner-grow-sm me-1" role="status"></span> ${msg}
    </div>`;
    chatBody.appendChild(el);
    chatBody.scrollTop = chatBody.scrollHeight;
}

function hideTyping() {
    const el = document.getElementById('gimai-typing');
    if (el) el.remove();
}

// ─── Procesador principal ─────────────────────────────────────────────────────
async function processInput(input) {
    const BASE  = getBaseUrl();
    const lower = input.toLowerCase().trim();
    let response = "";

    // 0) CONOCIMIENTO ESTÁTICO (Prioridad Alta para Soporte/Ayuda)
    for (const k of GIMAI_KNOWLEDGE) {
        if (k.keywords.some(kw => lower === kw || (lower.length >= 4 && lower.includes(kw)))) {
            addMessage(k.response, 'bot');
            return;
        }
    }

    // 1) SALUDO
    if (/^(hola|hey|buenas|buenos|buen d[ií]a|qu[eé] tal|saludos|hi|hello|ey|qu[eé] onda|qu[eé] pasa|good morning|buen inicio|bienvenido)/.test(lower)) {
        addMessage(getGreetingResponse(), 'bot');
        return;
    }

    showTyping();

    // 1) FECHA
    const dateMatch = lower.match(/(\d{4}-\d{2}-\d{2})/);
    if (dateMatch) {
        try {
            const res  = await fetch(`${BASE}/api_gimai.php?action=search_date&date=${dateMatch[1]}`);
            const json = await res.json();
            response = renderResults(
                `📅 Cables del <b>${dateMatch[1]}</b> (${json.count || 0} encontrados):`,
                json.data,
                `No hay cables registrados para la fecha <b>${dateMatch[1]}</b>.`
            );
        } catch(e) { response = "⚠️ No pude conectar con la base de datos."; }
        hideTyping(); addMessage(response, 'bot'); return;
    }

    // 2) BÚSQUEDA DE CONTENIDO COMPLETO: "texto sobre X" / "buscar en contenido X"
    const contentMatch = lower.match(/(?:texto\s+sobre|buscar\s+en\s+contenido[:\s]+|contenido[:\s]+|leer\s+sobre|en\s+el\s+texto)\s+(.+)/i);
    if (contentMatch) {
        const term = contentMatch[1].trim();
        showTyping('Leyendo archivos de cables...');
        hideTyping();
        showTyping('Leyendo archivos de cables...');
        try {
            const res  = await fetch(`${BASE}/api_gimai.php?action=search_content&term=${encodeURIComponent(term)}`);
            const json = await res.json();
            response = renderResults(
                `📄 Cables con "<b>${term}</b>" en su contenido (${json.count || 0}):`,
                json.data,
                `No encontré cables cuyo contenido mencione "<b>${term}</b>". Intenta con otro término.`,
                true  // Mostrar snippets
            );
        } catch(e) { response = "⚠️ Error al leer archivos del servidor."; }
        hideTyping(); addMessage(response, 'bot'); return;
    }

    // 3) ÚLTIMAS NOTICIAS
    if (/\b(último|últimas|ultimas|reciente|nuevas?|latest|ahora|hoy)\b/.test(lower)) {
        try {
            const res  = await fetch(`${BASE}/api_gimai.php?action=latest&limit=10`);
            const json = await res.json();
            response = renderResults("🆕 <b>Últimos cables recibidos:</b>", json.data, "No se encontraron cables recientes.");
        } catch(e) { response = "⚠️ No pude conectar con la base de datos."; }
        hideTyping(); addMessage(response, 'bot'); return;
    }

    // 4) AGENCIA (sola o combinada con tema: "AFP sobre deporte")
    let detectedAgency = null;
    let themeAfterAgency = '';
    for (const [keyword, code] of Object.entries(AGENCIES)) {
        if (lower.includes(keyword)) {
            detectedAgency = code;
            // Extraer tema si lo hay: "AFP sobre economía" → "economía"
            const afterMatch = lower.match(new RegExp(keyword + '\\s+(?:sobre|de|en|con)?\\s+(.+)', 'i'));
            if (afterMatch) themeAfterAgency = cleanSearchTerm(afterMatch[1]);
            break;
        }
    }
    if (detectedAgency) {
        try {
            let url = `${BASE}/api_gimai.php?action=search_agency&agency=${detectedAgency}`;
            if (themeAfterAgency) url += `&theme=${encodeURIComponent(themeAfterAgency)}`;
            const res  = await fetch(url);
            const json = await res.json();
            const label = themeAfterAgency
                ? `📡 Notas de <b>${detectedAgency}</b> sobre "<b>${themeAfterAgency}</b>" (${json.count || 0}):`
                : `📡 Últimas notas de <b>${detectedAgency}</b> (${json.count || 0}):`;
            response = renderResults(label, json.data, `No encontré notas de <b>${detectedAgency}</b>${themeAfterAgency ? ` sobre "${themeAfterAgency}"` : ''}.`);
        } catch(e) { response = "⚠️ No pude conectar con la base de datos."; }
        hideTyping(); addMessage(response, 'bot'); return;
    }

    // 5) CONOCIMIENTO ESTÁTICO
    for (const k of GIMAI_KNOWLEDGE) {
        if (k.keywords.some(kw => lower.includes(kw))) {
            hideTyping(); addMessage(k.response, 'bot'); return;
        }
    }

    // 6) BÚSQUEDA LIBRE por tema (con relevancia multi-palabra)
    const searchTerm = cleanSearchTerm(lower);
    if (searchTerm.length >= 2) {
        try {
            const res  = await fetch(`${BASE}/api_gimai.php?action=search_theme&theme=${encodeURIComponent(searchTerm)}`);
            const json = await res.json();
            if (json.count > 0) {
                response = renderResults(
                    `🔍 Resultados para <b>"${searchTerm}"</b> (${json.count} encontrados):`,
                    json.data,
                    ''
                );
            } else {
                // Si no hay resultados en BD, sugerir búsqueda en contenido
                response = `No encontré cables con el título "<b>${searchTerm}</b>".<br><br>
                    💡 ¿Quieres que busque <b>dentro del contenido</b> de las notas?<br>
                    Escribe: <i>"texto sobre ${searchTerm}"</i>`;
            }
        } catch(e) { response = "⚠️ No pude conectar con la base de datos. Verifica que el servidor esté activo."; }
    } else {
        response = `No entendí tu búsqueda. Prueba con:<br>
            &nbsp;• Un tema: <i>trump</i>, <i>economía</i><br>
            &nbsp;• Una fecha: <i>2026-04-24</i><br>
            &nbsp;• Una agencia: <i>AFP</i>, <i>Reuters</i><br>
            &nbsp;• Contenido: <i>texto sobre petróleo</i>`;
    }

    hideTyping();
    addMessage(response, 'bot');
}

// ─── Inicializar ──────────────────────────────────────────────────────────────
document.addEventListener("DOMContentLoaded", () => {
    const trigger     = document.getElementById('gimai-btn-trigger');
    const offcanvasEl = document.getElementById('gimai-offcanvas');
    const input       = document.getElementById('gimai-input');
    const send        = document.getElementById('gimai-send');
    const chatBody    = document.getElementById('gimai-chat-body');

    if (offcanvasEl) {
        const offcanvas = new bootstrap.Offcanvas(offcanvasEl);
        trigger.onclick = () => offcanvas.toggle();
        offcanvasEl.addEventListener('show.bs.offcanvas', () => {
            chatBody.innerHTML = "";
            addMessage(GIMAI_INTRO, 'bot');
            setTimeout(() => input.focus(), 400);
        });
    }

    const handleSend = () => {
        const val = input.value.trim();
        if (val) { addMessage(val, 'user'); input.value = ""; processInput(val); }
    };

    send.onclick  = handleSend;
    input.onkeypress = (e) => { if (e.key === 'Enter') handleSend(); };
});
