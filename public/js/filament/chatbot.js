document.addEventListener('DOMContentLoaded', function () {
    const chatbotBtn = document.getElementById('chatbot-button');
    const chatbotContainer = document.getElementById('chatbot-container');
    const chatBox = document.getElementById('chat');
    const optionsBox = document.getElementById('options');

    let categoriaSeleccionada = null;

    const categorias = {
        impresora: {
            nombre: "🖨 Impresora",
            preguntas: [
                { texto: "No imprime", respuesta: "Revisa que esté encendida, conectada al puerto correspondiente  y con papel disponible." },
                { texto: "Papel atascado", respuesta: "Apaga la impresora e identifica si hay papel visible en la bandeja de salida o entrada." },
                { texto: "Error de tinta", respuesta: "Verifica que los cartuchos no estén vacíos." },
            ]
        },
        computador: {
            nombre: "💻 Computador",
            preguntas: [
                { texto: "No enciende", respuesta: "Verifica que esté conectado a la corriente, revisa todo el cable." },
                { texto: "Está muy lento", respuesta: "Cierra programas que no estés usando y reinicia si es posible. Evita abrir demasiadas ventanas a la vez." },
                { texto: "No reconoce USB", respuesta: "Prueba otro puerto o reinicia el equipo. Asegúrate que el USB funcione en otro computador." },
            ]
        },
        internet: {
            nombre: "🌐 Red / Internet",
            preguntas: [
                { texto: "No tengo conexión", respuesta: "Revisa si estás conectado a una red WiFi o si tu cable está suelto." },
                { texto: "Wi-Fi muy lento", respuesta: "Cierra páginas o apps que consumen mucho internet e ingresa un ticket." },
                { texto: "Cortes intermitentes", respuesta: "Podría ser problema del proveedor. Espera unos minutos o contacta soporte si persiste." },
            ]
        }
    };

    if (chatbotBtn) {
        chatbotBtn.addEventListener('click', () => {
            chatbotContainer.classList.remove('hidden');
            if (chatBox.children.length === 0) {
                setTimeout(() => agregarMensaje("¡Hola! Soy tu asistente virtual. ¿En qué tipo de problema necesitas ayuda?"), 300);
                setTimeout(() => mostrarCategorias(), 900);
            }
        });
    }

    window.cerrarChatbot = () => chatbotContainer.classList.add('hidden');

    function mostrarCategorias() {
        optionsBox.innerHTML = '';
        Object.entries(categorias).forEach(([clave, cat]) => {
            const btn = crearBoton(cat.nombre, () => {
                agregarMensaje(cat.nombre, true);
                categoriaSeleccionada = clave;
                setTimeout(() => mostrarPreguntasCategoria(), 600);
            }, 'from-blue-500 to-indigo-500');
            optionsBox.appendChild(btn);
        });
    }

    function mostrarPreguntasCategoria() {
        const cat = categorias[categoriaSeleccionada];
        agregarMensaje(`¿Qué problema tienes con ${cat.nombre.split(" ")[1].toLowerCase()}?`);
        optionsBox.innerHTML = '';

        cat.preguntas.forEach(preg => {
            const btn = crearBoton(preg.texto, () => {
                agregarMensaje(preg.texto, true);
                setTimeout(() => agregarMensaje(preg.respuesta), 600);
                setTimeout(() => ofrecerCrearTicket(), 2000);
            }, 'from-purple-500 to-pink-500');
            optionsBox.appendChild(btn);
        });
    }

    function ofrecerCrearTicket() {
        setTimeout(() => {
            agregarMensaje("¿Te gustaría crear un ticket de soporte?");
            optionsBox.innerHTML = '';

            ["✅ Sí, crear ticket", "❌ No, gracias"].forEach(op => {
                const color = op.includes("Sí") ? 'from-green-500 to-emerald-500' : 'from-red-400 to-red-600';
                const btn = crearBoton(op, () => {
                    agregarMensaje(op, true);
                    if (op.includes("Sí")) {
                        window.location.href = "/tickets/create";
                    } else {
                        agregarMensaje("¡Perfecto! ¿Necesitas ayuda con otra cosa?");
                        setTimeout(() => mostrarCategorias(), 1000);
                    }
                }, color);
                optionsBox.appendChild(btn);
            });
        }, 600);
    }

    function agregarMensaje(texto, esUsuario = false) {
        const msg = document.createElement('div');
        msg.className = `p-2 rounded-xl shadow text-sm ${
            esUsuario ? 'bg-blue-100 text-right self-end' : 'bg-gray-100 text-left'
        } max-w-xs`;
        msg.textContent = texto;
        chatBox.appendChild(msg);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function crearBoton(texto, accion, gradientClass = 'from-indigo-500 to-indigo-600') {
        const btn = document.createElement('button');
        btn.textContent = texto;
        btn.className = `w-full text-black font-semibold py-2 px-4 rounded-xl shadow-md transition 
            bg-gradient-to-r ${gradientClass} hover:opacity-90`;
        btn.onclick = accion;
        return btn;
    }
});
