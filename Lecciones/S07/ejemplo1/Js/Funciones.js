let cajas = document.getElementsByTagName('div');
let primeraCaja = document.getElementById('primerCaja');

// -------Crear caja
let caja = document.createElement('div');
let contenido = document.createTextNode('Hola mundo desde JS');
caja.appendChild(contenido);
caja.setAttribute('class', 'caja naranja');
caja.setAttribute('id','cajaNueva');
let contenedor = document.getElementById('contenedor');
contenedor.appendChild(caja);