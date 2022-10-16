<?php
require ("conexion.php");
$compañias = array();
$symbols=array();
for ($i=944; $i <1168 ; $i++) {
  if (isset($_POST['id_compañia'.$i])){
    $id=intval($_POST['id_compañia'.$i]);
    $company=$mysqli->query("SELECT * FROM db_tesis.tes_companys where id_companys=$id;");
    $row = $company->fetch_array(MYSQLI_ASSOC);
    $company=$row['company'];
    $company="$company";
    $symbol=$row['symbol'];
    $symbol="$symbol";
    array_push($compañias,$company);
    array_push($symbols,$symbol);
  }
}
$compañias=json_encode($compañias);
$symbols=json_encode($symbols);
$output = shell_exec("python portafolios.py  $symbols $compañias");

?>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Minima varianza</title>
  </head>
  <body>
<?php echo $output; ?>
  </body>
</html>
