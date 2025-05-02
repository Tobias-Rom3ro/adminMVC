<?php
require_once(__DIR__ . "/../controlador/mdb/mdbProducto.php");
require_once(__DIR__ . "/../modelo/entidad/Producto.php");

function testInsertarProducto($id, $nombre, $descripcion, $precio) {
    $producto = new Producto($id, $nombre, $descripcion, $precio);
    $resultado = insertarProducto($producto);

    echo "Producto a insertar: ID=$id, Nombre=$nombre, Descripción=$descripcion, Precio=$precio\n";
    echo "Resultado: " . ($resultado > 0 ? "ÉXITO" : "FALLO") . "\n";
    echo "\n";

    return $resultado;
}

function testLeerProductos() {
    $productos = leerProductos();
    $cantidad = count($productos);
    echo "Cantidad de productos encontrados: $cantidad\n";

    if ($cantidad > 0) {
        echo "Listado de productos:\n";
        foreach ($productos as $index => $producto) {
            echo ($index + 1) . ". ID: " . $producto->getId() .
                ", Nombre: " . $producto->getNombre() .
                ", Precio: " . $producto->getPrecio() . "\n";
        }
    }
    echo "\n";

    return $productos;
}

function testBuscarProductoPorId($id) {
    $producto = buscarProductoPorId($id);

    if ($producto != null) {
        echo "ÉXITO - Producto encontrado:\n";
        echo "ID: " . $producto->getId() . "\n";
        echo "Nombre: " . $producto->getNombre() . "\n";
        echo "Descripción: " . $producto->getDescripcion() . "\n";
        echo "Precio: " . $producto->getPrecio() . "\n";
    } else {
        echo "FALLO - Producto no encontrado\n";
    }
    echo "\n";

    return $producto;
}

function testModificarProducto($id, $nombre, $descripcion, $precio) {
    $productoExistente = buscarProductoPorId($id);
    if ($productoExistente == null) {
        echo "No se puede modificar: el producto con ID $id no existe\n";
        echo "\n";
        return 0;
    }

    echo "Producto original:\n";
    echo "ID: " . $productoExistente->getId() . "\n";
    echo "Nombre: " . $productoExistente->getNombre() . "\n";
    echo "Descripción: " . $productoExistente->getDescripcion() . "\n";
    echo "Precio: " . $productoExistente->getPrecio() . "\n";

    $productoModificado = new Producto($id, $nombre, $descripcion, $precio);
    $resultado = modificarProducto($productoModificado);

    echo "Datos a modificar: Nombre=$nombre, Descripción=$descripcion, Precio=$precio\n";
    echo "Resultado: " . ($resultado > 0 ? "ÉXITO" : "FALLO (No se hicieron cambios)") . "\n";

    if ($resultado > 0) {
        $productoActualizado = buscarProductoPorId($id);
        echo "Producto actualizado:\n";
        echo "ID: " . $productoActualizado->getId() . "\n";
        echo "Nombre: " . $productoActualizado->getNombre() . "\n";
        echo "Descripción: " . $productoActualizado->getDescripcion() . "\n";
        echo "Precio: " . $productoActualizado->getPrecio() . "\n";
    }
    echo "\n";

    return $resultado;
}

function testBorrarProducto($id) {
    $productoExistente = buscarProductoPorId($id);

    if ($productoExistente == null) {
        echo "No se puede eliminar: el producto con ID $id no existe\n";
        echo "\n";
        return 0;
    }

    echo "Producto a eliminar:\n";
    echo "ID: " . $productoExistente->getId() . "\n";
    echo "Nombre: " . $productoExistente->getNombre() . "\n";

    $resultado = borrarProducto($id);
    echo "Resultado: " . ($resultado > 0 ? "ÉXITO - Producto eliminado" : "FALLO - No se pudo eliminar") . "\n";
    echo "\n";

    return $resultado;
}

testLeerProductos();
testInsertarProducto(null, "Salchipapa", "salchipapa mediana", 30000);
//testBuscarProductoPorId(99);
//testModificarProducto(99, "Pizza", "pizza hawaiana", 10000);
//testBorrarProducto(99);
//testBuscarProductoPorId(99);