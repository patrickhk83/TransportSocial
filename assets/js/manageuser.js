
/**
 * Enable dialog of create&edit user
 * @param signup_url
 */

function enable_user_dialog(signup_url)
{
	$('#birthday').datepicker({setStartDate: '-100y' , orientation: "bottom left" , autoclose: 'true' , format:'d-m-yyyy'});

	$("#signup_btn").click(function(){
		$('#fname').val(''); $('#lname').val(''); $('#email').val(''); $('#passwords').val(''); $('#repeat_password').val(''); $('#country').val('');
		$('#birthday').val(''); $('#occupation').val(''); $('#about_me').val(''); $('#hobbies').val(''); $('#musics').val(''); $('#movies').val(''); $('#books').val('');
		$('#dialog_form').dialog('open');
	});

	$("#dialog_form").dialog(
	{
		autoOpen:false ,
		height: 510 ,
		width: 640 ,
		modal: true ,
		buttons:
		{
			"Submit": function()
			{
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
				    $.ajax({
				        type : "POST"
				        , async : true
				        , url : signup_url	/*"<?php echo site_url("$controller_name/signup_user");?>"*/
				        , dataType : "json"
				        , timeout : 30000
				        , cache : false
				        , data : "person_id=" + user_id.val() +
				        			"&fname=" + fname.val() +
				        			"&lname=" + lname.val() +
				        			"&email=" + email.val() +
				        			"&passwords=" + passwords.val() +
				        			"&country=" + country.val() +
				        			"&birthday=" + birthday.val() +
				        			"&occupation=" + occupation.val() +
				        			"&about_me=" + about_me.val() +
				        			"&hobbies=" + hobbies.val() +
				        			"&musics=" + musics.val() +
				        			"&movies=" + movies.val() +
				        			"&books=" + books.val()
				        , error : function(request, status, error) {

					    }
				        , success : function(response, status, request) {
					        alert(response);
				        }
				    });
					$(this).dialog('close');
				}


			},
			"Cancel": function()
			{
				$(this).dialog('close');
			}
		}
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
