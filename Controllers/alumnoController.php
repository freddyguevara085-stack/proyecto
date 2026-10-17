<?php
class alumnoController extends Controller
{
    private $_alumno;

    function __construct()
    {
        parent::__construct();
        $this->_alumno = $this->loadModel("alumno");
    }

    public function verAlumno()
    {

        $fila = $this->_alumno->obtenerAlumno();
        $tabla = '';
        for ($i = 0; $i < count($fila); $i++) {
            $datos = json_encode($fila[$i]);
            $tabla .= ' 
          <tr>
          <td>' . $fila[$i]['carnet'] . '</td>
          <td>' . $fila[$i]['primerNombre'] . '</td>
          <td>' . $fila[$i]['segundoNombre'] . '</td>
          <td>' . $fila[$i]['primerApellido'] . '</td>
          <td>' . $fila[$i]['segundoApellido'] . '</td>
          <td>' . $fila[$i]['sexo'] . '</td>
          <td>' . $fila[$i]['edad'] . '</td>
          <td>' . $fila[$i]['fechaNacimiento'] . '</td>
          <td>' . $fila[$i]['correo'] . '</td>
          <td>' . $fila[$i]['telefono'] . '</td>
          <td>' . $fila[$i]['direccion'] . '</td>
          <td>' . $fila[$i]['nombreusuarioestudiante'] . '</td>
        <td> <a href="' . PLANTILLA . 'img/' . $fila[$i]['imagen'] . '" data-fancybox="gallery" data-caption="' . $fila[$i]['primerNombre'] . '">
            <img src="' . PLANTILLA . 'img/' . $fila[$i]['imagen'] . '" class="img-fluid rounded-start" style="height: 50px;" alt="">
            </a></td>
    
          <td >
          <button style="background-color: #5A2A7A	; border: #5A2A7A	;" data-Alumno=\'' . $datos . '\' " class="btn btn-info btn-circle btnEditarAlumno" data-bs-toggle="modal"
          data-bs-target="#modalEditarAlumno">
            <i style="color: white;" class="fa-solid fa-pen"></i>
            </button>
            <button data-borrarAlumno=' . $fila[$i]['carnet'] . ' class="btn btn-danger btn-circle btnBorrarAlumno">
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
        $this->_view->tabla = $this->verAlumno();
        $this->_view->renderizar('alumno');
    }




    public function agregarAlumno()
    {
        $claveUsuarioEstudiante = $this->getTexto('claveUsuarioEstudiante');
        if ($claveUsuarioEstudiante !== $this->getTexto('repetirClaveUsuarioEstudiante')) {
            echo 'ERROR_CLAVE';
            return;
        }

        $edad = $this->getTexto('edadA');
        if (filter_var($edad, FILTER_VALIDATE_INT, array(
            'options' => array('min_range' => 0, 'max_range' => 150)
        )) === false) {
            echo 'ERROR_EDAD';
            return;
        }
        $edad = (int) $edad;

        function upload_image()
        {
            if (isset($_FILES["imagenA"])) {
                $extension = explode('.', $_FILES['imagenA']['name']);
                $new_name = rand() . '.' . $extension[1];
                $destination = './Views/plantilla/img/' . $new_name;
                move_uploaded_file($_FILES['imagenA']['tmp_name'], $destination);
                return $new_name;
            }
        }
        $image = '';
        if ($_FILES["imagenA"]["name"] != '') {
            $image = upload_image();
            $this->_alumno->insertarAlumno(
                $this->getTexto('primerNombreA'),
                $this->getTexto('segundoNombreA'),
                $this->getTexto('primerApellidoA'),
                $this->getTexto('segundoApellidoA'),
                $this->getTexto('sexoA'),
                $edad,
                $this->getTexto('nacimientoA'),
                $this->getTexto('correoA'),
                $this->getTexto('telefonoA'),
                $this->getTexto('direccionA'),
                $image,
                $this->getTexto('nombreUsuarioEstudiante'),
                $claveUsuarioEstudiante
            );
            echo $this->verAlumno();
        } else {
            $this->_alumno->insertarAlumnoSinImagen(
                $this->getTexto('primerNombreA'),
                $this->getTexto('segundoNombreA'),
                $this->getTexto('primerApellidoA'),
                $this->getTexto('segundoApellidoA'),
                $this->getTexto('sexoA'),
                $edad,
                $this->getTexto('nacimientoA'),
                $this->getTexto('correoA'),
                $this->getTexto('telefonoA'),
                $this->getTexto('direccionA'),
                $this->getTexto('nombreUsuarioEstudiante'),
                $claveUsuarioEstudiante
            );

            echo $this->verAlumno();
        }
    }

    public function editarAlumno(){
        $edad = $this->getTexto('edadAUp');
        if (filter_var($edad, FILTER_VALIDATE_INT, array(
            'options' => array('min_range' => 0, 'max_range' => 150)
        )) === false) {
            echo 'ERROR_EDAD';
            return;
        }
        $edad = (int) $edad;


    
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
                $edad,
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
                $edad,
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
