<?php

class indexModel extends Model
{

    public function numeroAlumno()
    {
        return $this->_db->query("select *from alumno;")->rowCount();
    }

     public function datosAlumno()
    {
        return $this->_db->query("select *from alumno;")->fetchAll();
    }

  



}