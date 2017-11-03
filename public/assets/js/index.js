$(function () {


    $('#modal-cadastro-positivo').on('hidden.bs.modal', function (e) {
        $iframe = $(this).find("iframe");
        $iframe.attr("src", $iframe.attr("src"));
    });

    $('a.page-scroll').click(function() {
        $('a.page-scroll').removeClass('active');
        $(this).addClass('active');

        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 900);
                return false;
            }
        }
    });


    var settings = {
        "async": true,
        "crossDomain": true,
        "url": "/draw-date",
        "method": "GET",
        "headers": {
            "content-type": "application/json",
            "cache-control": "no-cache",
        },
        "processData": false,
    }

    $.ajax(settings).done(function (response) {

        var draw = "";

        $.each(response.data, function (key, value) {
            draw += "<li>" +
                " <i class=\"datasorteiospassados-icon\">"+value.date+"</i>" +
                "</li>";
        });

        $("#datasorteios-box").append(draw);

    });

    settings = {
        "async": true,
        "crossDomain": true,
        "url": "/winner",
        "method": "GET",
        "headers": {
            "content-type": "application/json",
            "cache-control": "no-cache",
        },
        "processData": false,
    }

    $.ajax(settings).done(function (response) {

        var winner = "";

        $.each(response.data, function (key, value) {
            winner += "<li>" +
                " <i class=\"calendarioganhador-icon\">"+value.date+"</i>" +
                "<p> <b>"+value.city+"</b> Número sorteado: "+value.code+"</p>" +
                "</li>";
        });

        $("#ganhadores-box").append(winner);

    });
})