$("#signInBox input").on('keyup', function(){
	checkSignInForm()
});

function checkSignInForm()
{
	var username = $("#signInBox #username").val();
	var password = $("#signInBox #password").val();

	if((username.length != 0) && (password.length != 0))
	{
		$("#signInBox #submit input").attr("disabled", false);
	}
	else
	{
		$("#signInBox #submit input").attr("disabled", true);
	}
}

$("#signUpBox input").on('keyup', function(){
	checkSignUpForm()
});

function checkSignUpForm()
{
	var firstname = $("#signUpBox #firstname").val();
	var lastname = $("#signUpBox #lastname").val();
	var zipcode = $("#signUpBox #zipcode").val();
	var city = $("#signUpBox #city").val();
	var username = $("#signUpBox #username").val();
	var password = $("#signUpBox #password").val();
	var password_check = $("#signUpBox #password_check").val();
	var email = $("#signUpBox #email").val();

	if((firstname.length != 0) && (lastname.length != 0) && (zipcode.length != 0) && (city.length != 0) && (username.length != 0) && (password.length != 0) && (password_check.length != 0) && (email.length != 0))
	{
		$("#signUpBox #submit input").attr("disabled", false);
	}
	else
	{
		$("#signUpBox #submit input").attr("disabled", true);
	}
}

$("#postAdBox input").on('keyup', function(){
	checkPostAdForm()
});

$("#postAdBox .upload-input").next().on('change', function(){
	checkPostAdForm()
});

$("#postAdBox .textarea").on('change', function(){
	checkPostAdForm()
});

function checkPostAdForm()
{
	var title = $("#postAdBox #ad_title").val();
	var description = $("#postAdBox #description").val();
	var categorie = $("#postAdBox #categorie").val();
	var price = $("#postAdBox #price").val();
	var coverUpload = $("#postAdBox #cover-upload").val();
	var pic1Upload = $("#postAdBox #pic1-upload").val();
	var pic2Upload = $("#postAdBox #pic2-upload").val();

	if((title.length != 0) && (description.length != 0) && (categorie.length != 0) && (price.length != 0) && (coverUpload.length != 0))
	{
		$("#postAdBox #submit input").attr("disabled", false);
	}
	else
	{
		$("#postAdBox #submit input").attr("disabled", true);
	}
}

$('.upload-input').next().change(function() {
    var filename = $(this).val();

	$(this).prev(".upload-input").children().html(filename + " ✔");
});

$(".select").on('click', function(){
	if($('.ul', this).css('display') == 'none')
	{
		$('.select .ul').stop().slideUp();
		$('.ul', this).stop().slideDown();
		$('.icon', this).stop().animate({borderSpacing: + 180}, {
            duration: 300,
            step: function(now) {
              $(this).css('-webkit-transform','rotate('+now+'deg)'); 
              $(this).css('-moz-transform','rotate('+now+'deg)');
              $(this).css('transform','rotate('+now+'deg)');
            }
        }, 0)

		$(this).css({"border-radius": "3px 3px 0px 0px"});
		$(this).animate({"background-color": "rgba(220, 220, 220)"});
	}
	else
	{
		$('.ul', this).stop().slideUp();
		$('.icon', this).stop().animate({borderSpacing: + 0}, {
            duration: 300,
            step: function(now) {
              $(this).css('-webkit-transform', 'rotate('+now+'deg)'); 
              $(this).css('-moz-transform', 'rotate('+now+'deg)');
              $(this).css('transform', 'rotate('+now+'deg)');
            }
        }, 0)

       	$(this).animate({"background-color": "rgba(230, 230, 230)"});
		$(this).css({"border-radius": "3px"});
	}
});

$(".select .ul .li").on('click', function(){
	var value = $(this).attr("value");

	var select = $(this).parent().parent().children("input");
	$(select).attr("value", value);

	var valueHtml = $(this).html();

	var selectHtml = $(this).parent().parent().children(".value");
	$('p', selectHtml).html(valueHtml);
});

$(".upload-input").on('click', function(){
	$(this).next().trigger("click");
});

$("#option-bar #searchoption-container .select .ul .li").on('click', function(){
	var value = $(this).attr("value");

	window.location.href = '/index.php?sort=' + value;
});