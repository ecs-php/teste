var $winners = new Vue({
  el: '.page-serasa-ganhadores',
  data: {
    winners: [],
    doorPrizes: []
  },
  methods: {
    loadWinners: function () {
      var _this = this;

      $.get('./api/Serasa/listWinners', {}, function (r) {
        _this.winners = r.results;
      });
    },
    listDoorPrizeDates: function () {
      var _this = this;

      $.get('./api/Serasa/listDoorPrizeDates', {}, function (r) {
        _this.doorPrizes = r.results;
      });
    },
  },
  mounted: function () {
    this.loadWinners();
    this.listDoorPrizeDates();
  },
});
