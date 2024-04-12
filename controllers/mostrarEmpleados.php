
<?php
function mostrarEmpleados()
{

    $objConsultas = new Consultas();
    // $result = $objConsultas -> ;
    $resultado = $objConsultas->cargarEmpleados();


    if (!isset($resultado)) {
        echo "<h2>No hay empleados registrados</h2>";
        return;
    }

    foreach ($resultado as $f) {
        echo '
            <tbody>
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <a href="#" class="employee-img">
                                            <img src="' . $f['foto'] . '" alt="employee">
                                        </a>
                                        <a href="#">' . $f['nombres'] . '</a>
                                    </td>
                                    <td>' . $f['apellidos'] . '</td>
                                    <td>' . $f['documento'] . '</td>
                                    <td>' . $f['tipo_documento'] . '</td>
                                    <td>' . $f['telefono'] . '</td>
                                    <td><a href="mailto:thomas@example.com">' . $f['correo'] . '</a> </td>
                                    <td><span class="bg-lightgreen badges">' . $f['estado'] . '</span></td>
                                    <td>' . $f['rol'] . '</td>

                                    <td>' . $f['fecha_de_creacion'] . '</td>
                                    <td>
                                        <a class="me-3 confirm-text" href="javascript:void(0);">
                                            <img src="../../imgs/icons/eye.svg" alt="eye">
                                        </a>
                                        <a class="me-3" href="editarEmpleado.html">
                                            <img src="../../imgs/icons/edit.svg" alt="eye">
                                        </a>
                                        <a class="me-3 confirm-text" href="javascript:void(0);">
                                            <img src="../../imgs/icons/trash.svg" alt="trash">

                                        </a>
                                    </td>
                                </tr>
            </tbody>
        ';
    }
}
?>