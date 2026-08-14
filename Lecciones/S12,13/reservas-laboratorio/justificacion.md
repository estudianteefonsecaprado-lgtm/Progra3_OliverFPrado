# Justificación

## 1. ¿Por qué eligió el método GET para el buscador y el método POST para el cambio de estado? ¿Qué ocurriría si los intercambiara?

Utilicé el método **GET** para el buscador porque únicamente consulta información y no modifica los datos almacenados. Además, los criterios de búsqueda quedan visibles en la URL, lo que permite copiarla o volver a abrirla conservando los mismos filtros aplicados. En mi proyecto esto se implementa en **panel.php**, donde los parámetros `q`, `estado` y `laboratorio` se obtienen desde `$_GET`.

Para el cambio de estado utilicé **POST** porque esta operación modifica la información de una solicitud. En **panel.php** el formulario envía el identificador de la solicitud, el nuevo estado y el token CSRF mediante `$_POST`, y posteriormente se llama a la función `actualizarEstadoSolicitud()`.

Si intercambiara ambos métodos, el buscador dejaría de generar una URL reutilizable y el cambio de estado podría ejecutarse simplemente visitando una dirección o recargando la página, lo que representaría un riesgo de seguridad y de modificación accidental de los datos.

---

## 2. ¿Cómo garantiza su implementación que un usuario no autenticado no pueda ver ni modificar las solicitudes? ¿Qué prueba realizó?

El acceso al panel está protegido mediante sesiones. Después de iniciar sesión correctamente se almacenan los datos mínimos del encargado en `$_SESSION` y se regenera el identificador de sesión utilizando `session_regenerate_id(true)`.

En **panel.php** se llama a la función `exigirSesion()`, ubicada en **includes/seguridad.php**. Esta función verifica que exista una sesión autenticada antes de mostrar el contenido del panel. Si la sesión no existe, el usuario es redirigido nuevamente a la página de inicio de sesión.

Como prueba, intenté acceder directamente a `panel.php` escribiendo la dirección en el navegador sin haber iniciado sesión y el sistema me redirigió al formulario de acceso mostrando el mensaje correspondiente.

---

## 3. ¿Qué diferencia hay entre validar y escapar? Señale un ejemplo de cada operación.

La validación consiste en comprobar que los datos recibidos cumplen las reglas establecidas antes de ser utilizados o almacenados. En mi proyecto esto ocurre, por ejemplo, cuando se verifica que el correo pertenezca al dominio institucional mediante `filter_var()` y cuando se valida que la cantidad de equipos se encuentre dentro del rango permitido.

Escapar consiste en convertir caracteres especiales antes de enviarlos al navegador para evitar que puedan interpretarse como código HTML o JavaScript. En mi implementación utilicé la función `e()`, basada en `htmlspecialchars()`, para mostrar de forma segura los datos en los formularios y en la tabla del panel de administración.

---

## 4. ¿Qué ocurre si el token CSRF no coincide? ¿Por qué utiliza una comparación en tiempo constante?

Todos los formularios que utilizan el método POST incluyen un token CSRF generado mediante una función criptográficamente segura y almacenado en la sesión.

Cuando se recibe una petición POST, el sistema verifica el token antes de procesar cualquier dato utilizando la función `tokenCsrfValidado()`. Si el token no coincide, la solicitud se rechaza y no se realiza ninguna modificación en la información.

La comparación se realiza utilizando `hash_equals()` en lugar del operador `==` porque esta función trabaja en tiempo constante y ayuda a evitar ataques que intentan descubrir el valor del token midiendo el tiempo que tarda la comparación.

---

## 5. ¿Qué información decidió guardar en la sesión, cuál en la cookie y por qué?

En la sesión decidí almacenar las solicitudes registradas y la información mínima del encargado autenticado, ya que estos datos deben permanecer únicamente mientras la sesión esté activa y no deben ser modificados por el usuario desde el navegador.

En la cookie únicamente guardé el correo electrónico del encargado cuando se selecciona la opción "Recordar correo". La cookie no almacena la contraseña ni información sensible, únicamente facilita que el usuario no tenga que volver a escribir el correo al iniciar sesión nuevamente.

Esta distribución mejora la seguridad porque la información importante permanece en el servidor mientras que en el navegador solo se conserva un dato que no compromete la autenticación del sistema.