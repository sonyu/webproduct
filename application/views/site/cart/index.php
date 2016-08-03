<style>
<!--
table#cart_contents td{padding:10px; border:1px solid #ccc}

-->
</style>
<div class="box-center">
	<!-- The box-center product-->
	<div class="tittle-box-center">
		<h2>Thông tin giỏ hàng(có <?php echo $total_items?> sản phẩm)</h2>
	</div>
	<div class="box-content-center product">
	<?php if($total_items> 0 ):?>
	<form action="<?php echo base_url('cart/update')?>" method = "post">
	<table id = cart_contents>
		<thead>
				<th>Sản phẩm</th>
				<th>Giá bán</th>
				<th>Số lượng</th>
				<th>Tổng số</th>
				<th>Xóa</th>
		</thead>
		<tbody>
				<?php $total_amount = 0?>
				<?php foreach ($carts as $row):?>
				<?php $total_amount =$total_amount + $row['subtotal']?>
				<tr>
				<td><?php echo $row['name']?></td>
				<td><?php echo number_format($row['price'])?></td>
				<td><input name="qty_<?php echo $row['id'];?>" value="<?php echo $row['qty'];?>" size = "5"></td>
				<td><?php echo number_format($row['subtotal']);?>đ</td>
				<td><a href="<?php echo base_url('cart/del/'.$row['id'])?>">Xóa</a></td>
				</tr>
				<?php endforeach;?>
				
				<tr>
					<td colspan = "5"><b style ="color: red">Tổng số tiền thanh toán : <?php echo number_format($total_amount).'đ' ?></b>
									  <a href = "<?php echo base_url('cart/del')?>">Xóa toàn bộ</a>	
					</td>
				</tr>
				<tr>
					<td colspan = "5" type = 'submit'><button>Cập nhật</button></td>
				</tr>
		</tbody>
	</table>
	</form>
	<?php else:?>
	<h4>Không có sản phẩm nào trong giỏ hàng</h4>
	<?php endif;?>
	</div>
</div>