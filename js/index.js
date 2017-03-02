$(document).on('pagebeforeshow', '#index', function() {
	ajax.ajaxCall("restfulapi.php/people", true);
});

$(document).on('click', '.button-update', function() {
	ajax.ajaxCall("restfulapi.php/person/" + $(this).data('id'), false);
});

$(document).on('click', '.button-delete', function() {
	ajax.ajaxDeleteCall("restfulapi.php/person/" + $(this).data('id'));
});

$(document).on('click', '#submitInsert', function() {
	ajax.ajaxInsertCall("restfulapi.php/person");
	return false;
});

$(document).on('click', '#submitUpdate', function() {
	ajax.ajaxUpdateCall("restfulapi.php/person/" + $(this).data('id'));
	return false;
});

var ajax = {
	parseJSON : function(result) {
		$('#person-list').empty();
		$.each(result,function(key, row) {
							$('#person-list')
									.append(
											'<li data-listid="'
													+ row.ID
													+ '">'
													+ '<h3>Name:'+ row.NAME + '</h3>'
													+ '<p>'
													+ 'Age: ' + row.AGE + ' - Email: ' + row.EMAIL + ' - Gender: '+ row.GENDER + ' - Phone:' + row.PHONE 
													+ '- Created: '+ row.DATECREATED + ' - Updated: '+ row.DATEUPDATED
													+ '</p>'
													+ '<p>'
													+ '<a href="" class="button-update" data-id="'
													+ row.ID
													+ '">Update</a>'
													+ '<a href="" class="button-delete" data-id="'
													+ row.ID + '">Delete</a>'
													+ '</p>'
													+ '</li>');
						});
		$('#person-list').listview('refresh');
	},
	parseJSONDetails : function(result) {
		$('#person-data').empty();
		$('#person-data').append('<li>Name: <input type="text" id="uname" value="'+result[0].NAME+'"></li>');
		$('#person-data').append('<li>Age: <input type="text" id="uage" value="'+result[0].AGE+'"></li>');
		$('#person-data').append('<li>Email: <input type="text" id="uemail" value="'+result[0].EMAIL+'"></li>');
		

		$('#person-data').append('<li>Gender: <select id="ugender"></select></li>');
		if(result[0].GENDER == 'M'){
			$('#ugender').append('<option value="M" selected="selected">M</option>');
			$('#ugender').append('<option value="F" >F</option>');
		}else {
			$('#ugender').append('<option value="M" >M</option>');
			$('#ugender').append('<option value="F" selected="selected">F</option>');
		}
		
		$('#person-data').append('<li>Phone: <input type="text" id="uphone" value="'+result[0].PHONE+'"></li>');
		$('#person-data').append('<li><input id="submitUpdate" type="button" name="submit" value="submit" data-id="'+ result[0].ID + '"></li>');
		$('#person-data').listview().listview('refresh');
		$.mobile.changePage("#update");		
	},
	ajaxCall : function(url, initialize) {
		var username = $("input#username").val();
		var password = $("input#password").val(); 
		$.ajax({
			url : url,
			async : 'true',
			dataType : 'json',
			beforeSend: function (xhr) {
			    xhr.setRequestHeader ("Authorization", "Basic " + btoa(username + ":" + password));
			},
			statusCode : {
				200 : function(result) {
					if (initialize) {
						ajax.parseJSON(result);
					} else {
						ajax.parseJSONDetails(result);
					}
				},
				401 : function(result) {
					alert('Invalid login!');
					$('#formInsert')[0].reset();
					$.mobile.changePage("#index");
					ajax.ajaxCall("restfulapi.php/people", true);
				},
				404 : function(request, error) {
					alert('Network error has occurred, please try again!');
				}
			}
		});
	},
	ajaxDeleteCall : function(url) {
		var username = $("input#username").val();
		var password = $("input#password").val(); 
		$.ajax({
			url : url,
			async : 'true',
			dataType : 'json',
			beforeSend: function (xhr) {
			    xhr.setRequestHeader ("Authorization", "Basic " + btoa(username + ":" + password));
			},
			type : 'DELETE',
			statusCode : {
				204 : function(result) {
					alert('Delete Ok!');
					ajax.ajaxCall("restfulapi.php/people", true);
				},
				401 : function(result) {
					alert('Invalid login!');
					$('#formInsert')[0].reset();
					$.mobile.changePage("#index");
					ajax.ajaxCall("restfulapi.php/people", true);
				},
				404 : function(request, error) {
					alert('Network error has occurred, please try again!');
				}
			}
		});
	},
	ajaxInsertCall : function(url) {
		var username = $("input#username").val();
		var password = $("input#password").val(); 
		var data = {}
		var Form = $('#formInsert');

		data['name'] = $('#iname').val();
		data['age'] = $('#iage').val();
		data['email'] = $('#iemail').val();
		data['gender'] = $('#igender').val();
		data['phone'] = $('#iphone').val();

		$.ajax({
			url : url,
			async : 'true',
			dataType : 'json',
			beforeSend: function (xhr) {
			    xhr.setRequestHeader ("Authorization", "Basic " + btoa(username + ":" + password));
			},
			type : 'POST',
			data : JSON.stringify(data),
			statusCode : {
				201 : function(result) {
					alert('Insert Ok!');
					$('#formInsert')[0].reset();
					$.mobile.changePage("#index");
					ajax.ajaxCall("restfulapi.php/people", true);
				},
				401 : function(result) {
					alert('Invalid login!');
					$('#formInsert')[0].reset();
					$.mobile.changePage("#index");
					ajax.ajaxCall("restfulapi.php/people", true);
				},
				404 : function(request, error) {
					alert('Network error has occurred, please try again!');
				}
			}
		});
	},
	ajaxUpdateCall : function(url) {
		var username = $("input#username").val();
		var password = $("input#password").val(); 
		var data = {}
		var Form = $('#formUpdate');

		data['name'] = $('#uname').val();
		data['age'] = $('#uage').val();
		data['email'] = $('#uemail').val();
		data['gender'] = $('#ugender').val();
		data['phone'] = $('#uphone').val();

		$.ajax({
			url : url,
			async : 'true',
			dataType : 'json',
			beforeSend: function (xhr) {
			    xhr.setRequestHeader ("Authorization", "Basic " + btoa(username + ":" + password));
			},
			type : 'PUT',
			data : JSON.stringify(data),
			statusCode : {
				200 : function(result) {
					alert('Update Ok!');
					$.mobile.changePage("#index");
					ajax.ajaxCall("restfulapi.php/people", true);
				},
				401 : function(result) {
					alert('Invalid login!');
					$('#formInsert')[0].reset();
					$.mobile.changePage("#index");
					ajax.ajaxCall("restfulapi.php/people", true);
				},
				404 : function(request, error) {
					alert('Network error has occurred, please try again!');
				}
			}

		});
	}
}