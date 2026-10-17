<?php

class notasController extends Controller
{
    private $_notas;

    public function __construct()
    {
        parent::__construct();
        $this->_notas = $this->loadModel("notas");
    }

    public function index()
    {
        Sessiones::acceso('alumno');

        $nombreUsuario = Sessiones::getClave('usuario');
        $alumno = $this->_notas->obtenerDatosAlumno($nombreUsuario);

        $this->_view->alumno = $alumno;

        if ($alumno && !empty($alumno['carnet'])) {
            $registros = $this->_notas->obtenerNotasPorAlumno($alumno['carnet']);
            $this->_view->tabla = $this->generarTablaNotas($registros);
        } else {
            $this->_view->tabla = '';
        }

        $this->_view->renderizar('notas');
    }

    private function generarTablaNotas($registros)
    {
        if (empty($registros)) {
            return '';
        }

        $tabla = '';
        foreach ($registros as $index => $row) {
            $ip = $row['IP'] !== null && $row['IP'] !== '' ? number_format((float)$row['IP'], 2) : null;
            $iip = $row['IIP'] !== null && $row['IIP'] !== '' ? number_format((float)$row['IIP'], 2) : null;
            $iiip = $row['IIIP'] !== null && $row['IIIP'] !== '' ? number_format((float)$row['IIIP'], 2) : null;
            $nf = $row['NF'] !== null && $row['NF'] !== '' ? number_format((float)$row['NF'], 2) : null;

            // Determinar estado de la materia
            if ($nf !== null) {
                if ((float)$nf >= 60) {
                    $badgeEstado = '<span class="badge bg-success text-white px-2 py-1"><i class="fa-solid fa-circle-check"></i> Aprobado</span>';
                } else {
                    $badgeEstado = '<span class="badge bg-danger text-white px-2 py-1"><i class="fa-solid fa-circle-xmark"></i> Reprobado</span>';
                }
            } else {
                $badgeEstado = '<span class="badge bg-info text-dark px-2 py-1"><i class="fa-solid fa-clock"></i> En Curso</span>';
            }

            $ipBadge = $ip !== null ? '<span class="fw-bold">' . $ip . '</span>' : '<span class="text-muted fst-italic">Pendiente</span>';
            $iipBadge = $iip !== null ? '<span class="fw-bold">' . $iip . '</span>' : '<span class="text-muted fst-italic">Pendiente</span>';
            $iiipBadge = $iiip !== null ? '<span class="fw-bold">' . $iiip . '</span>' : '<span class="text-muted fst-italic">Pendiente</span>';
            $nfBadge = $nf !== null ? '<span class="fw-bold fs-6 text-primary">' . $nf . '</span>' : '<span class="text-muted fst-italic">Pendiente</span>';

            $tabla .= '<tr>
                <td class="text-center">' . ($index + 1) . '</td>
                <td><strong>' . htmlspecialchars($row['nombreMateria']) . '</strong></td>
                <td>' . htmlspecialchars($row['docente']) . '</td>
                <td class="text-center">' . $ipBadge . '</td>
                <td class="text-center">' . $iipBadge . '</td>
                <td class="text-center">' . $iiipBadge . '</td>
                <td class="text-center">' . $nfBadge . '</td>
                <td class="text-center">' . $badgeEstado . '</td>
            </tr>';
        }

        return $tabla;
    }
}
