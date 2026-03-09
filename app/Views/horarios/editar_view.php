<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Editar Asignación de Horario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>Editar Asignación de Horario</h2>
            <a href="<?= base_url('horarios/por_docente'); ?>" class="btn btn-secondary">Volver</a>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= esc(session()->getFlashdata('success')); ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')); ?></div>
            <?php endif; ?>

            <form action="<?= base_url('horarios/actualizar/' . $horario['id']); ?>" method="post" id="formEditarHorario">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="id_docente">Docente</label>
                    <select name="id_docente" id="id_docente" class="form-control" required>
                        <?php foreach ($docentes as $docente): ?>
                            <option value="<?= esc($docente['id']); ?>" <?= ($docente['id'] == (old('id_docente') ?? $horario['id_docente'])) ? 'selected' : ''; ?>>
                                <?= esc($docente['nombres'] . ' ' . $docente['apellidos']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_materia">Materia</label>
                    <select name="id_materia" id="id_materia" class="form-control" required>
                        <?php foreach ($materias as $materia): ?>
                            <option value="<?= esc($materia['id']); ?>" <?= ($materia['id'] == (old('id_materia') ?? $horario['id_materia'])) ? 'selected' : ''; ?>>
                                <?= esc($materia['nombre_materia']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php
                $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                $dia1 = old('dia_1') ?? $horario['dia_1'] ?? '';
                $dia2 = old('dia_2') ?? $horario['dia_2'] ?? '';
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dia_1">Día 1</label>
                            <select name="dia_1" id="dia_1" class="form-control" required>
                                <?php foreach ($dias as $d): ?>
                                    <option value="<?= esc($d); ?>" <?= ($dia1 === $d) ? 'selected' : ''; ?>><?= esc($d); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dia_2">Día 2</label>
                            <select name="dia_2" id="dia_2" class="form-control">
                                <option value="">(Opcional)</option>
                                <?php foreach ($dias as $d): ?>
                                    <option value="<?= esc($d); ?>" <?= ($dia2 === $d) ? 'selected' : ''; ?>><?= esc($d); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hora_inicio">Hora de Inicio</label>
                            <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="<?= esc(old('hora_inicio') ?? $horario['hora_inicio']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hora_fin">Hora de Fin</label>
                            <input type="time" name="hora_fin" id="hora_fin" class="form-control" value="<?= esc(old('hora_fin') ?? $horario['hora_fin']); ?>" required>
                            <small class="form-text text-muted">Mediodía = 12:00. Medianoche = 00:00.</small>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Guardar cambios</button>
            </form>
        </div>
    </div>
</div>
<script>
document.getElementById('formEditarHorario').addEventListener('submit', function(e) {
    var inicio = document.getElementById('hora_inicio').value;
    var fin = document.getElementById('hora_fin').value;
    if (inicio && fin && fin <= inicio) {
        e.preventDefault();
        alert('La hora de fin debe ser posterior a la hora de inicio.\nMediodía = 12:00. Medianoche = 00:00.');
        return false;
    }
});
</script>
</body>
</html>

