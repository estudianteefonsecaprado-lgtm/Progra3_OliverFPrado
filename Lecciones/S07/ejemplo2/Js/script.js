console.log("El script se cargó correctamente");

const perfil = {
    nombre: "Oliver Josiel F Prado",
    rol: "Ingeniero en informática",
    habilidades: ["HTML", "CSS", "SQL", "C#", "JS"]
};

const elementoSaludo = document.querySelector('#saludo');
const elementoRol = document.getElementById('rol');

elementoSaludo.textContent = `Hola, soy ${perfil.nombre}`;
elementoRol.textContent = perfil.rol;

const listaHabilidades = document.querySelector("#lista-habilidades");

function crearItemHabilidad(habilidad) {
    const item = document.createElement("li");
    item.textContent = habilidad;
    item.classList.add("list-group-item");
    return item;
}

perfil.habilidades.forEach((habilidad) => {
    const item = crearItemHabilidad(habilidad);
    listaHabilidades.appendChild(item);
});

const botonTema = document.querySelector("#btn-tema");

botonTema.addEventListener("click", () => {

    const oscuroActivo = document.body.classList.toggle("modo-oscuro");

    if (oscuroActivo) {
        botonTema.textContent = "Modo Claro";
        botonTema.setAttribute("aria-pressed", "true");
    } else {
        botonTema.textContent = "Modo Oscuro";
        botonTema.setAttribute("aria-pressed", "false");
    }
});