function renderWinnerData(date, city, number) {
    var winnerData = $('<div>').addClass('col-sm-6 col-md-6 col-xs-12 no-padding');
    $('<span>').addClass('icon-calendar-winner').appendTo(winnerData);
    $('<span>').addClass('winner-value-date font-color-default').html(date).appendTo(winnerData);
    var div = $('<div>').addClass('winner-value').appendTo(winnerData);
    $('<p>').addClass('font-blue-theme').html(city).appendTo(div);
    $('<p>').html('Número sorteado: ' + number).appendTo(div);

    return winnerData;
}

function renderNextDateItem(date, alreadyDrawn)
{
    var item = $('<div>').addClass('col-20p next-date-size');
    $('<span>').addClass(alreadyDrawn == 'Y' ? 'icon-next-date-y' : 'icon-next-date-n').appendTo(item);
    $('<span>').addClass('next-date-calendar-value-n font-color-default').html(date).appendTo(item);

    return item;
}

$(document).ready(function() {
    // carrega o vídeo do Youtube ao exibir o modal
    $('#modalVideo').on('shown.bs.modal', function() {
        $('#modalVideo iframe').attr('src', 'https://www.youtube.com/embed/_1CrH9F7byE?modestbranding=1&rel=0&controls=0&showinfo=0&html5=1&autoplay=1');
    });

    // remove o link do vídeo ao ocultar o modal
    $('#modalVideo').on('hidden.bs.modal', function() {
        $('#modalVideo iframe').attr('src', '');
    });

    // carrega informações dos sorteados
    $.ajax({
        type: 'GET',
        url: 'winners.json',
        dataType: 'text',
        success: function(response) {
            var json = JSON.parse(response);

            for(i in json.winners) {
                $('#winners-list').append(renderWinnerData(json.winners[i].date, 
                    json.winners[i].city, json.winners[i].number));
            }
        },
        error: function(xhr) {
            alert('Não foi possível obter a lista de ganhadores dos sorteios.');
        }
    });

    // carrega informações dos próximos sorteios
    $.ajax({
        type: 'GET',
        url: 'dates.json',
        dataType: 'text',
        success: function(response) {
            var json = JSON.parse(response);

            $('#nextDate').html(json.nextDate);

            for(i in json.dates) {
                $('#next-dates-list').append(renderNextDateItem(json.dates[i].date, 
                    json.dates[i].alreadyDrawn));
            }
        },
        error: function(xhr) {
            alert('Não foi possível obter as datas dos próximos sorteios.');
        }
    });
});