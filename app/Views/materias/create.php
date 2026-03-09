<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Agregar Materia</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h1 class="h4 mb-3">Agregar Materia</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')); ?></div>
    <?php endif; ?>

    <form action="<?= base_url('materias/store'); ?>" method="post" class="mb-3">
        <div class="mb-3">
            <label class="form-label" for="nombre_materia">Nombre de la materia</label>
            <input class="form-control" type="text" name="nombre_materia" id="nombre_materia" value="<?= esc(old('nombre_materia') ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="descripcion">Descripción</label>
            <textarea class="form-control" name="descripcion" id="descripcion" rows="3"><?= esc(old('descripcion') ?? ''); ?></textarea>
        </div>

        <button class="btn btn-success" type="submit">Guardar</button>
        <a class="btn btn-secondary" href="<?= base_url('materias'); ?>">Volver a lista</a>
    </form>
</body>
</html>

