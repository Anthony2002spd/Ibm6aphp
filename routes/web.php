<?php
session_start();

// Definir la ruta base de tu aplicación
$basePath = '/Ibm6aphp/public/';

// Obtener la URI de la solicitud
$requestUri = $_SERVER["REQUEST_URI"];

// Remover el prefijo basePath
$route = str_replace($basePath, '', $requestUri);
$route = strtok($route, '?'); // Quitar parámetros GET

// Array que mapea las rutas con los nombres de los controladores
$controllers = [
    'persona' => 'PersonaController',
    'direccion' => 'DireccionController',
    'estadocivil' => 'EstadoCivilController',
    'telefono' => 'TelefonoController',
    'sexo' => 'SexoController',
];

// Si no se especifica una ruta, mostrar el menú
if (empty($route)) {
    echo "<h1>Selecciona la tabla que deseas administrar:</h1>";
    echo "<ul>";
    foreach (array_keys($controllers) as $tableName) {
        echo "<li><a href='" . $basePath . $tableName . "'>" . ucfirst($tableName) . "</a></li>";
    }
    echo "</ul>";
} else {
    // Separar el segmento principal de la ruta (el nombre de la tabla)
    $segments = explode('/', $route);
    $tableName = $segments[0];

    // Verificar si existe un controlador para la tabla solicitada
    if (isset($controllers[$tableName])) {
        $controllerName = $controllers[$tableName];
        $controllerFile = '../app/controllers/' . $controllerName . '.php';

        // Incluir el archivo del controlador si existe
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controllerName();

            // Determinar la acción a ejecutar en el controlador
            $action = isset($segments[1]) ? $segments[1] : 'index';

            switch ($action) {
                case 'index':
                    $controller->index();
                    break;
                case 'edit':
                    if (isset($_GET['id' . $tableName])) {
                        $controller->edit($_GET['id' . $tableName]);
                    } else {
                        echo "Error: Falta el ID para editar.";
                    }
                    break;
                case 'eliminar':
                    if (isset($_GET['id' . $tableName])) {
                        $controller->eliminar($_GET['id' . $tableName]);
                    } else {
                        echo "Error: Falta el ID para eliminar.";
                    }
                    break;
                case 'delete':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $controller->delete();
                    }
                    break;
                case 'update':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $controller->update();
                    }
                    break;
                // Puedes agregar más casos para otras acciones (crear, ver, etc.)
                default:
                    echo "Error 404: Acción no encontrada en el controlador.";
                    break;
            }
        } else {
            echo "Error: No se encontró el archivo del controlador para " . $tableName . ".";
        }
    } else {
        echo "Error 404: Tabla no válida.";
    }
}
?>
