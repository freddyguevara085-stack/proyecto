<?php

class matriculaController extends Controller
{
    private $_matricula;

    function __construct()
    {
        parent::__construct();
        $this->_matricula = $this->loadModel("matricula");
    }

    public function verMatricula()
    {
        $fila = $this->_matricula->obtenerMatricula();
        $tabla = '';
        for ($i = 0; $i < count($fila); $i++) {
            $datos = json_encode($fila[$i]);
            $grupoNombre = $fila[$i]['nombreGrupo'] ? $fila[$i]['nombreGrupo'] : 'N/A';
            $alumnoNombre = $fila[$i]['nombreAlumno'] ? $fila[$i]['carnet'] . ' - ' . $fila[$i]['nombreAlumno'] : 'N/A';

            $tabla .= ' 
          <tr>
          <td>' . $fila[$i]['idMatricula'] . '</td>
          <td>' . $grupoNombre . '</td>
          <td>' . $alumnoNombre . '</td>
          <td>
          <button style="background-color: #5A2A7A; border: #5A2A7A;" data-Matricula=\'' . $datos . '\' class="btn btn-info btn-circle btnEditarMatricula" data-bs-toggle="modal" data-bs-target="#modalEditarMatricula">
            <i style="color: white;" class="fa-solid fa-pen"></i>
          </button>
          <button data-borrarMatricula="' . $fila[$i]['idMatricula'] . '" class="btn btn-danger btn-circle btnBorrarMatricula">
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
        $this->_view->grupos = $this->_matricula->obtenerGrupos();
        $this->_view->alumnos = $this->_matricula->obtenerAlumnos();
        $this->_view->tabla = $this->verMatricula();
        $this->_view->renderizar('matricula');
    }

    public function agregarMatricula()
    {
        $this->_matricula->insertarMatricula(
            $this->getTexto('grupoIdGrupo'),
            $this->getTexto('alumnoIdAlumno')
        );
        echo $this->verMatricula();
    }

    public function editarMatricula()
    {
        $this->_matricula->actualizarMatricula(
            $this->getTexto('idMatriculaUp'),
            $this->getTexto('grupoIdGrupoUp'),
            $this->getTexto('alumnoIdAlumnoUp')
        );
        echo $this->verMatricula();
    }

    public function borrarMatricula()
    {
        $id = $this->getTexto('id');
        $this->_matricula->eliminarMatricula($id);
        echo $this->verMatricula();
    }
}
