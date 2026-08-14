// Verificar que el archivo JavaScript se cargó correctamente
console.log("SCRIPT CARGADO");
// ============================================================
// Verificar que se detectan los clics del usuario
document.addEventListener("click", function () {
    console.log("CLICK");
});
/*
==============================================================
Proyecto Final - Programación III
Sistema de Gestión de Biblioteca
--------------------------------------------------------------
Archivo: script.js

Descripción:
Validaciones del lado del cliente para los formularios
del sistema.

Autor: Oliver Fonseca Prado
Universidad Castro Carazo
==============================================================
*/

// ============================================================
// Esperar a que cargue la página
// ============================================================
document.addEventListener("DOMContentLoaded", function () {

    const formulario = document.querySelector("form");

    if (!formulario) {

        return;

    }

    // ========================================================
    // Quitar error al escribir
    // ========================================================

    const campos = formulario.querySelectorAll("input, select");

    campos.forEach(function (campo) {

        campo.addEventListener("input", function () {

            campo.classList.remove("is-invalid");

        });

        campo.addEventListener("change", function () {

            campo.classList.remove("is-invalid");

        });

    });

    // ========================================================
    // Validar formulario
    // ========================================================

    formulario.addEventListener("submit", function (evento) {

        let valido = true;

        const nombre = document.querySelector("[name='nombre']");

        if (nombre && nombre.value.trim() === "") {

            nombre.classList.add("is-invalid");
            nombre.focus();
            valido = false;

        }

        const apellido = document.querySelector("[name='apellido']");

        if (apellido && apellido.value.trim() === "") {

            apellido.classList.add("is-invalid");

            if (valido) {

                apellido.focus();

            }

            valido = false;

        }

        const correo = document.querySelector("[name='correo']");

        if (correo) {

            const expresion = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!expresion.test(correo.value.trim())) {

                correo.classList.add("is-invalid");

                if (valido) {

                    correo.focus();

                }

                valido = false;

            }

        }

        const contrasena = document.querySelector("[name='contrasena']");

        if (contrasena && contrasena.value.length < 8) {

            contrasena.classList.add("is-invalid");

            if (valido) {

                contrasena.focus();

            }

            valido = false;

        }

        const titulo = document.querySelector("[name='titulo']");

        if (titulo && titulo.value.trim() === "") {

            titulo.classList.add("is-invalid");

            if (valido) {

                titulo.focus();

            }

            valido = false;

        }

        const anio = document.querySelector("[name='anio']");

        if (anio) {

            const actual = new Date().getFullYear();

            const valor = parseInt(anio.value);

            if (isNaN(valor) || valor < 1000 || valor > actual) {

                anio.classList.add("is-invalid");

                if (valido) {

                    anio.focus();

                }

                valido = false;

            }

        }

        if (!valido) {

            evento.preventDefault();

        }

    });

});

// ============================================================
// Efecto visual al hacer clic
// ============================================================

document.addEventListener("click", function (e) {

    const iconos = ["✨", "⭐", "📚", "🐋"];

    for (let i = 0; i < 5; i++) {

        const efecto = document.createElement("span");

        efecto.className = "click-efecto";

        efecto.textContent = iconos[Math.floor(Math.random() * iconos.length)];

        efecto.style.left = e.pageX + (Math.random() * 80 - 40) + "px";

        efecto.style.top = e.pageY + (Math.random() * 80 - 40) + "px";

        efecto.style.fontSize = (20 + Math.random() * 15) + "px";

        document.body.appendChild(efecto);

        setTimeout(function () {

            efecto.remove();

        }, 1200);

    }

});