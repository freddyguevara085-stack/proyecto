<?php

class docenteController extends Controller
{
    private $_docente;

    function __construct()
    {
        parent::__construct();
        $this->_docente = $this->loadModel("docente");
    }

    public function verDocente()
    {
        $fila = $this->_docente->obtenerDocente();
        $tabla = '';
        for ($i = 0; $i < count($fila); $i++) {
            $datos = json_encode($fila[$i]);
            $tabla .= ' 
          <tr>
          <td>' . $fila[$i]['idDocente'] . '</td>
          <td>' . $fila[$i]['nombreDocente'] . '</td>
          <td>' . $fila[$i]['especialidad'] . '</td>
          <td>
          <button style="background-color: #5A2A7A; border: #5A2A7A;" data-Docente=\'' . $datos . '\' class="btn btn-info btn-circle btnEditarDocente" data-bs-toggle="modal" data-bs-target="#modalEditarDocente">
            <i style="color: white;" class="fa-solid fa-pen"></i>
          </button>
          <button data-borrarDocente="' . $fila[$i]['idDocente'] . '" class="btn btn-danger btn-circle btnBorrarDocente">
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
        $this->_view->tabla = $this->verDocente();
        $this->_view->renderizar('docente');
    }

    public function agregarDocente()
    {
        $claveUsuarioDocente = $this->getTexto('claveUsuarioDocente');

        if ($claveUsuarioDocente !== $this->getTexto('repetirClaveUsuarioDocente')) {
            echo 'ERROR_CLAVE';
            return;
        }

        $this->_docente->insertarDocente(
            $this->getTexto('nombreDocente'),
            $this->getTexto('especialidad'),
            $this->getTexto('nombreUsuarioDocente'),
            $claveUsuarioDocente
        );
        echo $this->verDocente();
    }

    public function editarDocente()
    {
        $this->_docente->actualizarDocente(
            $this->getTexto('idDocenteUp'),
            $this->getTexto('nombreDocenteUp'),
            $this->getTexto('especialidadUp')
        );
        echo $this->verDocente();
    }

    public function borrarDocente()
    {
        $id = $this->getTexto('id');
        $this->_docente->eliminarDocente($id);
        echo $this->verDocente();
    }
}
