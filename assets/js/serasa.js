"use strict";var $winners=new Vue({el:".page-serasa-ganhadores",data:{winners:[],doorPrizes:[]},methods:{loadWinners:function(){var s=this;$.get("./api/Serasa/listWinners",{},function(e){s.winners=e.results})},listDoorPrizeDates:function(){var s=this;$.get("./api/Serasa/listDoorPrizeDates",{},function(e){s.doorPrizes=e.results})}},mounted:function(){this.loadWinners(),this.listDoorPrizeDates()}});
//# sourceMappingURL=serasa.js.map
