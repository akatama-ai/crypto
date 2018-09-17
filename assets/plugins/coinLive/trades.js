	var resultReturnedBuy=false;
	var resultReturnedSell=false;
	var streamUrl = "https://streamer.cryptocompare.com/";
	var currentSubs;
	var currentSubsText = "";
	var dataUrl = "https://min-api.cryptocompare.com/data/subs?fsym=" + coinSymbol + "&tsyms=USD";
	var socketT = io(streamUrl);
	$.getJSON(dataUrl, function(data) {
		currentSubs = data['USD']['TRADES'];
		for (var i = 0; i < currentSubs.length; i++) {
			currentSubsText += currentSubs[i] + ", ";
		}
		$('#sub-exchanges').text(currentSubsText);
		socketT.emit('SubAdd', { subs: currentSubs });
	});   

	socketT.on('m', function(currentData) {
		var tradeField = currentData.substr(0, currentData.indexOf("~"));
		if (tradeField == CCC.STATIC.TYPE.TRADE) {
			transformData(currentData);
		}
		
	});

	var transformData = function(data) {
		var coinfsym = CCC.STATIC.CURRENCY.getSymbol(coinSymbol);
		var cointsym = currencySymbol;
		var incomingTrade = CCC.TRADE.unpack(data);
		
		var newTrade = {
			Market: incomingTrade['M'],
			Type: incomingTrade['T'],
			ID: incomingTrade['ID'],
			Price: CCC.convertValueToDisplay(cointsym, incomingTrade['P']*currencyRate),
			Quantity: CCC.convertValueToDisplay(coinfsym, incomingTrade['Q']),
			Total: CCC.convertValueToDisplay(cointsym, incomingTrade['TOTAL']*currencyRate)
		};
		if (incomingTrade['F'] & 1) 
		{
			if(resultReturnedSell==false)
			$("#STrades").html('');
			displayData(newTrade,"#STrades");
			resultReturnedSell=true;
		}
		else if (incomingTrade['F'] & 2) 
		{
			if(resultReturnedBuy==false)
			$("#bTrades").html('');
			displayData(newTrade,"#bTrades");
			resultReturnedBuy=true;
		}
		
	};
	setTimeout(function(){ 

	if(resultReturnedBuy==false)
	$('#bTrades').html('<tr><td colspan="4">No live trading occuring now ...</td></tr>');

	if(resultReturnedSell==false)
	$('#STrades').html('<tr><td colspan="4">No live trading occuring now ...</td></tr>');
	}, 10000);
	var displayData = function(dataUnpacked,element) {
		var maxTableSize = 20;
		var length = $(element+' tr').length;
		$(element).prepend(
			"<tr><td>" + dataUnpacked.Market + "</td><td>" + dataUnpacked.Price + "</td><td>" + dataUnpacked.Quantity + "</td><td>" + dataUnpacked.Total + "</td></tr>"
		);

		if (length >= (maxTableSize)) {
			$(element+' tr:last').remove();
		}
	};
