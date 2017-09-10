<?php 
if(!isset($_SESSION)){
	session_start();
}

if(!isset($_SESSION['username']) && !isset($_SESSION['acctype'])){
	header('location:index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	<title>Gajendra Retail</title>

	<!-- Included Bootstrap CSS Files -->
	<link rel="stylesheet" href="./js/bootstrap/css/bootstrap.min.css" /> 
	<link rel="stylesheet" href="./js/bootstrap/css/bootstrap-responsive.min.css" />
	
	<!-- Includes FontAwesome -->
	<link rel="stylesheet" href="./css/font-awesome/css/font-awesome.min.css" />

	<!-- Css -->	
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/product.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>	

</head>
<body>
	<div class="container">
		<div class="row">
			<div class="span3">
				<div class="well">
					<ul class="nav nav-list">
						<li class="nav-header">Menus</li>
						<li>
							<a href="myaccount.php?item=billing">Billing</a>
						</li>
						<li>
							<a href="myaccount.php?item=summary">Summary</a>
						</li>
						<li>
							<a href="myaccount.php?item=manage">Manage</a>
						</li>																		
						<li>
							<a href="template/logout.php">Logout</a>
						</li>						
					</ul>
				</div>							
			</div>
			<div class="span9" id="account_manage">
				<div class="well">
				<?php
				$item = $_GET['item'];
				switch($item){
					case "billing":
							include 'template/connection.php';
							$result = mysqli_query($connection, "SELECT * FROM items");
							while($row = mysqli_fetch_assoc($result)){
							$num = $row['ID'];
							echo "<label>".$row['PRODUCT']."</label>"."<button onclick='Exec.menu(\"$num\");'>+</button>";

							}
						break;
						
					case "summary":
							?>
							<div class="well">
								<br><br><br>
								<table>
									<tbody>
										<tr>
											<th style="width:10%;">S.No</th>
											<th style="width:50%;">Detail</th>
											<th style="width:20%;">Price</th>
											<th style="width:5%;">Remove</th>
										</tr>
							<?php
							include 'template/connection.php';
							$sno = 0;
							$total = 0;
								$result = mysqli_query($connection, "SELECT * FROM total;");
								while($row = mysqli_fetch_assoc($result)){
									$sno++;
									$id = $row['ID'];
									$product = $row['TIMESTAMP'];
									$price = $row['PRICE'];
									?>
									<tr>		
										<td><?php echo $sno;?></td>
										<td><?php echo $product ?></td>
										<td><?php echo "£ ".$price  ?></td>
										<td><button onclick="Exec.delbill('<?php echo $id; ?>');">-</button></td>
									</tr>
									<?php
									$total = $total + $price;
								}
							?>
							<tr>
								<th>Total</th>
								<th></th>
								<th><?php echo "£".$total; ?></th>
								<th></th>
							</tr>
							</tbody>
							</table>
							</div>							
							<?php
						break;
						
						case "manage":
						?>
								<div class="well">
									<br><br><br>
									<table>
										<tbody>
											<tr>
												<th style="width:10%;">S.No</th>
												<th style="width:50%;">Detail</th>
												<th style="width:20%;">Price</th>
												<th style="width:5%;">Remove</th>
											</tr>
								<?php
								include 'template/connection.php';
								$sno = 0;
								$result = mysqli_query($connection, "SELECT * FROM items");
								while($row = mysqli_fetch_assoc($result)){
								$sno++;
								$key = $row['ID'];	
								$product = $row['PRODUCT'];
								$price = $row['PRICE'];
								?>
								<tr>		
									<td><?php echo $sno;?></td>
									<td><?php echo $product ?></td>
									<td><?php echo "£ ".$price  ?></td>
									<td><button onclick="Exec.managedel('<?php echo $key; ?>');">-</button></td>
								</tr>
								<?php
								}
								?>
								</tbody>
								</table>
								</div>
								<div class="well">
									<p>Add Items</p>
									<input type="text" placeholder="Item Name" id="name"/>
									<input type="text" placeholder="Price in £" id="price" /><br>
									<button onclick="Exec.addManage();">Add</button>
								</div>
								<?php
							break;		
				}
				?>
				</div>
				<div id="order">
					<?php include 'template/menuview.php'; ?>
				</div>
			</div>
	
		</div>
	</div>
		<script>
		function funs(){
			this.menu = function(idss){
				$.ajax({
					method: "POST",
					url: "template/additem.php",
					data: {id:idss},
					success: function(status){
						$("#order").load("template/menuview.php")
					}
				});
			}
			
			this.remove = function(idss){
				console.log(idss);
				$.ajax({
					method: "POST",
					url: "template/additem.php",
					data: {remove:idss},
					success: function(status){
						$("#order").load("template/menuview.php")
					}
				});
			}

			this.addbill = function(amount){
				console.log(amount);
				$.ajax({
					method: "POST",
					url: "template/additem.php",
					data: {amount:amount},
					success: function(status){
						$("#order").load("template/menuview.php")
					}
				});
			}	

			this.delbill = function(id){
				console.log(id);
				$.ajax({
					method: "POST",
					url: "template/additem.php",
					data: {del:id},
					success: function(status){
						window.location.href = "myaccount.php?item=summary";
					}
				});
			}	
			
			this.managedel = function(id){
				console.log(id);
				$.ajax({
					method: "POST",
					url: "template/additem.php",
					data: {mdelid:id},
					success: function(status){
						window.location.href = "myaccount.php?item=manage";
					}
				});
			}	
			
			this.addManage = function(){
				var name = $('#name').val();
				var price = $('#price').val();
				$.ajax({
					method: "POST",
					url: "template/additem.php",
					data: {vname:name, vprice:price},
					success: function(status){
						window.location.href = "myaccount.php?item=manage";
					}
				});
			}									
		}
		
		var Exec = new funs();
	</script>
</body>
</html>