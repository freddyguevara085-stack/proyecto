<?php

class grupoModel extends Model
{
    public function obtenerGrupo()
    {
        return $this->_db->query("SELECT * FROM grupo;")->fetchAll();
    }

    public function insertarGrupo($nombreGrupo)
    {
        $sql = 'INSERT INTO grupo (nombreGrupo) VALUES (:nombreGrupo)';
        $this->_db->prepare($sql)->execute([
            'nombreGrupo' => $nombreGrupo
        ]);
    }

    public function actualizarGrupo($idGrupo, $nombreGrupo)
    {
        $sql = 'UPDATE grupo SET nombreGrupo = :nombreGrupo WHERE idGrupo = :idGrupo';
        $this->_db->prepare($sql)->execute([
            'idGrupo' => $idGrupo,
            'nombreGrupo' => $nombreGrupo
        ]);
    }

    public function eliminarGrupo($idGrupo)
    {
        $sql = 'DELETE FROM grupo WHERE idGrupo = :idGrupo';
        $this->_db->prepare($sql)->execute([
            'idGrupo' => $idGrupo
        ]);
    }
}
