let sidebar_flag = true;

$('.sidebar__button').on('click', function(){
	if(sidebar_flag)
	{
		$('.sidebar__container').css('transform', 'translateX(0)');
		$('.sidebar__arrow').css('transform', 'rotateY(180deg)');
	}
	else
	{
		$('.sidebar__container').css('transform', 'translateX(-300px)');
		$('.sidebar__arrow').css('transform', 'rotateY(0deg)');
	}
	sidebar_flag = !sidebar_flag;
});