<?php

class asignacioncomponenteController extends Controller
{
    private $_asignacioncomponente;

    function __construct()
    {
        parent::__construct();
        $this->_asignacioncomponente = $this->loadModel("asignacioncomponente");
    }

    public function verAsignacionComponente()
    {
        $fila = $this->_asignacioncomponente->obtenerAsignacionComponente();
        $tabla = '';
        for ($i = 0; $i < count($fila); $i++) {
            $datos = json_encode($fila[$i]);
            $docenteNombre = $fila[$i]['nombreDocente'] ? $fila[$i]['nombreDocente'] : 'N/A';
            $materiaNombre = $fila[$i]['nombreMateria'] ? $fila[$i]['nombreMateria'] : 'N/A';

            $tabla .= ' 
          <tr>
          <td>' . $fila[$i]['idAsignacion'] . '</td>
          <td>' . $docenteNombre . '</td>
          <td>' . $materiaNombre . '</td>
          <td>
          <button style="background-color: #5A2A7A; border: #5A2A7A;" data-AsignacionComponente=\'' . $datos . '\' class="btn btn-info btn-circle btnEditarAsignacionComponente" data-bs-toggle="modal" data-bs-target="#modalEditarAsignacionComponente">
            <i style="color: white;" class="fa-solid fa-pen"></i>
          </button>
          <button data-borrarAsignacionComponente="' . $fila[$i]['idAsignacion'] . '" class="btn btn-danger btn-circle btnBorrarAsignacionComponente">
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
        $this->_view->docentes = $this->_asignacioncomponente->obtenerDocentes();
        $this->_view->materias = $this->_asignacioncomponente->obtenerMaterias();
        $this->_view->tabla = $this->verAsignacionComponente();
        $this->_view->renderizar('asignacioncomponente');
    }

    public function agregarAsignacionComponente()
    {
        $this->_asignacioncomponente->insertarAsignacionComponente(
            $this->getTexto('docenteIdDocente'),
            $this->getTexto('materiaAsignacion')
        );
        echo $this->verAsignacionComponente();
    }

    public function editarAsignacionComponente()
    {
        $this->_asignacioncomponente->actualizarAsignacionComponente(
            $this->getTexto('idAsignacionUp'),
            $this->getTexto('docenteIdDocenteUp'),
            $this->getTexto('materiaAsignacionUp')
        );
        echo $this->verAsignacionComponente();
    }

    public function borrarAsignacionComponente()
    {
        $id = $this->getTexto('id');
        $this->_asignacioncomponente->eliminarAsignacionComponente($id);
        echo $this->verAsignacionComponente();
    }
}
