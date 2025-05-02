<?php
session_start();
require_once (__DIR__."/../mdb/mdbProducto.php");

$id = filter_input(INPUT_GET, 'id');
$respuesta = [];

if($id) {
    $producto = buscarProductoPorId($id);

    if($producto != null) {
        $respuesta = [
            'type' => 'success',
            'msg' => 'Producto encontrado',
            'producto' => [
                'id' => $producto->getId(),
                'nombre' => $producto->getNombre(),
                'descripcion' => $producto->getDescripcion(),
                'precio' => $producto->getPrecio()
            ]
        ];
    } else {
        $respuesta = [
            'type' => 'error',
            'msg' => 'Producto no encontrado'
        ];
    }
} else {
    $respuesta = [
        'type' => 'error',
        'msg' => 'ID de producto no proporcionado'
    ];
}

echo json_encode($respuesta);
?>