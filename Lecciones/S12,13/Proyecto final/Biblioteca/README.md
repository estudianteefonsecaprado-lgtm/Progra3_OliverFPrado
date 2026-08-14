# Sistema de Gestión de Biblioteca

Proyecto Final del curso **Programación III**.

## Autor

**Oliver Fonseca Prado**  
Universidad Castro Carazo

---

## Descripción

Sistema web desarrollado en PHP y MySQL para la administración de una biblioteca.

Permite gestionar:

- Libros
- Autores
- Categorías
- Usuarios
- Inicio y cierre de sesión
- Control de acceso mediante roles (Administrador y Usuario)

---

## Tecnologías utilizadas

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript
- Bootstrap 5
- Bootstrap Icons
- XAMPP

---

## Instalación

1. Copiar la carpeta **Biblioteca** dentro de `htdocs` de XAMPP.
2. Iniciar los servicios **Apache** y **MySQL**.
3. Abrir **phpMyAdmin**.
4. Importar el archivo **biblioteca.sql**.
5. Acceder al proyecto desde:

```
http://localhost/Biblioteca/
```

*(Si la carpeta tiene otro nombre, utilizar la ruta correspondiente.)*

---

## Usuarios

Para facilitar la revisión del proyecto se incluye un usuario administrador y uno usuario.

**Correo electrónico**

```
admin@biblioteca.com
```

**Contraseña**

```
admin123
```

**Nombre del usuario**

```
Oliver Fonseca
```
Usuario: 

**Correo electrónico**

```
ejemplo@gmail.com

```

**Contraseña**

```
12345678
```

**Nombre del usuario**

```
J P
---

## Funcionalidades

- Inicio de sesión.
- Registro de usuarios.
- Administración de libros.
- Administración de autores.
- Administración de categorías.
- Administración de usuarios.
- Validaciones del lado del cliente y del servidor.
- Contraseñas protegidas mediante `password_hash()`.
- Diseño responsivo.

---

## Notas

- El módulo de administración de usuarios solo está disponible para usuarios con rol **Administrador**.
- Las restricciones de la base de datos impiden eliminar autores o categorías que tengan libros asociados, garantizando la integridad de la información.

---

**Autor:** Oliver Fonseca Prado  
**Curso:** Programación III  
**Universidad Castro Carazo**