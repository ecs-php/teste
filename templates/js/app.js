$(function() {
	$.get('json/winners.json', function(result){
		let items = [];
		$.each(result, function(key, val){
			items.push('<div class="col-xs-12 col-sm-6"><div class="inline"><div class="calendar-orange sprite">'+val.date+'</div><div class="block-inline"><span class="winner-city">'+val.city+' - '+val.state+'</span><span class="winner-number">Número sorteado: <b>'+val.number+'</b></span></div></div></div>')
		});
		$("#winners").append(items);
	});
});