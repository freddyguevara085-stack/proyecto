<?php
class indexController extends Controller
{
    private $_index;

    function __construct()
    {
        parent::__construct();
        $this->_index = $this->loadModel("index");
    }

    public function getNumeroAlumno()
    {
        $numero = $this->_index->numeroAlumno();
       
        return $numero;
    }

    public function getDatosAlumno()
    {
        $datos = $this->_index->datosAlumno();
       for($i=0;$i<count($datos);$i++){
        $alumnos=json_encode($datos);
        
        } 
        return $alumnos;
        
    }


    public function index()
    {
        $this->_view->numeroAlumnos=$this->getNumeroAlumno();
        $this->_view->alumnos=$this->getDatosAlumno();
        $this->_view->renderizar('index');
    }
}
