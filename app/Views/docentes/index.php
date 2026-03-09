<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Docentes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Docentes</h1>
        <div>
            <a class="btn btn-secondary me-2" href="<?= base_url('alumnos'); ?>">Volver al panel</a>
            <a class="btn btn-primary" href="<?= base_url('docentes/create'); ?>">Agregar docente</a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')); ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')); ?></div>
    <?php endif; ?>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Email</th>
                <th style="width: 150px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($docentes)): ?>
                <?php foreach ($docentes as $docente): ?>
                    <tr>
                        <td><?= esc($docente['nombres']); ?></td>
                        <td><?= esc($docente['apellidos']); ?></td>
                        <td><?= esc($docente['email']); ?></td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="<?= base_url('docentes/edit/' . $docente['id']); ?>">Editar</a>
                            <form action="<?= base_url('docentes/delete/' . $docente['id']); ?>" method="post" class="d-inline" onsubmit="return confirm('¿Eliminar este docente?');">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay docentes cargados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

