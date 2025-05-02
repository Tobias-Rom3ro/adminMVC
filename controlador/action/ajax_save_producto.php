<?php
session_start();
require_once (__DIR__."/../mdb/mdbProducto.php");

// Obtener los datos enviados del formulario
$action = filter_input(INPUT_POST, 'action');
$id = filter_input(INPUT_POST, 'id');
$nombre = filter_input(INPUT_POST, 'nombre');
$descripcion = filter_input(INPUT_POST, 'descripcion');
$precio = filter_input(INPUT_POST, 'precio');

$respuesta = [];

// Validar que se hayan recibido los datos necesarios
if(!$nombre || !$descripcion || !$precio) {
    $respuesta = [
        'type' => 'error',
        'msg' => 'Todos los campos son obligatorios'
    ];
    echo json_encode($respuesta);
    exit();
}

require_once (__DIR__."/../../modelo/entidad/Producto.php");

// Determinar si es una actualización o inserción
if($action == 'update') {
    // Actualización
    $producto = new Producto($id, $nombre, $descripcion, $precio);
    $resultado = modificarProducto($producto);

    if($resultado > 0) {
        $respuesta = [
            'type' => 'success',
            'msg' => 'Producto actualizado correctamente'
        ];
    } else {
        $respuesta = [
            'type' => 'error',
            'msg' => 'Error al actualizar el producto'
        ];
    }
} else if($action == 'add') {
    // Inserción
    // Para inserción con autoincremento en la BD, usar NULL o 0 como ID
    $producto = new Producto(null, $nombre, $descripcion, $precio);
    $resultado = insertarProducto($producto);

    if($resultado > 0) {
        $respuesta = [
            'type' => 'success',
            'msg' => 'Producto agregado correctamente'
        ];
    } else {
        $respuesta = [
            'type' => 'error',
            'msg' => 'Error al agregar el producto'
        ];
    }
} else {
    $respuesta = [
        'type' => 'error',
        'msg' => 'Acción no válida'
    ];
}

// Enviar respuesta en formato JSON
echo json_encode($respuesta);
?>