<div class="box-center">
	<!-- The box-center product-->
	<div class="tittle-box-center">
		<h2>Thông tin đơn hàng</h2>
	</div>
	<div class="box-content-center product">
		<h1>Thông tin chi tiết đơn hàng</h1>
		<form class="t-form form_action" method="post"
			action="<?php echo site_url('user/edit')?>"
			enctype="multipart/form-data">
			<div class="form-row">
				<label for="param_email" class="form-label">Email:<span class="req">*</span></label>
				<div class="form-item">
					<input type="text" class="input" id="email" name="email"
						value="<?php echo isset($user->email)? $user->email:''?>">
					<div class="clear"></div>
					<div class="error" id="email_error"><?php echo form_error('email')?></div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="form-row">
				<label for="param_name" class="form-label">Họ và tên:<span
					class="req">*</span></label>
				<div class="form-item">
					<input type="text" class="input" id="name" name="name"
						value="<?php echo isset($user->name)? $user->name:''?>">
					<div class="clear"></div>
					<div class="error" id="name_error"><?php echo form_error('name')?></div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="form-row">
				<label for="param_phone" class="form-label">Số điện thoại:<span
					class="req">*</span></label>
				<div class="form-item">
					<input type="text" class="input" id="phone" name="phone"
						value="<?php echo isset($user->phone)? $user->phone:''?>">
					<div class="clear"></div>
					<div class="error" id="phone_error"><?php echo form_error('phone')?></div>
				</div>
				<div class="clear"></div>
			</div>

			<div class="form-row">
				<label for="param_address" class="form-label">Ghi chú:<span
					class="req">*</span></label>
				<div class="form-item">
					<textarea class="input" id="message" name="message"></textarea>
					<div class="clear"></div>
					<div class="error" id="message_error"><?php echo form_error('message')?></div>
				</div>
				<div class="clear"></div>
			</div>


			<div class="form-row">
				<label class="form-label">&nbsp;</label>
				<div class="form-item">
					<input type="submit" class="button" value="Chỉnh sửa thông tin"
						name="submit">
				</div>
			</div>
		</form>
		<div class="clear"></div>

	</div>
</div>