<h1>Catálogo de Libros</h1>
<?php
/** @var array $resumen */
/** @var array $generos */
/** @var array $libros */
?>
<p>
    <strong>Total de libros:</strong> <?= $resumen['total']; ?> |
    <strong>Disponibles:</strong> <?= $resumen['disponibles']; ?> |
    <strong>No disponibles:</strong> <?= $resumen['no_disponibles']; ?>
</p>

<form method="GET">

    <input type="hidden" name="accion" value="listar">

    <label>Filtrar por género:</label>

    <select name="genero">

        <option value="">Todos</option>

        <?php foreach ($generos as $g): ?>

            <option
                value="<?= htmlspecialchars($g['genero']) ?>"
                <?= (($_GET['genero'] ?? '') == $g['genero']) ? 'selected' : '' ?>>

                <?= htmlspecialchars($g['genero']) ?>

            </option>

        <?php endforeach; ?>

    </select>

    <button type="submit">Filtrar</button>

</form>

<br>

<a href="index.php?accion=crear">
    Registrar Libro
</a>

<br><br>

<table border="1" cellpadding="8">

    <thead>

        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Año</th>
            <th>Género</th>
            <th>ISBN</th>
            <th>Disponibilidad</th>
            <th>Acciones</th>
        </tr>

    </thead>

    <tbody>

        <?php if (count($libros) > 0): ?>

            <?php foreach ($libros as $libro): ?>

                <tr>

                    <td><?= htmlspecialchars($libro['titulo']) ?></td>

                    <td><?= htmlspecialchars($libro['autor']) ?></td>

                    <td><?= htmlspecialchars($libro['anio_publicacion']) ?></td>

                    <td><?= htmlspecialchars($libro['genero']) ?></td>

                    <td>

                        <?= htmlspecialchars($libro['isbn'] ?? 'Sin ISBN') ?>

                    </td>

                    <td>

                        <?= $libro['disponible'] ? 'Disponible' : 'No disponible'; ?>

                    </td>

                    <td>

                        <a href="index.php?accion=editar&id=<?= $libro['id'] ?>">
                            Editar
                        </a>

                        |

                        <form
                            method="POST"
                            action="index.php?accion=eliminar"
                            style="display:inline;"
                            onsubmit="return confirm('¿Desea eliminar este libro?');">

                            <input
                                type="hidden"
                                name="id"
                                value="<?= $libro['id'] ?>">

                            <button type="submit">
                                Eliminar
                            </button>

                        </form>

                    </td>

                </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>

                <td colspan="7">

                    No hay libros registrados.

                </td>

            </tr>

        <?php endif; ?>

    </tbody>

</table>