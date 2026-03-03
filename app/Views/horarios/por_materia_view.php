<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alumnos por Materia</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>Listado de Alumnos por Materia</h2>
            <a href="<?= base_url('/alumnos') ?>" class="btn btn-primary">Volver al Listado Principal</a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('horarios/filtrar_materia') ?>" method="post" class="mb-4">
                <?= csrf_field() ?>
                <div class="form-row align-items-end">
                    <div class="col-md-8">
                        <label for="id_materia">Seleccionar Materia</label>
                        <select name="id_materia" id="id_materia" class="form-control" required>
                            <option value="">Seleccione una materia</option>
                            <?php foreach ($materias as $materia): ?>
                                <option value="<?= esc($materia['id']) ?>" <?= (isset($materia_seleccionada) && $materia_seleccionada['id'] == $materia['id']) ? 'selected' : '' ?>>
                                    <?= esc($materia['nombre_materia'])
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

            <?php if (isset($materia_seleccionada)): ?>
                <h4 class="mt-4">Alumnos en: <?= esc($materia_seleccionada['nombre_materia']) ?></h4>
            <?php endif; ?>

            <table id="alumnosTable" class="table table-striped table-bordered mt-4">
                <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($alumnos)): ?>
                    <?php foreach ($alumnos as $alumno): ?>
                        <tr>
                            <td><?= esc($alumno['codigo']) ?></td>
                            <td><?= esc($alumno['nombres']) ?></td>
                            <td><?= esc($alumno['apellidos']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">No hay alumnos inscritos en la materia seleccionada o no se ha seleccionado una materia.</td>
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
        $('#alumnosTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            },
            "responsive": true
        });
    });
</script>
</body>
</html>
