var pathApiRest = "http://localhost/teste/backend/web";
var apikey = "";
$(document).ready(function () {
    var data = {
        email: 'user1@gmail.com',
        password: 'user1',
    };
    $.ajax({
        type: "POST",
        url: pathApiRest + "/login",
        processData: false,
        data: JSON.stringify(data),
        dataType: "json",
        success: function (json) {
            apikey = json.apikey;
            $.ajax({
                type: "GET",
                url: pathApiRest + "/product",
                processData: false,
                data: '',
                dataType: "json",
                headers: {
                    "Authorization": "Basic "+apikey
                },
                success: function (json) {
                    $(".winner_list").html("");
                    for(var product in json){
                        var html = '<div class="col-xl-6 col-lg-6 col-md-6">'
                            +'      <div class="row">'
                            +'          <span class="icon icon4 ">05/04</span>'
                            +'          <div class="icon4-text">'
                            +'              <b>'+json[product]["title"]+'</b><br>'
                            +'              '+json[product]["title"] +' '
                            +'          </div>'
                            +'      </div>'
                            +'  </div>';
                        $(".winner_list").append(html);
                    }
                }
            });
        }
    });



});

