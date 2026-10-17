<?php

class notasModel extends Model
{
    public function obtenerDatosAlumno($nombreUsuario)
    {
        $stmt = $this->_db->prepare("SELECT * FROM alumno WHERE nombreusuarioestudiante = :user LIMIT 1");
        $stmt->execute(array(':user' => $nombreUsuario));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerNotasPorAlumno($carnet)
    {
        $sql = "SELECT 
                    m.id AS idMateria,
                    m.nombreMateria,
                    COALESCE(
                        d.nombreDocente,
                        (SELECT d2.nombreDocente 
                         FROM asignacioncomponentes ac 
                         JOIN docente d2 ON ac.docenteIdDocente = d2.idDocente 
                         WHERE ac.materiaAsignacion = m.id 
                         LIMIT 1),
                        'Sin asignar'
                    ) AS docente,
                    n.IP,
                    n.IIP,
                    n.IIIP,
                    n.NF
                FROM notas n
                INNER JOIN materia m ON n.materiaNota = m.id
                LEFT JOIN docente d ON n.docenteNota = d.idDocente
                WHERE n.alumnoNota = :carnet1

                UNION

                SELECT 
                    m.id AS idMateria,
                    m.nombreMateria,
                    COALESCE(
                        (SELECT d2.nombreDocente 
                         FROM asignacioncomponentes ac 
                         JOIN docente d2 ON ac.docenteIdDocente = d2.idDocente 
                         WHERE ac.materiaAsignacion = m.id 
                         LIMIT 1),
                        'Sin asignar'
                    ) AS docente,
                    NULL AS IP,
                    NULL AS IIP,
                    NULL AS IIIP,
                    NULL AS NF
                FROM inscripcioncomponentes ic
                INNER JOIN materia m ON ic.materiaIdMateria = m.id
                WHERE ic.alumnoInscripcion = :carnet2
                AND m.id NOT IN (SELECT materiaNota FROM notas WHERE alumnoNota = :carnet3)
                ORDER BY nombreMateria ASC";

        $stmt = $this->_db->prepare($sql);
        $stmt->execute(array(
            ':carnet1' => $carnet,
            ':carnet2' => $carnet,
            ':carnet3' => $carnet
        ));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
