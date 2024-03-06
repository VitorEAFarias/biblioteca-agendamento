<?php

$file = "relatorio.csv";
mb_convert_encoding($file, 'UTF-16LE', 'UTF-8');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename=' . $file);

$content = "Evento ID; Nome do Evento; Local; Categoria; Qtd. Participantes; Status; Solicitante; Email Solicitante; Ramal Solicitante; Responsável; Email Responsável; Ramal Responsável; Data Incial; Data Final; Hora Inicial; Hora Final; Participante PcD; Detalhes PcD; Café; Observação; \n";


foreach ($results as $result) {
  foreach ($auditorios as $auditorio) {
    if ($result['local_id'] == $auditorio['local_id']) {
      $local = $auditorio['nomeLocal'];
    }
  }

  if ($result['status'] == 0) {
    $status = 'Em Análise';
  } else if ($result['status'] == 1) {
    $status = 'Não Aprovado';
  } else if ($result['status'] == 2) {
    $status = 'Aprovado';
  } else if ($result['status'] == 3) {
    $status = 'Cancelado';
  } else {
    $status = 'Sem Status';
  }

  $result['dataInicial'] = date("d/m/Y", strtotime($result['dataInicial']));
  $result['dataFinal'] = date("d/m/Y", strtotime($result['dataFinal']));
  $result['participantePcD'] = $result['participantePcD'] == 1 ? 'Sim' : 'Não';
  $result['coffe'] = $result['coffe'] == 1 ? 'Sim' : 'Não';

  $content .=
    $result['evento_id'] . ";" .
    $result['nomeEvento'] . ";" .
    $local . ";" .
    $result['categoria'] . ";" .
    $result['quantidade'] . ";" .
    $status . ";" .
    $result['solicitante'] . ";" .
    $result['email'] . ";" .
    $result['ramal'] . ";" .
    $result['responsavel'] . ";" .
    $result['email_responsavel'] . ";" .
    $result['ramal_responsavel'] . ";" .
    $result['dataInicial'] . ";" .
    $result['dataFinal'] . ";" .
    $result['horaInicial'] . ";" .
    $result['horaFinal'] . ";" .
    $result['participantePcD'] . ";" .
    $result['detalhesPcD'] . ";" .
    $result['coffe'] . ";" .
    $result['observacoes'] . "\n";
}

echo "\xEF\xBB\xBF";
echo $content;
