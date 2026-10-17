<?php

class grupoController extends Controller
{
    private $_grupo;

    function __construct()
    {
        parent::__construct();
        $this->_grupo = $this->loadModel("grupo");
    }

    public function verGrupo()
    {
        $fila = $this->_grupo->obtenerGrupo();
        $tabla = '';
        for ($i = 0; $i < count($fila); $i++) {
            $datos = json_encode($fila[$i]);
            $tabla .= ' 
          <tr>
          <td>' . $fila[$i]['idGrupo'] . '</td>
          <td>' . $fila[$i]['nombreGrupo'] . '</td>
          <td>
          <button style="background-color: #5A2A7A; border: #5A2A7A;" data-Grupo=\'' . $datos . '\' class="btn btn-info btn-circle btnEditarGrupo" data-bs-toggle="modal" data-bs-target="#modalEditarGrupo">
            <i style="color: white;" class="fa-solid fa-pen"></i>
          </button>
          <button data-borrarGrupo="' . $fila[$i]['idGrupo'] . '" class="btn btn-danger btn-circle btnBorrarGrupo">
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
        $this->_view->tabla = $this->verGrupo();
        $this->_view->renderizar('grupo');
    }

    public function agregarGrupo()
    {
        $this->_grupo->insertarGrupo(
            $this->getTexto('nombreGrupo')
        );
        echo $this->verGrupo();
    }

    public function editarGrupo()
    {
        $this->_grupo->actualizarGrupo(
            $this->getTexto('idGrupoUp'),
            $this->getTexto('nombreGrupoUp')
        );
        echo $this->verGrupo();
    }

    public function borrarGrupo()
    {
        $id = $this->getTexto('id');
        $this->_grupo->eliminarGrupo($id);
        echo $this->verGrupo();
    }
}
