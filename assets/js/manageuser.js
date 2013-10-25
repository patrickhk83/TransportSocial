/**
 * Enable dialog of create&edit user
 * @param signup_url
 */

function enable_user_dialog(signup_url , default_img_url , user_id)
{

	var date = new Date();
  $('.date').datepicker({
    startDate: date.toString('d-m-yyyy'),
    orientation: "bottom",
    autoclose: 'true'
  });

	$('#dialog_form').on("scroll", function(){
    $('.date').datepicker('hide');
	});

	$("#submit_btn").click(function() {
		{
			$('#customer_form').ajaxSubmit({
				success:function(response)
				{
					if(!response.success)
					{
						$('#error_message_box').html(response.message);
					}
					else alert(response.message);
					if(response.success) {
						$('#dialog_form').modal('hide');
						location.reload();
					}
				},
				error: function(response)
				{
					alert(response.message);
					console.log(response);
				},
				dataType:'json'
			});
		}
	});
}


$("document").ready(function(){
  $('.profile-pic').change(function(evt) {
		var files = evt.target.files;
		var id = evt.target.id;
		var file = this;
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
					var thumb = $(file).closest('.file-wrapper').next('.thumb').attr('src', e.target.result);
				};
			})(f);

			reader.readAsDataURL(f);
		}
	});
});