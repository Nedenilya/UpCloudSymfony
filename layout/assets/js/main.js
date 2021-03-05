$(document).ready(function(){

	let left_sidebar_flag = true;
	let right_sidebar_flag = true;

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

	$('.history__button').on('click', function(){
		if(right_sidebar_flag){
			$('.right__sidebar__container').css('transform', 'translateX(0px)');
		}
		else{
			$('.right__sidebar__container').css('transform', 'translateX(300px)');
		}
		right_sidebar_flag = !right_sidebar_flag;
	});

});
