<?php

class usuarioModel extends Model
{
    public function obtenerUsuario()
    {
        return $this->_db->query("select *from usuario;")->fetchAll();
    }

    public function insertarUsuario($nombreUsuario, $clave, $rol)
    {
        $claveHash = password_hash($clave, PASSWORD_DEFAULT);

        $this->_db->prepare('insert into usuario(nombreUsuario, clave, rol)
            values(:nombreUsuario, :clave, :rol)')->execute(array(
                'nombreUsuario' => $nombreUsuario,
                'clave' => $claveHash,
                'rol' => $rol
            ));
    }
}
