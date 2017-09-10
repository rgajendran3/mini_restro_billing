<?php
if(!isset($_SESSION)){
	session_start();
}
if(isset($_SESSION['cart'])){
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
	include 'connection.php';
	$sno = 0;
	$total = 0;
	foreach($_SESSION['cart'] as $key=>$value){
		$result = mysqli_query($connection, "SELECT * FROM items WHERE ID='$value'");
		$row = mysqli_fetch_assoc($result);
		$sno++;
		$product = $row['PRODUCT'];
		$price = $row['PRICE'];
		?>
		<tr>		
			<td><?php echo $sno;?></td>
			<td><?php echo $product ?></td>
			<td><?php echo "£ ".$price  ?></td>
			<td><button onclick="Exec.remove('<?php echo $key; ?>');">-</button></td>
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
	<p>Change for £5 = <?php if($total < 5){$t = 5-$total; echo "<b>£".$t."</b>"; }else{echo "0";}?></p>
	<p>Change for £10 = <?php if($total < 10){$t = 10-$total; echo "<b>£".$t."</b>"; }else{echo "0";}?></p>
	<p>Change for £20 = <?php if($total < 20){$t = 20-$total; echo "<b>£".$t."</b>"; }else{echo "0";}?></p>
	<p>Change for £50 = <?php if($total < 50){$t = 50-$total; echo "<b>£".$t."</b>"; }else{echo "0";}?></p>
	<button onclick="Exec.addbill('<?php echo $total; ?>');">Add Bill</button>
	</div>
	<?php
}
	?>