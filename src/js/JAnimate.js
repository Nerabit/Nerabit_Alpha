$(document).on('mouseenter', '.submit', function(){
	$(this).stop().animate({"background-color": "rgb(211, 60, 44)"}, 400);
	$('p', this).stop().animate({color: "white"}, 400);
}).on('mouseleave', '.submit', function(){
	$(this).stop().animate({"background-color": "rgba(211, 60, 44, 0)"}, 200);
	$('p', this).stop().animate({color: "rgb(211, 60, 44)"}, 200);
});

$(document).on('mouseenter', 'input[type=submit]', function(){
	$(this).stop().animate({"background-color": "rgb(211, 60, 44)", color: "white"}, 400);
}).on('mouseleave', 'input[type=submit]', function(){
	$(this).stop().animate({"background-color": "rgba(211, 60, 44, 0)", color: "rgb(211, 60, 44)"}, 200);
});


$(document).on('mouseenter', '.ad', function(){
	$('.hover-img', this).stop().fadeIn(400);
}).on('mouseleave', '.ad', function(){
	$('.hover-img', this).stop().fadeOut(200);
});

$(document).on('mouseenter', 'header nav ul#right li', function(){
	$('h2', this).colorFade("rgb(211, 60, 44)", 300);
}).on('mouseleave', 'header nav ul#right li', function(){
	$('h2', this).colorFade("rgb(120, 120, 120)", 200);
});

$(document).on('click', 'header nav ul#right li #signIn', function(){
	$('#signInBox').stop().fadeIn(400);
	$('#signInBox #username').focus();
	backgroundBlur(true);
});

$(document).on('click', 'header nav ul#right li #signUp', function(){
	$('#signUpBox').stop().fadeIn(400);
	$('#signInBox #firstname').focus();
	backgroundBlur(true)
});

$(document).on('click', 'header nav ul#right li#submit input', function(){
	$('#postAdBox').stop().fadeIn(400);
	$('#signInBox #ad_title').focus();
	backgroundBlur(true);
});

$(document).on('click', '.cross', function(){
	backgroundBlur(false);
});

$(document).on('click', '#backgroundBlur', function(){
	backgroundBlur(false);
});

var scroll = 0;

getScroll();
animateHeader();

$(window).scroll(function (event) {
    getScroll();

    animateHeader();
});

function getScroll()
{
	scroll = $(window).scrollTop();
}

function animateHeader()
{
	if(scroll != 0) 
    {
    	$('header').stop().animate({"background-color": 'rgba(227, 227, 227, 0.8)'});
    	$('header #left .logo img').stop().animate({width: '150px'});
    	$('header li').stop().animate({height: '65px', "line-height": "65px"});
    }
    else
    {
    	$('header').stop().animate({"background-color": 'rgba(227, 227, 227, 0)'});
    	$('header #left .logo img').stop().animate({width: '214px'});
    	$('header li').stop().animate({height: '77px', "line-height": "77px"});
    }	
}

function backgroundBlur(arg)
{
	if(arg == true)
	{
		$('#backgroundBlur').stop().fadeIn(400);
	}
	else
	{
		$('.box').stop().fadeOut(400);
		$('#backgroundBlur').stop().fadeOut(400);
	}
}