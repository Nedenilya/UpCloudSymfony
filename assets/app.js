/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

$(document).ready(function(){


    let left_sidebar_flag = false;
    let right_sidebar_flag = true;


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


// popap login frame
    $('#signin').on('click', function(){
        $('.login__popap').css('display', 'block');
    });


// popap register frame
    $('#signup').on('click', function(){
        $('.register__popap').css('display', 'block');
    });


// close frame button
    $('.close__button').on('click', function(){
        $('.login__popap').css('display', 'none');
        $('.register__popap').css('display', 'none');
    });

    $('.item__act').on('click', function(e){
        $(".action__popap", e.delegateTarget).toggleClass("active");
        e.preventDefault();
    });

});

