
function makeItLive() { 
    var socket = io.connect('https://streamer.cryptocompare.com/');
    var subscription = get_coinsSpread();
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
	var dataUnpack = function(data) {
		console.log(dataUnpack);
		return false;
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
	lowHighLive = element.find(".lowHighLive");
		
	currentPrice[pair]['CHANGE24HOUR'] = CCC.convertValueToDisplay(tsym, (currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']));
	currentPrice[pair]['CHANGE24HOURPCT'] = slag((currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']) / currentPrice[pair]['OPEN24HOUR'] * 100) + "%";
	var chNew=currentPrice[pair]['CHANGE24HOUR'];
	if (chNew >= 0.0) { classMain="up"; classUD="ti-arrow-up";} else { classUD="ti-arrow-down";classMain="down";}
	$(change).parent().removeClass('up').removeClass('down').addClass(classMain);
	$(change).html(chNew + "%" + "<i class='"+classUD+"'></i>");
	
	
	var actPriceNew=currentPrice[pair]['PRICE']*currencyRate;
	priceLiveNewFormat ="<span>"+currencySymbol+"</span><span>"+slag(actPriceNew)+"</span>";
	previousprice = $(price).attr('attrPrice')*currencyRate;
	
	$(price).attr('attrPrice',actPriceNew);
	$(price).html(priceLiveNewFormat);
	$(volume).html(slag((currentPrice[pair]['VOLUME24HOURTO']*currencyRate)/actPriceNew) + " "+coin);
	var tcoins=$('#current'+coinSymbol).attr('data-coins');
	$(capital).html(currencySymbol+" "+slag(tcoins*currentPrice[pair]['PRICE']*currencyRate)); 
	$(supply).html(slag(coin_data.supply)+" "+coin);
	$(lastMarket).html(exchange_id);
	
	$(lowHighLive).html(currencySymbol+" "+slag(currentPrice[pair]['LOW24HOUR']*currencyRate) + " / " +slag(currentPrice[pair]['HIGH24HOUR']*currencyRate));
	
};
}
function get_coinsSpread() {
    var result = [];
    $('.coinsSpread').each(function() {
        result.push('5~CCCAGG~'+$(this).attr('data-id')+'~USD')
    });
    return result;
}
makeItLive();