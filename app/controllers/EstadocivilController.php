<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/Ibm6aphp/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Ibm6aphp/app/models/Estadocivil.php';

class EstadoCivilController {
    private $estadoCivil;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->estadoCivil = new EstadoCivil($this->db);
    }

    // Mostrar todos los estados civiles
    public function index() {
        $estadosCiviles = $this->estadoCivil->read();
        require_once '../app/views/estadocivil/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo "Formulario recibido";  // Verificar si llega el formulario
            if (isset($_POST['nombre'])) {
                $this->estadoCivil->nombre = $_POST['nombre'];
                if ($this->estadoCivil->create()) {
                    echo "Estado civil creado exitosamente";
                    // Redirigir o mostrar un mensaje de éxito
                } else {
                    echo "Error al crear el estado civil";
                }
            } else {
                echo "Faltan datos";
            }
        } else {
            echo "Método incorrecto";  // Verificar que el formulario no se envíe con GET
        }
        die();  // Detener la ejecución para ver los mensajes
    }

    public function edit($idestadocivil) {
        $this->estadoCivil->idestadocivil = $idestadocivil;
        $estadoCivil = $this->estadoCivil->readOne();

        if (!$estadoCivil) {
            die("Error: No se encontró el registro.");
        }

        require_once '../app/views/estadocivil/edit.php';
    }

    public function eliminar($idestadocivil) {
        $this->estadoCivil->idestadocivil = $idestadocivil;
        $estadoCivil = $this->estadoCivil->readOne();

        if (!$estadoCivil) {
            die("Error: No se encontró el registro.");
        }

        require_once '../app/views/estadocivil/delete.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo "Formulario recibido";  // Verificar si llega el formulario
            if (isset($_POST['nombre'])) {
                $this->estadoCivil->nombre = $_POST['nombre'];
                $this->estadoCivil->idestadocivil = $_POST['idestadocivil'];
                if ($this->estadoCivil->update()) {
                    echo "Estado civil actualizado exitosamente";
                    // Redirigir o mostrar un mensaje de éxito
                } else {
                    echo "Error al actualizar el estado civil";
                }
            } else {
                echo "Faltan datos";
            }
        } else {
            echo "Método incorrecto";  // Verificar que el formulario no se envíe con GET
        }
        die();  // Detener la ejecución para ver los mensajes
    }

    // Eliminar un estado civil
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['idestadocivil'])) {
                $this->estadoCivil->idestadocivil = $_POST['idestadocivil'];
                if ($this->estadoCivil->delete()) {
                    echo "Estado civil borrado exitosamente";
                    die();
                    header('Location: index.php?msg=deleted');
                    exit;
                } else {
                    header('Location: index.php?msg=error');
                    exit;
                }
            } else {
                echo "Faltan datos";
            }
        } else {
            echo "Método incorrecto";  // Verificar que el formulario no se envíe con GET
        }
        die();  // Detener la ejecución para ver los mensajes
    }
}

// Manejo de la acción en la URL
if (isset($_GET['action'])) {
    $controller = new EstadoCivilController();

    switch ($_GET['action']) {
        case 'create':
            $controller->create();
            break;
        case 'update':
            $controller->update();
            break;
        case 'delete':
            $controller->delete();
            break;
        default:
            echo "Acción no válida.";
            break;
    }
} else {
    echo "No se especificó ninguna acción.";
}

?>