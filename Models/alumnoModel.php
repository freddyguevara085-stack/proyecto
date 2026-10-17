<?php

class alumnoModel extends Model
{

    public function obtenerAlumno()
    {
        return $this->_db->query("select *from alumno;")->fetchAll();
    }


    

  
    public function insertarAlumno($primerNombre,$segundoNombre,$primerApellido,$segundoApellido,$sexo,$edad,$nacimiento,$correo,$telefono,$direccion,$imagen,$usuario,$clave)
    {
        $hash = password_hash($clave, PASSWORD_DEFAULT);

        $this->_db->beginTransaction();
        try {
            $this->_db->prepare('insert into alumno(primerNombre,segundoNombre,primerApellido,segundoApellido,sexo,edad,fechaNacimiento,correo,telefono,direccion,imagen,nombreusuarioestudiante)
        values(:pNombre,:sNombre,:pApellido,:sApellido,:sexo,:edad,:fNacimiento,:correo,:tel,:direccion,:imagen,:nombreusuarioestudiante)')->execute(array(
                        'pNombre' => $primerNombre,
                        'sNombre' => $segundoNombre,
                        'pApellido' => $primerApellido,
                        'sApellido' => $segundoApellido,
                        'sexo' => $sexo,
                        'edad' => $edad,
                        'fNacimiento' => $nacimiento,
                        'correo' => $correo,
                        'tel' => $telefono,
                        'direccion' => $direccion,
                        'imagen' => $imagen,
                        'nombreusuarioestudiante' => $usuario
                    ));

            // El procedimiento de estudiante asigna el rol correcto y evita
            // llamar a insertarUsuario con una cantidad de parámetros inválida.
            $sentenciaUsuario = $this->_db->prepare(
                'CALL insertarEstudianteUsuario(:nombreUsuario, :clave)'
            );
            $sentenciaUsuario->execute(array(
                'nombreUsuario' => $usuario,
                'clave' => $hash
            ));
            $sentenciaUsuario->closeCursor();

            $this->_db->commit();
        } catch (Exception $e) {
            $this->_db->rollBack();
            throw $e;
        }
    }

    public function insertarAlumnoSinImagen($primerNombre,$segundoNombre,$primerApellido,$segundoApellido,$sexo,$edad,$nacimiento,$correo,$telefono,$direccion,$usuario,$clave)
    {
        $this->insertarAlumno($primerNombre,$segundoNombre,$primerApellido,$segundoApellido,$sexo,$edad,$nacimiento,$correo,$telefono,$direccion,null,$usuario,$clave);
    }

    public function actualizarAlumno($carnet,$primerNombre,$segundoNombre,$primerApellido,$segundoApellido,$sexo,$edad,$nacimiento,$correo,$telefono,$direccion,$imagen)
{
    $sql = "UPDATE alumno 
            SET primerNombre = :primerNombre, 
                segundoNombre = :segundoNombre, 
                primerApellido = :primerApellido, 
                segundoApellido = :segundoApellido, 
                sexo = :sexo, 
                edad = :edad, 
                fechaNacimiento = :fechaNacimiento, 
                correo = :correo, 
                telefono = :telefono, 
                direccion = :direccion, 
                imagen = :imagen 
            WHERE carnet = :carnet";
    
    $this->_db->prepare($sql)->execute([
        'carnet' => $carnet,
        'primerNombre' => $primerNombre,
        'segundoNombre' => $segundoNombre,
        'primerApellido' => $primerApellido,
        'segundoApellido' => $segundoApellido,
        'sexo' => $sexo,
        'edad' => $edad,
        'fechaNacimiento' => $nacimiento,
        'correo' => $correo,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'imagen' => $imagen,
        'carnet' => $carnet
    ]);

}


   public function actualizarAlumnoSinImagen($carnet,$primerNombre,$segundoNombre,$primerApellido,$segundoApellido,$sexo,$edad,$nacimiento,$correo,$telefono,$direccion)
{
    $sql = "UPDATE alumno 
            SET primerNombre = :primerNombre, 
                segundoNombre = :segundoNombre, 
                primerApellido = :primerApellido, 
                segundoApellido = :segundoApellido, 
                sexo = :sexo, 
                edad = :edad, 
                fechaNacimiento = :fechaNacimiento, 
                correo = :correo, 
                telefono = :telefono, 
                direccion = :direccion
            WHERE carnet = :carnet";
    
    $this->_db->prepare($sql)->execute([
        'carnet' => $carnet,
        'primerNombre' => $primerNombre,
        'segundoNombre' => $segundoNombre,
        'primerApellido' => $primerApellido,
        'segundoApellido' => $segundoApellido,
        'sexo' => $sexo,
        'edad' => $edad,
        'fechaNacimiento' => $nacimiento,
        'correo' => $correo,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'carnet' => $carnet
    ]);

}



    public function eliminarAlumno($id)
    {
        $this->_db->prepare('delete from alumno where carnet=:id')->execute(array('id' => $id));
    }




}
