<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Materia a Docente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>Asignar Materia a Docente</h2>
            <a href="<?= base_url('/alumnos') ?>" class="btn btn-primary">Volver al Panel Principal</a>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= esc(session()->getFlashdata('success')); ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')); ?></div>
            <?php endif; ?>
            <?php if (empty($docentes) || empty($materias)): ?>
                <div class="alert alert-warning">
                    Para asignar una materia debe existir al menos un docente y una materia.
                    <a href="<?= base_url('docentes'); ?>">Gestionar docentes</a> |
                    <a href="<?= base_url('materias'); ?>">Gestionar materias</a>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('horarios/guardar') ?>" method="post" id="formAsignar">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="id_docente">Docente</label>
                    <select name="id_docente" id="id_docente" class="form-control" required>
                        <option value="">Seleccionar Docente</option>
                        <?php foreach ($docentes as $docente): ?>
                            <option value="<?= esc($docente['id']) ?>"><?= esc($docente['nombres'] . ' ' . $docente['apellidos']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_materia">Materia</label>
                    <select name="id_materia" id="id_materia" class="form-control" required>
                        <option value="">Seleccionar Materia</option>
                        <?php foreach ($materias as $materia): ?>
                            <option value="<?= esc($materia['id']) ?>"><?= esc($materia['nombre_materia']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <fieldset class="border p-3">
                            <legend class="w-auto px-2">Día 1</legend>
                            <div class="form-group">
                                <label for="dia_1">Día</label>
                                <select name="dia_1" id="dia_1" class="form-control" required>
                                    <option value="Lunes">Lunes</option>
                                    <option value="Martes">Martes</option>
                                    <option value="Miércoles">Miércoles</option>
                                    <option value="Jueves">Jueves</option>
                                    <option value="Viernes">Viernes</option>
                                    <option value="Sábado">Sábado</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="hora_inicio_1">Hora de inicio</label>
                                <input type="time" name="hora_inicio_1" id="hora_inicio_1" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="hora_fin_1">Hora de fin</label>
                                <input type="time" name="hora_fin_1" id="hora_fin_1" class="form-control" required>
                                <small class="form-text text-muted">Mediodía = 12:00. Medianoche = 00:00.</small>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="border p-3">
                            <legend class="w-auto px-2">Día 2 (opcional)</legend>
                            <div class="form-group">
                                <label for="dia_2">Día</label>
                                <select name="dia_2" id="dia_2" class="form-control">
                                    <option value="">(Sin segundo día)</option>
                                    <option value="Lunes">Lunes</option>
                                    <option value="Martes">Martes</option>
                                    <option value="Miércoles">Miércoles</option>
                                    <option value="Jueves">Jueves</option>
                                    <option value="Viernes">Viernes</option>
                                    <option value="Sábado">Sábado</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="hora_inicio_2">Hora de inicio (día 2)</label>
                                <input type="time" name="hora_inicio_2" id="hora_inicio_2" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="hora_fin_2">Hora de fin (día 2)</label>
                                <input type="time" name="hora_fin_2" id="hora_fin_2" class="form-control">
                                <small class="form-text text-muted">Si no selecciona hora para el día 2, no se creará horario para ese día.</small>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Guardar Asignación</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
document.getElementById('formAsignar').addEventListener('submit', function(e) {
    var inicio1 = document.getElementById('hora_inicio_1').value;
    var fin1 = document.getElementById('hora_fin_1').value;
    var dia2 = document.getElementById('dia_2').value;
    var inicio2 = document.getElementById('hora_inicio_2').value;
    var fin2 = document.getElementById('hora_fin_2').value;

    if (inicio1 && fin1 && fin1 <= inicio1) {
        e.preventDefault();
        alert('En el Día 1, la hora de fin debe ser posterior a la hora de inicio.\nMediodía = 12:00. Medianoche = 00:00.');
        return false;
    }

    if (dia2) {
        if (!inicio2 || !fin2) {
            e.preventDefault();
            alert('Si selecciona un Día 2 debe indicar hora de inicio y fin para ese día.');
            return false;
        }
        if (fin2 <= inicio2) {
            e.preventDefault();
            alert('En el Día 2, la hora de fin debe ser posterior a la hora de inicio.\nMediodía = 12:00. Medianoche = 00:00.');
            return false;
        }
    }
});
</script>
</body>
</html>
