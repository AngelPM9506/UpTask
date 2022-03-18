<?php 

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareaController{
    public static function index(){
        session_start();
        $proyectoId = s($_GET['item']);
        if (!$proyectoId) {
            header('Location: /');
        }
        $proyecto = Proyecto::where('url', $proyectoId);
        if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /404');
        }
        $tareas = Tarea::belongsTo('proyectoId', $proyecto->id);
        echo json_encode(['tareas' => $tareas]);
    }
    public static function crear(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $proyectoId = $_POST['proyectoId'];
            $proyecto = Proyecto::where('url', $proyectoId);
            if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error', 
                    'mensaje' => 'Hubo un error al agregar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            }
            //echo json_encode($proyecto);
            /**Instanciar y crear la tarea  */
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();
            if ($resultado['resultado']) {
                $respuesta = [
                    'tipo' => 'exito', 
                    'id' => $resultado['id'],
                    'mensaje' => 'Tarea añadida exitosamente',
                    'proyectoId' => $proyecto->id
                ];
            }else{
                $respuesta = [
                    'tipo' => 'error', 
                    'mensaje' => 'La tarea no se pudo guardar'
                ];
            }
            echo json_encode($respuesta);
        }
    }
    public static function actualizar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            /**Validar que el proyecto exista */
            $proyecto = Proyecto::where('url', $_POST['proyectoId']);
            if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Estatus de tarea No actualizada'
                ];
                echo json_encode($respuesta);
                return;
            }
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();
            if ($resultado) {
                $respuesta = [
                    'tipo' => 'exito', 
                    'id' => $tarea->id,
                    'proyectoId' => $proyecto->id,
                    'mensaje' => 'Estatus de tarea actualizado correctamente'
                ];
                echo json_encode(['respuesta' => $respuesta]);
            }
        }
    }
    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            /**Validar que el proyecto exista */
            $proyecto = Proyecto::where('url', $_POST['proyectoId']);
            if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Estatus de tarea No actualizada'
                ];
                echo json_encode($respuesta);
                return;
            }
            $tarea = new Tarea($_POST);
            $resultado = $tarea->eliminar();
            if ($resultado) {
                $resultado = [
                    'resultado' => $resultado,
                    'mensaje' => 'Eliminado correctamente',
                    'tipo' => 'exito'
                ];
            } else {
                $resultado = [
                    'resultado' => $resultado,
                    'mensaje' => 'Algo salio mal, la tarea no se eliminó',
                    'tipo' => 'error'
                ];
            }
            
            echo json_encode($resultado);
        }
    }
}