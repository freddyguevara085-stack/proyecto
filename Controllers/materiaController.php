<?php
class materiaController extends Controller
{
    private $_materia;

    function __construct()
    {
        parent::__construct();
        $this->_materia = $this->loadModel("materia");
    }

    public function verMateria()
    {

        $fila = $this->_materia->obtenerMateria();
        $tabla = '';
        for ($i = 0; $i < count($fila); $i++) {
            $datos = json_encode($fila[$i]);
            $tabla .= ' 
          <tr>
          <td>' . $fila[$i]['id'] . '</td>
          <td>' . $fila[$i]['nombreMateria'] . '</td>
          <td>' . $fila[$i]['ciclo'] . '</td>
          <td>' . $fila[$i]['creditos'] . '</td>
          
          <td >
          <button style="background-color: #5A2A7A	; border: #5A2A7A	;" data-Materia=\'' . $datos . '\' " class="btn btn-info btn-circle btnEditarMateria" data-bs-toggle="modal"
          data-bs-target="#modalEditarMateria">
            <i style="color: white;" class="fa-solid fa-pen"></i>
            </button>
            <button data-borrarMateria=' . $fila[$i]['id'] . ' class="btn btn-danger btn-circle btnBorrarMateria">
            <i class="fas fa-trash"></i>
            </button>

          </td>
  
          </tr>';

        }

        return $tabla;


    }




    public function index()
    {
         Sessiones::acceso('administrador');
        $this->_view->tabla = $this->verMateria();
        $this->_view->renderizar('materia');
    }




    public function agregarMateria()
    {

        
        
     
            $this->_materia->insertarMateria(
                $this->getTexto('nombreMateria'),
                $this->getTexto('ciclo'),
                $this->getTexto('creditos')
            );
            echo $this->verMateria();
      
          
    }

    
    public function actualizarMateria()
    {

            $this->_materia->editarMateria(
                $this->getTexto('idM'),
                $this->getTexto('nombreMateriaUp'),
                $this->getTexto('cicloUp'),
                $this->getTexto('creditosUp')
            );
            echo $this->verMateria();
      
          
    }
    

    public function editarAlumno(){


    
        function upload_image()
        {
            if (isset($_FILES["imagenAUp"])) {
                $extension = explode('.', $_FILES['imagenAUp']['name']);
                $new_name = rand() . '.' . $extension[1];
                $destination = './Views/plantilla/img/' . $new_name;
                move_uploaded_file($_FILES['imagenAUp']['tmp_name'], $destination);
                return $new_name;
            }
        }
        $image = '';
        if ($_FILES["imagenAUp"]["name"] != '') {
            $image = upload_image();
            $this->_alumno->actualizarAlumno(
                $this->getTexto('carnetA'),
                $this->getTexto('primerNombreAUp'),
                $this->getTexto('segundoNombreAUp'),
                $this->getTexto('primerApellidoAUp'),
                $this->getTexto('segundoApellidoAUp'),
                $this->getTexto('sexoAUp'),
                $this->getTexto('edadAUp'),
                $this->getTexto('nacimientoAUp'),
                $this->getTexto('correoAUp'),
                $this->getTexto('telefonoAUp'),
                $this->getTexto('direccionAUp'),
                $image
            );
            echo $this->verAlumno();
        } else {
            $this->_alumno->actualizarAlumnoSinImagen(
                $this->getTexto('carnetA'),
                $this->getTexto('primerNombreAUp'),
                $this->getTexto('segundoNombreAUp'),
                $this->getTexto('primerApellidoAUp'),
                $this->getTexto('segundoApellidoAUp'),
                $this->getTexto('sexoAUp'),
                $this->getTexto('edadAUp'),
                $this->getTexto('nacimientoAUp'),
                $this->getTexto('correoAUp'),
                $this->getTexto('telefonoAUp'),
                $this->getTexto('direccionAUp')
            );

            echo $this->verAlumno();
        }


    }


    public function borrarAlumno()
    {
        $carnet = $this->getTexto('id');
        $this->_alumno->eliminarAlumno($carnet);
        echo $this->verAlumno();
    }


}
