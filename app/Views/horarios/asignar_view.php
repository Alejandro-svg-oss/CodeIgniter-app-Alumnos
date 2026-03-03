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
            <a href="<?= base_url('/alumnos') ?>" class="btn btn-primary">Volver al Listado Principal</a>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('horarios/guardar') ?>" method="post">
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
                        <div class="form-group">
                            <label for="dia_1">Día 1</label>
                            <select name="dia_1" id="dia_1" class="form-control" required>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miércoles">Miércoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                                <option value="Sábado">Sábado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dia_2">Día 2</label>
                            <select name="dia_2" id="dia_2" class="form-control">
                                <option value="">(Opcional)</option>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miércoles">Miércoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                                <option value="Sábado">Sábado</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hor-inicio">Hora de Inicio</label>
                            <input type="time" name="hor-inicio" id="hor-inicio" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hora_fin">Hora de Fin</label>
                            <input type="time" name="hora_fin" id="hora_fin" class="form-control" required>
                        </div>
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
</body>
</html>
