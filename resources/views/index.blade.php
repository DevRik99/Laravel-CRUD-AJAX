<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CRUD (MVC)- SENATI</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="https://www.senati.edu.pe/sites/all/themes/senati_theme/favicon/favicon.ico"
        type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>

<body>
    <div class="container p-4 ">
        <h1 class="text-center">CRUD - SENATI</h1>
        <!-- <button type="button" id="myModal" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Launch demo modal
        </button> -->

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <form method="POST" action="{{ route('usuarios.store') }}" class="modal-dialog"
                role="document">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar nuevo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="form-group">
                                <label for="name">Nombre:</label>
                                <input type="text" required name="name" class="form-control" id="name"
                                    placeholder="Tu nombre">
                            </div>
                            <div class="form-group">
                                <label for="area">Area:</label>
                                <input type="text" required name="area" class="form-control" id="area"
                                    placeholder="Area de trabajo">
                            </div>
                            <div class="form-group">
                                <label for="phone">Telefono:</label>
                                <input type="number" min="1" required name="phone" class="form-control" id="phone"
                                    placeholder="Telefono">
                            </div>
                            <div class="form-group">
                                <label for="register">Fecha de registro:</label>
                                <input type="register" readonly required class="form-control" id="register"
                                    placeholder="">
                                <small>La fecha de registro se genera de forma automatica.</small>
                                <br>
                                <small class="text-danger">El ID es autoincrementable, los nuevos usuarios aparecen al
                                    final.</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <p type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</p>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8">
                            <h2>Gestion de <b>usuarios</b></h2>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" data-toggle="modal" data-target="#exampleModal"
                                class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar
                                nuevo</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Titulo</th>
                            <th>Telefono</th>
                            <th>Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                            <tr>
                                <td class="number">{{ $usuario->id }}</td>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->area }}</td>
                                <td class="number">{{ $usuario->phone }}</td>
                                <td class="text-capitalize">{{ $usuario->created_at->diffForHumans() }}</td>
                                <td>
                                    <a class="add" title="Actualizar" data-toggle="tooltip"><i
                                            class="material-icons">&#xE03B;</i></a>
                                    <a class="edit" title="Editar" data-toggle="tooltip"><i
                                            class="material-icons">&#xE254;</i></a>
                                    <a class="delete" title="Eliminar" data-toggle="tooltip"><i
                                            class="material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="font-weight: bold"
                                    class="text-center text-danger text-bold text-uppercase">No hay usuarios que
                                    mostrar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $usuarios->links() }}
        </div>
        <p></p>
    </div>
    <script>
        $(document).ready(function () {
            let oldData = [];
            $('[data-toggle="tooltip"]').tooltip();
            var actions = `
                            <a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                            <a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                            <a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                            `;
            let getTime = () => {
                let current_datetime = new Date()
                let formatted_date = current_datetime.getFullYear() + "-" + (current_datetime.getMonth() +
                        1) + "-" +
                    current_datetime.getDate() + " " + current_datetime.getHours() + ":" + current_datetime
                    .getMinutes() +
                    ":" + current_datetime.getSeconds()
                return formatted_date
            }

            $(document).on("click", ".edit", function () {
                oldData = []
                $(this).parents("tr").find("td:not(:last-child)").each(function () {
                    if (!$(this).hasClass("text-capitalize")) {
                        if (!$(this).hasClass("number")) {
                            $(this).html(
                                '<input type="text" class="form-control" value="' +
                                $(this).text() + '">');
                        } else {
                            oldData.push($(this).text())
                            $(this).html(
                                '<input type="number" class="form-control" value="' +
                                $(this)
                                .text() + '">');
                        }
                    }
                });
                $(this).parents("tr").find(".add, .edit").toggle();
                $(".add-new").attr("disabled", "disabled");
            });
            $(document).on("click", ".add", function () {
                var empty = false;
                let data = []
                var input = $(this).parents("tr").find('input[type="text"]');
                var number = $(this).parents("tr").find('input[type="number"]');
                input.each(function () {
                    if (!$(this).val()) {
                        $(this).addClass("error");
                        empty = true;
                    } else {
                        $(this).removeClass("error");
                    }
                });
                number.each(function () {
                    if (!$(this).val()) {
                        $(this).addClass("error");
                        empty = true;
                    } else {
                        $(this).removeClass("error");
                    }
                });
                $(this).parents("tr").find(".error").first().focus();

                if (!empty) {
                    input.each(function () {
                        $(this).parent("td").html($(this).val());
                        data.push($(this).val())
                    });
                    number.each(function () {
                        $(this).parent("td").html($(this).val());
                        data.push($(this).val())
                    });
                    $(this).parents("tr").find(".add, .edit").toggle();
                    $(".add-new").removeAttr("disabled");

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "update",
                        data: {
                            'oldId': oldData[0],
                            'id': data[2],
                            'name': data[0],
                            'area': data[1],
                            'phone': data[3],
                        },
                        type: 'POST',
                        success: data => {
                            if (data) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Los datos fueron actulizados con exito.',
                                    showConfirmButton: true,
                                    timer: 2500
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Algo salio al intentar actualizar los datos, revisa que el ID no este en uso y que los datos ingresados sean correctos.'
                                }).then(() => {
                                    location.reload();
                                })
                            }
                        },
                    });
                }
            });
            // Delete row on delete button click
            $(document).on("click", ".delete", function () {
                Swal.fire({
                    title: '¿Estas seguro de eliminar este usuario?',
                    text: "Recuerda que esta proceso es irreversible.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Estoy seguro'
                }).then((result) => {
                    if (result.value) {
                        $(this).parents("tr").remove();
                        let parent = $(this).parents("tr")
                        let td = $(this).parents("tr").children("td")
                        let id = td[0].textContent
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            }
                        });

                        $.ajax({
                            url: "delete",
                            data: {
                                'id': id
                            },
                            type: 'POST',
                            success: data => {
                                console.log(data)
                            },
                            error: function (error) {
                                console.log(error)
                            }
                        });
                        $(".add-new").removeAttr("disabled");
                        Swal.fire(
                            'Eliminado',
                            'El usuario fue eliminado con exito',
                            'success'
                        )
                    }
                })
            });
            $('#myModal').on('shown.bs.modal', function () {
                $('#myInput').trigger('focus')
            })
            document.querySelector(".add-new").addEventListener("click", e => {
                $('#register').val(getTime())
            })
        });

    </script>
</body>

</html>
