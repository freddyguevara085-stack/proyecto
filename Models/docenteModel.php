<?php

class docenteModel extends Model
{
    public function obtenerDocente()
    {
        return $this->_db->query("SELECT * FROM docente;")->fetchAll();
    }

    public function insertarDocente($nombreDocente, $especialidad, $usuario, $clave)
    {
        $hash = password_hash($clave, PASSWORD_DEFAULT);

        $this->_db->beginTransaction();
        try {
            $sql = 'INSERT INTO docente (nombreDocente, especialidad, nombreusuariodocente) VALUES (:nombreDocente, :especialidad, :nombreusuariodocente)';
            $this->_db->prepare($sql)->execute([
                'nombreDocente' => $nombreDocente,
                'especialidad' => $especialidad,
                'nombreusuariodocente' => $usuario
            ]);

            $sql = 'CALL insertarUsuario(:nombreUsuario, :clave, :rol)';
            $this->_db->prepare($sql)->execute([
                'nombreUsuario' => $usuario,
                'clave' => $hash,
                'rol' => 'docente'
            ]);

            $this->_db->commit();
        } catch (Exception $e) {
            $this->_db->rollBack();
            throw $e;
        }
    }

    public function actualizarDocente($idDocente, $nombreDocente, $especialidad)
    {
        $sql = 'UPDATE docente SET nombreDocente = :nombreDocente, especialidad = :especialidad WHERE idDocente = :idDocente';
        $this->_db->prepare($sql)->execute([
            'idDocente' => $idDocente,
            'nombreDocente' => $nombreDocente,
            'especialidad' => $especialidad
        ]);
    }

    public function eliminarDocente($idDocente)
    {
        $sql = 'DELETE FROM docente WHERE idDocente = :idDocente';
        $this->_db->prepare($sql)->execute([
            'idDocente' => $idDocente
        ]);
    }
}
