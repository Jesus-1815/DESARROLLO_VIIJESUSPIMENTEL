<?php

require_once 'clases.php';

$gestorBlog = new GestorBlog();
$gestorBlog->cargarEntradas();

$action = $_GET['action'] ?? 'list';
$mensaje = '';

// Manejo de las acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
            case 'edit':
                // Asegurarse de que el tipo esté definido
                if (!isset($_POST['tipo'])) {
                    $mensaje = "Error: Tipo de entrada no especificado.";
                    break;
                }

                // Recopilar la información del formulario
                $tipo = (int)$_POST['tipo'];
                $titulo = $_POST['titulo'] ?? null;
                $descripcion = $_POST['descripcion'] ?? null;

                // Información adicional para más columnas
                $titulo1 = $_POST['titulo1'] ?? null;
                $descripcion1 = $_POST['descripcion1'] ?? null;
                $titulo2 = $_POST['titulo2'] ?? null;
                $descripcion2 = $_POST['descripcion2'] ?? null;

                if ($_POST['action'] === 'add') {
                    // Crear una nueva entrada
                    if ($tipo === 1) {
                        $nuevaEntrada = new EntradaUnaColumna($titulo, $descripcion);
                    } elseif ($tipo === 2) {
                        $nuevaEntrada = new EntradaDosColumnas($titulo1, $descripcion1, $titulo2, $descripcion2);
                    } elseif ($tipo === 3) {
                        $nuevaEntrada = new EntradaTresColumnas($titulo1, $descripcion1, $titulo2, $descripcion2, $_POST['titulo3'], $_POST['descripcion3']);
                    }

                    // Agregar la nueva entrada
                    $gestorBlog->agregarEntrada($nuevaEntrada);
                    $mensaje = "Entrada añadida con éxito.";
                } elseif ($_POST['action'] === 'edit' && isset($_POST['id'])) {
                    // Editar una entrada existente
                    $entrada = $gestorBlog->obtenerEntrada($_POST['id']);
                    if ($entrada) {
                        if ($tipo === 1) {
                            $entrada->titulo = $titulo;
                            $entrada->descripcion = $descripcion;
                        } elseif ($tipo === 2) {
                            $entrada->titulo1 = $titulo1;
                            $entrada->descripcion1 = $descripcion1;
                            $entrada->titulo2 = $titulo2;
                            $entrada->descripcion2 = $descripcion2;
                        } elseif ($tipo === 3) {
                            $entrada->titulo1 = $titulo1;
                            $entrada->descripcion1 = $descripcion1;
                            $entrada->titulo2 = $titulo2;
                            $entrada->descripcion2 = $descripcion2;
                            $entrada->titulo3 = $_POST['titulo3'];
                            $entrada->descripcion3 = $_POST['descripcion3'];
                        }

                        $gestorBlog->editarEntrada($entrada);
                        $mensaje = "Entrada actualizada con éxito.";
                    } else {
                        $mensaje = "Error: Entrada no encontrada.";
                    }
                }
                $action = 'list';
                break;
        }
    }
}

if ($action === 'delete' && isset($_GET['id'])) {
    $gestorBlog->eliminarEntrada($_GET['id']);
    $mensaje = "Entrada eliminada con éxito.";
    $action = "list";
}

if (($action === 'move_up' || $action === 'move_down') && isset($_GET['id'])) {
    $gestorBlog->moverEntrada($_GET['id'], $action === 'move_up' ? 'up' : 'down');
    $mensaje = "Entrada reordenada con éxito.";
    $action = "list";
}

// Manejo básico de errores para parámetros inválidos
if (!in_array($action, ['list', 'add', 'edit', 'delete', 'move_up', 'move_down', 'view'])) {
    $mensaje = "Error: Acción no reconocida.";
    $action = 'list';
}

$entradas = $gestorBlog->obtenerEntradas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Gestor de Blog</h1>
        
        <?php if ($mensaje): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <nav class="mb-4">
            <a href="index.php?action=list" class="btn btn-primary">Listar Entradas</a>
            <a href="index.php?action=add" class="btn btn-success">Agregar Entrada</a>
            <a href="index.php?action=view" class="btn btn-info">Ver Blog</a>
        </nav>

        <?php if ($action === 'list'): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($entradas as $entrada): ?>
                        <tr>
                            <td><?php echo $entrada->id; ?></td>
                            <td><?php echo $entrada->obtenerDetallesEspecificos(); ?></td>
                            <td><?php echo $entrada->tipo; ?> columna(s)</td>
                            <td><?php echo $entrada->fecha_creacion; ?></td>
                            <td>
                                <a href="index.php?action=edit&id=<?php echo $entrada->id; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="index.php?action=delete&id=<?php echo $entrada->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta entrada?')">Eliminar</a>
                                <a href="index.php?action=move_up&id=<?php echo $entrada->id; ?>" class="btn btn-secondary btn-sm">▲</a>
                                <a href="index.php?action=move_down&id=<?php echo $entrada->id; ?>" class="btn btn-secondary btn-sm">▼</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="index.php?action=view" class="btn btn-primary">Ver Blog</a>
        
        <?php elseif ($action === 'add' || $action === 'edit'): ?>
    <?php
    $entradaEditar = null;
    if ($action === 'edit' && isset($_GET['id'])) {
        $entradaEditar = $gestorBlog->obtenerEntrada($_GET['id']);
    }
    ?>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="<?php echo $action; ?>">
        <?php if ($entradaEditar): ?>
            <input type="hidden" name="id" value="<?php echo $entradaEditar->id; ?>">
        <?php endif; ?>
        
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de Entrada</label>
            <select class="form-select" id="tipo" name="tipo" required>
                <option value="1" <?php echo $entradaEditar && $entradaEditar->tipo == 1 ? 'selected' : ''; ?>>1 Columna</option>
                <option value="2" <?php echo $entradaEditar && $entradaEditar->tipo == 2 ? 'selected' : ''; ?>>2 Columnas</option>
                <option value="3" <?php echo $entradaEditar && $entradaEditar->tipo == 3 ? 'selected' : ''; ?>>3 Columnas</option>
            </select>
        </div>

        <div id="campos-dinamicos">
            <!-- Los campos se generarán dinámicamente con JavaScript -->
        </div>

        <button type="submit" class="btn btn-primary"><?php echo $action === 'add' ? 'Agregar' : 'Actualizar'; ?> Entrada</button>
        <a href="index.php?action=list" class="btn btn-secondary">Volver al Listado</a>
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tipoSelect = document.getElementById('tipo');
        const camposDinamicos = document.getElementById('campos-dinamicos');

        const entradaEditar = <?php echo $entradaEditar ? json_encode($entradaEditar) : 'null'; ?>;

        function generarCampos() {
            const tipo = parseInt(tipoSelect.value);
            let campos = '';

            for (let i = 1; i <= tipo; i++) {
                const tituloKey = tipo === 1 ? 'titulo' : `titulo${i}`;
                const descripcionKey = tipo === 1 ? 'descripcion' : `descripcion${i}`;

                const tituloValue = entradaEditar ? (entradaEditar[tituloKey] || '') : '';
                const descripcionValue = entradaEditar ? (entradaEditar[];
                const descripcionKey] || '') : '';campos +=[];

    <div class="mb-3">
        <label for="titulo${i}" class="form-label">Título ${i}</label>
        <input type="text" class="form-control" id="titulo${i}" name="titulo${i}" value="${tituloValue}" required>
    </div>
    <div class="mb-3">
        <label for="descripcion${i}" class="form-label">Descripción ${i}</label>
        <textarea class="form-control" id="descripcion${i}" name="descripcion${i}" required>${descripcionValue}</textarea>
    </div>
`;
}

camposDinamicos.innerHTML = campos;
}

// Generar los campos iniciales cuando se carga la página
generarCampos();

tipoSelect.addEventListener('change', generarCampos);
});
</script>

<?php elseif ($action === 'view'): ?>
<h2>Blog</h2>
<div class="blog-entries">
<?php foreach ($entradas as $entrada): ?>
<div class="blog-entry">
    <h3><?php echo $entrada->obtenerDetallesEspecificos(); ?></h3>
    <p>Publicado el: <?php echo $entrada->fecha_creacion; ?></p>
    
    <?php if ($entrada instanceof EntradaUnaColumna): ?>
        <p><?php echo $entrada->descripcion; ?></p>
    <?php elseif ($entrada instanceof EntradaDosColumnas): ?>
        <div class="row">
            <div class="col">
                <h4><?php echo $entrada->titulo1; ?></h4>
                <p><?php echo $entrada->descripcion1; ?></p>
            </div>
            <div class="col">
                <h4><?php echo $entrada->titulo2; ?></h4>
                <p><?php echo $entrada->descripcion2; ?></p>
            </div>
        </div>
    <?php elseif ($entrada instanceof EntradaTresColumnas): ?>
        <div class="row">
            <div class="col">
                <h4><?php echo $entrada->titulo1; ?></h4>
                <p><?php echo $entrada->descripcion1; ?></p>
            </div>
            <div class="col">
                <h4><?php echo $entrada->titulo2; ?></h4>
                <p><?php echo $entrada->descripcion2; ?></p>
            </div>
            <div class="col">
                <h4><?php echo $entrada->titulo3; ?></h4>
                <p><?php echo $entrada->descripcion3; ?></p>
            </div>
        </div>
    <?php endif; ?>
</div>
<hr>
<?php endforeach; ?>
</div>
<?php endif; ?>
</div>
</body>
</html>
