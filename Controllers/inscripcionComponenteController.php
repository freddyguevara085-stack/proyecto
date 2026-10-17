<?php
    class inscripcionComponenteController extends Controller{
        private $_inscripcionComponente;
    
    function __construct()
    {
       parent::__construct(); 
       $this->_inscripcionComponente = $this->loadModel("inscripcionComponente");
    }


public function idAlumno()
    {
         $datos=$this->_inscripcionComponente->obtenerDatosAlumno(Sessiones::getClave('usuario'));
     
        $id = $datos[0]["carnet"];

       return $id;

    } 




public function getInscripciones()
{
    $datos=$this->_inscripcionComponente->obtenerDatosAlumno(Sessiones::getClave('usuario'));
    $id = $datos[0]["carnet"];
    $fila=$this->_inscripcionComponente->obtenerInscripciones($id);

    $tabla = '';
        for ($i = 0; $i < count($fila); $i++) {
            $datos = json_encode($fila[$i]);
            $tabla .= ' 
          <tr>
          <td>' . $fila[$i]['carnet'] . '</td>
          <td>' . $fila[$i]['primerNombre'] .' '. $fila[$i]['segundoNombre'] .' '. $fila[$i]['primerApellido']. ' '. $fila[$i]['segundoApellido']. '    </td>
          <td>' . $fila[$i]['id'] . '</td>
          <td>' . $fila[$i]['nombreMateria'] . '  </td>

          <td>
          <button style="background-color: #5A2A7A	; border: #5A2A7A	;" data-cita=\'' . $datos . '\' " class="btn btn-info btn-circle btnAceptarCita">
            <i style="color: white;" class="fa-solid fa-check"></i>
            </button>
   <button data-borrarServicio=' . $fila[$i]['carnet'] . ' class="btn btn-danger btn-circle btBorrarDoctor">
   <i class="fas fa-xmark"> </i>
   </button>

          </td>
  
          </tr>';

        }
    return $tabla;
    

}





   public function getMaterias()
    {


        $fila = $this->_inscripcionComponente->datosMateria();
        $datos = '<option value="0">Seleccione Materia</option>';
       for($i=0;$i<count($fila);$i++){
        $datos .= '<option value="' . $fila[$i]['id'] . '">' . $fila[$i]['nombreMateria'] . ' ' . 'ciclo:' . ' ' . $fila[$i]['ciclo'] . '</option>';
         
        
        } 
        return $datos;
        
    }










       public function index()
    {

      $this->_view->tabla=$this->getInscripciones();
      $this->_view->id=$this->idAlumno();
        $this->_view->materia=$this->getMaterias();
      $this->_view->renderizar('inscripcionComponente');
    }

    

     public function inscribirMateria(){
        
           $this->_inscripcionComponente->registrarInscripcion($this->getTexto('idMateria'),$this->getTexto('idAlum'));
           echo $this->getInscripciones();
        
          
          
   
        
    }




    }
    
 


?>