<h1><?= isset($libro) && $libro ? 'Editar Libro' : 'Registrar Libro'; ?></h1>

<form method="POST">

    <label>Título</label><br>
    <input type="text"
           name="titulo"
           value="<?= htmlspecialchars($libro['titulo'] ?? '') ?>"
           required>
    <br><br>

    <label>Autor</label><br>
    <input type="text"
           name="autor"
           value="<?= htmlspecialchars($libro['autor'] ?? '') ?>"
           required>
    <br><br>

    <label>Año de publicación</label><br>
    <input type="number"
           name="anio_publicacion"
           min="1000"
           max="<?= date('Y') ?>"
           value="<?= htmlspecialchars($libro['anio_publicacion'] ?? '') ?>"
           required>
    <br><br>

    <label>Género</label><br>
    <select name="genero" required>

        <option value="">Seleccione...</option>

        <option value="Novela gráfica"
            <?= (($libro['genero'] ?? '') == 'Novela gráfica') ? 'selected' : '' ?>>
            Novela gráfica
        </option>

        <option value="Romance"
            <?= (($libro['genero'] ?? '') == 'Romance') ? 'selected' : '' ?>>
            Romance
        </option>

        <option value="Juvenil"
            <?= (($libro['genero'] ?? '') == 'Juvenil') ? 'selected' : '' ?>>
            Juvenil
        </option>

        <option value="Otro"
            <?= (($libro['genero'] ?? '') == 'Otro') ? 'selected' : '' ?>>
            Otro
        </option>

    </select>

    <br><br>

    <label>ISBN (opcional)</label><br>
    <input type="text"
           name="isbn"
           value="<?= htmlspecialchars($libro['isbn'] ?? '') ?>">
    <br><br>

    <label>Disponibilidad</label><br>

    <select name="disponible">

        <option value="1"
            <?= (($libro['disponible'] ?? '') == 1) ? 'selected' : '' ?>>
            Disponible
        </option>

        <option value="0"
            <?= (($libro['disponible'] ?? '') == 0) ? 'selected' : '' ?>>
            No disponible
        </option>

    </select>

    <br><br>

    <button type="submit">
        <?= isset($libro) && $libro ? 'Actualizar' : 'Guardar'; ?>
    </button>

    <a href="index.php">Cancelar</a>

</form>