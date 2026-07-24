# Sistema de Reservas del Laboratorio de Cómputo

Práctica Independiente 5 - Semana 10  
Curso: IN3014 Programación de Computadoras III  
Universidad Castro Carazo

## Descripción

Esta aplicación permite registrar solicitudes de reserva para los laboratorios de cómputo de la universidad. Los estudiantes pueden realizar solicitudes mediante un formulario público y el encargado del laboratorio puede iniciar sesión para administrarlas.

Toda la información se almacena temporalmente en la sesión del servidor, por lo que no se utiliza base de datos.

---

## Requisitos

- PHP 8
- XAMPP
- Apache

---

## Instalación

1. Copiar la carpeta **reservas-laboratorio** dentro de:

```
xampp/htdocs/
```

2. Iniciar Apache desde el panel de XAMPP.

3. Abrir el navegador e ingresar a:

```
http://localhost/reservas-laboratorio/
```

---

## Credenciales de prueba

Puede iniciar sesión con cualquiera de las siguientes cuentas:

**Correo:**

```
oliverprado@castrocarazo.ac.cr
```

o

```
admin.lab@castrocarazo.ac.cr
```

**Contraseña:**

```
j1234567
```

---

## Funcionalidades

- Registro de solicitudes de reserva.
- Inicio de sesión para encargados.
- Administración de solicitudes.
- Cambio de estado entre pendiente, aprobada y rechazada.
- Búsqueda por nombre o carné.
- Filtro por laboratorio.
- Filtro por estado.
- Cierre seguro de sesión.

---

## Validaciones implementadas

### Formulario de solicitudes

- Todos los campos son obligatorios.
- Validación del lado del servidor.
- Validación del correo institucional.
- Validación del número de carné.
- Validación de la cantidad de equipos (1 a 30).
- La fecha no puede ser anterior al día actual.
- No se permiten reservas para sábados ni domingos.
- Validación de laboratorio mediante lista permitida.
- Validación de la hora mediante lista permitida.
- El motivo debe cumplir la longitud establecida.
- Conservación de los datos válidos cuando existen errores.

### Seguridad

- Uso de sesiones para proteger el panel.
- Regeneración del identificador de sesión al iniciar sesión.
- Contraseñas almacenadas mediante `password_hash()`.
- Verificación mediante `password_verify()`.
- Protección CSRF en todos los formularios POST.
- Escape de la salida con `htmlspecialchars()`.
- Cookie para recordar el correo del encargado.
- Cierre completo de sesión.

---

## Estructura del proyecto

```
reservas-laboratorio/
│
├── css/
│   └── estilos.css
│
├── herramientas/
│   └── generar_hash.php
│
├── includes/
│   ├── datos.php
│   ├── funciones.php
│   └── seguridad.php
│
├── index.php
├── login.php
├── panel.php
├── salir.php
├── README.md
└── justificacion.md
```