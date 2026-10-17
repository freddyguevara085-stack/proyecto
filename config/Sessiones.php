<?php
class Sessiones
{
    public static function acceso($rol)
    {
        if(Sessiones::getClave('autenticado'))
        {
            if( Sessiones::getNivel(Sessiones::getClave('rol')) >= Sessiones::getNivel($rol)){
                return true;
            } 
           else
            header("Location:".BASE_URL.'error/error/505');
        }
        else
        header("Location:".BASE_URL.'error/error/504');

            
    }

    public static function esAdministrador()
    {
        if(Sessiones::getClave('autenticado'))
        {
            if( Sessiones::getNivel(Sessiones::getClave('rol')) === Sessiones::getNivel('administrador')){
                return true;
            } 
           else
            return false;
        }
        else
        return false;

            
    }

    public static function getVista($rol)
    {
        if(Sessiones::getClave('autenticado'))
        {
            if( Sessiones::getNivel(Sessiones::getClave('rol')) >= Sessiones::getNivel($rol)){
                return true;
            } 
            else
            return false;
        }
        else
        return false;
    }

    public static function accesoVista($rol){
        $rolActual = Sessiones::getClave('rol');
        if($rolActual == $rol) {
            return true;
        }
        if($rol == 'alumno' && $rolActual == 'estudiante') {
            return true;
        }
        return false;
    }

    public static function getNivel($nivel)
    {
        $rol['administrador']=3;
        $rol['docente']=2;
        $rol['alumno']=1;
        $rol['estudiante']=1;
        if(isset($rol[$nivel]))  
            return $rol[$nivel]; 
        else
            return 0;     
    }

    public static function setClave($clave,$valor)
    {
        $_SESSION[$clave]=$valor;
    }

    public static function iniciar()
    {
        session_start();
    }

    public static function getClave($clave)
    {
        if(isset($_SESSION[$clave]))
            return $_SESSION[$clave];
        else
            return false;
    }

    public static function salir()
    {
        session_destroy();
    }
}