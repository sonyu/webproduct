<!-- head -->
<?php $this->load->view('admin/product/head', $this->data)?>

<div class="line"></div>
<div class="wrapper" id="main_product">
	<div class="widget">

		<div class="title">
			<span class="titleIcon"><input id="titleCheck" name="titleCheck"
				type="checkbox"></span>
			<h6>Danh sách sản phẩm</h6>
			<div class="num f12">
				Số lượng: <b><?php echo $total_rows?></b>
			</div>
		</div>
		<table class="sTable mTable myTable" id="checkAll" cellpadding="0"
			cellspacing="0" width="100%">
			<thead class="filter">
				<tr>
					<td colspan="6">
						<form class="list_filter form" action="<?php echo admin_url('product')?>" method="get">
							<table cellpadding="0" cellspacing="0" width="80%">
								<tbody>
									<tr>
										<td class="label" style="width: 40px;"><label for="filter_id">Mã
												số</label></td>
										<td class="item"><input name="id" value="<?php echo $this->input->get('id');?>" id="filter_id"
											style="width: 55px;" type="text"></td>
										<td class="label" style="width: 40px;"><label for="filter_id">Tên</label></td>
										<td class="item" style="width: 155px;"><input name="name"
											value="<?php echo $this->input->get('name'); ?>" id="filter_iname" style="width: 155px;" type="text"></td>
										<td class="label" style="width: 60px;"><label
											for="filter_status">Thể loại</label></td>
										<td class="item"><select name="catalog">
												<option value=""></option>
												<!-- kiem tra danh muc co danh muc con hay khong -->
												<?php foreach ($catalogs as $row):?>
												<?php if(count($row->subs)> 1):?>
												<optgroup label="<?php echo $row->name?>">
												    <?php foreach ($row->subs as $subs):?>
													<option value="<?php echo $subs->id?>" <?php echo ($this->input->get('catalog')== $subs->id ) ?'selected':''?>><?php echo $subs->name?></option>
													<?php endforeach;?>
												</optgroup>
												<?php else :?>
												<option value="<?php echo $row->id?>"<?php echo ($this->input->get('catalog')== $row->id ) ?'selected':''?>><?php echo $row->name?></option>
												<?php endif;?>
											    <?php endforeach;?>
										</select></td>

										<td style="width: 150px"><input class="button blueB"
											value="Lọc" type="submit"> <input class="basic" value="Reset"
											onclick="window.location.href = '<?php echo admin_url('product')?>'; "
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
					<td>Tên</td>
					<td>Giá</td>
					<td style="width: 75px;">Ngày tạo</td>
					<td style="width: 120px;">Hành động</td>
				</tr>
			</thead>
			<tfoot class="auto_check_pages">
				<tr>
					<td colspan="6">
						<div class="list_action itemActions">
							<a href="#submit" id="submit" class="button blueB"
								url="admin/product/del_all.html"> <span style="color: white;">Xóa
									hết</span>
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
				<tr class="row_9">
					<td><input name="id[]" value="<?php echo $row->id?>"
						type="checkbox"></td>
					<td class="textC"><?php echo $row->id?></td>
					<td>
						<div class="image_thumb">
							<img
								src="<?php echo base_url('upload/product/'.$row->image_link)?>"
								height="50">
							<div class="clear"></div>
						</div> <a href="" class="tipS" title="" target="_blank"> <b><?php echo $row->name?></b>
					</a>
						<div class="f11">Đã bán: <?php echo $row->buyed?> | Xem: <?php echo $row->view?></div>
					</td>
					<td class="textR">
					<?php if($row->discount >0):?>
					<?php $new_price = $row->price -$row->discount?>
					<b style='color: red'><?php echo number_format($new_price)?></b>
						<p style="text-decoration: line-through"><?php echo number_format($row->price)?></p>
					<?php else :?>
					<b style='color: red'><?php echo  number_format($row->price)?></b>
					<?php endif;?>
					</td>
					<td class="textC">01-01-1970</td>
					<td class="option textC">
						</a> <a href="product/view/9.html" target="_blank" class="tipS"
						title="Xem chi tiết sản phẩm"> <img
							src="<?php echo public_url('admin')?>/images/icons/color/view.png">
					</a> <a href="admin/product/edit/9.html" title="Chỉnh sửa"
						class="tipS"> <img
							src="<?php echo public_url('admin')?>/images/icons/color/edit.png">
					</a> <a href="admin/product/del/9.html" title="Xóa"
						class="tipS verify_action"> <img
							src="<?php echo public_url('admin')?>/images/icons/color/delete.png">
					</a></td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>
</div>