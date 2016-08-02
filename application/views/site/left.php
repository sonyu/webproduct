
<div class="box-left">
	<div class="title tittle-box-left">
		<h2>Tìm kiếm theo giá</h2>
	</div>
	<div class="content-box">
		<!-- The content-box -->
		<form class="t-form form_action" method="post" style="padding: 10px"
			action="product/search_price.html" name="search">

			<div class="form-row">
				<label for="param_price_from" class="form-label" style="width: 70px">Giá
					từ:<span class="req">*</span>
				</label>
				<div class="form-item" style="width: 90px">
					<select class="input" id="price_from" name="price_from">
						<option value="0">0 đ</option>
						<option value="1000000">1,000,000 đ</option>
						<option value="2000000">2,000,000 đ</option>
						<option value="3000000">3,000,000 đ</option>
						<option value="4000000">4,000,000 đ</option>
						<option value="5000000">5,000,000 đ</option>
						<option value="6000000">6,000,000 đ</option>
						<option value="7000000">7,000,000 đ</option>
						<option value="8000000">8,000,000 đ</option>
						<option value="9000000">9,000,000 đ</option>
						<option value="10000000">10,000,000 đ</option>
					</select>
					<div class="clear"></div>
					<div class="error" id="price_from_error"></div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="form-row">
				<label for="param_price_from" class="form-label" style="width: 70px">Giá
					tới:<span class="req">*</span>
				</label>
				<div class="form-item" style="width: 90px">
					<select class="input" id="price_to" name="price_to">
						<option value="1000000">1,000,000 đ</option>
						<option value="2000000">2,000,000 đ</option>
						<option value="3000000">3,000,000 đ</option>
						<option value="4000000">4,000,000 đ</option>
						<option value="5000000">5,000,000 đ</option>
						<option value="6000000">6,000,000 đ</option>
						<option value="7000000">7,000,000 đ</option>
						<option value="8000000">8,000,000 đ</option>
						<option value="9000000">9,000,000 đ</option>
						<option value="10000000">10,000,000 đ</option>
						<option value="11000000">11,000,000 đ</option>
						<option value="12000000">12,000,000 đ</option>
						<option value="13000000">13,000,000 đ</option>
						<option value="14000000">14,000,000 đ</option>
						<option value="15000000">15,000,000 đ</option>
						<option value="16000000">16,000,000 đ</option>
						<option value="17000000">17,000,000 đ</option>
						<option value="18000000">18,000,000 đ</option>
						<option value="19000000">19,000,000 đ</option>
						<option value="20000000">20,000,000 đ</option>
					</select>
					<div class="clear"></div>
					<div class="error" id="price_from_error"></div>
				</div>
				<div class="clear"></div>
			</div>

			<div class="form-row">
				<label class="form-label">&nbsp;</label>
				<div class="form-item">
					<input class="button" name="search" value="Tìm kiềm"
						style="height: 30px !important; line-height: 30px !important; padding: 0px 10px !important"
						type="submit">
				</div>
				<div class="clear"></div>
			</div>
		</form>
	</div>
	<!-- End content-box -->
</div>


<div class="box-left">
	<div class="title tittle-box-left">
		<h2>Danh mục sản phẩm</h2>
	</div>
	<div class="content-box">
		<!-- The content-box -->
		<ul class="catalog-main">
	          <?php foreach ($catalog_list as $row):?>
                           <li><span><a href="<?php echo base_url('product/catalog/'.$row->id)?>"
					title="<?php echo $row->name?>"><?php echo $row->name?></a></span>
                    			<?php if(!empty($row->subs)):?>
                    			 <!-- lay danh sach danh muc con -->
				<ul class="catalog-sub">
			             	 	 <?php foreach ($row->subs as $subs):?> 
			                            <li><a href="<?php echo base_url('product/catalog/'.$subs->id)?>"
						title="<?php echo $subs->name?>"><?php echo $subs->name?></a></li>		
			                     <?php endforeach;?>
			                     </ul>
			                     <?php endif;?>
						   </li>
			  <?php endforeach;?>
	        </ul>
	</div>
	<!-- End content-box -->
</div>
