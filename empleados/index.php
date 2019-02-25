

<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

} else {
   echo "Inicia Sesion para acceder a este contenido.<br>";
   echo "<br><a href='login.html'>Login</a>";
   echo "<br><br><a href='index.html'>Registrarme</a>";
   header('Location: http://localhost/login/login.html');//redirige a la página de login si el usuario quiere ingresar sin iniciar sesion


exit;
}

$now = time();

if($now > $_SESSION['expire']) {
session_destroy();
header('Location: http://localhost/login/login.html');//redirige a la página de login, modifica la url a tu conveniencia
echo "Tu sesion a expirado,
<a href='login.html'>Inicia Sesion</a>";
exit;
}
?>

<?php
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datos de empleados</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">

	<style>
		.content {
			margin-top: 80px;
		}
	</style>

</head>
<body>
<div class="jumbotron text-center">
  <h1>Bienvenido <?php echo  $_SESSION['username'];?></h1>
  <p>Manten tu perfil actualizado</p> 
  <a href=logout.php><button type="button" class="btn btn-success"> Cerrar Sesion</button></a>
</div>
	<nav class="navbar navbar-default navbar-fixed-top">
		<?php include('nav.php');?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Lista de empleados</h2>
			<hr />

			<?php
			if(isset($_GET['aksi']) == 'delete'){
				// escaping, additionally removing everything that could be (html/javascript-) code
				$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
				$cek = mysqli_query($con, "SELECT * FROM empleados WHERE codigo='$nik'");
				if(mysqli_num_rows($cek) == 0){
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encontraron datos.</div>';
				}else{
					$delete = mysqli_query($con, "DELETE FROM empleados WHERE codigo='$nik'");
					if($delete){
						echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Datos eliminado correctamente.</div>';
					}else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar los datos.</div>';
					}
				}
			}
			?>

			<form class="form-inline" method="get">
				<div class="form-group">
					<select name="filter" class="form-control" onchange="form.submit()">
						<option value="0">Filtros de datos de empleados</option>
						<?php $filter = (isset($_GET['filter']) ? strtolower($_GET['filter']) : NULL);  ?>
						<option value="1" <?php if($filter == 'Tetap'){ echo 'selected'; } ?>>Fijo</option>
						<option value="2" <?php if($filter == 'Kontrak'){ echo 'selected'; } ?>>Contratado</option>
                        <option value="3" <?php if($filter == 'Outsourcing'){ echo 'selected'; } ?>>Outsourcing</option>
					</select>
				</div>
			</form>
			<br />
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
                    <th>No</th>
					<th>Código</th>
					<th>Nombre</th>
                    <th>Lugar de nacimiento</th>
                    <th>Fecha de nacimiento</th>
					<th>Teléfono</th>
					<th>Cargo</th>
					<th>Estado</th>
                    <th>Acciones</th>
				</tr>
				<?php
				if($filter){
					$sql = mysqli_query($con, "SELECT * FROM empleados WHERE estado='$filter' ORDER BY codigo ASC");
				}else{
					$sql = mysqli_query($con, "SELECT * FROM empleados ORDER BY codigo ASC");
				}
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
						echo '
						<tr>
							<td>'.$no.'</td>
							<td>'.$row['codigo'].'</td>
							<td><a href="profile.php?nik='.$row['codigo'].'"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.$row['nombres'].'</a></td>
                            <td>'.$row['lugar_nacimiento'].'</td>
                            <td>'.$row['fecha_nacimiento'].'</td>
							<td>'.$row['telefono'].'</td>
                            <td>'.$row['puesto'].'</td>
							<td>';
							if($row['estado'] == '1'){
								echo '<span class="label label-success">Fijo</span>';
							}
                            else if ($row['estado'] == '2' ){
								echo '<span class="label label-info">Contratado</span>';
							}
                            else if ($row['estado'] == '3' ){
								echo '<span class="label label-warning">Outsourcing</span>';
							}
						echo '
							</td>
							<td>

								<a href="edit.php?nik='.$row['codigo'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
								<a href="index.php?aksi=delete&nik='.$row['codigo'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['nombres'].'?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
						$no++;
					}
				}
				
				
				?>
			</table>
			</div>
			
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
                    
					<th>Codigo Vendedor</th>
					<th>Nombre Vendedor</th>
                    
				</tr>
				<?php
				if($filter){
					$sql = mysqli_query($con, "SELECT * FROM vendedores WHERE estado='$filter' ORDER BY idvendedores ASC");
				}else{
					$sql = mysqli_query($con, "SELECT * FROM vendedores ORDER BY idvendedores ASC");
				}
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
						echo '
						<tr>
							
							<td>'.$row['idvendedores'].'</td>
							<td><a href="profile.php?nik='.$row['idvendedores'].'"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.$row['nomvendedores'].'</a></td>
                            
							<td>';
							
                            
                          
						echo '
							</td>
							<td>

								<a href="edit.php?nik='.$row['idvendedores'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
								<a href="index.php?aksi=delete&nik='.$row['idvendedores'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['nomvendedores'].'?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
						$no++;
					}
				}
				
				
				?>
			</table>
			</div>
			
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
                    
					<th>Codigo Estado</th>
					<th>Nombre Estado</th>
                    
				</tr>
				<?php
				if($filter){
					$sql = mysqli_query($con, "SELECT * FROM estadoventa WHERE estado='$filter' ORDER BY idvendedores ASC");
				}else{
					$sql = mysqli_query($con, "SELECT * FROM estadoventa ORDER BY idestado ASC");
				}
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
						echo '
						<tr>
							
							<td>'.$row['idestado'].'</td>
							<td><a href="profile.php?nik='.$row['idestado'].'"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.$row['nomestado'].'</a></td>
                            
							<td>';
							
                            
                          
						echo '
							</td>
							<td>

								<a href="edit.php?nik='.$row['idestado'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
								<a href="index.php?aksi=delete&nik='.$row['idestado'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['nomestado'].'?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
						$no++;
					}
				}
				
				
				?>
			</table>
			</div>
			
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
                    
					<th>Codigo Articulo</th>
					<th>Nombre Articulo</th>
                    
				</tr>
				<?php
				if($filter){
					$sql = mysqli_query($con, "SELECT * FROM ariculo WHERE estado='$filter' ORDER BY idvendedores ASC");
				}else{
					$sql = mysqli_query($con, "SELECT * FROM ariculo ORDER BY idarticulo ASC");
				}
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
						echo '
						<tr>
							
							<td>'.$row['idarticulo'].'</td>
							<td><a href="profile.php?nik='.$row['idarticulo'].'"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.$row['nomarticulo'].'</a></td>
                            
							<td>';
							
                            
                          
						echo '
							</td>
							<td>

								<a href="edit.php?nik='.$row['idarticulo'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
								<a href="index.php?aksi=delete&nik='.$row['idarticulo'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['nomarticulo'].'?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
						$no++;
					}
				}
				
				
				?>
			</table>
			</div>

			<div class="table-responsive">
			<table class="table table-striped table-hover">

				
					<h1><small>Vendedor que tuvo más ventas</small></h1>
					<br>
					<br>

				<tr>
                    
					<th>Nombre Vendedores</th>
					<th>Ventas</th>
                    
				</tr>
				<?php
				if($filter){
					$sql = mysqli_query($con, "SELECT * FROM ariculo WHERE estado='$filter' ORDER BY idvendedores ASC");
				}else{
					$sql = mysqli_query($con, "SELECT vendedores.nomvendedores, sum(monto) as monto FROM ventas,vendedores WHERE ventas.idvendedor = vendedores.idvendedores GROUP by  vendedores.nomvendedores");
				}
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
						echo '
						<tr>
							
							<td>'.$row['nomvendedores'].'</td>
							<td><a href="profile.php?nik='.$row['nomvendedores'].'"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.$row['monto'].'</a></td>
                            
							<td>';
							
                            
                          
						echo '
							</td>
							<td>

								<a href="edit.php?nik='.$row['nomvendedores'].'" title="Editar datos" </a>
								<a href="index.php?aksi=delete&nik='.$row['nomvendedores'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['monto'].'?\')""></a>
							</td>
						</tr>
						';
						$no++;
					}
				}
				
				
				?>
			</table>
			</div>


			<div class="table-responsive">
			<table class="table table-striped table-hover">

				
					<h1><small>Cuantas ventas hay en cada estado</small></h1>
					<br>
					<br>

				<tr>
                    
					<th>Nombre Estado</th>
					<th>Cantidad Según Estado</th>
					<th>Id Estado</th>
					
                    
				</tr>
				<?php
				if($filter){
					$sql = mysqli_query($con, "SELECT * FROM ariculo WHERE estado='$filter' ORDER BY idvendedores ASC");
				}else{
					$sql = mysqli_query($con, "SELECT estadoventa.nomestado, ventas.idestadoventa, COUNT(ventas.idventas) AS cantidadVentas FROM ventas, estadoventa WHERE ventas.idestadoventa = estadoventa.idestado GROUP BY estadoventa.nomestado");
				}
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
						echo '
						<tr>
							
							<td>'.$row['nomestado'].'</td>
							<td>'.$row['cantidadVentas'].'</td>
							<td><a href="profile.php?nik='.$row['idestadoventa'].'"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.$row['idestadoventa'].'</a></td>
                            
							<td>';
							
                            
                          
						echo '
							</td>
							<td>

								<a href="edit.php?nik='.$row['nomestado'].'" title="Editar datos" </a>
								<a href="index.php?aksi=delete&nik='.$row['idestadoventa'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['cantidadVentas'].'?\')""></a>
							</td>
						</tr>
						';
						$no++;
					}
				}
				
				
				?>
			</table>
			</div>

			<div>
			
			<div>
		</div>
	</div><center>
	<p>&copy; Sistemas Web <?php echo date("Y");?></p
		</center>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
