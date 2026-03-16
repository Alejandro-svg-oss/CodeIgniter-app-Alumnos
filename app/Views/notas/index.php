<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de notas por materia</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4">Gestión de notas por materia</h1>

    <?php if (! empty($error)) : ?>
        <div class="alert alert-danger"><?= esc($error) ?></div>
    <?php endif; ?>

    <?php if (! empty($mensaje)) : ?>
        <div class="alert alert-success"><?= esc($mensaje) ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="id_materia">Materia</label>
                <select id="id_materia" class="form-control">
                    <option value="">Seleccione una materia</option>
                    <?php foreach ($materias as $materia): ?>
                        <option value="<?= esc($materia['id']) ?>">
                            <?= esc($materia['nombre_materia']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="periodo">Período</label>
                <select id="periodo" class="form-control">
                    <option value="1">Período 1</option>
                    <option value="2">Período 2</option>
                    <option value="3">Período 3</option>
                    <option value="4">Período 4</option>
                </select>
            </div>
        </div>
    </div>

    <form id="form-notas" action="<?= base_url('notas/guardar') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="periodo" id="input_periodo" value="1">
        <div id="alumnos-materia-contenedor">
            <!-- Aquí se cargará la lista de alumnos y notas -->
        </div>
        <button type="submit" class="btn btn-primary mt-3" style="display: none;" id="btn-guardar-notas">Guardar</button>
    </form>

    <a href="<?= base_url('alumnos') ?>" class="btn btn-secondary mt-3">Volver</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    function cargarNotas() {
        const idMateria = $('#id_materia').val();
        const periodo = $('#periodo').val();

        $('#alumnos-materia-contenedor').html('');
        $('#btn-guardar-notas').hide();
        $('#input_periodo').val(periodo);

        if (!idMateria) {
            return;
        }

        $.getJSON('<?= base_url('notas/por_materia') ?>/' + idMateria + '?periodo=' + periodo, function (response) {
            if (!response || !response.alumnos || response.alumnos.length === 0) {
                $('#alumnos-materia-contenedor').html('<div class="alert alert-info">No hay estudiantes inscritos en esta materia.</div>');
                return;
            }

            const alumnos = response.alumnos;

            let html = '<table class="table table-bordered mt-3"><thead><tr>' +
                '<th>Código</th><th>Nombre</th><th>Lab</th><th>Parcial</th></tr></thead><tbody>';

            alumnos.forEach(function (item) {
                const idMatricula = item.id_matricula;
                html += '<tr>' +
                    '<td>' + item.codigo + '</td>' +
                    '<td>' + item.nombres + ' ' + item.apellidos + '</td>' +
                    '<td><input type="number" step="0.01" min="0" max="10" name="lab[' + idMatricula + ']" class="form-control" value="' + (item.lab !== null ? item.lab : '') + '"></td>' +
                    '<td><input type="number" step="0.01" min="0" max="10" name="parcial[' + idMatricula + ']" class="form-control" value="' + (item.parcial !== null ? item.parcial : '') + '"></td>' +
                    '<input type="hidden" name="id_matricula[]" value="' + idMatricula + '">' +
                    '</tr>';
            });

            html += '</tbody></table>';
            $('#alumnos-materia-contenedor').html(html);
            $('#btn-guardar-notas').show();
        });
    }

    $('#id_materia').on('change', cargarNotas);
    $('#periodo').on('change', function () {
        if ($('#id_materia').val()) {
            cargarNotas();
        }
    });
</script>
</body>
</html>

