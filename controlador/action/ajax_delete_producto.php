<?php
session_start();
require_once (__DIR__."/../mdb/mdbProducto.php");

$id = filter_input(INPUT_POST, 'id');
$respuesta = [];

if($id) {
    $resultado = borrarProducto($id);

    if($resultado > 0) {
        $respuesta = [
            'type' => 'success',
            'msg' => 'Producto eliminado correctamente'
        ];
    } else {
        $respuesta = [
            'type' => 'error',
            'msg' => 'Error al eliminar el producto'
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