<!-- head -->
<?php $this->load->view('admin/slide/head', $this->data)?>

<div class="line"></div>
<div class="wrapper">

	<!-- Form -->
	<form class="form" id="form"
		action="" method="post"
		enctype="multipart/form-data">
		<fieldset>
			<div class="widget">
				<div class="title">
					<img
						src="<?php echo public_url('admin')?>/images/icons/dark/add.png"
						class="titleIcon">
					<h6>Cập nhật Slide</h6>
				</div>

				<ul class="tabs">
					<li><a href="#tab1">Thông tin chung</a></li>

				</ul>

				<div class="tab_container">
					<div id="tab1" class="tab_content pd0">
						<div class="formRow">
							<label class="formLeft" for="param_name">Tên:<span class="req">*</span></label>
							<div class="formRight">
								<span class="oneTwo"><input name="name" id="param_name"
									value="<?php echo $slide->name?>" _autocheck="true"
									type="text"></span> <span name="name_autocheck"
									class="autocheck"></span>
								<div name="name_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label class="formLeft">Hình ảnh:<span class="req">*</span></label>
							<div class="formRight">
								<div class="left">
									<input type="file" id="image" name="image"> <img alt=""
										src="<?php echo base_url('upload/slide/'.$slide->image_link)?>"
										style="width: 100px; height: 70px">
								</div>
								<div name="image_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>
                      
<div class="formRow">
							<label class="formLeft" for="param_info">Mô tả:</label>
							<div class="formRight">
								<span class="oneTwo"><input name="info" id="param_info" value="<?php echo $slide->info?>"
									_autocheck="true" type="text"></span> <span
									name="name_autocheck" class="autocheck"></span>
								<div name="name_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label class="formLeft" for="param_sort_order">Thứ tự hiển thị:</label>
							<div class="formRight">
								<span class="oneTwo"><input name="sort_order" id="param_sort_order" value="<?php echo $slide->sort_order?>"
									_autocheck="true" type="text"></span> <span
									name="name_autocheck" class="autocheck"></span>
								<div name="name_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label class="formLeft" for="param_sort_order">Link:</label>
							<div class="formRight">
								<span class="oneTwo"><input name="link" id="param_link" value="<?php echo $slide->link?>"
									_autocheck="true" type="text"></span> <span
									name="name_autocheck" class="autocheck"></span>
								<div name="name_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow hide"></div>
					</div>

				</div>
				<!-- End tab_container-->

				<div class="formSubmit">
					<input type="submit" value="Cập nhật" class="redB"> <input
						type="reset" value="Hủy bỏ" class="basic">
				</div>
				<div class="clear"></div>
			</div>
		</fieldset>
	</form>
</div>
<div class="clear mt30"></div>