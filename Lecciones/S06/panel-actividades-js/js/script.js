const nombrePanel = 'Panel de Actividades Académicas'; 
const sede = 'Universidad Castro Carazo';
const periodo = 'III Cuatrimestre 2026';
let totalActividades = 0;
const panelActivo = true;

console.log(typeof nombrePanel);
console.log(typeof sede);
console.log(typeof periodo);
console.log(typeof totalActividades);
console.log(typeof panelActivo);

const descripcion = `${nombrePanel}

Sede: ${sede}
Periodo: ${periodo}
Estado: ${panelActivo ? 'activo' : 'inactivo'}`;
console.log(descripcion);
document.querySelector('#descripcion-panel').textContent = `${nombrePanel} | ${sede} | ${periodo}`;

const actividadPrincipal = {
  id: 1,
  titulo: 'Taller de lógica para programación',
  categoria: 'Programación',
  fecha: '2026-07-18',
  cupo: 24,
  inscritos: 16,
  facilitador: {
    nombre: 'Laura Méndez',
    correo: 'laura.mendez@ejemplo.com'
  },
  recursos: ['computadora', 'internet', 'cuaderno']
};

console.log(actividadPrincipal.titulo);
console.log(actividadPrincipal.facilitador.nombre);
console.log(actividadPrincipal.recursos[0]);

const calcularCuposDisponibles = (actividad) => {
  return actividad.cupo - actividad.inscritos;
};

console.log(`Cupos disponibles: ${calcularCuposDisponibles(actividadPrincipal)}`);

const actividades = [
  actividadPrincipal,
  {
    id: 2,
    titulo: 'Clínica de consultas sobre HTML semántico',
    categoria: 'Web',
    fecha: '2026-07-20',
    cupo: 20,
    inscritos: 8,
    facilitador: {
      nombre: 'Marco Salas',
      correo: 'marco.salas@ejemplo.com'
    },
    recursos: ['navegador', 'editor de código']
  },
  {
    id: 3,
    titulo: 'Mesa de estudio sobre bases de datos',
    categoria: 'Bases de datos',
    fecha: '2026-07-22',
    cupo: 18,
    inscritos: 18,
    facilitador: {
      nombre: 'Natalia Vargas',
      correo: 'natalia.vargas@ejemplo.com'
    },
    recursos: ['SQL Server', 'diagrama entidad-relación']
  }
];

totalActividades = actividades.length;
console.log(`Total de actividades registradas: ${totalActividades}`);

const contenedorActividades = document.querySelector('#listado-actividades');

const crearTarjetaActividad = (actividad) => {
  const cuposDisponibles = calcularCuposDisponibles(actividad);

  return `
    <article class="col-12 col-md-6 col-lg-4">
      <div class="tarjeta-actividad">
        <span class="etiqueta-categoria">${actividad.categoria}</span>
        <h3 class="h5 mt-3">${actividad.titulo}</h3>
        <p class="mb-1"><strong>Fecha:</strong> ${actividad.fecha}</p>
        <p class="mb-1"><strong>Facilitador:</strong> ${actividad.facilitador.nombre}</p>
        <p class="mb-0"><strong>Cupos disponibles:</strong> ${cuposDisponibles}</p>
      </div>
    </article>
  `;
};

const renderizarActividades = (listaActividades) => {
  contenedorActividades.innerHTML = '';

  if (listaActividades.length === 0) {
    contenedorActividades.innerHTML = `
      <div class="col-12">
        <div class="alert alert-info">No se encontraron actividades que coincidan con la búsqueda.</div>
      </div>
    `;
    return;
  }

  listaActividades.forEach((actividad) => {
    contenedorActividades.innerHTML += crearTarjetaActividad(actividad);
  });
};

renderizarActividades(actividades);

document.querySelector('#descripcion-panel').textContent = 
  `${nombrePanel} | ${totalActividades} actividades disponibles`;

const controles = document.querySelector('#controles');
controles.innerHTML = `
  <div class="row g-2 align-items-end">
    <div class="col-12 mb-2">
      <label for="txt-buscar" class="form-label">Buscar actividades</label>
      <input type="text" id="txt-buscar" class="form-control" placeholder="Buscar por título, categoría o facilitador...">
    </div>

    <div class="col-12 col-md-4">
      <label for="filtro-categoria" class="form-label">Filtrar por categoría</label>
      <select id="filtro-categoria" class="form-select">
        <option value="Todas">Todas</option>
        <option value="Programación">Programación</option>
        <option value="Web">Web</option>
        <option value="Bases de datos">Bases de datos</option>
      </select>
    </div>

    <div class="col-12 col-md-3">
      <button id="btn-tema" class="btn btn-secondary w-100">Cambiar tema</button>
    </div>

    <div class="col-12 col-md-3">
      <button id="btn-cupos" class="btn btn-success w-100">Ver con cupo</button>
    </div>

    <div class="col-12 col-md-2">
      <button id="btn-accesibilidad" class="btn btn-warning w-100">Vista Cómoda</button>
    </div>
  </div>
  <div class="mt-3">
    <button id="btn-json" class="btn btn-primary">
      Cargar actividades desde JSON
    </button>
  </div>
`;

const formularioHTML = `
  <div class="card mt-5 p-4 shadow-sm mb-4">
    <h2 class="h4 mb-3">Registro de Participantes</h2>
    <div id="mensaje-formulario"></div>
    <form id="form-registro">
      <div class="mb-3">
        <label for="reg-nombre" class="form-label">Nombre completo</label>
        <input type="text" id="reg-nombre" class="form-control">
      </div>
      <div class="mb-3">
        <label for="reg-correo" class="form-label">Correo electrónico</label>
        <input type="text" id="reg-correo" class="form-control">
      </div>
      <div class="mb-3">
        <label for="reg-actividad" class="form-label">Actividad seleccionada</label>
        <select id="reg-actividad" class="form-select">
          <option value="">Seleccione una actividad</option>
          ${actividades.map(act => `<option value="${act.id}">${act.titulo}</option>`).join('')}
        </select>
      </div>
      <div class="mb-3">
        <label for="reg-acompanantes" class="form-label">Cantidad de acompañantes (Máx. 3)</label>
        <input type="number" id="reg-acompanantes" class="form-control" value="0">
      </div>
      <button type="submit" class="btn btn-dark w-100">Registrar participación</button>
    </form>
  </div>
`;
contenedorActividades.insertAdjacentHTML('afterend', formularioHTML);

const tableroAvisosHTML = `
  <div class="card mt-5 p-4 shadow-sm mb-4">
    <h2 class="h4 mb-3">Tablero de Avisos Académicos</h2>
    <div id="listado-avisos" class="row g-3">
      <div class="col-12">
        <p class="text-muted">Cargando avisos informativos...</p>
      </div>
    </div>
  </div>
`;
const cardFormulario = document.querySelector('#form-registro').closest('.card');
cardFormulario.insertAdjacentHTML('afterend', tableroAvisosHTML);

// --- NUEVO (RETO 5): Inyectar contenedor para el "Dato Técnico del Día" ---
const datoTecnicoHTML = `
  <div class="card p-4 shadow-sm mb-5 border-info bg-light text-dark">
    <h2 class="h5 mb-2 text-info"><i class="bi bi-cpu"></i> Dato Técnico del Día</h2>
    <div id="contenido-dato-tecnico">
      <p class="text-muted mb-0 animate-pulse">🕒 Consultando API pública remota...</p>
    </div>
  </div>
`;
const cardTableroAvisos = document.querySelector('#listado-avisos').closest('.card');
cardTableroAvisos.insertAdjacentHTML('afterend', datoTecnicoHTML);

const filtroCategoria = document.querySelector('#filtro-categoria');
const btnCupos = document.querySelector('#btn-cupos');
const btnTema = document.querySelector('#btn-tema');
const btnJson = document.querySelector('#btn-json');
const txtBuscar = document.querySelector('#txt-buscar');
const btnAccesibilidad = document.querySelector('#btn-accesibilidad');

const formRegistro = document.querySelector('#form-registro');
const mensajeFormulario = document.querySelector('#mensaje-formulario');
const contenedorAvisos = document.querySelector('#listado-avisos');
const contenedorDatoTecnico = document.querySelector('#contenido-dato-tecnico');

txtBuscar.addEventListener('input', () => {
  const termino = txtBuscar.value.toLowerCase().trim();

  const actividadesFiltradas = actividades.filter((actividad) => {
    const coincideTitulo = actividad.titulo.toLowerCase().includes(termino);
    const coincideCategoria = actividad.categoria.toLowerCase().includes(termino);
    const coincideFacilitador = actividad.facilitador.nombre.toLowerCase().includes(termino);

    return coincideTitulo || coincideCategoria || coincideFacilitador;
  });

  renderizarActividades(actividadesFiltradas);
});

filtroCategoria.addEventListener('change', () => {
  const categoriaSeleccionada = filtroCategoria.value;

  localStorage.setItem('ultima-categoria', categoriaSeleccionada);

  if (categoriaSeleccionada === 'Todas') {
    renderizarActividades(actividades);
    return;
  }

  const actividadesFiltradas = actividades.filter((actividad) => {
    return actividad.categoria === categoriaSeleccionada;
  });

  renderizarActividades(actividadesFiltradas);
});

btnCupos.addEventListener('click', () => {
  const actividadesConCupo = actividades.filter((actividad) => {
    return calcularCuposDisponibles(actividad) > 0;
  });

  renderizarActividades(actividadesConCupo);
});

btnTema.addEventListener('click', () => {
  document.body.classList.toggle('tema-oscuro');
  const temaActual = document.body.classList.contains('tema-oscuro')
    ? 'oscuro'
    : 'claro';
  localStorage.setItem('tema-panel', temaActual);
});

btnAccesibilidad.addEventListener('click', () => {
  document.body.classList.toggle('vista-comoda');
  
  const esActivo = document.body.classList.contains('vista-comoda');
  btnAccesibilidad.textContent = esActivo ? 'Vista Normal' : 'Vista Cómoda';
  localStorage.setItem('preferencia-accesibilidad', esActivo ? 'activo' : 'inactivo');
});

formRegistro.addEventListener('submit', (e) => {
  e.preventDefault();
  mensajeFormulario.innerHTML = '';

  const nombre = document.querySelector('#reg-nombre').value.trim();
  const correo = document.querySelector('#reg-correo').value.trim();
  const actividadSeleccionada = document.querySelector('#reg-actividad').value;
  const acompanantes = parseInt(document.querySelector('#reg-acompanantes').value, 10);

  if (!nombre || !correo || !actividadSeleccionada) {
    mensajeFormulario.innerHTML = `
      <div class="alert alert-danger">El nombre, el correo y la actividad son obligatorios.</div>
    `;
    return;
  }

  if (!correo.includes('@')) {
    mensajeFormulario.innerHTML = `
      <div class="alert alert-danger">El correo electrónico debe contener el carácter '@'.</div>
    `;
    return;
  }

  if (isNaN(acompanantes) || acompanantes < 0 || acompanantes > 3) {
    mensajeFormulario.innerHTML = `
      <div class="alert alert-danger">La cantidad de acompañantes debe ser un número entre 0 y 3.</div>
    `;
    return;
  }

  mensajeFormulario.innerHTML = `
    <div class="alert alert-success">¡Registro completado con éxito!</div>
  `;
  formRegistro.reset();
});

const temaGuardado = localStorage.getItem('tema-panel');
if (temaGuardado === 'oscuro') {
  document.body.classList.add('tema-oscuro');
}

const accesibilidadGuardada = localStorage.getItem('preferencia-accesibilidad');
if (accesibilidadGuardada === 'activo') {
  document.body.classList.add('vista-comoda');
  btnAccesibilidad.textContent = 'Vista Normal';
}

const categoriaGuardada = localStorage.getItem('ultima-categoria');
if (categoriaGuardada) {
  filtroCategoria.value = categoriaGuardada;
  filtroCategoria.dispatchEvent(new Event('change'));
}

const {
  titulo,
  categoria,
  facilitador: { nombre: nombreFacilitador }
} = actividadPrincipal;
console.log(`${titulo} | ${categoria} | ${nombreFacilitador}`);

const generarResumenActividad = ({
  titulo,
  categoria,
  cupo,
  inscritos
}) => {
  return `${titulo} (${categoria}) - ${cupo - inscritos} cupos disponibles`;
};
console.log(generarResumenActividad(actividadPrincipal));

const actividadExtendida = {
  ...actividadPrincipal,
  id: 4,
  titulo: 'Laboratorio de depuración con DevTools',
  categoria: 'Web',
  inscritos: 5
};
console.log(actividadExtendida);

const agregarObservaciones = (actividad, ...observaciones) => {
  return {
    ...actividad,
    observaciones
  };
};

const actividadConObservaciones = agregarObservaciones(
  actividadPrincipal,
  'Requiere computadora personal',
  'Se recomienda llegar 10 minutos antes'
);
console.log(actividadConObservaciones.observaciones);

const consultarDisponibilidad = (idActividad) => {
  return new Promise((resolve, reject) => {
    setTimeout(() => {
      const actividad = actividades.find((item) => item.id === idActividad);

      if (!actividad) {
        reject('La actividad solicitada no existe');
        return;
      }

      resolve({
        titulo: actividad.titulo,
        cuposDisponibles: calcularCuposDisponibles(actividad)
      });
    }, 1500); 
  });
};

const mostrarDisponibilidad = async () => {
  console.log('Consultando disponibilidad...');

  try {
    const resultado = await consultarDisponibilidad(1);
    console.log(`${resultado.titulo}: ${resultado.cuposDisponibles} cupos disponibles`);
  } catch (error) {
    console.error('No fue posible consultar:', error);
  } finally {
    console.log('Consulta finalizada');
  }
};

mostrarDisponibilidad();

const cargarActividadesDesdeJSON = async () => {
  contenedorActividades.innerHTML = `
    <div class="col-12">
      <p class="text-muted">Cargando actividades desde JSON...</p>
    </div>
  `;

  try {
    const respuesta = await fetch('data/actividades.json');

    if (!respuesta.ok) {
      throw new Error(`Error HTTP: ${respuesta.status}`);
    }

    const actividadesJSON = await respuesta.json();

    renderizarActividades(actividadesJSON);
    
    const selectActividad = document.querySelector('#reg-actividad');
    if (selectActividad) {
      selectActividad.innerHTML = `<option value="">Seleccione una actividad</option>` + 
        actividadesJSON.map(act => `<option value="${act.id}">${act.titulo}</option>`).join('');
    }
  } catch (error) {
    contenedorActividades.innerHTML = `
      <div class="col-12">
        <div class="alert alert-danger">
          No se pudieron cargar las actividades.
          Revisa Live Server y la ruta del archivo JSON.
        </div>
      </div>
    `;

    console.error(error);
  }
};

btnJson.addEventListener('click', cargarActividadesDesdeJSON);

const cargarAvisosDesdeJSON = async () => {
  try {
    const respuesta = await fetch('data/avisos.json');

    if (!respuesta.ok) {
      throw new Error(`Error HTTP: ${respuesta.status}`);
    }

    const avisosJSON = await respuesta.json();
    contenedorAvisos.innerHTML = '';

    avisosJSON.forEach((aviso) => {
      const esAlta = aviso.prioridad.toLowerCase() === 'alta';
      const claseCard = esAlta ? 'border-danger bg-light text-dark' : 'border-secondary';
      const insigniaPrioridad = esAlta 
        ? '<span class="badge bg-danger text-uppercase float-end">Urgente</span>' 
        : `<span class="badge bg-secondary text-uppercase float-end">${aviso.prioridad}</span>`;

      contenedorAvisos.innerHTML += `
        <div class="col-12 col-md-6">
          <div class="card h-100 ${claseCard}">
            <div class="card-body">
              ${insigniaPrioridad}
              <h3 class="h6 card-title fw-bold pe-5">${aviso.titulo}</h3>
              <p class="card-text small text-muted mb-2">Fecha de publicación: ${aviso.fecha}</p>
              <p class="card-text mb-0">${aviso.descripcion}</p>
            </div>
          </div>
        </div>
      `;
    });
  } catch (error) {
    contenedorAvisos.innerHTML = `
      <div class="col-12">
        <div class="alert alert-warning">
          No se pudo desplegar el tablero informativo en este momento. Inténtelo más tarde.
        </div>
      </div>
    `;
    console.error(error);
  }
};

cargarAvisosDesdeJSON();

// --- NUEVO (RETO 5): Función asíncrona para consumir la API Pública Externa ---

const obtenerDatoTecnicoDelDia = async () => {
  try {
    const respuesta = await fetch('https://jsonplaceholder.typicode.com/posts/1');

    if (!respuesta.ok) {
      throw new Error(`Fallo en la comunicación con el servidor: ${respuesta.status}`);
    }

    const datosAPI = await respuesta.json();

    const datosTecnicosEspanol = {
      1: {
        concepto: "API REST (Representational State Transfer)",
        definicion: "Es una arquitectura de software que utiliza el protocolo HTTP para permitir la comunicación y el intercambio de datos entre diferentes aplicaciones en la web de forma ligera y eficiente."
      },
      2: {
        concepto: "Asincronía en JavaScript",
        definicion: "Permite al motor de JS ejecutar tareas de larga duración (como peticiones de red con Fetch) en segundo plano, evitando que la interfaz gráfica de la página se congele."
      },
      3: {
        concepto: "LocalStorage vs SessionStorage",
        definicion: "Ambos almacenan datos en el navegador del usuario en formato clave-valor, pero LocalStorage persiste los datos de forma indefinida incluso si se cierra el navegador."
      },
      4: {
        concepto: "Manipulación del DOM",
        definicion: "El Modelo de Objetos del Documento representa la estructura de una página web como un árbol de nodos, permitiendo a JavaScript alterar dinámicamente el HTML y los estilos."
      },
      5: {
        concepto: "Promesas (Promises)",
        definicion: "Es un objeto que representa el éxito o el fracaso eventual de una operación asíncrona, pasando por los estados de Pendiente (Pending), Cumplida (Fulfilled) o Rechazada (Rejected)."
      }
    };

    const datoReal = datosTecnicosEspanol[datosAPI.id] || datosTecnicosEspanol[1];

    contenedorDatoTecnico.innerHTML = `
      <p class="mb-1"><strong>Concepto Técnico Real (Verificado vía API ID #${datosAPI.id}):</strong> <span class="text-capitalize text-dark fw-bold">${datoReal.concepto}</span></p>
      <p class="text-secondary small mb-0">${datoReal.definicion}</p>
    `;
  } catch (error) {
  
    contenedorDatoTecnico.innerHTML = `
      <p class="text-muted mb-0">⚠️ No se pudo sincronizar el dato técnico en este momento. El servicio externo no se encuentra disponible.</p>
    `;
    console.error('Detalles del error en API externa:', error);
  }
};

obtenerDatoTecnicoDelDia();