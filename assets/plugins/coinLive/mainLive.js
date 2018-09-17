function formatNumber(e){return new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 2 }).format(e)}
function slag(x) {
		if(isNaN(x)) return x;
		if(x < 9999) {
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
	
var socket = io.connect('https://socket.coincap.io');
$(document).ready(function () {
 socket.on('trades', function (data) {
		updateMarkets(data);
	});
});


window.updateMarkets = function (data) {
	if (data.coin != undefined) {
		var coin = data.coin;
		var exchange_id = data.exchange_id;
		var coin_data = data.msg;
		var aa='#current'+coin;
		var bb='#respOn'+coin;
		var element = $(aa);
		var element2 = $(bb);
		price = element.find(".priceLive");
		volume = element.find(".volLive");
		change = element.find(".changeLive");
		capital = element.find(".capLive");
		supply = element.find(".supplyLive");
		lastMarket = element.find(".lastMarket");
		var actPriceNew=coin_data.price*currencyRate;
		priceLiveNewFormat ="<span>"+symbol+"</span><span>"+slag(actPriceNew)+"</span>";
		previousprice = $(price).attr('attrPrice')*currencyRate;
		
		$(price).attr('attrPrice',actPriceNew);
		$(price).html(priceLiveNewFormat);
		$(volume).html(slag((coin_data.volume*currencyRate)/actPriceNew) + " "+coin);
		$(capital).html(symbol+" "+fnum(coin_data.mktcap*currencyRate)); 
		$(supply).html(slag(coin_data.supply)+" "+coin);
		$(lastMarket).html(exchange_id);
		
		var chNew=coin_data.cap24hrChange;
		if (chNew >= 0.0) {
			 classUD="ti-arrow-up";
			 classMain="up";
		} else {
			classUD="ti-arrow-down";
			classMain="down";
		}
		
		$(change).parent().removeClass('up').removeClass('down').addClass(classMain);
		
		$(change).html(chNew + "%" + "<i class='"+classUD+"'></i>");
		if (actPriceNew !== previousprice) {
			_class = previousprice < actPriceNew ? 'statusGreenLive' : 'statusRedLive';
			$(aa+","+bb).addClass(_class);
			setTimeout(function () {
				$(aa+","+bb).removeClass('statusGreenLive statusRedLive');
			}, 300);
		}
	}
};