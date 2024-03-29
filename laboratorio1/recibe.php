<?php
include "lib/header.php";
include "clases.php";

// Crear un objeto gestorNoticia
$manejador = new gestorNoticia();

// Verificar si se ha enviado el formulario para agregar una noticia
if (isset($_POST['enviar'])) {
    // Obtener los valores del formulario
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $fecha = $_POST['fecha'];
    $autor = $_POST['autor'];
    $noticia = $_POST['noticia'];

    // Utilizar el método agregarNoticia
    $manejador->agregarNoticia($id, $titulo, $fecha, $autor, $noticia);
}

// Verificar si se ha enviado la solicitud para eliminar una noticia
if (isset($_GET['eliminar'])) {
    // Obtener el ID de la noticia a eliminar
    $idNoticiaEliminar = $_GET['eliminar'];

    // Llamar a la función eliminarNoticia del gestor de noticias
    $manejador->eliminarNoticia($idNoticiaEliminar);
}

// Verificar si se ha enviado el formulario para editar una noticia
if (isset($_POST['editar'])) {
    // Obtener los valores del formulario de edición
    $id = $_POST['id'];
    $nuevoTitulo = $_POST['titulo'];
    $nuevaFecha = $_POST['fecha'];
    $nuevoAutor = $_POST['autor'];
    $nuevaNoticia = $_POST['noticia'];
    // Utilizar el método editarNoticia
    $manejador->editarNoticia($id, $nuevoTitulo, $nuevaFecha, $nuevoAutor, $nuevaNoticia);
}

?>

<style>
    body {
        background-image: linear-gradient(to right, #9CCC65 0%, #8BC34A 20%, #7CB342 40%, #689F38 60%, #558B2F 80%, #33691E 100%);
        /* Gradient ajustado al estilo Frutiger Aero */
        background-size: 800px;
        /* Adjust for larger patterns */
        animation: animateBackground 10s ease-in-out infinite;
        /* Animation for movement */
    }

    @keyframes animateBackground {
        from {
            background-position: 0 0;
        }

        to {
            background-position: -800px 0;
        }
    }
</style>

<h1>Noticias actuales</h1>

<div class="container-fluid"> <!-- Aumento del ancho del contenedor -->
    <div class="row justify-content-center">
        <div class="col-md-12"> <!-- Aumento del ancho -->
        <button type="button" class="btn btn-primary mb-3" id="btnVerMasRecientes">Ver más recientes</button>
            <table class="table table-bordered table-dark" id="tablaNoticias">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Autor</th>
                        <th>Noticia</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Verificar si el array de noticias no está vacío antes de iterar sobre él
                    if (!empty($manejador->getNoticias())) {
                        $noticias = $manejador->getNoticias();
                        foreach ($noticias as $noticia) {
                    ?>
                            <tr>
                                <td><?php echo $noticia->getTitulo(); ?></td>
                                <td><?php echo $noticia->getFecha(); ?></td>
                                <td><?php echo $noticia->getAutor(); ?></td>
                                <td><?php echo $noticia->getNoticia(); ?></td>
                                <td>
                                    <a href="#" class="btn btn-danger" onclick="confirmarEliminar(<?php echo $noticia->getId(); ?>)">
                                        <i class="fas fa-trash-alt"></i> <!-- Ícono de bote de basura -->
                                    </a>

                                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#editModal" data-id="<?php echo $noticia->getId(); ?>" data-titulo="<?php echo $noticia->getTitulo(); ?>" data-fecha="<?php echo $noticia->getFecha(); ?>" data-autor="<?php echo $noticia->getAutor(); ?>" data-noticia="<?php echo $noticia->getNoticia(); ?>">
                                        <i class="fas fa-pencil-alt"></i> <!-- Ícono de lápiz -->
                                    </a>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        // En caso de que no haya noticias disponibles
                        echo "<tr><td colspan='5'>No hay noticias disponibles</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
//Incluir la pagina footer
include "lib/footer.php";
?>

<!-- Script para ordenar noticias -->
<script>
    $(document).ready(function() {
        // Función para ordenar las filas por fecha de manera descendente
        function ordenarPorFechaDescendente() {
            var tbody = $('#tablaNoticias tbody');
            tbody.find('tr').sort(function(a, b) {
                return new Date($(b).find('td:eq(1)').text()) - new Date($(a).find('td:eq(1)').text());
            }).appendTo(tbody);
        }

        // Manejar el clic en el botón "Ver más recientes"
        $('#btnVerMasRecientes').click(function() {
            // Llamar a la función para ordenar las filas
            ordenarPorFechaDescendente();
        });
    });
</script>


<!--- SCRIPT PARA CONFIRMAR ELIMINAR --->
<script>
    function confirmarEliminar(idNoticia) {
        // Mostrar un modal de confirmación
        if (confirm('¿Estás seguro de querer eliminar esta noticia?')) {
            // Si el usuario confirma, redirigir a la URL de eliminar
            window.location.href = "?eliminar=" + idNoticia;
        } else {
            // Si el usuario cancela, no hacer nada
            return false;
        }
    }
</script>

<!-- Modal de edición -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Noticia</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="id" class="form-label">Id:</label>
                        <input type="text" class="form-control" id="id" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo">
                    </div>
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="fecha">
                    </div>
                    <div class="mb-3">
                        <label for="autor" class="form-label">Autor</label>
                        <input type="text" class="form-control" id="autor">
                    </div>
                    <div class="mb-3">
                        <label for="noticia" class="form-label">Noticia</label>
                        <textarea class="form-control" id="noticia" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="btnGuardarCambios">Guardar cambios</button>

            </div>
        </div>
    </div>
</div>

<!-- Script de edicion -->
<script>
    $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var titulo = button.data('titulo');
        var fecha = button.data('fecha');
        var autor = button.data('autor');
        var noticia = button.data('noticia');
        // Establecer valores en los campos del formulario
        var modal = $(this);
        modal.find('#id').val(id);
        modal.find('#titulo').val(titulo);
        modal.find('#fecha').val(fecha);
        modal.find('#autor').val(autor);
        modal.find('#noticia').val(noticia);
    });

    $('#btnGuardarCambios').click(function() {
        var id = $('#id').val();
        var titulo = $('#titulo').val();
        var fecha = $('#fecha').val();
        var autor = $('#autor').val();
        var noticia = $('#noticia').val();
        
        $.post('recibe.php', {
            editar: '1',
            id: id,
            titulo: titulo,
            fecha: fecha,
            autor: autor,
            noticia: noticia
        }, function(data) {
            // Recargar la página después de editar la noticia
            location.reload();
        });
    });
</script>


