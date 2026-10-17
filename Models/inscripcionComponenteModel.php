<?php

class inscripcionComponenteModel extends Model
{

    public function obtenerDatosAlumno($nombre)
    {
        return $this->_db->query("select *from alumno where nombreusuarioestudiante="."'$nombre'")->fetchAll();
    }

       public function obtenerInscripciones($carnet)
    {
        return $this->_db->query("select * from alumno inner join inscripcioncomponentes on carnet=alumnoInscripcion inner join 
materia on id=materiaIdMateria where carnet='$carnet' ;")->fetchAll();
    }

       public function datosMateria()
    {
       return $this->_db->query("select *from materia")->fetchAll();
    }


     public function registrarInscripcion($idM,$idA)
    {

        $this->_db->prepare('insert into inscripcionComponentes(materiaIdMateria,alumnoInscripcion)
    values(:idM,:idA)')->execute(array(
                    'idM' => $idM,
                    'idA' => $idA
                    
                ));

                     

    }

   

    

}
