
$( document ).ready(function() {
     $.ajax({
        url: "data/data.json",
        dataType: "text",
        success: function(data) {
            let json = $.parseJSON(data);
            let dates = json.dates;
            let winners = json.winners;

            for (var i = winners.length - 1; i >= 0; i--) {
                $('.winners-list').append(
                    $('<li class="col-lg-6">').append(
                        $('<span class="image winner-date">').text(winners[i].date),
                        $('<span class="winner">').append(
                            $('<span class="city">').text(winners[i].city),
                            $('<span class="number">').text('Número sorteado: ' + winners[i].number)
                        )
                    )
                );
            };

            
            for (var i = 0; i < dates.length; i ++ ) {
                let classes = 'image date';
                if(dates[i].status == 1) {
                    classes = 'image date done';
                };
                $('.prize-draw-list').append(
                    $('<li class="col-lg-5 col-sm-5">').append(
                        $('<div class="'+ classes + '">').text(dates[i].date)
                    )
                );
            };


        }
    });
});