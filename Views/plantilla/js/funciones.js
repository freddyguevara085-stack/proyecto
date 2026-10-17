$(document).ready(function () {

    let baseUrl="http://localhost/proyecto/Views/Plantilla/";

    incializarDataTable();

    Fancybox.bind('[data-fancybox="gallery"]', {
        // Your custom options for a specific gallery
    });

    /* Funcion para enviar los datos del formulario de registro de estudiantes y agregar a la BD */

    $('#formAgregarAlumno').submit(function (e) {
        e.preventDefault();

        if ($('#claveUsuarioEstudiante').val() !== $('#repetirClaveUsuarioEstudiante').val()) {
            Swal.fire({
                title: "Error",
                text: "Las contraseñas no coinciden",
                icon: "error"
            });
            return;
        }

        $.ajax({
            url: 'alumno/agregarAlumno',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                if (respuesta.trim() === 'ERROR_EDAD') {
                    Swal.fire({
                        title: "Edad no valida",
                        text: "Ingrese una edad entera entre 0 y 150",
                        icon: "error"
                    });
                    return;
                }

                if (respuesta.trim() === 'ERROR_CLAVE') {
                    Swal.fire({
                        title: "Error",
                        text: "Las contraseñas no coinciden",
                        icon: "error"
                    });
                    return;
                }

                $('#modalAgregarAlumno').modal('hide');
                $('#formAgregarAlumno')[0].reset();
                $('#myTable').DataTable().destroy();
                $('#myTable tbody').html(respuesta);
                incializarDataTable();
                Swal.fire({
                    title: "Se agrego registro!",
                    text: "con exito!",
                    icon: "success"
                });

            }
        });

    });

    /*Funcion para cargar los datos en el formulario de editar Alumno */

    $("#myTable").on("click", ".btnEditarAlumno", function () {

        var datos = JSON.parse($(this).attr("data-Alumno"));
        console.log(datos);
        $('#carnetA').val(datos.carnet);
        $('#primerNombreAUp').val(datos.primerNombre);
        $('#segundoNombreAUp').val(datos.segundoNombre);
        $('#primerApellidoAUp').val(datos.primerApellido);
        $('#segundoApellidoAUp').val(datos.segundoApellido);
        $('#sexoAUp').val(datos.sexo);
        $('#edadAUp').val(datos.edad);
        $('#nacimientoAUp').val(datos.fechaNacimiento);
        $('#correoAUp').val(datos.correo);
        $('#telefonoAUp').val(datos.telefono);
        $('#direccionAUp').val(datos.direccion);
        $('#imagenPrw').attr("src", baseUrl + "img/" + datos.imagen);





    });

    /* Funcion para enviar los datos del formulario de editar estudiante y actualizar en la BD */
    $('#formEditarAlumno').submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: 'alumno/editarAlumno',
                type: 'post',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    if (respuesta.trim() === 'ERROR_EDAD') {
                        Swal.fire({
                            title: "Edad no valida",
                            text: "Ingrese una edad entera entre 0 y 150",
                            icon: "error"
                        });
                        return;
                    }

                    $('#modalEditarAlumno').modal('hide');
                    $('#formEditarAlumno')[0].reset();
                    $('#myTable').DataTable().destroy();
                    $('#myTable tbody').html(respuesta);
                    incializarDataTable();
                    Swal.fire({
                        title: "Se edito el registro!",
                        text: "con exito!",
                        icon: "success"
                    });

                }
            });

        });





    /* Funcion para eliminar registros de alumno */
    $("#myTable").on("click", ".btnBorrarAlumno", function () {

        Swal.fire({
            title: "Estas seguro?",
            text: "No podras revertir esta acción!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Eliminar!",
            cancelButtonText: "Cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                var idAlumno = $(this).attr("data-borrarAlumno");
                console.log(idAlumno);
                $.ajax({
                    url: 'alumno/borrarAlumno',
                    type: "POST",
                    data: { "id": idAlumno },
                    success: function (respuesta) {
                        console.log(respuesta);
                        $("#myTable").DataTable().destroy();
                        $("#myTable tbody").html(respuesta);
                        incializarDataTable();
                        Swal.fire({
                            title: "Eliminado!",
                            text: "Registro eliminado.",
                            icon: "success"
                        });

                    }



                });
            }
            else if (result.dismiss === Swal.DismissReason.cancel) Swal.fire({
                title: "Cancelado",
                text: "El registro no tuvo cambios :)",
                icon: "error"
            });



        });


    });


    /* Funcion para agregar materia */
    
    $('#formAgregarMateria').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: 'materia/agregarMateria',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalAgregarMateria').modal('hide');
                $('#formAgregarMateria')[0].reset();
                $('#myTable').DataTable().destroy();
                $('#myTable tbody').html(respuesta);
                incializarDataTable();
                Swal.fire({
                    title: "Se agrego registro!",
                    text: "con exito!",
                    icon: "success"
                });

            }
        });

    });

     /*Funcion para cargar los datos en el formulario de editar materia */

    $("#myTable").on("click", ".btnEditarMateria", function () {

        var datos = JSON.parse($(this).attr("data-Materia"));
        console.log(datos);
        $('#idM').val(datos.id);
        $('#nombreMateriaUp').val(datos.nombreMateria);
        $('#cicloUp').val(datos.ciclo);
        $('#creditosUp').val(datos.creditos);
       
    });

    /* Funcion editar materia mandando los datos al controlador */

     $('#formEditarMateria').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: 'materia/actualizarMateria',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                console.log (respuesta);
                $('#modalEditarMateria').modal('hide');
                $('#formEditarMateria')[0].reset();
                $('#myTable').DataTable().destroy();
                $('#myTable tbody').html(respuesta);
                incializarDataTable();
                Swal.fire({
                    title: "Se Actualizo el registro!",
                    text: "con exito!",
                    icon: "success"
                });

            }
        });

    });

    /* ===================================================
       FUNCIONES CRUD PARA GRUPO
       =================================================== */

    $('#formAgregarGrupo').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'grupo/agregarGrupo',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalAgregarGrupo').modal('hide');
                $('#formAgregarGrupo')[0].reset();
                $('#myTable').DataTable().destroy();
                $('#myTable tbody').html(respuesta);
                incializarDataTable();
                Swal.fire({
                    title: "Se agrego registro!",
                    text: "con exito!",
                    icon: "success"
                });
            }
        });
    });

    $("#myTable").on("click", ".btnEditarGrupo", function () {
        var datos = JSON.parse($(this).attr("data-Grupo"));
        $('#idGrupoUp').val(datos.idGrupo);
        $('#nombreGrupoUp').val(datos.nombreGrupo);
    });

    $('#formEditarGrupo').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'grupo/editarGrupo',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalEditarGrupo').modal('hide');
                $('#formEditarGrupo')[0].reset();
                $('#myTable').DataTable().destroy();
                $('#myTable tbody').html(respuesta);
                incializarDataTable();
                Swal.fire({
                    title: "Se edito el registro!",
                    text: "con exito!",
                    icon: "success"
                });
            }
        });
    });

    $("#myTable").on("click", ".btnBorrarGrupo", function () {
        Swal.fire({
            title: "Estas seguro?",
            text: "No podras revertir esta acción!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Eliminar!",
            cancelButtonText: "Cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                var idGrupo = $(this).attr("data-borrarGrupo");
                $.ajax({
                    url: 'grupo/borrarGrupo',
                    type: "POST",
                    data: { "id": idGrupo },
                    success: function (respuesta) {
                        $("#myTable").DataTable().destroy();
                        $("#myTable tbody").html(respuesta);
                        incializarDataTable();
                        Swal.fire({
                            title: "Eliminado!",
                            text: "Registro eliminado.",
                            icon: "success"
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: "Cancelado",
                    text: "El registro no tuvo cambios :)",
                    icon: "error"
                });
            }
        });
    });

    /* ===================================================
       FUNCIONES CRUD PARA DOCENTE
       =================================================== */

    $('#formAgregarDocente').submit(function (e) {
        e.preventDefault();

        if ($('#claveUsuarioDocente').val() !== $('#repetirClaveUsuarioDocente').val()) {
            Swal.fire({
                title: "Error",
                text: "Las contraseñas no coinciden",
                icon: "error"
            });
            return;
        }

        $.ajax({
            url: 'docente/agregarDocente',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                if (respuesta === 'ERROR_CLAVE') {
                    Swal.fire({
                        title: "Error",
                        text: "Las contraseñas no coinciden",
                        icon: "error"
                    });
                    return;
                }

                $('#modalAgregarDocente').modal('hide');
                $('#formAgregarDocente')[0].reset();
                $('#myTable').DataTable().destroy();
                $('#myTable tbody').html(respuesta);
                incializarDataTable();
                Swal.fire({
                    title: "Se agrego registro!",
                    text: "con exito!",
                    icon: "success"
                });
            }
        });
    });

    $("#myTable").on("click", ".btnEditarDocente", function () {
        var datos = JSON.parse($(this).attr("data-Docente"));
        $('#idDocenteUp').val(datos.idDocente);
        $('#nombreDocenteUp').val(datos.nombreDocente);
        $('#especialidadUp').val(datos.especialidad);
    });

    $('#formEditarDocente').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'docente/editarDocente',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalEditarDocente').modal('hide');
                $('#formEditarDocente')[0].reset();
                $('#myTable').DataTable().destroy();
                $('#myTable tbody').html(respuesta);
                incializarDataTable();
                Swal.fire({
                    title: "Se edito el registro!",
                    text: "con exito!",
                    icon: "success"
                });
            }
        });
    });

    $("#myTable").on("click", ".btnBorrarDocente", function () {
        Swal.fire({
            title: "Estas seguro?",
            text: "No podras revertir esta acción!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Eliminar!",
            cancelButtonText: "Cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                var idDocente = $(this).attr("data-borrarDocente");
                $.ajax({
                    url: 'docente/borrarDocente',
                    type: "POST",
                    data: { "id": idDocente },
                    success: function (respuesta) {
                        $("#myTable").DataTable().destroy();
                        $("#myTable tbody").html(respuesta);
                        incializarDataTable();
                        Swal.fire({
                            title: "Eliminado!",
                            text: "Registro eliminado.",
                            icon: "success"
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: "Cancelado",
                    text: "El registro no tuvo cambios :)",
                    icon: "error"
                });
            }
        });
    });

    /* ===================================================
       FUNCIONES CRUD PARA MATRICULA
       =================================================== */

    $('#formAgregarMatricula').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'matricula/agregarMatricula',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalAgregarMatricula').modal('hide');
                $('#formAgregarMatricula')[0].reset();
                $('#myTable').DataTable().destroy();
                $('#myTable tbody').html(respuesta);
                incializarDataTable();
                Swal.fire({
                    title: "Se agrego registro!",
                    text: "con exito!",
                    icon: "success"
                });
            }
        });
    });

    $("#myTable").on("click", ".btnEditarMatricula", function () {
        var datos = JSON.parse($(this).attr("data-Matricula"));
        $('#idMatriculaUp').val(datos.idMatricula);
        $('#grupoIdGrupoUp').val(datos.grupoIdGrupo);
        $('#alumnoIdAlumnoUp').val(datos.alumnoIdAlumno);
    });

    $('#formEditarMatricula').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'matricula/editarMatricula',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalEditarMatricula').modal('hide');
                $('#formEditarMatricula')[0].reset();
                $('#myTable').DataTable().destroy();
                $('#myTable tbody').html(respuesta);
                incializarDataTable();
                Swal.fire({
                    title: "Se edito el registro!",
                    text: "con exito!",
                    icon: "success"
                });
            }
        });
    });

    $("#myTable").on("click", ".btnBorrarMatricula", function () {
        Swal.fire({
            title: "Estas seguro?",
            text: "No podras revertir esta acción!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Eliminar!",
            cancelButtonText: "Cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                var idMatricula = $(this).attr("data-borrarMatricula");
                $.ajax({
                    url: 'matricula/borrarMatricula',
                    type: "POST",
                    data: { "id": idMatricula },
                    success: function (respuesta) {
                        $("#myTable").DataTable().destroy();
                        $("#myTable tbody").html(respuesta);
                        incializarDataTable();
                        Swal.fire({
                            title: "Eliminado!",
                            text: "Registro eliminado.",
                            icon: "success"
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: "Cancelado",
                    text: "El registro no tuvo cambios :)",
                    icon: "error"
                });
            }
        });
    });

    /* ===================================================
       FUNCIONES CRUD PARA ASIGNACION COMPONENTE
       =================================================== */

    $('#formAgregarAsignacionComponente').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'asignacioncomponente/agregarAsignacionComponente',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalAgregarAsignacionComponente').modal('hide');
                $('#formAgregarAsignacionComponente')[0].reset();
                $('#myTable').DataTable().destroy();
                $('#myTable tbody').html(respuesta);
                incializarDataTable();
                Swal.fire({
                    title: "Se agrego registro!",
                    text: "con exito!",
                    icon: "success"
                });
            }
        });
    });

    $("#myTable").on("click", ".btnEditarAsignacionComponente", function () {
        var datos = JSON.parse($(this).attr("data-AsignacionComponente"));
        $('#idAsignacionUp').val(datos.idAsignacion);
        $('#docenteIdDocenteUp').val(datos.docenteIdDocente);
        $('#materiaAsignacionUp').val(datos.materiaAsignacion);
    });

    $('#formEditarAsignacionComponente').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'asignacioncomponente/editarAsignacionComponente',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalEditarAsignacionComponente').modal('hide');
                $('#formEditarAsignacionComponente')[0].reset();
                $('#myTable').DataTable().destroy();
                $('#myTable tbody').html(respuesta);
                incializarDataTable();
                Swal.fire({
                    title: "Se edito el registro!",
                    text: "con exito!",
                    icon: "success"
                });
            }
        });
    });

    $("#myTable").on("click", ".btnBorrarAsignacionComponente", function () {
        Swal.fire({
            title: "Estas seguro?",
            text: "No podras revertir esta acción!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Eliminar!",
            cancelButtonText: "Cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                var idAsignacion = $(this).attr("data-borrarAsignacionComponente");
                $.ajax({
                    url: 'asignacioncomponente/borrarAsignacionComponente',
                    type: "POST",
                    data: { "id": idAsignacion },
                    success: function (respuesta) {
                        $("#myTable").DataTable().destroy();
                        $("#myTable tbody").html(respuesta);
                        incializarDataTable();
                        Swal.fire({
                            title: "Eliminado!",
                            text: "Registro eliminado.",
                            icon: "success"
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: "Cancelado",
                    text: "El registro no tuvo cambios :)",
                    icon: "error"
                });
            }
        });
    });

    /* ===================================================
       FUNCIONES CRUD PARA USUARIO
       =================================================== */



    $('#formAgregarUsuario').submit(function (e) {
        e.preventDefault();

        if ($('#clave').val() !== $('#repetir').val()) {
            Swal.fire({
                title: "Las claves no coinciden",
                text: "Verifica la clave y vuelve a intentarlo.",
                icon: "error"
            });
            return;
        }

        $.ajax({
            url: 'usuario/agregarUsuario',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalAgregarUsuario').modal('hide');
                $('#formAgregarUsuario')[0].reset();
                $('#myTable').DataTable().destroy();
                $('#myTable tbody').html(respuesta);
                incializarDataTable();
                Swal.fire({
                    title: "Se agrego registro!",
                    text: "con exito!",
                    icon: "success"
                });
            },
            error: function (respuesta) {
                Swal.fire({
                    title: "No se pudo guardar",
                    text: respuesta.responseText,
                    icon: "error"
                });
            }
        });
    });


    // funcion para inscripcion de componentes
    $('#formInscribirMateria').submit(function (e) {
        e.preventDefault();


        $.ajax({
            url: 'inscripcionComponente/inscribirMateria',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalInscribirComponente').modal('hide');
                $('#formInscribirMateria')[0].reset();
                $('#myTable').DataTable().destroy();
                $('#myTable tbody').html(respuesta);
                incializarDataTable();
                Swal.fire({
                    title: "Se agrego registro!",
                    text: "con exito!",
                    icon: "success"
                });
            },
            error: function (respuesta) {
                Swal.fire({
                    title: "No se pudo guardar",
                    text: respuesta.responseText,
                    icon: "error"
                });
            }
        });
    });








    /* Mostrar / Ocultar contraseñas */
    $(document).on("click", ".btnTogglePassword", function (e) {
        e.preventDefault();
        let targetSelector = $(this).attr("data-target") || $(this).data("target");
        let input = targetSelector ? $(targetSelector) : $(this).closest(".input-group").find("input");
        let icon = $(this).find("i");

        if (input.length) {
            if (input.attr("type") === "password") {
                input.attr("type", "text");
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
            } else {
                input.attr("type", "password");
                icon.removeClass("fa-eye-slash").addClass("fa-eye");
            }
            input.focus();
        }
    });

    $('.modal').on('hidden.bs.modal', function () {
        $(this).find('.password-toggle-input').attr('type', 'password');
        $(this).find('.btnTogglePassword i').removeClass('fa-eye-slash').addClass('fa-eye');
    });

});


function incializarDataTable() {

    $('#myTable').DataTable({
        dom: 'Bftrip',
        buttons: [
            'copy', 'excel', 'pdf', 'print'
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.1.5/i18n/es-MX.json',
        },
        responsive: true
    });



}



function ocultarPass(elemento, icono) {
    let input = document.getElementById(elemento) || document.querySelector(elemento);
    if (!input) return;
    let icon = icono.tagName === "I" ? icono : (icono.querySelector("i") || icono);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
    input.focus();
}