<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Materias</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Materias</h1>
        <div>
            <a class="btn btn-secondary me-2" href="<?= base_url('alumnos'); ?>">Volver al panel</a>
            <a class="btn btn-primary" href="<?= base_url('materias/create'); ?>">Agregar materia</a>
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
                <th>Nombre</th>
                <th>Descripción</th>
                <th style="width: 150px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($materias)): ?>
                <?php foreach ($materias as $materia): ?>
                    <tr>
                        <td><?= esc($materia['nombre_materia']); ?></td>
                        <td><?= esc($materia['descripcion']); ?></td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="<?= base_url('materias/edit/' . $materia['id']); ?>">Editar</a>
                            <form action="<?= base_url('materias/delete/' . $materia['id']); ?>" method="post" class="d-inline" onsubmit="return confirm('¿Eliminar esta materia?');">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay materias cargadas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

