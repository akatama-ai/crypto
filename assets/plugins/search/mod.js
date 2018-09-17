	
	function alertBox(type,text)
	{
		var titles={error:'Encountered an error!',success:'Success',warning:'<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>'};
		var types={error:'red',success:'blue',warning:'blue'};
		$.confirm({
			title: titles[type],
			content: text,
			type: types[type],
			typeAnimated: true,
			buttons: {
				ok: function () {
				}
			}
		});
	}
	var search=false;
	
	$(document).on('click','.searchItem',function(e){
		var query=$(this).attr('data-val');
		window.location.href=baseUrl+"coin/"+query;
		});
	$(document).on('click','.search-cross',function()
	{
		$('#query').val('');
		$('.appendDivSearch').addClass('hide').html('');
		$('.search-spinner,.search-cross').addClass('hide');
		$('.search-icon').removeClass('hide');
		search=false;
	});
	var processingRequest=0;
	var processingRequest2=0;
	function searchCallBack(){
		if(processingRequest==1)
		return false;
	
		var data=new FormData();
		var searchValue=$('#query').val();
		searchValue=searchValue.replace(/\s+/g," ");
		if(searchValue.length==0)
		{
			$('.search-spinner,.search-cross').addClass('hide');
			$('.search-icon').removeClass('hide');
			$('.appendDivSearch').addClass('hide').html('');
			search=false;
			return false;
		}
		
		// searchValue=searchValue.trim().replace(/[^-\w\s]+/g, '');
		if(searchValue.length>0)
		{
			processingRequest=1;
			data.append('query',searchValue);
			$.ajax({
					url:baseUrl+'search/post',
					type:"POST",
					contentType:false,
					data:data,
					cache:false,
					processData:false,
					beforeSend:function()
					{
						$('.search-cross,.search-icon').addClass('hide');
						$('.search-spinner').removeClass('hide');
					},
					success:function(data)
					{
						if(data.length!=0)
						{
							if(searchValue.length!=0)
							{
								$('.appendDivSearch').html(data).removeClass('hide');
								$('.search-spinner').addClass('hide');
								$('.search-cross').removeClass('hide');
								search=true;
							}
							else
							{
								$('.search-spinner,.search-cross').addClass('hide');
								$('.search-icon').removeClass('hide');
								$('.appendDivSearch').addClass('hide').html('');
								search=false;
							}
						}
						else
						{
							$('.search-spinner,.search-cross').addClass('hide');
							$('.search-icon').removeClass('hide');
							$('.appendDivSearch').addClass('hide').html('');
							search=false;
						}
						// $(".result-class").replaceText(searchValue, "<strong>"+searchValue+"<\/strong>" )
						// $('#searchSatusAppend').html('<span id="clearSearch" class="fa fa-times-circle searchCancel-btn "></span>');
						processingRequest=0;
					}
				});
		}
		else
		{
			$('.appendDivSearch').html('').addClass('hide');
		}
	}

	$('#query').donetyping(searchCallBack,500);	  
	 
	$(document).on('click','.addW', function(e) {
		e.preventDefault();
		var type=$(this).find('.throw').hasClass('on')?0:1;
		var sym=$(this).attr('data-attr');
		sym=sym.replace(/\s+/g," ");
		if(sym.length==0)
		{
			alertBox('error','InValid Access');
			return false;
		}
		// searchValue=searchValue.trim().replace(/[^-\w\s]+/g, '');
		if(sym.length>0)
		{
			processingRequest2=1;
			var data=new FormData();
			data.append('sym',sym);
			data.append('type',type);
			$.ajax({
					url:baseUrl+'manage/watch',
					type:"POST",
					contentType:false,
					data:data,
					cache:false,
					processData:false,
					beforeSend:function()
					{
						
					},
					success:function(data)
					{
						var responseData=$.parseJSON(data);
						var response=responseData['response'];
						var responseHtml=responseData['responseHtml'];
						if(response == 0)
						{
							alertBox('error',responseHtml);
						}
						else if(response == 1)
						{
							if(type==1)
							$(".addW[data-attr='"+sym+"'] >.throw").removeClass('on').removeClass('off').attr('class','throw on');
							else
							$(".addW[data-attr='"+sym+"'] >.throw").removeClass('on').removeClass('off').attr('class','throw off');
						}
						
						processingRequest2=0;
					}
				});
		}
		
	});
		
		$(document).on('keyup paste','#query', function() {
		// this.val = $(this).val($(this).val().replace(/[^-\w\s]+/g, ''));
		searchCallBack();
		}).bind('paste', function () {
		searchCallBack();
	});

$('#query').click(function() {
	 // $('.search-fld-focus').toggle();
	  if(search)
	$('.appendDivSearch').removeClass('hide');
  });