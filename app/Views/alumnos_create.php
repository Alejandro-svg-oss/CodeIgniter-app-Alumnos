<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Agregar Alumno</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h1 class="h4 mb-3">Agregar Alumno</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <div><strong>No se pudo guardar</strong></div>
            <div><?= esc(session()->getFlashdata('error')); ?></div>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('alumnos/store'); ?>" method="post" class="mb-3">
        <div class="mb-3">
            <label class="form-label" for="codigo">Código</label>
            <input class="form-control" type="text" name="codigo" id="codigo" value="<?= esc(old('codigo') ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="nombres">Nombres</label>
            <input class="form-control" type="text" name="nombres" id="nombres" value="<?= esc(old('nombres') ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="apellidos">Apellidos</label>
            <input class="form-control" type="text" name="apellidos" id="apellidos" value="<?= esc(old('apellidos') ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="telefono">Teléfono</label>
            <input class="form-control" type="text" name="telefono" id="telefono" value="<?= esc(old('telefono') ?? ''); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label" for="codigo_carrera">Carrera</label>
            <select class="form-control" name="codigo_carrera" id="codigo_carrera" required>
                <option value="">Seleccionar carrera</option>
                <?php foreach ($carreras as $carrera): ?>
                    <option value="<?= esc($carrera->codigo_carrera); ?>"
                        <?= old('codigo_carrera') == $carrera->codigo_carrera ? 'selected' : ''; ?>>
                        <?= esc($carrera->nombre_carrera); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="btn btn-success" type="submit">Guardar</button>
        <a class="btn btn-secondary" href="<?= base_url('alumnos'); ?>">Volver a lista</a>
    </form>
</body>
</html>
