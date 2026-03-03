<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Horarios por Docente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>Listado de Materias por Docente</h2>
            <a href="<?= base_url('/alumnos') ?>" class="btn btn-primary">Volver al Listado Principal</a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('horarios/filtrar_docente') ?>" method="post" class="mb-4">
                <?= csrf_field() ?>
                <div class="form-row align-items-end">
                    <div class="col-md-8">
                        <label for="id_docente">Seleccionar Docente</label>
                        <select name="id_docente" id="id_docente" class="form-control" required>
                            <option value="">Seleccione un docente</option>
                            <?php foreach ($docentes as $docente): ?>
                                <option value="<?= esc($docente['id']) ?>" <?= (isset($docente_seleccionado) && $docente_seleccionado['id'] == $docente['id']) ? 'selected' : '' ?>>
                                    <?= esc($docente['nombres'] . ' ' . $docente['apellidos'])
                                    ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-info">Filtrar</button>
                    </div>
                </div>
            </form>

            <?php if (isset($docente_seleccionado)): ?>
                <h4 class="mt-4">Horarios para: <?= esc($docente_seleccionado['nombres'] . ' ' . $docente_seleccionado['apellidos']) ?></h4>
            <?php endif; ?>

            <table id="horariosTable" class="table table-striped table-bordered mt-4">
                <thead>
                <tr>
                    <th>Materia</th>
                    <th>Día 1</th>
                    <th>Día 2</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($horarios)): ?>
                    <?php foreach ($horarios as $horario): ?>
                        <tr>
                            <td><?= esc($horario['nombre_materia']) ?></td>
                            <td><?= esc($horario['dia_1']) ?></td>
                            <td><?= esc($horario['dia_2']) ?></td>
                            <td><?= esc($horario['hor-inicio']) ?></td>
                            <td><?= esc($horario['hora_fin']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay horarios asignados para el docente seleccionado o no se ha seleccionado un docente.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#horariosTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            },
            "responsive": true
        });
    });
</script>
</body>
</html>
