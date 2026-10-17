<?php

class materiaModel extends Model
{

    public function obtenerMateria()
    {
        return $this->_db->query("select *from materia;")->fetchAll();
    }

  
    public function insertarMateria($nombre,$ciclo,$creditos)
    {

        $this->_db->prepare('insert into materia(nombreMateria,ciclo,creditos)
    values(:nombre,:ciclo,:creditos)')->execute(array(
                    'nombre' => $nombre,
                    'ciclo' => $ciclo,
                    'creditos' => $creditos
                    
                ));
    }

    

    public function insertarServicioSinImagen($tipo,$descripcion,$precio)
    {
       
        $this->_db->prepare('insert into servicio(tipo_servicio,descripcion,precio)
    values(:tipo,:descripcion,:precio)')->execute(array(
                    'tipo' => $tipo,
                    'descripcion' => $descripcion,
                    'precio' => $precio
                    
                ));

    }

    public function editarMateria($id,$nombre,$ciclo,$creditos)
{
    $sql = "UPDATE materia 
            SET nombreMateria = :nombre, 
                ciclo = :ciclo, 
                creditos = :creditos, 
                 
            WHERE id = :id";
    
    $this->_db->prepare($sql)->execute([
        'nombre' => $nombre,
        'ciclo' => $ciclo,
        'creditos' => $creditos,
        'id' => $id
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