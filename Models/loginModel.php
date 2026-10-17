<?php

class loginModel extends Model
{
   
    public function obtenerUsuario($user){
        $sql = "SELECT * from usuario WHERE nombreUsuario = BINARY ?";
        $query = $this->_db->prepare($sql);
        $query->execute(array($user));
        $result = $query->fetch(PDO::FETCH_BOTH);
        return $result;
    }



}
