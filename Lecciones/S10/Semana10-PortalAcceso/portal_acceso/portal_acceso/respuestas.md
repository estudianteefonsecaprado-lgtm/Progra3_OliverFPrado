1.

type="email" solo ayuda a validar en el navegador, pero se puede desactivar o modificar. filter_var() valida el correo en el servidor, por lo que sigue siendo necesario para mayor seguridad.

2.

$_SESSION guarda datos en el servidor, mientras que una cookie los guarda en el navegador del usuario. En una sesión se puede guardar el usuario autenticado, pero no sería buena idea guardar ahí archivos grandes. En una cookie se puede guardar el correo para recordarlo, pero no una contraseña.

3.

Los dos hashes son diferentes porque password_hash() genera un valor aleatorio cada vez. Aun así, password_verify() puede comprobar correctamente si la contraseña coincide con el hash.

4.

Se usa el mensaje "Las credenciales no son correctas" para no decir si falló el correo o la contraseña. Así se evita dar información que pueda ayudar a un atacante.

5.

Si se elimina la verificación del token CSRF, otro sitio podría enviar formularios al sistema usando la sesión del usuario sin que este se dé cuenta. Esto podría permitir acciones no autorizadas.