<?php
// Incluir el archivo que contiene las clases y la interfaz
require_once 'Clases.php';

// Crear una instancia del GestorTareas
$gestor = new GestorTareas();

// Manejar la acción solicitada (agregar, editar, eliminar, cambiar estado)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener la acción
    $accion = $_POST['accion'] ?? '';

    switch ($accion) {
        case 'agregar':
            // Crear una tarea según el tipo
            $tipo = $_POST['tipo'];
            $id = uniqid(); // Generar un ID único
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $prioridad = $_POST['prioridad'];
            $fechaCreacion = date('Y-m-d'); // Fecha actual

            switch ($tipo) {
                case 'desarrollo':
                    $lenguaje = $_POST['lenguaje'] ?? ''; // Valor por defecto si no se envía
                    $tarea = new TareaDesarrollo($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion, $lenguaje);
                    break;
                case 'diseno':
                    $herramienta = $_POST['herramienta'] ?? ''; // Valor por defecto
                    $tarea = new TareaDiseno($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion, $herramienta);
                    break;
                case 'testing':
                    $tipoTest = $_POST['tipoTest'] ?? ''; // Valor por defecto
                    $tarea = new TareaTesting($id, $titulo, $descripcion, $estado, $prioridad, $fechaCreacion, $tipoTest);
                    break;
            }
            $gestor->agregarTarea($tarea);
            break;

        case 'eliminar':
            $gestor->eliminarTarea($_POST['id']);
            break;

        case 'actualizar':
            $tarea = $gestor->buscarTareaPorId($_POST['id']);
            if ($tarea) {
                $tarea->setTitulo($_POST['titulo']);
                $tarea->setDescripcion($_POST['descripcion']);
                $tarea->setEstado($_POST['estado']);
                $tarea->setPrioridad($_POST['prioridad']);
                $gestor->actualizarTarea($tarea);
            }
            break;

        case 'cambiar_estado':
            $gestor->actualizarEstadoTarea($_POST['id'], $_POST['nuevoEstado']);
            break;
    }
}

// Listar las tareas
$tareas = $gestor->listarTareas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Tareas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Gestor de Tareas</h1>

        <!-- Formulario para agregar tarea -->
        <form action="" method="POST">
            <input type="hidden" name="accion" value="agregar">
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" class="form-control" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" name="descripcion" required></textarea>
            </div>
            <div class="form-group">
                <label for="estado">Estado</label>
                <select class="form-control" name="estado" required>
                    <option value="pendiente">Pendiente</option>
                    <option value="en_progreso">En Progreso</option>
                    <option value="completada">Completada</option>
                </select>
            </div>
            <div class="form-group">
                <label for="prioridad">Prioridad</label>
                <select class="form-control" name="prioridad" required>
                    <option value="1">Alta</option>
                    <option value="2">Media alta</option>
                    <option value="3">Media</option>
                    <option value="4">Media baja</option>
                    <option value="5">Baja</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo de Tarea</label>
                <select class="form-control" name="tipo" required>
                    <option value="desarrollo">Desarrollo</option>
                    <option value="diseno">Diseño</option>
                    <option value="testing">Testing</option>
                </select>
            </div>
            <div class="form-group" id="especifico">
                <!-- Campos específicos por tipo de tarea -->
                <label for="lenguaje">Lenguaje de Programación (solo para desarrollo)</label>
                <input type="text" class="form-control" name="lenguaje">
                <label for="herramienta">Herramienta de Diseño (solo para diseño)</label>
                <input type="text" class="form-control" name="herramienta">
                <label for="tipoTest">Tipo de Test (solo para testing)</label>
                <select class="form-control" name="tipoTest">
                    <option value="unitario">Unitario</option>
                    <option value="integracion">Integración</option>
                    <option value="e2e">E2E</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Tarea</button>
        </form>

        <!-- Tabla para listar tareas -->
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                    <th>Detalles Específicos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tareas as $tarea): ?>
                <tr>
                    <td><?= $tarea->getTitulo() ?></td>
                    <td><?= $tarea->getDescripcion() ?></td>
                    <td><?= $tarea->getEstado() ?></td>
                    <td><?= $tarea->getPrioridad() ?></td>
                    <td><?= $tarea->obtenerDetallesEspecificos() ?></td>
                    <td>
                        <form action="" method="POST" style="display:inline;">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id" value="<?= $tarea->getId() ?>">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                        <form action="" method="POST" style="display:inline;">
                            <input type="hidden" name="accion" value="cambiar_estado">
                            <input type="hidden" name="id" value="<?= $tarea->getId() ?>">
                            <input type="hidden" name="nuevoEstado" value="<?= $tarea->getEstado() === 'completada' ? 'en_progreso' : 'completada' ?>">
                            <button type="submit" class="btn btn-warning">Cambiar Estado</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Script para manejar la visibilidad de los campos específicos por tipo de tarea
        document.querySelector('select[name="tipo"]').addEventListener('change', function() {
            const tipo = this.value;
            const especifico = document.getElementById('especifico');
            especifico.style.display = tipo === 'desarrollo' ? 'block' : 'none';
            especifico.style.display = tipo === 'diseno' ? 'block' : 'none';
            especifico.style.display = tipo === 'testing' ? 'block' : 'none';
        });
    </script>
</body>
</html>

