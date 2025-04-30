<?php

function buscarProductoPorId($id){
    require_once(__DIR__."/../../modelo/dao/ProductoDAO.php");
    $dao = new ProductoDAO();
    $producto = $dao->buscarProductoPorId($id);
    return $producto;
}

function leerProductos(){
    require_once(__DIR__."/../../modelo/dao/ProductoDAO.php");
    $dao = new ProductoDAO();
    $productos = $dao->leerProductos();
    return $productos;
}

function insertarProducto($producto){
    require_once(__DIR__."/../../modelo/dao/ProductoDAO.php");
    $dao = new ProductoDAO();
    $resultado = $dao->insertarProducto($producto);
    return $resultado;
}

function modificarProducto($producto){
    require_once(__DIR__."/../../modelo/dao/ProductoDAO.php");
    $dao = new ProductoDAO();
    $resultado = $dao->modificarProducto($producto);
    return $resultado;
}

function borrarProducto($id){
    require_once(__DIR__."/../../modelo/dao/ProductoDAO.php");
    $dao = new ProductoDAO();
    $res = $dao->borrarProducto($id);
    return $res;
}