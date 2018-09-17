var currentPrice = {};
var socket = io.connect('https://streamer.cryptocompare.com/');
var subscription = ['5~CCCAGG~'+coinSymbol+'~USD'];
socket.emit('SubAdd', { subs: subscription });
socket.on("m", function(message) {
	var messageType = message.substring(0, message.indexOf("~"));
	// console.log(message);
	var res = {};
	if (messageType == CCC.STATIC.TYPE.CURRENTAGG) {
		res = CCC.CURRENT.unpack(message);
		dataUnpack(res);
	}
});
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
var dataUnpack = function(data) {
	if(data['FLAGS']==undefined)
	return false;
	
	var from = data['FROMSYMBOL'];
	var to = data['TOSYMBOL'];
	var fsym = CCC.STATIC.CURRENCY.getSymbol(from);
	var tsym = CCC.STATIC.CURRENCY.getSymbol(to);
	var pair = from + to;
	if (!currentPrice.hasOwnProperty(pair)) {
		currentPrice[pair] = {};
	}
	for (var key in data) {
		currentPrice[pair][key] = data[key];
	}
	
	currentPrice[pair]['CHANGE24HOUR'] = CCC.convertValueToDisplay(tsym, (currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']));
	currentPrice[pair]['CHANGE24HOURPCT'] = slag((currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']) / currentPrice[pair]['OPEN24HOUR'] * 100) + "%";
	var chNew=currentPrice[pair]['CHANGE24HOUR'];
	if (chNew >= 0.0) { classMain="up";} else { classMain="down";}
	var prevAttr=$('.livePrice').attr('data-pricePrev');
	$('.24hrChangeLive').removeClass('up').removeClass('down').addClass(classMain).html(currentPrice[pair]['CHANGE24HOURPCT']);
	var pr=slag(currentPrice[pair]['PRICE']*currencyRate);
	$('.livePrice').html(pr);
	$('.livePrice').attr('data-pricePrev',pr);
	$('.lastTradeLive').html(coinSymbol+" "+slag(currentPrice[pair]['LASTVOLUME']) + " ( " +currencySymbol+" "+slag((currentPrice[pair]['LASTVOLUMETO']*currencyRate))+") /"+(currentPrice[pair]['LASTMARKET']));
	$('.vol24Live').html(coinSymbol+" "+slag(currentPrice[pair]['VOLUME24HOUR'])+" ( "+currencySymbol+" "+slag(currentPrice[pair]['VOLUME24HOURTO']*currencyRate)+" ) ");
	
	var unit=$('#qty').val();
	var cFrom=currentPrice[pair]['PRICE'];
	
	var toCurrPriceRate=cFrom*currencyRate*unit;
	
	$('#convert').val(currencySymbol+" "+slag(toCurrPriceRate));
	
	$('.mktCapLive').html(currencySymbol+" "+slag(totalCoins*currentPrice[pair]['PRICE']*currencyRate));
	
	$('.lowHighLive').html(currencySymbol+" "+slag(currentPrice[pair]['LOW24HOUR']*currencyRate) + " / " +currencySymbol+" "+slag(currentPrice[pair]['HIGH24HOUR']*currencyRate));
	
	if (currentPrice[pair]['PRICE'] != prevAttr) {
		_class = prevAttr < currentPrice[pair]['PRICE'] ? 'up' : 'down';
		$('.livePrice2').addClass(_class);
		setTimeout(function () {
			$('.livePrice2').removeClass('up down');
		}, 300);
	}
				
	
};