<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Calendario Académico - Agenda Jobs</title>
    <link rel="stylesheet" href="../resources/css/fullcalendar.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="../resources/css/home.css">
</head>
<body>
    <?php
    require_once('../controlador/EventController.php');
    $eventController = new EventController();
    $eventos = $eventController->obtenerEventos();
    ?>

    <div class="container">
        <a class="btn btn-success btn-lg" href="../menu_admin.php">Regresar</a><br><br>
        <div class="row">
            <div class="col msjs">
                <?php include('./Vmsjs.php'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <h3 class="text-center" id="title">Agenda Steve Jobs</h3>
            </div>
        </div>
    </div>

    <div id="calendar"></div>

    <?php  
    include('./VmodalNuevoEvento.php');
    include('./VmodalUpdateEvento.php');
    ?>

    <script src="../resources/js/jquery-3.0.0.min.js"></script>
    <script src="../resources/js/popper.min.js"></script>
    <script src="../resources/js/bootstrap.min.js"></script>
    <script src="../resources/js/moment.min.js"></script>
    <script src="../resources/js/fullcalendar.min.js"></script>
    <script src='../resources/locales/es.js'></script>

    <script type="text/javascript">
    $(document).ready(function() {
        var eventos = <?php echo json_encode($eventos); ?>;
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            locale: 'es',
            defaultView: 'month',
            navLinks: true,
            editable: true,
            eventLimit: true,
            selectable: true,
            selectHelper: true,
            events: eventos,

            select: function(start, end) {
                $("#exampleModal").modal();
                $("input[name='fecha_inicio']").val(start.format('YYYY-MM-DD'));
                $("input[name='fecha_fin']").val(end.format('YYYY-MM-DD'));
            },

            eventRender: function(event, element) {
                element.find(".fc-content").prepend("<span id='btnCerrar' class='closeon material-icons'>&#xe5cd;</span>");
                element.find(".closeon").on("click", function() {
                    if (confirm("Deseas borrar este evento?")) {
                        $('#calendar').fullCalendar('removeEvents', event._id);
                        $.ajax({
                            type: "POST",
                            url: './VdeleteEvento.php',
                            data: {id: event._id},
                            success: function(response) {
                                alert("Evento eliminado");
                            }
                        });
                    }
                });
            },

            eventDrop: function(event, delta, revertFunc) {
                var start = event.start.format('YYYY-MM-DD');
                var end = (event.end ? event.end.format('YYYY-MM-DD') : start);
                $.ajax({
                    url: './Vdrag_drop_evento.php',
                    data: 'start=' + start + '&end=' + end + '&idEvento=' + event._id,
                    type: "POST",
                    success: function(response) {
                        alert("Evento actualizado");
                    }
                });
            },

            eventClick: function(event) {
                $("input[name='idEvento']").val(event._id);
                $("input[name='evento']").val(event.title);
                $("input[name='fecha_inicio']").val(event.start.format('YYYY-MM-DD'));
                $("input[name='fecha_fin']").val((event.end ? event.end.format("YYYY-MM-DD") : event.start.format('YYYY-MM-DD')));
                $("#modalUpdateEvento").modal();
            },
        });

        setTimeout(function() {
            $(".alert").slideUp(300);
        }, 3000);
    });
    </script>
</body>
</html>