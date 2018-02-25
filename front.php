<html>
  <head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body>
    <h1>Filtro</h1>
    <form action="index.php" method="POST">
      Data Criação Inicio:<br>
      <input type="date" name="data_inicio" value="">
      <br><br>
      Data Criação Fim:<br>
      <input type="date" name="data_fim" value="">
      <br><br>

      <h1>Ordenação</h1>
      <input type="radio" name="filter" value="1" checked> Data Criação<br>
      <input type="radio" name="filter" value="2"> Data Atualização<br>
      <input type="radio" name="filter" value="3"> Prioridade<br><br>
      <br><br>

      <input type="submit" value="Enviar">
    </form>

  </body>
</html>
