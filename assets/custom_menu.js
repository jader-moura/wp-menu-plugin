

jQuery( document ).ready(function($) {

    var activeLI;

    $('.site-header ul.menu').addClass('loaded');

    $('.site-header').append(`
        <div class="subMenuWrapper">
  
        </div>`);


    $( ".site-header ul.menu > li" ).on( "mouseenter", function() {

        if(!$(this).find( "a" ).first().is("#bookDemo") ){

            activeLI = $(this);
            $(activeLI).addClass('active');
            $('.subMenuWrapper').addClass('active');
            
            let title = $(activeLI).find( "a" ).first().text();
            (title == undefined) ? title = '' : ''; 
            let introText = $(activeLI).find( "a" ).find('span').attr('intro-text');
            (introText == undefined) ? introText = '' : ''; 

            let width = $(window).width() - ($(activeLI).offset().left);
            $(activeLI).find('.sub-menu li').width(width);

            if($(activeLI).find('.sub-menu').height() < 200){
                $('.subMenuWrapper').css('min-height', '200px');
            }
            else{
                $('.subMenuWrapper').css('min-height',$(activeLI).find('.sub-menu').height() + 20 + "px");
            }
        }

    } );

    $( ".subMenuWrapper" ).on( "mouseenter", function() {
        $(activeLI).addClass('active');
        $('.subMenuWrapper').addClass('active');
    } );

    $( ".site-header ul.menu > li" ).on( "mouseleave", function() {
        activeLI = $(this);
        $(activeLI).removeClass('active');
        $('.subMenuWrapper').removeClass('active');
    } );

    $( ".subMenuWrapper" ).on( "mouseleave", function() {
        $(activeLI).removeClass('active');
        $('.subMenuWrapper').removeClass('active');
    } );

    /** FIX Mobile Menu double click/jumps with li sub-menu */

    $('.site-header ul.menu > li').click(function(e){
        if ($(window).width() < 993) {
            $('.site-header ul.menu .sub-menu').height('0px');
            $('.site-header ul.menu .sub-menu').removeClass('active');

            if(!$(this).find('.sub-menu').hasClass('active')){
                $(this).find('.sub-menu').addClass('active');
                $(this).find('.sub-menu').height($(this).find('.sub-menu > li').length * 49 + 'px');
            }
        }
    });


    $(document).mouseup(function(e) {
        if ($(window).width() < 993) {
            var container = $(".site-header #site-navigation");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                $('.site-header ul.menu .sub-menu').height('0px');
                $('.site-header ul.menu .sub-menu').removeClass('active');
            }
        }
    });
    /** End FIX **/

});
