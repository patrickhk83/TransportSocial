



/**
 * Enable dialog of create&edit user
 * @param signup_url
 */

function enable_user_dialog(signup_url , default_img_url , user_id)
{

	$('#birthday').datepicker({setStartDate: '-100y' , orientation: "bottom left" , autoclose: 'true' , format:'d-m-yyyy' , beforeShow: function() {
			var $datePicker = $("#birthday");
			var zIndexModal = $datePicker.closest(".modal").css("z-index");
			$datePicker.css("z-index", zIndexModal + 1);  }});

	$("#submit_btn").click(function() {

		var bValid = true;
		var user_id = $('#person_id');
		var fname = $("#fname") , lname = $("#lname") , email = $( "#email" ) , passwords = $( "#passwords" ) , repeat_password = $('#repeat_password') , country = $('#country');
		var birthday = $('#birthday') , occupation = $('#occupation') , about_me = $('#about_me') , hobbies = $('#hobbies') , musics = $('#musics') , movies = $('#movies') , books = $('#books');
		var msg = $('#error_message_box');
		bValid = bValid && check_empty_field(fname, "<? echo lang('create_user_validation_fname_label'); ?>");
		bValid = bValid && check_empty_field(lname, "<? echo lang('create_user_validation_lname_label'); ?>");
        bValid = bValid && check_empty_field(email, "<? echo lang('create_user_validation_email_label'); ?>");
        bValid = bValid && check_empty_field(country, "<? echo lang('create_user_validation_location_label'); ?>");
		if(user_id.val() == '0')
		{
        	bValid = bValid && check_empty_field(passwords, "<? echo lang('create_user_validation_password_label'); ?>");
        	bValid = bValid && check_empty_field(repeat_password, "<? echo lang('create_user_validation_password_confirm_label'); ?>");
		}
		if(passwords.val() != repeat_password.val())
		{
			alert(passwords.val());
			alert(repeat_password.val());
			msg.html("<li><? echo lang('create_user_password_must_match'); ?></li>");
			bValid = false;
		}

		if(bValid)
		{
			$('#customer_form').ajaxSubmit({
				success:function(response)
				{
					if(!response.success)
					{
						$('#error_message_box').html("<li>" + response.message + "</li>");
					}
					else alert(response.message);
					if(response.success) $('#dialog_form').modal('hide');
				},
				error: function(response)
				{
					//$('#error_message_box').html("<li>" + response.message + "</li>");
					alert(response.message);
				},
				dataType:'json'
			});
		}
	});

	$("#signup_btn").click(function(){
		if(user_id == 0)
		{
			$('#fname').val(''); $('#lname').val(''); $('#email').val(''); $('#passwords').val(''); $('#repeat_password').val(''); $('#country').val('');
			$('#birthday').val(''); $('#occupation').val(''); $('#about_me').val(''); $('#hobbies').val(''); $('#musics').val(''); $('#movies').val(''); $('#books').val('');
			$('#error_message_box').html(''); $('#person_id').val('0');
			$('#files1').val(''); $('#files2').val(''); $('#files3').val(''); $('#files4').val(''); $('#files5').val('');
			$('#list1').html('<img class="thumb" src="'+ default_img_url +'">');
			$('#list2').html('<img class="thumb" src="'+ default_img_url +'">');
			$('#list3').html('<img class="thumb" src="'+ default_img_url +'">');
			$('#list4').html('<img class="thumb" src="'+ default_img_url +'">');
			$('#list5').html('<img class="thumb" src="'+ default_img_url +'">');
		}
		else
		{
		    $.ajax({
		        type : "POST"
		        , async : true
		        , url : signup_url
		        , dataType : "json"
		        , timeout : 30000
		        , cache : false
		        , data : "person_id=" + user_id
		        , error : function(request, status, error) {
			         alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
		        }
		        , success : function(response, status, request) {

		    		$('#fname').val(response[0]);
		    		$('#lname').val(response[1]);
		    		$('#email').val(response[2]);
		    		$('#label_password').attr('class' , 'wide');
		    		$('#label_repeat_password').attr('class' , 'wide');
		    		$('#repeat_password').val('');
		    		$('#passwords').val('');
		    		$('#country').val(response[3]);
		    		$('#birthday').val(response[4]);
		    		$('#occupation').val(response[5]);
		    		$('#about_me').val(response[6]);
		    		$('#hobbies').val(response[7]);
		    		$('#musics').val(response[8]);
		    		$('#movies').val(response[9]);
		    		$('#books').val(response[10]);
		    		$('#list1').html('<img class="thumb" src="'+ response[11] +'">');
		    		$('#list2').html('<img class="thumb" src="'+ response[12] +'">');
		    		$('#list3').html('<img class="thumb" src="'+ response[13] +'">');
		    		$('#list4').html('<img class="thumb" src="'+ response[14] +'">');
		    		$('#list5').html('<img class="thumb" src="'+ response[15] +'">');
		    		$('#error_message_box').html('');
		    		$('#person_id').val(user_id);
		        }
		    });
		}
		$('#dialog_form').modal({backdrop:false,keyboard:false});
	});

}

function check_empty_field(link , label)
{
	var msg = $('#error_message_box');
	if(link.val().length < 1)
	{
		msg.html("<li>The " + label + " is a required field.</li>");
		return false;
	}
	else return true;
}


function handleFileSelect1(evt)
{
	var files = evt.target.files;

	for(var i = 0 , f; f = files[i]; i ++)
	{
		if(!f.type.match('image/gif') &&
				!f.type.match('image/jpg') &&
				!f.type.match('image/png') &&
				!f.type.match('image/jpeg'))
			continue;

		if(i > 1) break;

		var reader = new FileReader();

		reader.onload = ( function(theFile) {
			return function(e) {
				var span = document.getElementById("list1");
				var inn = "<img class='thumb' src='" + e.target.result + "' />";
				span.innerHTML = inn;
			};
		})(f);

		reader.readAsDataURL(f);
	}
}

function handleFileSelect2(evt)
{
	var files = evt.target.files;

	for(var i = 0 , f; f = files[i]; i ++)
	{
		if(!f.type.match('image.*')) continue;
		if(i > 1) break;

		var reader = new FileReader();

		reader.onload = ( function(theFile) {
			return function(e) {
				var span = document.getElementById("list2");
				var inn = "<img class='thumb' src='" + e.target.result + "' />";
				span.innerHTML = inn;
			};
		})(f);

		reader.readAsDataURL(f);
	}
}

function handleFileSelect3(evt)
{
	var files = evt.target.files;

	for(var i = 0 , f; f = files[i]; i ++)
	{
		if(!f.type.match('image.*')) continue;
		if(i > 1) break;

		var reader = new FileReader();

		reader.onload = ( function(theFile) {
			return function(e) {
				var span = document.getElementById("list3");
				var inn = "<img class='thumb' src='" + e.target.result + "' />";
				span.innerHTML = inn;
			};
		})(f);
		reader.readAsDataURL(f);
	}
}

function handleFileSelect4(evt)
{
	var files = evt.target.files;

	for(var i = 0 , f; f = files[i]; i ++)
	{
		if(!f.type.match('image.*')) continue;
		if(i > 1) break;

		var reader = new FileReader();

		reader.onload = ( function(theFile) {
			return function(e) {
				var span = document.getElementById("list4");
				var inn = "<img class='thumb' src='" + e.target.result + "' />";
				span.innerHTML = inn;
			};
		})(f);
		reader.readAsDataURL(f);
	}
}

function handleFileSelect5(evt)
{
	var files = evt.target.files;

	for(var i = 0 , f; f = files[i]; i ++)
	{
		if(!f.type.match('image.*')) continue;
		if(i > 1) break;

		var reader = new FileReader();

		reader.onload = ( function(theFile) {
			return function(e) {
				var span = document.getElementById("list5");
				var inn = "<img class='thumb' src='" + e.target.result + "' />";
				span.innerHTML = inn;
			};
		})(f);
		reader.readAsDataURL(f);
	}
}