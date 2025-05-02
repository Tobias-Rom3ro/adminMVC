<?php
require_once ("DataSource.php");
require_once (__DIR__."/../entidad/Producto.php");

class ProductoDAO {

    public function buscarProductoPorId($id){
        $data_source = new DataSource();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM producto WHERE id = :id",
            array(':id'=>$id));
        $producto = null;
        if(count($data_table)==1){
            foreach($data_table as $indice => $valor){
                $producto = new Producto(
                    $data_table[$indice]["id"],
                    $data_table[$indice]["nombre"],
                    $data_table[$indice]["descripcion"],
                    $data_table[$indice]["precio"]
                );
            }
            return $producto;
        }else{
            return null;
        }
    }

    public function leerProductos(){
        $data_source = new DataSource();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM producto ORDER BY id ASC");
        $producto = null;
        $productos = array();
        foreach($data_table as $indice => $valor){
            $producto = new Producto(
                $data_table[$indice]["id"],
                $data_table[$indice]["nombre"],
                $data_table[$indice]["descripcion"],
                $data_table[$indice]["precio"]
            );
            array_push($productos, $producto);
        }
        return $productos;
    }

    public function insertarProducto(Producto $producto){
        $data_source = new DataSource();
        $sql = "INSERT INTO producto VALUES (:id, :nombre, :descripcion, :precio)";
        $resultado = $data_source->ejecutarActualizacion($sql, array(
                ':id'=>$producto->getId(),
                ':nombre'=>$producto->getNombre(),
                ':descripcion'=>$producto->getDescripcion(),
                ':precio'=>$producto->getPrecio()
            )
        );
        return $resultado;
    }

    public function modificarProducto(Producto $producto){
        $data_source = new DataSource();
        $sql = "UPDATE producto SET nombre= :nombre, "
            . " descripcion= :descripcion, "
            . " precio= :precio "
            . " WHERE id= :id ";
        $resultado = $data_source->ejecutarActualizacion($sql, array(
                ':nombre'=>$producto->getNombre(),
                ':descripcion'=>$producto->getDescripcion(),
                ':precio'=>$producto->getPrecio(),
                ':id'=>$producto->getId()
            )
        );

        return $resultado;
    }

    public function borrarProducto($id){
        $data_source = new DataSource();
        $producto = $this->buscarProductoPorId($id);
        $resultado = $data_source->ejecutarActualizacion("DELETE FROM producto WHERE id = :id", array(':id'=>$id));

        return $resultado;
    }

}