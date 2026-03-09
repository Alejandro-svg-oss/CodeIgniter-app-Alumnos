<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Agregar Docente</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h1 class="h4 mb-3">Agregar Docente</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')); ?></div>
    <?php endif; ?>

    <form action="<?= base_url('docentes/store'); ?>" method="post" class="mb-3">
        <div class="mb-3">
            <label class="form-label" for="nombres">Nombres</label>
            <input class="form-control" type="text" name="nombres" id="nombres" value="<?= esc(old('nombres') ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="apellidos">Apellidos</label>
            <input class="form-control" type="text" name="apellidos" id="apellidos" value="<?= esc(old('apellidos') ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email" value="<?= esc(old('email') ?? ''); ?>" required>
        </div>

        <button class="btn btn-success" type="submit">Guardar</button>
        <a class="btn btn-secondary" href="<?= base_url('docentes'); ?>">Volver a lista</a>
    </form>
</body>
</html>

