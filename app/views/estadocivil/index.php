<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listas de los Estados Civiles</title>
    <link rel="stylesheet" href="/Ibm6aphp/public/css/style.css">
</head>
<body>

<div class="container">
    <h1>Listas de los Estados Civiles</h1>
    <a href="/Ibm6aphp/app/views/estadocivil/create.php"><button>Agregar</button></a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($estadosCiviles) && is_array($estadosCiviles)): ?>
                <?php foreach ($estadosCiviles as $estadoCivil): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($estadoCivil['idestadocivil']); ?></td>
                        <td><?php echo htmlspecialchars($estadoCivil['nombre']); ?></td>
                        <td>
                            <a href="/Ibm6aphp/public/estadocivil/edit?idestadocivil=<?php echo htmlspecialchars($estadoCivil['idestadocivil']); ?>">
                                <button>Editar</button>
                            </a>
                            <a href="/Ibm6aphp/public/estadocivil/eliminar?idestadocivil=<?php echo htmlspecialchars($estadoCivil['idestadocivil']); ?>"
                               onclick="return confirm('¿Estás seguro de eliminar este registro?');">
                                <button>Eliminar</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay registros disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="/Ibm6aphp/public/js/script.js"></script>
</body>
</html>