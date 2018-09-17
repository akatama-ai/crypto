<!DOCTYPE html>
<html lang="en">
  <head>
   <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
   <?php $this->load->view("front/includes/head",['adPageHeader'=>$_ci_view]); ?>
  </head>
<body>
	<div id="respondSearch" class="crypto-main-container">
	<?php $this->load->view("front/includes/header"); ?>
		<span class="spinner"></span>
	<div class="crypton_detail_area">

		<div class="coin_details_right_area">
			<div class="top_bar_details">
				<div class="rank_detail"><?php echo showLangVal($activeLanguage,"rank")." ".$coinInfo['sortOrder'];?></div>
				<a data-attr="<?php echo $coinInfo['cryptoId']?>" class="addWBtn add_watchlist_btn <?php $check=in_array($coinInfo['cryptoId'],$watchList);echo $check?"active on":"off"?>"><?php echo $check? showLangVal($activeLanguage,"added") : showLangVal($activeLanguage,"add");  ?></a>
				<div class="clearfix"></div>
			</div><!-- .top_bar_details -->
			<div class="coin_det_row coin_det_row2">
				<div class="crue_coin">
					<div class="cure_coinbefore">

							<div class="cure_coin_icon"><a href="<?php echo base_url()."coin/".$coinInfo['symbol']?>"><img src="<?php echo base_url()."assets/images/coins/".$coinInfo['image'];?>" class="img-responsive"></a></div>
							<div>
								<div class="details_coin_title"><a href="<?php echo base_url()."coin/".$coinInfo['symbol']?>"><?php echo $coinInfo['coinName'];?></a></div>
								<div><a href="<?php echo base_url()."coin/".$coinInfo['symbol']?>"><?php echo $coinInfo['symbol'];?></a></div>
							</div>

					</div>
				</div>
				<div class="crue_coin">
					<div class="avg_details_area"><?php echo showLangVal($activeLanguage,"average_price_short"); ?></div>
					<span class="livePrice2 avg_details_price">
					<?php echo $activeCurrency['symbol'];?>
					<span data-pricePrev="<?php echo $coinInfo['price'];?>" class="livePrice">
						<?php echo intlCurFmtr($coinInfo['price']*$activeCurrency['rate']);?>
					</span>
					<span class="avg_details_price_curr">
						<?php echo $activeCurrency['currency'];?></span>
					</span>
				</div>
				<div class="crue_coin">
					<div class="avg_details_area"><?php echo showLangVal($activeLanguage, "24hrchange"); ?></div>
					<span class="24hrChangeLive avg_details_price_24hr <?php echo $coinInfo['changePercentage24Hour']>=0?"up":"down";?>"><?php echo round($coinInfo['changePercentage24Hour'],2);?>%</span>
				</div>
			</div><!-- .coin_det_row -->

			<div class="coin_det_row">
				<div class="crue_coin crue_coin_sm">
					<div class=" avg_details_area"><?php echo showLangVal($activeLanguage, "market_cap_short"); ?></div>
					<span class="mktCapLive avg_details_price fontsize14"><?php echo $activeCurrency['symbol']." ".intlCurFmtr($coinInfo['marketCap']*$activeCurrency['rate']);?></span>
				</div>
				<div class="crue_coin crue_coin_sm">
					<div class="avg_details_area"><?php echo showLangVal($activeLanguage, "volume_24h_short"); ?></div>
					<span class="vol24Live avg_details_price fontsize14"><?php echo $coinInfo['symbol']." ".intlCurFmtr($coinInfo['volume24Hour']);?> (<?php echo $activeCurrency['symbol']." ".intlCurFmtr($coinInfo['volume24HourTo']*$activeCurrency['rate']);?>)</span>
				</div>
				<div class="crue_coin crue_coin_sm">
					<div class="avg_details_area"><?php echo showLangVal($activeLanguage, "low_slash_high_24h"); ?></div>
					<span class="lowHighLive avg_details_price fontsize14"><?php echo $activeCurrency['symbol']." ".intlCurFmtr($coinInfo['low24Hour']*$activeCurrency['rate']);?> / <?php echo $activeCurrency['symbol']." ".intlCurFmtr($coinInfo['high24Hour']*$activeCurrency['rate']);?></span>
				</div>
				<div class="crue_coin crue_coin_sm">
					<div class="avg_details_area"><?php echo showLangVal($activeLanguage, "total_coins"); ?></div>
					<span class="avg_details_price fontsize14"><?php echo $activeCurrency['symbol']." ".intlCurFmtr($coinInfo['supply']);?></span>
				</div>
				<div class="crue_coin crue_coin_sm">
					<div class="avg_details_area"><?php echo showLangVal($activeLanguage, "last_trade"); ?></div>
					<span class="lastTradeLive avg_details_price fontsize14"><?php echo $coinInfo['symbol']." ".intlCurFmtr($coinInfo['lastVolume']);?> ( <?php echo $activeCurrency['symbol']." ".intlCurFmtr($coinInfo['lastVolumeTo']*$activeCurrency['rate']);?>) / <?php echo strlen($coinInfo['lastMarket'])==0?"unknown":$coinInfo['lastMarket'];?></span>
				</div>
			</div><!-- .coin_det_row -->

			<div class="int_calc_area">
				<span class="int_calc_label"><?php echo $coinInfo['symbol'];?>/USD <?php echo showLangVal($activeLanguage,"calculator"); ?></span>
				<input id="qty" class="int_calc_input" type="number" value="1">
				<span class="int_calc_equalto">=</span>
				<input disabled id="convert" class="int_calc_input" type="text" value="<?php echo $activeCurrency['symbol'].intlCurFmtr($coinInfo['price']*$activeCurrency['rate']);?>">
				<a target="_blank" class="by_detail_btn" href="<?php echo ( isset($coinInfo['affiliateLink']) && strlen($coinInfo['affiliateLink'])>0 ) ? $coinInfo['affiliateLink']:$affiliateLink;?>"><?php echo showLangVal($activeLanguage,"buy"); ?> <?php echo $coinInfo['symbol'];?></a>
				<div class="clearfix"></div>
			</div><!-- .int_calc_area -->

		</div><!-- .coin_details_right_area -->
		<?php $this->load->view("front/includes/ad-show",['currentPage' => $_ci_view, "className" => "footer_add"]); ?>
		<div class="clearfix"></div>
	</div><!-- .crypton_detail_area -->
	<div class="crypton_detail_area border-all-none">
		<div class="coin_details_right_area">

			<ul class="coin_tabs_area">
				<li class="active tab_charts"><a data-toggle="tab" href="#charts"><?php echo showLangVal($activeLanguage,"charts"); ?></a></li>
				<li class="tab_histo"><a data-toggle="tab" href="#h_data"><?php echo showLangVal($activeLanguage,"historical_data"); ?></a></li>
				<li class="tab_live"><a data-toggle="tab" href="#l_trading"><?php echo showLangVal($activeLanguage,"live_trading"); ?></a></li>
				<li class="tab_social"><a data-toggle="tab" href="#social"><?php echo showLangVal($activeLanguage,"social"); ?></a></li>
			</ul>

			<div class="tab-content">
				<div id="charts" class="tab-pane fade in active">
					<div class="charts_area">
						<!--<div class="charts_title_area">
							<div class="top_bar_details charts_Title">
								Coin Chart
								<div class="clearfix"></div>
							</div>
						</div>-->
						<div class="day_chart_main">
							<div id="chartSection" class="charts_graph_area"><div class="loaderChartMain"><img src="<?php echo base_url()."assets/images/loader.svg"?>" width="15px"></div></div>
						</div>
					</div><!-- .charts_area -->
					<div class="clearfix"></div>
				</div><!-- #charts -->
				<div id="h_data" class="tab-pane fade">
					<!--<div class="charts_title_area">
						<div class="top_bar_details charts_Title">
							<?php echo showLangVal($activeLanguage,"historical_data"); ?>
							<div class="clearfix"></div>
						</div>
					</div>-->
					<div class="day_chart_main historical_data_table">
						<div class="table-responsive">
							<table id="loadHist" class="table">
								<thead>
									<tr>
										<th class="text-left"><?php echo showLangVal($activeLanguage,"date"); ?></th>
										<th class="text-right"><?php echo showLangVal($activeLanguage,"open"); ?></th>
										<th class="text-right"><?php echo showLangVal($activeLanguage,"high"); ?></th>
										<th class="text-right"><?php echo showLangVal($activeLanguage,"low"); ?></th>
										<th class="text-right"><?php echo showLangVal($activeLanguage,"close"); ?></th>
										<th class="text-right"><?php echo showLangVal($activeLanguage,"volume"); ?></th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div id="l_trading" class="tab-pane fade">
				<div class="charts_title_area">
						<div class="top_bar_details charts_Title">
							<?php echo showLangVal($activeLanguage,"buy_live_trades"); ?>
							<div class="clearfix"></div>
						</div>
					</div>
					
					<div class="day_chart_main historical_data_table">
						<div class="table-responsive">
						   <table class="table">
							<thead>
							  <tr>
								<th><?php echo showLangVal($activeLanguage,"market_name"); ?></th>
								<th><?php echo $coinInfo['symbol']." ".showLangVal($activeLanguage,"rate"); ?></th>
								<th><?php echo showLangVal($activeLanguage,"quantity"); ?></th>
								<th><?php echo showLangVal($activeLanguage,"total"); ?></th>
							  </tr>
							</thead>
							<tbody id="bTrades"><tr><td colspan="4"><?php echo showLangVal($activeLanguage,"loading_buy_live_trades"); ?></td></tr></tbody>
						  </table>
						</div>
					</div>
					
					<div class="charts_title_area">
						<div class="top_bar_details charts_Title">
							<?php echo showLangVal($activeLanguage,"sell_live_trades"); ?>
							<div class="clearfix"></div>
						</div>
					</div>
					
					<div class="day_chart_main historical_data_table">
						<div class="table-responsive">
						   <table class="table">
							<thead>
							  <tr>
								<th><?php echo showLangVal($activeLanguage,"market_name"); ?></th>
								<th><?php echo $coinInfo['symbol']." ".showLangVal($activeLanguage,"rate"); ?></th>
								<th><?php echo showLangVal($activeLanguage,"quantity"); ?></th>
								<th><?php echo showLangVal($activeLanguage,"total"); ?></th>
							  </tr>
							</thead>
							<tbody id="STrades"><tr><td colspan="4"><?php echo showLangVal($activeLanguage,"loading_sell_live_trades"); ?></td></tr></tbody>
						  </table>
						</div>
					</div>
				</div>
				<div id="social" class="tab-pane fade">
					<?php
					$TwitterFeed=array_key_exists('Twitter',$coinSocialFeed)?$coinSocialFeed['Twitter']:[];
					$RedditFeed=array_key_exists('Reddit',$coinSocialFeed)?$coinSocialFeed['Reddit']:[];
					$FacebookFeed=array_key_exists('Facebook',$coinSocialFeed)?$coinSocialFeed['Facebook']:[];
					?>
					<div class="charts_title_area">
						<div class="top_bar_details charts_Title">
							<?php echo showLangVal($activeLanguage,"socials"); ?>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="social_widgets_area">
						<div class="social_widgets_block">
							<div class="widget_title">Google</div>
							<div class="all_coin_widgets">
								<script type="text/javascript" src="https://ssl.gstatic.com/trends_nrtr/1127_RC02/embed_loader.js"></script>
								<script type="text/javascript"> trends.embed.renderExploreWidget("TIMESERIES", {"comparisonItem":[{"keyword":"<?php echo $coinInfo['coinName'];?>","geo":"","time":"today 12-m"},{"keyword":"<?php echo $coinInfo['symbol']?>","geo":"","time":"today 12-m"}],"category":0,"property":""}, {"exploreQuery":"q=<?php echo $coinInfo['coinName']?>,<?php echo $coinInfo['symbol']?>,<?php echo $coinInfo['coinName']?>%20ban&date=today 12-m","guestPath":"https://trends.google.com:443/trends/embed/"}); </script>
							</div>
						</div><!-- .social_widgets_block -->
						<?php if(count($FacebookFeed)>0 && isset($FacebookFeed['name'])){?>
							<script>(function(d, s, id) {
							  var js, fjs = d.getElementsByTagName(s)[0];
							  if (d.getElementById(id)) return;
							  js = d.createElement(s); js.id = id;
							  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&appId=1645146312195843&autoLogAppEvents=1';
							  fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));
							</script>
							<div class="social_widgets_block">
								<div class="widget_title">Facebook</div>
								<div class="all_coin_widgets">
									<div class="fb-page" data-href="<?php echo $FacebookFeed['link'];?>" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?php echo $FacebookFeed['link'];?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $FacebookFeed['link'];?>"><?php echo $FacebookFeed['name'];?></a></blockquote></div>
								</div>
							</div><!-- .social_widgets_block -->
						<?php } ?>
						<?php if(count($TwitterFeed)>0 && isset($TwitterFeed['link'])){?>
						<div class="social_widgets_block">
							<div class="widget_title">Twitter</div>
							<div class="all_coin_widgets">
								<a class="twitter-timeline"  href="<?php echo $TwitterFeed['link'];?>?ref_src=twsrc%5Etfw">Tweets by <?php echo $coinInfo['coinName']?></a>
								<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
							</div>
						</div><!-- .social_widgets_block -->
						<?php } ?>
						<?php if(count($RedditFeed)>0 && isset($RedditFeed['name'])){?>
						<div class="social_widgets_block">
							<div class="widget_title">Reddit</div>
							<div class="all_coin_widgets">
								<script src="<?php echo $RedditFeed['link'];?>.embed?limit=30&amp;t=all" type="text/javascript"></script>
							</div>
						</div><!-- .social_widgets_block -->
						<?php } ?>
					</div><!-- .social_widgets_area -->

					<div class="clearfix"></div>
				</div>
				<?php
				if(strlen($coinInfo['description'])>0){?>
				<br>
				  <div class="charts_title_area">
					<div class="top_bar_details charts_Title">
						<?php echo showLangVal($activeLanguage,"description"); ?>
					  <div class="clearfix"></div>
					</div>
				  </div>
				<div>
					<?php echo $coinInfo['description'];?>
				</div>
				<?php } ?>
			</div>

		</div><!-- .coin_details_right_area -->
	</div><!-- .crypton_detail_area -->


<?php $this->load->view("front/includes/footer"); ?>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<!-- Resources -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/amstock.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/<?php echo $nightMode?"light":"dark"?>.js"></script>

<script>
var currencySymbol="<?php echo $activeCurrency['symbol'];?>";
var currency="<?php echo $activeCurrency['currency'];?>";
var currencyRate="<?php echo $activeCurrency['rate'];?>";
var coinPriceBasic="<?php echo $coinInfo['price'];?>";
var coinSymbol="<?php echo $coinInfo['symbol'];?>";
var totalCoins="<?php echo $coinInfo['supply'];?>";
var base_url="<?php echo base_url();?>";
$(document).ready(function(){
	function formatNumber(e){return new Intl.NumberFormat('en-IN', { style:"decimal"}).format(e)}
	function slag(x) {
		if(isNaN(x)) return x;
		if(x < 99999) {
			return formatNumber(x);
		}
		if(x < 1000000) {
			return (x/1000).toFixed(3) + " K";
		}
		if( x < 10000000) {
			return (x/1000000).toFixed(3) + " M";
		}
		if(x < 1000000000) {
			return (x/1000000).toFixed(3) + " M";
		}
		if(x < 1000000000000) {
			return (x/1000000000).toFixed(3) + " B";
		}
		if(x < 1000000000000000) {
			return (x/1000000000000).toFixed(3) + "T";
		}
		return "1T+";
	}
	 $("#qty").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
	$(document).on('change keyup keydown paste mouseup','#qty', function(e) {
		var qty=$(this).val();
		if(qty>=0)
		{
			var finalPrice=qty*currencyRate*coinPriceBasic;

			$('#convert').val(currencySymbol+" "+slag(finalPrice));
		}
		else
		{
			$('#convert').val(currencySymbol+' 0');
			$(this).val('');
		}
	});

  function formatLegendValue(graphDataItem, valueText) {
	return currencySymbol + valueText;
  }
	function init_coin_chart() {
		var primaryColor = '<?php echo $nightMode?"#4731a6":"#f69f11";?>';
		var secondaryColor = '<?php echo $nightMode?"#715ec8":"#f2dcb8";?>';
		var chart;
	  var chartOptions = {
		type: 'stock',
	  "theme": "<?php echo $nightMode?"light":"dark";?>",
		categoryAxesSettings: {
		  minPeriod: 'DD',
		  color: secondaryColor,
		  gridColor: primaryColor, // vertical grid color
		  gridAlpha: 0.1,
		  gridThickness: 1,
		  equalSpacing: true // skip time gaps
		},

	  "dataDateFormat": "DD-MM-YYYY",

		dataSets: [{
		  title: coinSymbol,
		  fieldMappings: [{
			fromField: 'close',
			toField: 'value'
		  }, {
			fromField: 'volumeto',
			toField: 'volume'
		  }],
		  categoryField: 'time'
		}],

		"panelsSettings": {
		 "recalculateToPercents": "never"
		},
		"valueAxesSettings": {
		unit: currencySymbol+" ",
		unitPosition: "left"
	  },
		panels: [{
		  showCategoryAxis: true,
		  title: 'Price',
		  percentHeight: 70,
		  drawingIconsEnabled: true,
		  eraseAll: false,
		  stockGraphs: [ {
			id: 'g1',
			type: 'smoothedLine',
			valueField: 'value',
			lineColor: primaryColor,
			fillAlphas: 0.15,
			lineThickness: 2,
			comparable: true,
			compareField: 'value',
			balloonText: '[[title]]: <b>' + currencySymbol + '[[value]]</b>',
			compareGraphBalloonText: '[[title]]: <b>' + currencySymbol + '[[value]]</b>',
			useDataSetColors: false
		  }],
		  stockLegend: {
			periodValueTextRegular: currencySymbol+" [[value.close]]",
			color: secondaryColor
		  },
		  valueAxes: [{
			position: 'right',
			color: secondaryColor, // color of values
			gridColor: primaryColor, //horizontal grid line color
			gridAlpha: 0.1,
			gridThickness: 1
		  }]
		}, {
		  title: 'Volume',
		  percentHeight: 30,
		  stockGraphs: [ {
			valueField: 'volume',
			type: 'column',
			showBalloon: false,
			lineColor: primaryColor,
			fillAlphas: 0.3,
			useDataSetColors: false
		  } ],
		  stockLegend: {
			periodValueTextRegular: '[[value.close]]'
		  },
		  valueAxes: [{
			position: 'right',
			gridColor: primaryColor, //horizontal grid line color
			gridAlpha: 0.1,
			gridThickness: 1
		  }]
		}],

		chartScrollbarSettings: {
		  graph: 'g1',
		  graphFillColor: primaryColor,
		  graphFillAlpha: 0.4,
		  selectedGraphFillColor: primaryColor,
		  selectedGraphFillAlpha: 1
		},

		chartCursorSettings: {
		  valueBalloonsEnabled: true,
		  graphBulletSize: 1,
		  valueLineBalloonEnabled: true,
		  valueLineEnabled: true,
		  valueLineAlpha: 1,
		  categoryBalloonColor: primaryColor,
		  categoryBalloonAlpha: 0.8,
		  cursorColor: primaryColor,
		  cursorAlpha: 0.8
		},

		periodSelector: {
		  position: 'top',
		  periodsText: '',
		  inputFieldsEnabled: true, //disable dates input
		  periods: [
		  {
			period: 'DD',
			count: 7,
			label: '1W'
		  },{
			period: 'MM',
			count: 1,
			label: '1 Month',
			selected: true
		  },{
			period: 'MM',
			count: 6,
			label: '6M'
		  },{
			period: 'YYYY',
			count: 1,
			label: '1Y'
		  }, {
			period: 'MAX',
			label: 'All'
		  }]
		},

		dataSetSelector: {
		  position: '' // leave empty to hide the native dataSet selection control
		},

		comparedDataSets: [],

		listeners: [{
		  event: 'init',
		  method: function () {
			// add chart background image when the chart is initialized
			$('#chartSection').find('.amcharts-stock-panel-div-stockPanel0 .amcharts-main-div').prepend('<div class="text-center"><img style="max-width:200px; no-repeat center; position: absolute; height: 100%; opacity: 0.18;" src="<?php echo base_url()."assets/images/coins/".$coinInfo['image'];?>"></div>');
		  }
		}]
	  };

	 chart = AmCharts.makeChart('chartSection', chartOptions);

		//return false;
		// $('#cpreloader').fadeIn();
	  $.getJSON(base_url + 'chartLoadMain/'+ coinSymbol +"/"+currency, function (response) {
		// $('#cpreloader').fadeOut();
		if (typeof response != 'undefined') {
			  chart.dataSets[0].dataProvider = response;
			  chart.validateData();
			  var $table = $('#loadHist');
				var $tbody = $table.find('tbody');
				$tbody.html('')
				var history = response;
				var n = history.length;

				for (var i=0; i<n; i++) {
				  if (history[i]) {
					  var d=(history[i].time).split('-');
					$tbody.append('<tr>' +
					  '<td>' + d[2]+"-"+d[1]+"-"+d[0]+ '</td>' +
					  '<td>' + currencySymbol+" "+slag(history[i].open*currencyRate) + '</td>' +
					  '<td>' + currencySymbol+" "+slag(history[i].high*currencyRate) + '</td>' +
					  '<td>' + currencySymbol+" "+slag(history[i].low*currencyRate) + '</td>' +
					  '<td>' + currencySymbol+" "+slag(history[i].close*currencyRate) + '</td>' +
					  '<td>' + currencySymbol+" "+slag(history[i].volumeto*currencyRate) + '</td>' +
					  '</tr>');
				  }
				}
				var histTable = $('#loadHist').DataTable({"oLanguage": { "sSearch": "Filter Data"}}); histTable.order( [ 0, 'desc' ] ).draw();

		}
	  });
	}
	init_coin_chart();
	$(document).on('click','.addWBtn', function(e) {
		e.preventDefault();
		if(processingRequest==1)
		return false;
		var element=$(this);
		var type=element.hasClass('on')?0:1;
		var sym=element.attr('data-attr');
		sym=sym.trim().replace(/\s+/g,"");
		if(sym.length==0)
		{
			alertBox('error','InValid Access');
			return false;
		}
		if(sym.length>0)
		{
			element.html('<img src="<?php echo base_url()."assets/images/loader.svg"?>"  width="15px">');
			processingRequest=1;
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
					{},
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
							{
								$(".addW[data-attr='"+sym+"'] >.throw").removeClass('on').removeClass('off').attr('class','on');
								element.removeClass('on').removeClass('off').addClass('on');
								element.addClass('active');
								element.html('Added');
							}
							else
							{
								$(".addW[data-attr='"+sym+"'] >.throw").removeClass('on').removeClass('off').attr('class','off');
								element.removeClass('on').removeClass('active').removeClass('off').addClass('off');
								element.html('Add');
							}

						}

						processingRequest=0;
					}
				});
		}
	});
});
</script>
<script src="<?php echo base_url()."assets/plugins/coinLive/coinLive.js?a=".time();?>"></script>
<script src="<?php echo base_url()."assets/plugins/coinLive/trades.js?a=".time();?>"></script>
</body>
</html>
