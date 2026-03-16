<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscripción de materias por alumno</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4">Inscripción de materias por alumno</h1>

    <?php if (! empty($error)) : ?>
        <div class="alert alert-danger"><?= esc($error) ?></div>
    <?php endif; ?>

    <?php if (! empty($mensaje)) : ?>
        <div class="alert alert-success"><?= esc($mensaje) ?></div>
    <?php endif; ?>

    <form action="<?= base_url('inscripciones/guardar') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="id_alumno">Alumno</label>
            <select name="id_alumno" id="id_alumno" class="form-control" required>
                <option value="">Seleccione un alumno</option>
                <?php foreach ($alumnos as $alumno): ?>
                    <option value="<?= esc($alumno['id']) ?>">
                        <?= esc($alumno['nombres'] . ' ' . $alumno['apellidos']) ?> (<?= esc($alumno['codigo']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Materias (máximo 5 en total por alumno)</label>
            <?php foreach ($materias as $materia): ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="id_materia[]" id="materia_<?= esc($materia['id']) ?>" value="<?= esc($materia['id']) ?>">
                    <label class="form-check-label" for="materia_<?= esc($materia['id']) ?>">
                        <?= esc($materia['nombre_materia']) ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="submit" class="btn btn-primary">Inscribir</button>
        <a href="<?= base_url('alumnos') ?>" class="btn btn-secondary">Volver</a>
    </form>

    <hr class="my-4">

    <h2>Materias inscritas por alumno</h2>

    <div class="form-group">
        <label for="id_alumno_listado">Alumno</label>
        <select id="id_alumno_listado" class="form-control">
            <option value="">Seleccione un alumno</option>
            <?php foreach ($alumnos as $alumno): ?>
                <option value="<?= esc($alumno['id']) ?>">
                    <?= esc($alumno['nombres'] . ' ' . $alumno['apellidos']) ?> (<?= esc($alumno['codigo']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div id="materias-alumno-contenedor">
        <!-- Aquí se cargará dinámicamente la lista de materias -->
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $('#id_alumno_listado').on('change', function () {
        const idAlumno = $(this).val();
        $('#materias-alumno-contenedor').html('');

        if (!idAlumno) {
            return;
        }

        $.getJSON('<?= base_url('inscripciones/materias_alumno') ?>/' + idAlumno, function (data) {
            if (!data || data.length === 0) {
                $('#materias-alumno-contenedor').html('<div class="alert alert-info">El alumno no tiene materias inscritas.</div>');
                return;
            }

            let html = '<table class="table table-bordered mt-3"><thead><tr><th>Materia</th></tr></thead><tbody>';
            data.forEach(function (item) {
                html += '<tr><td>' + item.nombre_materia + '</td></tr>';
            });
            html += '</tbody></table>';

            $('#materias-alumno-contenedor').html(html);
        });
    });
</script>
</body>
</html>

