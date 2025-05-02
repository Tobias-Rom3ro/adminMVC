<?php
session_start();
require_once (__DIR__."/../mdb/mdbProducto.php");

// Esta función es llamada por loadProducts() en productos.js (mediante GET)
$productos = leerProductos();
$listaProductos = [];

foreach($productos as $producto) {
    $prod = [
        'id' => $producto->getId(),
        'nombre' => $producto->getNombre(),
        'descripcion' => $producto->getDescripcion(),
        'precio' => $producto->getPrecio()
    ];
    array_push($listaProductos, $prod);
}

$respuesta = [
    'productos' => $listaProductos,
    'type' => 'success',
    'msg' => 'Lista de productos obtenida'
];

// Enviar respuesta en formato JSON
echo json_encode($respuesta);
?>