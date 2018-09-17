<footer>
	<div class="container-fluid">
			<div class="row">
				<div class="col-md-6">
					<div class="copyright-text"><?php echo showLangVal($activeLanguage,"copyright")." ".date("Y"); ?> &copy; <?php echo $title." ".showLangVal($activeLanguage,"all_rights_reserved"); ?></div>
				</div>
				<div class="col-md-6">
					<div class="footer-nav">
						<?php
						foreach($pages as $page) {
							?>
							<a href="<?php echo base_url("page/".$page['permalink']); ?>"><?php echo $page['title']; ?></a>
							<?php
						}
						?>
						<a href="<?php echo base_url("contact-us"); ?>"><?php echo showLangVal($activeLanguage,"contact_us"); ?></a>
					</div>
				</div>
			</div>
		</div>
	<script type="application/javascript" src="<?php echo base_url("assets/jquery/jquery.min.js"); ?>"></script>
	<script type="application/javascript" src="<?php echo base_url("assets/bootstrap/js/bootstrap.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/bootstrap-select/js/bootstrap-select.min.js"); ?>"></script>
	<script type="application/javascript" src="<?php echo base_url("assets/plugins/jConfirm/jquery-confirm.js"); ?>"></script>
	<script type="application/javascript" src="<?php echo base_url("assets/plugins/doneTyping/doneTyping.js"); ?>"></script>
	<script>var baseUrl="<?php echo base_url();?>";</script>
	<script type="application/javascript" src="<?php echo base_url("assets/plugins/search/mod.js"); ?>"></script>
	<script src="<?php echo base_url()."assets/plugins/clipboard/clipBoard.js"?>"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
	<script src="<?php echo base_url()."assets/plugins/coinLive/ccc-streamer-utilities.js"?>"></script>
    <script src="<?php echo base_url()."assets/js/bootstrap-select.min.js"?>"></script>
	<script> 
	$(document).ready(function() {
			$('.selectpicker').selectpicker({
				title: 'USD'
			});
	});
	var currencySymbol="<?php echo $activeCurrency['symbol'];?>";
	var currencyRate="<?php echo $activeCurrency['rate'];?>";
	var baseUrl="<?php echo base_url();?>";
	
	function alertBox(type,text)
	{
		var titles={error:'<?php echo showLangVal($activeLanguage,"error"); ?>',success:'<?php echo showLangVal($activeLanguage,"success"); ?>',warning:'<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>'};
		var types={error:'red',success:'blue',warning:'blue'};
		$.confirm({
			title: titles[type],
			content: text,
			theme: '<?php echo $nightMode?"dark":"dark"?>',
			type: types[type],
			typeAnimated: true,
			buttons: {
				ok: function () {
				}
			}
		});
	}
		$(document).ready(function() {
					
			var uri = window.location.toString();
			var perma="<?php echo base_url().$url?>";
				
			if (uri.indexOf("?") > 0) {
			   window.history.pushState(null,null,perma);
			}
			$(document).on('click','.lightsonoff',function(e){ 
				var active=$(this).is(":checked"); 
				var type='off';
				if(active)
				{
					type='on';
				}
				window.location.href=perma+"?lights="+type;
			});
			$("#header_currency").change(function() {
				window.location.href=perma+"?cur="+$(this).find("option:selected").attr('data-value');
			});
			
			$(document).on('click','.langChange',function(e){
				var name=$(this).attr("data-perma");  
				window.location.href=perma+"?language="+name;
			});
			$(document).on('click','.menuBtn',function(e){
				$(".menu").addClass("menu--open");
			});
			$(document).on('click','.close-button__link',function(e){
				$(".menu.menu--open").removeClass("menu--open");
			});
			$(document).on('click','.menu',function(event){
				event.stopPropagation();
			});
			
			///////
			
			$(document).on('click','.crcChn',function(e){
				$(".menu_settings_header").addClass("menu_open");
				$(this).addClass("crcChn2").removeClass('crcChn');
			});
			$(document).on('click','.crcChn2',function(e){
				$(".menu_settings_header").removeClass('menu_open');
				$(this).removeClass('crcChn2').addClass("crcChn");
			});
			// $(document).on('click','.close-button__link',function(e){
				// $(".menu_settings_header.menu_open").removeClass("menu_open");
			// });
			// $(document).on('click','.menu_settings_header',function(event){
				// event.stopPropagation();
			// });
			
			///////
			
			var clipboard = new Clipboard('#clip');
			clipboard.on('success', function(e) {
			$('#clip').addClass('tickClass');
			var delay=1000;
			setTimeout(function()
			{
				$('#clip').removeClass('tickClass');
				var delay=1000;
				},delay);
				e.clearSelection();
			});
			(function($){
				$.fn.focusTextToEnd = function(){
					this.focus();
					var $thisVal = this.val();
					this.val('').val($thisVal);
					return this;
				}
			}(jQuery));
			$(document).on('click','.title_edit',function(e){
				$('.user_edit_input').removeClass('hide').focusTextToEnd();
				$('.modal__title').addClass('hide');
				$(this).addClass('updateTitle');
				$(this).html('<span class="top_tooltip_dp">Save</span>');
			});
			$(document).on('click','.updateTitle',function(e){
				var element=$(this);
				var username=$('.user_edit_input').val();
				if($('.user_edit_input').attr('data-name') == username)
				{
					$('.user_edit_input').addClass('hide');
					$('.modal__title').removeClass('hide');
					element.removeClass('updateTitle');
					element.html('<span class="top_tooltip_dp">Edit</span>');
				}
				else
				{
					element.addClass('accountEditLoader');
					$.ajax ({
							type: 'POST',
							url: baseUrl+'manage/account/update_username',
							data: {pName:username},
							success: function(result) {
								var responseData=$.parseJSON(result);
								var response=responseData['response'];
								var responseHtml=responseData['responseHtml'];
								if(response==0)
								{	
									alertBox('error',responseHtml);
									element.removeClass('updateTitle').removeClass('accountEditLoader');
								}
								else if(response==1)
								{
									alertBox('success',responseHtml);
									$('.user_edit_input').addClass('hide');
									$('.modal__title').removeClass('hide');
									element.removeClass('updateTitle').removeClass('accountEditLoader');
									$('.user_edit_input').val(username);
									$('.modal__title').html(username);
									$('.trimUser').html(username.substring(0,1));
								}
								
							}
						});
					}
			});
			<?php if(!isset($this->session->secure)){?>
			$(document).on('click','#createNewPortfolio',function(e){
			e.preventDefault();
			
			var pName=$('#pName').val();
			pName=pName.trim().replace(/\s+/g,"");
			
			if(pName.length==0)
			{
				alertBox('error','<?php echo showLangVal($activeLanguage,"account_add_error"); ?>');
				return false;
			}
			var element=$(this);
			element.html('<img src="<?php echo base_url()."assets/images/loader.svg"?>">');
			 
			var data=new FormData();
			data.append('pName',pName);
			$.ajax({
					url:baseUrl+'manage/account/new',
					type:"POST",
					contentType:false,
					data:data,
					cache:false,
					processData:false,
					beforeSend:function(){},
					success:function(data)
					{
						var responseData=$.parseJSON(data);
						var response=responseData['response'];
						var responseHtml=responseData['responseHtml'];
						if(response == 0)
						{
							alertBox('error',responseHtml);
							element.html('<img src="<?php echo base_url()."assets/images/create_portfolio_check.svg"?>"><?php echo showLangVal($activeLanguage,"create_account"); ?>');
						}
						else if(response == 1)
						{
							alertBox('success',"<?php echo showLangVal($activeLanguage,"account_add_success"); ?>");
							var page=window.location.pathname;
							if(page!="/portfolio")
							location.reload();
							else
							window.location.href="<?php echo base_url()."portfolio?redirectLogin=1"?>";
						}
						processingRequest=0;
					}
				});
			});
			 var swipeMenurep="";
		$(document).on('click','.bkrestore',function(e){
			$('#rep').html(swipeMenurep);
		});
		$(document).on('click','.res-btn',function(e){
			e.preventDefault();
			swipeMenurep=$('#rep').html();
			var cryptoId=$(this).attr('data-attr');
			var img=$(this).attr('data-img');
			var symbol=$(this).attr('data-symbol');
			$('#rep').html('<div class="portfolio_add_area restore_portfolio"><a href="#" class="bkrestore back-button"></a><div class="icon_image restore_man"></div><div class="icon_title portfolio_title"><?php echo showLangVal($activeLanguage,"restore_account"); ?></div><div class="profile_name_label_input"><div class="profile_name_label"><?php echo showLangVal($activeLanguage,"backup_code"); ?></div><input placeholder="<?php echo showLangVal($activeLanguage,"restore_account_field_permalink"); ?>" class="profile_name_input form-control text-center" id="rPname" type="text"></div><div class="clearfix"></div><a class="add_portofolio_btn" id="resPortfolio"><?php echo showLangVal($activeLanguage,"restore_account"); ?></a><div class="clearfix"></div></div><div class="clearfix"></div>');		
		});
		
		$(document).on('click','#resPortfolio',function(e){
			e.preventDefault();
			
			var resH=$('#rPname').val();
			resH=resH.trim().replace(/\s+/g,"");
			
			if(resH.length!=8)
			{
				alertBox('error','<?php echo showLangVal($activeLanguage,"account_restore_error_message_1"); ?>');
				return false;
			}
			var element=$(this);
			element.html('<img src="<?php echo base_url()."assets/images/loader.svg"?>">');
			
			var data=new FormData();
			data.append('resH',resH);
			$.ajax({
					url:baseUrl+'manage/account/restore',
					type:"POST",
					contentType:false,
					data:data,
					cache:false,
					processData:false,
					beforeSend:function(){},
					success:function(data)
					{
						console.log(data);
						var responseData=$.parseJSON(data);
						var response=responseData['response'];
						var responseHtml=responseData['responseHtml'];
						if(response == 0)
						{
							alertBox('error',responseHtml);
							element.html('<img src="<?php echo base_url()."assets/images/restore.svg"?>"> <?php echo showLangVal($activeLanguage,"restore_account"); ?>');
						}
						else if(response == 1)
						{
							alertBox('success',"<?php echo showLangVal($activeLanguage,"account_restore_success_message"); ?>");
							location.reload();
						}
						
						processingRequest=0;
					}
				});
			});
			<?php } ?>
		});
	</script>
</footer>
<div class="search-fld-focus" style="display: none;"></div>