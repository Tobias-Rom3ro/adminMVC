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

if(!$nombre || !$descripcion || !$precio) {
    $respuesta = [
        'type' => 'error',
        'msg' => 'Todos los campos son obligatorios'
    ];
    echo json_encode($respuesta);
    exit();
}

require_once (__DIR__."/../../modelo/entidad/Producto.php");

if($action == 'update') {
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

echo json_encode($respuesta);
?>