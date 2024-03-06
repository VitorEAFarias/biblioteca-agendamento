<?php require('../src/settings_template_agenda.php'); ?>

<?php
try {
  $conn = new PDO("mysql:host=" . SERVER_HOST . ";dbname=" . SERVER_DBNAME, SERVER_USERNAME, SERVER_PASSWORD);

  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $conn->query('SELECT a.evento_id, a.dataInicial, a.dataFinal, a.horaInicial, a.horaFinal, a.nomeEvento, a.observacoes , b.nomeLocal, b.color FROM eventos a INNER JOIN local b on a.local_id = b.local_id WHERE a.status = 2');

  echo "Connected successfully <br>";
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

while ($row_events = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $id = $row_events['evento_id'];
  $title = $row_events['nomeLocal'];
  $description = $row_events['observacoes'];

  $dateStart = date("Y-m-d", strtotime($row_events['dataInicial']));
  $timeStart = date("H:i:s", strtotime($row_events['horaInicial']));
  $start = $dateStart . ' ' . $timeStart;

  $DateEnd = date("Y-m-d", strtotime($row_events['dataFinal']));
  $TimeEnd = date("H:i:s", strtotime($row_events['horaFinal']));
  $end = $DateEnd . ' ' . $TimeEnd;

  $eventos[] = [
    'id' => $id,
    'title' => 'h - ' . $title,
    'start' => $start,
    'end' => $end,
    'description'  => $title,
  ];
}

//print_r($eventos);

//include_once('calendar.html');

?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      selectable: true,
      selectMirror: true,
      select: function(arg) {
        $("#myModal").modal();

        $("#btnSubmit").on('click', function(event) {
          event.preventDefault();

          var start = $("#inputTimeEvent").val(
            arg.start.toLocaleDateString('fr-CA', {
              year: 'numeric',
              month: '2-digit',
              day: '2-digit'
            })
            .replaceAll('/', '-')
          );

          $("#formAddEvent").submit();
        })

        calendar.unselect()
      },
      events: [
        <?php
        foreach ($eventos as $key => $value) :
          echo "{
            title: '{$value['title']}',
            start: '{$value['start']}',
            color: '#333',
          },";
        endforeach;
        ?>
      ],
    });

    calendar.render();
  });
</script>


<main class="ls-main ">
  <div class="container-fluid">
    <h1 class="ls-title-intro ls-ico-plus"><?= $title ?></h1>
    <!?php include($base_path.'/templates/alert-template.php') ?>
      <div class="row">

        <?php
        // var_dump($jsonevents); 
        ?>


        <div id='calendar'></div>
      </div>
  </div>
</main>