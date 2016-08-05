<!-- head -->
<?php $this->load->view('admin/transaction/head', $this->data)?>

<div class="line"></div>
<div class="wrapper" id="main_transaction">
	<div class="widget">
            
    <?php $this->load->view('admin/message', $this->data);?>
		<div class="title">
			<span class="titleIcon"><input id="titleCheck" name="titleCheck"
				type="checkbox"></span>
			<h6>Danh sách giao dịch</h6>
			<div class="num f12">
				Số lượng: <b><?php echo $total_rows?></b>
			</div>
		</div>
		<table class="sTable mTable myTable" id="checkAll" cellpadding="0"
			cellspacing="0" width="100%">
			<thead class="filter">
				<tr>
					<td colspan="8">
						<form class="list_filter form" action="<?php echo admin_url('transaction')?>" method="get">
							<table cellpadding="0" cellspacing="0" width="80%">
								<tbody>
									<tr>
										<td class="label" style="width: 40px;"><label for="filter_id">Mã
												số</label></td>
										<td class="item"><input name="id" value="<?php echo $this->input->get('id');?>" id="filter_id"
											style="width: 55px;" type="text"></td>

										<td style="width: 150px"><input class="button blueB"
											value="Lọc" type="submit"> <input class="basic" value="Reset"
											onclick="window.location.href = '<?php echo admin_url('transaction')?>'; "
											type="reset"></td>
									</tr>
								</tbody>
							</table>
						</form>
					</td>
				</tr>
			</thead>

			<thead>
				<tr>
					<td style="width: 21px;"><img
						src="<?php echo public_url('admin')?>/images/icons/tableArrows.png"></td>
					<td style="width: 60px;">Mã số</td>
					<td>Số tiền</td>
					<td>Cổng thanh toán</td>
					<td>Trạng thái</td>
					<td style="width: 75px;">Ngày tạo</td>
					<td style="width: 120px;">Hành động</td>
				</tr>
			</thead>
			<tfoot class="auto_check_pages">
				<tr>
					<td colspan="6">
						<div class="list_action itemActions">
							<a href="#submit" id="submit" class="button blueB"
								url="<?php echo admin_url('transaction/del_all')?>"> <span style="color: white;">Xóa hết</span>
							</a>
						</div>
						<div class="pagination">
						<?php echo $this->pagination->create_links();?>
						</div>
					</td>
				</tr>
			</tfoot>
			<tbody class="list_item">
			<?php foreach ($list as $row):?>
				<tr class="row_<?php echo $row->id?>">
					<td><input name="id[]" value="<?php echo $row->id?>"
						type="checkbox"></td>
					<td class="textC"><?php echo $row->id?></td>
					<td>
						<?php echo number_format($row->amount)?>
					</td>
					<td>
						<?php echo $row->payment?>
					</td>
					<td>
						<?php 
							if($row->status == 0){
								echo  'Chưa thanh toán';
							}elseif($row->status == 1){
								echo 'Đã thanh toán';
							}else{
								echo 'Thanh toán thất bại';
							}
						?>
					</td>
					
					<td class="textC"><?php echo convet_timestamp($row->created)?></td>
					<td class="option textC">
						</a> <a href="<?php echo admin_url('transaction/view/'.$row->id)?>" target="_blank" class="tipS"
						title="Xem chi tiết giao dịch"> <img
							src="<?php echo public_url('admin')?>/images/icons/color/view.png">
					</a><a href="<?php echo admin_url('transaction/xoa/'.$row->id)?>" title="Xóa"
						class="tipS verify_action"> <img
							src="<?php echo public_url('admin')?>/images/icons/color/delete.png">
					</a></td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>
</div>