
	<!-- // being page Header -->
        <div id="page-header">
          <div class="container">
            <div class="row">
              <div class="page-header">
                <ul class="list-inline brand-tabs">
                  <li><?= $cdata['title']; ?> <i class="fas fa-arrow-right"></i></li>
                  <li class="completed"><a href="javascript:void(0);">
                    <span class="number">01 </span><span class="text"><?= (isset($mdata['title']) ? $mdata['title'] : 'Model'); ?></span>
                  </a></li>
                  <li class="completed"><a href="javascript:void(0);">
                    <span class="number">02 </span><span class="text"><?= (isset($pdata['title']) ? $pdata['title'] : 'Provider'); ?></span>
                  </a></li>
                  <li class="completed"><a href="javascript:void(0);">
                    <span class="number">02 </span><span class="text"><?= (isset($data['title']) ? $data['title'] : 'Storage'); ?></span>
                  </a></li>
                  <li class="active"><a href=""><span class="number">04 </span><span class="text">Condition</span></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- // end Header -->
        
        <!-- // being content Area -->
        <section id="main-content">
          <div class="container">
            <div class="row">
              <h3>Choose Your Condition</h3>
            </div>
            <div class="row">
              <ul class="list-inline model-list">
				 <?php
					foreach($condition AS $con){
						echo '<li class="col-md-3 col-sm-4 col-xs-12">
						  <a href="javascript:;" onclick="get_cond_des('.$con['id'].')" class="btn btn-primary btn-lg btn-block">'.$con['title'].'</a>
						</li>';
					}
				  ?>
              </ul>
            </div>
            <div class="row" >
              <div class="col-md-offset-1 col-md-11">
                <div id="desc" style="display:none;">
                  <h4>If All of the following are true:</h4>
				  <div id="con-des"></div>
                </div>
              </div>
            </div>
            <div class="row" id="pricing"  style="display:none;">
              <div class="col-md-offset-1 col-md-5">
                <div class="totalPrice">
                  Your Offer is: <span>$<span id="s_price">00.00</span></span>
                </div>
              </div>
              <div class="col-md-5">
                <div class="row">
                  <div class="col-sm-offset-2 col-sm-3 col-xs-4 ">
                    <label class="quantit-label">
                      Quantity
                    </label>
                  </div>
                  <div class="col-sm-2  col-xs-2">
                  <span id="quantity-group">
                    <input type="number" id="quntity" min="01" max="999" value="01" >
                    <button type="button" class="quantity-right-plus btn btn-link btn-sm btn-number" data-type="plus" data-field="">
                                            <i class="fas fa-sort-up"></i>
                    </button>
                     <button type="button" class="quantity-left-minus btn btn-link btn-sm btn-number"  data-type="minus" data-field="">
                      <i class="fas fa-sort-down"></i>
                    </button>
                    </span>           
                  </div>
                  <div class="col-sm-5  col-xs-6">
					<input type="hidden" name="pid" id="pid" value="" />
                    <a  href="javascript:void(0);" onclick="add_to_cart(1)" class="btn btn-primary btn-checkout btn-block">Checkout</a>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12 ">
                    <a href="javascript:;" onclick="add_to_cart(2)" class="add-to-cart ">Add to Cart and Add Another Device</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- // end content Area -->
		
	<script>
		function get_cond_des(id){
			$.ajax({
				url:"<?= base_url();?>get/conditon_details",
				type:'POST',
				dataType:'JSON',
				data:{'id':id},
				success:function(result){
					$('#con-des').html(result.description);
					$('#desc').slideDown();
					get_pricing();
				},
				error: function (xhr, textStatus, errorThrown){
					alert(xhr.responseText);
				}
			});
		}
		function get_pricing(){
			$.ajax({
				url:"<?= base_url();?>get/pricing",
				type:'POST',
				dataType:'JSON',
				data:{'mod_id':<?= $mdata['id']; ?>,'pro_id':<?= $pdata['id']; ?>,'sto_id':<?= $data['id']; ?>,'con_id':<?= $con['id']; ?>},
				success:function(res){
					$("#s_price").text(res.pricing);
					$("#pid").val(res.pid);
					$('#pricing').slideDown();
				},
				error: function (xhr, textStatus, errorThrown){
					alert(xhr.responseText);
				}
			});
		}
		function add_to_cart(chk){
			var pid=$('#pid').val();
			var qty=$('#quntity').val();
			$.ajax({
				url:"<?= base_url();?>cart/add",
				type:'POST',
				dataType:'JSON',
				data:{'pid':pid,'qty':qty},
				success:function(res){
				  if(chk==1){
					window.location.replace("<?= base_url();?>order/checkout");
				  }
				  else{
					window.location.replace("<?= base_url();?>");
				  }
				},
				error: function (xhr, textStatus, errorThrown){
					alert(xhr.responseText);
				}
			});
		}
	</script>
        