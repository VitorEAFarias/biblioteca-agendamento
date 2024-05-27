<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/locales-all.min.js"></script>
<script src='https://unpkg.com/popper.js/dist/umd/popper.min.js'></script>
<script src='https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js'></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.min.css">

<style>
  .fc .fc-timegrid-slot-minor {
    border-top-style: none;
  }

  .fc-theme-standard .fc-scrollgrid {
    border: none !important;
  }

  #calendar a {
    text-decoration: none;
    color: black;
  }

  .fc-col-header-cell-cushion {
    color: grey;
    text-decoration: none;
    font-weight: 400 !important;
  }

  .fc .fc-timegrid-col.fc-day-today {
    background-color: white;
  }

  .cor-sala {
    width: 30px;
    height: 15px;
    border-radius: 5px;
  }

  .btn-acesso {
    padding: 10px 10px;
    border: 1px solid #0F4192;
    background-color: white;
    border-radius: 8px;
    margin-right: 20px;
    color: #0F4192;
    margin-bottom: 20px;
  }

  .btn-acesso:hover {
    border: 1px solid white;
    background-color: #0F4192;
    color: white;
  }

  .btn-cadastro {
    background-color: #4463B0;
    border: 1px solid #4463B0;
    border-radius: 8px;
    color: white;
  }

  .btn-cadastro:hover {
    background-color: white;
    border-radius: 8px;
    color: #4463B0;
  }

  .active {
    border: none;
    background-color: white;
    color: #0F4192;
  }

  .fc-prev-button,
  .fc-next-button {
    background-color: white !important;
    border-radius: 50% !important;
    width: 40px !important;
    height: 40px !important;
    padding: 0 !important;
  }

  .fc-today-button,
  .fc-timeGridDay-button,
  .fc-timeGridWeek-button {
    color: #0f4192 !important;
    border: none !important;
    background-color: white !important;
    border-radius: 5px !important;
  }

  .fc-icon-chevron-left:before,
  .fc-icon-chevron-right:before {
    color: #0f4192;
  }

  .fc-button-active {
    background-color: #0f4192 !important;
    color: white !important;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      timeZone: 'UTC',
      dayMaxEventRows: true,
      views: {
        timeGrid: {
          dayMaxEventRows: 1
        }
      },

      initialView: 'timeGridWeek',
      headerToolbar: {
        left: 'title',
        center: 'prev today next',
        right: 'timeGridDay,timeGridWeek'
      },

      locale: 'pt-br',
      buttonIcons: true,
      navLinks: true,
      editable: false,
      eventLimit: true,
      slotMinTime: '08:00:00',
      slotMaxTime: '18:00:00',
      events: [
        <?php
        foreach ($eventos as $key => $value) :
          if ($value['cancelado']) continue;

          $id = $value['evento_id'];

          foreach ($results as $valor) {
            if ($valor['evento_id'] == $id) {
              $data_final = date("d/m/Y", strtotime($valor['dataFinal']));
              $data_final_en = date("Y-m-d", strtotime($valor['dataFinal']));
            }
          }

          if ($user['user_adm'] == 1) {
            $title = utf8_decode($value['nomeEvento']);
            $id = $value['evento_id'];
          }

          if ($user['user_adm'] == 0) {
            $title = 'OCUPADO';
          }

          $color = $value['color'];

          $descriptionStart = date("d/m/Y", strtotime($value['data_evento'])) . ' das ' . $value['horaInicial'];
          $descriptionEnd =  $data_final . ' ate ' . $value['horaFinal'];
          $tituloInicio =  '<br /><b>Início:</b> ';
          $tituloTermino =  '<br /><b>Término:</b> ';

          $people = "<br /><b>Participantes: </b>" . $value['quantidade'];

          $tituloObservacoes =   '<hr /><b>Observações:</b> ';

          $tituloInicio = utf8_decode($tituloInicio);
          $tituloTermino = utf8_decode($tituloTermino);
          $tituloCafe = utf8_decode($tituloCafe);
          $tituloRecursos = utf8_decode($tituloRecursos);
          $tituloObservacoes = utf8_decode($tituloObservacoes);

          $nomeLocal = '<b>Local:</b> ' . utf8_decode($value['nomeLocal']);
          if (!$value['nomeLocal']) {
            $nomeLocal = '<b>Local:</b> ' .  utf8_decode('Não informado');
          }

          $solicitante = '<br /><b>Solicitante:</b> ' . utf8_decode($value['solicitante']);
          $ramal = '<br /><b>Ramal:</b> ' . utf8_decode($value['ramal']);
          $horarioCafe = '<br /><b>Horário Café:</b> ' . utf8_decode($value['horaInicialCafe']) . ' até ' . utf8_decode($value['horaFinalCafe']);
          $horarioCafe = utf8_decode($horarioCafe);

          $description =
            '<b>ID:</b>' . $id . '\n <br>' .
            '<b>Evento:</b> ' . $title
            . $solicitante . $ramal . '<br>' . $nomeLocal .  $tituloInicio . $descriptionStart .
            '\n' . $tituloTermino .  $descriptionEnd . $horarioCafe . $people .  '' . $tituloObservacoes . utf8_decode($value['observacoes']);
          $description = utf8_encode($description);
          $description = str_replace("'", 0, $description);

          $value['nomeEvento'] = str_replace("'", 0, $value['nomeEvento']);
          $value['data_evento'] = date('Y-m-d', strtotime($value['data_evento']));
          $value['horaInicial'] = $value['data_evento'] . ' ' . $value['horaInicial'];
          $value['horaFinal'] = $data_final_en . ' ' . $value['horaFinal'];

          if ($user['user_adm'] == 0) {
            $title = 'OCUPADO';
            echo "{
              title: 'OCUPADO',
              start: '{$value['horaInicial']}',
              end: '{$value['horaFinal']}',
              display: '{$value['color']}',
              color: '{$value['color']}',
              description:  \n''
            },";
          } else {
            echo "{
              id: '{$value['evento_id']}',
              title: '{$value['nomeEvento']}',
              start: '{$value['horaInicial']}',
              end: '{$value['horaFinal']}',
              display: '{$value['color']}',
              color: '{$value['color']}',
              description:  \n'" . str_replace(["'", "\r", "\n"], '', $description) . "'
            },";
          }

        endforeach;
        ?>
      ],

      viewDidMount: function(info) {
        var allDayCell = document.querySelector('.fc-scrollgrid-section-body');
        if (allDayCell) {
          var allDayRow = allDayCell.closest('tr');
          if (allDayRow) {
            allDayRow.style.display = 'none';
          }
        }
      },

      eventDidMount: function(info) {
        var tooltip = new Tooltip(info.el, {
          title: info.event.extendedProps.description,
          placement: 'top',
          trigger: 'hover',
          container: 'body',
          html: true
        });
      },
    });

    calendar.render();

  });
</script>

<main class="ls-main">
  <div class="container-fluid">
    <?php include($base_path . '/templates/alert-template.php') ?>
    <div>
      <h1 style="color: #0f4192">Agendamentos</h1>

      <div class="d-flex align-items-center justify-content-between">
        <div>
          <a href="agendamentos"><button class="btn-acesso active ">Todos</button></a>
          <a href="agendamentos/historico"><button class="btn-acesso">Minhas Solicitações</button></a>
        </div>
        <div>
          <a href="/field-search-form/two" class="ls-btn btn btn-cadastro"><i class="fas fa-calendar-alt"></i> Agendar</a>
        </div>
      </div>
      <div id='calendar' style="max-height: 650px;"></div>
      <div class="row mt-3">
        <?php
        foreach ($locais as $local) { ?>
          <div class="col-md-3 d-flex align-items-center mb-2">
            <div class="cor-sala" style="background-color: <?= $local['color'] ?>"></div>
            <span style="margin-left: 10px"><?= $local['nomeLocal'] ?></span>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</main>