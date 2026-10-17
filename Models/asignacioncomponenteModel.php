<?php

class asignacioncomponenteModel extends Model
{
    public function obtenerAsignacionComponente()
    {
        $sql = "SELECT a.idAsignacion, a.docenteIdDocente, a.materiaAsignacion, 
                       d.nombreDocente, 
                       m.nombreMateria 
                FROM asignacionComponentes a 
                LEFT JOIN docente d ON a.docenteIdDocente = d.idDocente 
                LEFT JOIN materia m ON a.materiaAsignacion = m.id;";
        return $this->_db->query($sql)->fetchAll();
    }

    public function obtenerDocentes()
    {
        return $this->_db->query("SELECT idDocente, nombreDocente FROM docente;")->fetchAll();
    }

    public function obtenerMaterias()
    {
        return $this->_db->query("SELECT id, nombreMateria FROM materia;")->fetchAll();
    }

    public function insertarAsignacionComponente($docenteIdDocente, $materiaAsignacion)
    {
        $sql = 'INSERT INTO asignacionComponentes (docenteIdDocente, materiaAsignacion) VALUES (:docenteIdDocente, :materiaAsignacion)';
        $this->_db->prepare($sql)->execute([
            'docenteIdDocente' => $docenteIdDocente,
            'materiaAsignacion' => $materiaAsignacion
        ]);
    }

    public function actualizarAsignacionComponente($idAsignacion, $docenteIdDocente, $materiaAsignacion)
    {
        $sql = 'UPDATE asignacionComponentes SET docenteIdDocente = :docenteIdDocente, materiaAsignacion = :materiaAsignacion WHERE idAsignacion = :idAsignacion';
        $this->_db->prepare($sql)->execute([
            'idAsignacion' => $idAsignacion,
            'docenteIdDocente' => $docenteIdDocente,
            'materiaAsignacion' => $materiaAsignacion
        ]);
    }

    public function eliminarAsignacionComponente($idAsignacion)
    {
        $sql = 'DELETE FROM asignacionComponentes WHERE idAsignacion = :idAsignacion';
        $this->_db->prepare($sql)->execute([
            'idAsignacion' => $idAsignacion
        ]);
    }
}
