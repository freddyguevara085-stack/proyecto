<?php
class usuarioController extends Controller
{
    private $_usuario;

    function __construct()
    {
        parent::__construct();
        $this->_usuario = $this->loadModel("usuario");
    }

    public function verUsuario()
    {
        $fila = $this->_usuario->obtenerUsuario();
        $tabla = '';

        for ($i = 0; $i < count($fila); $i++) {
            $tabla .= '
            <tr>
                <td>' . $fila[$i]['idUsuario'] . '</td>
                <td>' . $fila[$i]['nombreUsuario'] . '</td>
                <td>' . $fila[$i]['clave'] . '</td>
                <td>' . $fila[$i]['rol'] . '</td>
                <td>
                    <button class="btn btn-secondary btn-circle" disabled>
                        <i class="fa-solid fa-lock"></i>
                    </button>
                </td>
            </tr>';
        }

        return $tabla;
    }

    public function index()
    {
        Sessiones::acceso('administrador');
        $this->_view->tabla = $this->verUsuario();
        $this->_view->renderizar('usuario');
    }

    public function agregarUsuario()
    {
        $clave = $this->getTexto('clave');
        $repetirClave = $this->getTexto('repetir');

        if ($clave === '' || $clave !== $repetirClave) {
            http_response_code(400);
            echo 'Las claves no coinciden';
            return;
        }

        $this->_usuario->insertarUsuario(
            $this->getTexto('nombreUsuario'),
            $clave,
            $this->getTexto('rolUsuario')
        );

        echo $this->verUsuario();
    }
}
