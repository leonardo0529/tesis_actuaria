<?php
require ("conexion.php");
 ?>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Formulario Crear Portafolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" id="woocommmerce" href="https://themes.getbootstrap.com/wp-content/plugins/woocommerce/assets/css/woocommerce.css?ver=3.8.1" type="text/css" media="all">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function(){
      $('#mitabla').DataTable({
        "order": [[1,]],
        "language":{
          "lengthMenu": "Mostrar _MENU_ registros por pagina",
          "info": "Mostrando pagina _PAGE_ de _PAGES_",
          "infoEmpty": "No hay registros disponibles",
          "infoFiltered": "(filtrada de _MAX_ registros)",
          "loadingRecords": "Cargando...",
          "processing":     "Procesando...",
          "search": "Buscar:",
          "zeroRecords":    "No se encontraron registros coincidentes",
          "paginate": {
            "next":       "Siguiente",
            "previous":   "Anterior"
          },
        }
      });
    });
    </script>
  </head>
  <body>

  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <input type="hidden" name="seccion" value="1ra">
    <div class="wrapper">
        <div id="wizard" class="form-group">
          <center>
            <?php  if (!isset($_POST['nivel_riesgo'])){ ?>
            <h4>Formulario para generar un portafolio</h4><br>
            <h6>Complete los siguientes datos</h6>
            <section>
              <div class="container">
                <div class="row">
                  <div class="col-sm">
                  <label>Monto que desea invertir</label><br>
                    <input type="number" name='monto_invertir'  step=1000 style="width:auto;heigth: 5px" min=1000 >
                </div>
                <div class="col-sm">
                  <label for="periodicidad">Periodiciad a reinvertir</label><br>
                  <select name="periodicidad">
                   <option value="selec">Seleccione</option>
                   <option value="Semanal">Semanal</option>
                   <option value="mensual">Mensual</option>
                  </select>
                </div>
                <div class="col-sm">
                  <label for="nivel_riesgo">Nivel de riesgo para esta inversión</label><br>
                  <select name="nivel_riesgo">
                   <option value="selec">Seleccione</option>
                   <option value="Baja">Bajo</option>
                   <option value="Media">Medio</option>
                   <option value="Alta">Alto</option>
                  </select>
                </div>
                <br>
                <button type="submit" name="button" value="filt_comp" style="background-color:rgba(0, 135, 155); border-color:white;color:white; width:145px; height:40px">Continuar</button>
              </div>
            </div>
          </div>
        </div>
          </form>
          <?php
        }else{
             $nivel_riesgo=$_POST['nivel_riesgo'];
          ?>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <input type="hidden" name="seccion" value="2da">
          <h4>Estas son las empresas en las que puede invertir de acuerdo con su información.</h4>
          <h2>Seleccione las empresas en las que quiera invertir</h2>
          <div class="container">
        	  <div class="form-group">
        		<div class="row table-responsive">
              <table class="table table-striped" id="mitabla">
        						<thead class="thead-dark" >
        							<tr>
        								<th style="font-size:80%; width:30;">Seleccionar</th>
        								<th style="font-size:80%; width:80;">Compañia</th>
        								<th style="font-size:80%; width:150;"nowrap>Sector</th>
                        <th style="font-size:80%; width:150;"nowrap>Industria</th>
        							</tr>
        						</thead>
                    <tbody>
                      <?php
                      $resultado = $mysqli->query("SELECT * FROM db_tesis.tes_companys where volatilidad='$nivel_riesgo' order by company;");
                      while($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
                      $compañia=$row['company'];
                      $sector=$row['sector'];
                      $industria=$row['industria'];
                      $id=$row['id_companys'];
                      $symbol=$row['symbol'];
                      $company=$row['company'];

                       ?>
                  <tr>
                     <td style="font-size:100%; width:50;">
                       <input type="checkbox" id="cbox1" name=<?php echo "id_compañia".$id; ?> value=<?php echo $id; ?>>
                     </td>
                     <td style="font-size:100%; width:auto;"  ><?php echo $compañia; ?></td>
                     <td style="font-size:100%; width:auto;"  ><?php echo $sector; ?></td>
                     <td style="font-size:100%; width:auto;"  ><?php echo $industria ?></td>
                  </tr>
                </tbody>
              <?php }  ?>
              </table>
            </div>
            <button type="submit" name="button" value='selec_empresas' style="background-color:rgba(0, 135, 155); border-color:white;color:red; width:145px; height:40px">Continuar</button>
          </div>
      </div>
      <?php
    } ?>
</form>

  </body>
</html>
