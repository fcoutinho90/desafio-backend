<?php

// Leio o qrquivo de tickets
$arquivo = file_get_contents("./tickets.json");

// Transformo o arquivo em array
$tickets = json_decode($arquivo, true);

// Percorro cada ticket para priorizar
foreach ($tickets as $key => $value) {

  $ticketID = $value["TicketID"];
  $categoryID = $value["CategoryID"];
  $CustomerID = $value["CustomerID"];
  $CustomerName = $value["CustomerName"];
  $CustomerEmail = $value["CustomerEmail"];
  $DateCreate = $value["DateCreate"];
  $DateUpdate = $value["DateUpdate"];

  $Interactions = $value["Interactions"];

  // Percorro as interações para priorizar
  foreach ($Interactions as $keychildren => $valuechildren) {

    $Subject = $valuechildren["Subject"];

    // Se o assunto conter Reclamação entã irá recerber prioridade alta
    if (strpos($Subject, 'Reclamação') !== false) {

      $tickets[$key]["Prioridade"] = "Alta";

    }
    else {

      $tickets[$key]["Prioridade"] = "Normal";
    }

  }

  // Verificando a diferença entre a data de envio e retorno de msgs
  $date1 = strtotime($DateCreate);
  $date2 = strtotime($DateUpdate);
  $datediff = $date2 - $date1;
  // Se o tempo de interação for maior que 30 dias, vou trata-lá como prioridade alta
  if (round($datediff / (60 * 60 * 24)) >= 30) {
    $tickets[$key]["Prioridade"] = "Alta";
  }

}

function checkdata($dataInicio, $dataFim, $data)
{
  $inicio = strtotime($dataInicio);
  $fim = strtotime($dataFim);
  $data = strtotime($data);

  return (($data >= $inicio) && ($data <= $fim));
}


$dataInicio = $_POST["data_inicio"];
$dataFim = $_POST["data_fim"];
$ord = $_POST["filter"];


foreach ($tickets as $key => $value) {

  $DateCreate = $value["DateCreate"];

  $check = checkdata($dataInicio, $dataFim, $DateCreate);

  if ($check == false) {
    unset($tickets[$key]);
  }

}


$filtertickets = array();
foreach ($tickets as $key => $value)
{
  if ($ord == 1) {
    $filtertickets[$key] = $value['DateCreate'];
  }
  if ($ord == 2) {
    $filtertickets[$key] = $value['DateUpdate'];
  }
  if ($ord == 3) {
    $filtertickets[$key] = $value['Prioridade'];
  }
}
array_multisort($filtertickets, SORT_ASC, $tickets);


echo "
<html>
  <head>
  <title></title>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
  </head>

  <body>
  <table>
    <tr>
      <th>ID</th>
      <th>Data Criação</th>
      <th>Data Atualização</th>
      <th>Prioridade</th>
    </tr>";

echo '</tr></thead><tbody>';

foreach($tickets as $key => $value) {
    echo '<tr>';
    echo '<td>'.$value["TicketID"].'</td>';
    echo '<td>'.$value["DateCreate"].'</td>';
    echo '<td>'.$value["DateUpdate"].'</td>';
    echo '<td>'.$value["Prioridade"].'</td>';
    echo '</tr>';

}

echo '</tbody></table>';



?>
