<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Listado de Alumnos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
</head>
<body class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Alumnos</h1>
        <a class="btn btn-primary" href="<?= base_url('alumnos/create'); ?>">Agregar alumno</a>
        <a class="btn btn-info" href="<?= base_url('alumnos_carrera'); ?>">Buscar por Carrera</a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= esc(session()->getFlashdata('error')); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($dbError)): ?>
        <div class="alert alert-danger">
            <div><strong>Error de base de datos</strong></div>
            <div><?= esc($dbError); ?></div>
        </div>
    <?php endif; ?>

    <table id="alumnosTable" class="table table-striped">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Teléfono</th>
                <th style="width: 140px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($alumnos)): ?>
                <?php foreach ($alumnos as $alumno): ?>
                    <tr>
                        <td><?= esc($alumno['codigo']); ?></td>
                        <td><?= esc($alumno['nombres']); ?></td>
                        <td><?= esc($alumno['apellidos']); ?></td>
                        <td><?= esc($alumno['telefono']); ?></td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="<?= base_url('alumnos/edit/' . $alumno['id']); ?>">Editar</a>
                            <form action="<?= base_url('alumnos/delete/' . $alumno['id']); ?>" method="post" class="d-inline" onsubmit="return confirm('¿Está seguro que desea eliminar este registro?');">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No hay alumnos cargados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script>
        $(function () {
            $('#alumnosTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
                }
            });
        });
    </script>
</body>
</html>
