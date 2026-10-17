<?php

class matriculaModel extends Model
{
    public function obtenerMatricula()
    {
        $sql = "SELECT m.idMatricula, m.grupoIdGrupo, m.alumnoIdAlumno, 
                       g.nombreGrupo, 
                       CONCAT(a.primerNombre, ' ', a.primerApellido) AS nombreAlumno, 
                       a.carnet 
                FROM matricula m 
                LEFT JOIN grupo g ON m.grupoIdGrupo = g.idGrupo 
                LEFT JOIN alumno a ON m.alumnoIdAlumno = a.carnet;";
        return $this->_db->query($sql)->fetchAll();
    }

    public function obtenerGrupos()
    {
        return $this->_db->query("SELECT idGrupo, nombreGrupo FROM grupo;")->fetchAll();
    }

    public function obtenerAlumnos()
    {
        return $this->_db->query("SELECT carnet, primerNombre, primerApellido FROM alumno;")->fetchAll();
    }

    public function insertarMatricula($grupoIdGrupo, $alumnoIdAlumno)
    {
        $sql = 'INSERT INTO matricula (grupoIdGrupo, alumnoIdAlumno) VALUES (:grupoIdGrupo, :alumnoIdAlumno)';
        $this->_db->prepare($sql)->execute([
            'grupoIdGrupo' => $grupoIdGrupo,
            'alumnoIdAlumno' => $alumnoIdAlumno
        ]);
    }

    public function actualizarMatricula($idMatricula, $grupoIdGrupo, $alumnoIdAlumno)
    {
        $sql = 'UPDATE matricula SET grupoIdGrupo = :grupoIdGrupo, alumnoIdAlumno = :alumnoIdAlumno WHERE idMatricula = :idMatricula';
        $this->_db->prepare($sql)->execute([
            'idMatricula' => $idMatricula,
            'grupoIdGrupo' => $grupoIdGrupo,
            'alumnoIdAlumno' => $alumnoIdAlumno
        ]);
    }

    public function eliminarMatricula($idMatricula)
    {
        $sql = 'DELETE FROM matricula WHERE idMatricula = :idMatricula';
        $this->_db->prepare($sql)->execute([
            'idMatricula' => $idMatricula
        ]);
    }
}
