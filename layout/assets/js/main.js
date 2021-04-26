$(document).ready(function(){


	let left_sidebar_flag = true;
	let right_sidebar_flag = true;

	if(!$('.registration_form_username').val()) 
    	$('.registration_form_username').attr("placeholder", "Username");

    if(!$('.registration_form_email').val()) 
     	$('.registration_form_email').attr("placeholder", "E-mail");

    if(!$('.registration_form_plainPassword').val()) 
     	$('.registration_form_plainPassword').attr("placeholder", "Password");

    $('.form__submit__btn').on('click', function(e){
	    if($('#password_check').val().trim() === $('.registration_form_plainPassword').val().trim() ){
			alert('match done');
		} else{
			alert('match error');
		}
	});
// left sidebar dlide
	$('.sidebar__button').on('click', function(){
		if(left_sidebar_flag){
			$('.left__sidebar__container').css('transform', 'translateX(0)');
			$('.sidebar__arrow').css('transform', 'rotateY(180deg)');
		}
		else{
			$('.left__sidebar__container').css('transform', 'translateX(-300px)');
			$('.sidebar__arrow').css('transform', 'rotateY(0deg)');
		}
		left_sidebar_flag = !left_sidebar_flag;
	});

// right sidebar slide
	$('.history__button').on('click', function(){
		if(right_sidebar_flag){
			// $('.right__sidebar__container').css('transform', 'translateX(0px)');
			$('.right__sidebar__container').css('display', 'flex');
		}
		else{
			// $('.right__sidebar__container').css('transform', 'translateX(300px)');
			$('.right__sidebar__container').css('display', 'none');
		}
		right_sidebar_flag = !right_sidebar_flag;
	});

// close frame button
	$('.close__button').on('click', function(){
		$('.login__popap').css('display', 'none');
		$('.register__popap').css('display', 'none');
	});

	$('.item__act').on('click', function(e){
		$(".action__popap", e.delegateTarget).toggleClass("active");
	});
});
