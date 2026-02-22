<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Editar Alumno</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h1 class="h4 mb-3">Editar Alumno</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <div><strong>No se pudo actualizar</strong></div>
            <div><?= esc(session()->getFlashdata('error')); ?></div>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('alumnos/update/' . $alumno['id']); ?>" method="post" class="mb-3">
        <div class="mb-3">
            <label class="form-label" for="codigo">Código</label>
            <input class="form-control" type="text" name="codigo" id="codigo" value="<?= esc(old('codigo') ?? $alumno['codigo']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="nombres">Nombres</label>
            <input class="form-control" type="text" name="nombres" id="nombres" value="<?= esc(old('nombres') ?? $alumno['nombres']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="apellidos">Apellidos</label>
            <input class="form-control" type="text" name="apellidos" id="apellidos" value="<?= esc(old('apellidos') ?? $alumno['apellidos']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="telefono">Teléfono</label>
            <input class="form-control" type="text" name="telefono" id="telefono" value="<?= esc(old('telefono') ?? $alumno['telefono']); ?>" required>
        </div>

        <button class="btn btn-success" type="submit">Guardar</button>
        <a class="btn btn-secondary" href="<?= base_url('alumnos'); ?>">Volver a lista</a>
    </form>
</body>
</html>
