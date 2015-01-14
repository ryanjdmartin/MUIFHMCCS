/* Custom JS/JQuery goes here. If you've got something bigger, make a new file. */

$(document).ready(function() {
    //Makes navbar items roll open on mouseover instead of click
    $('ul.nav li.dropdown').hover(function() {
      $(this).find('.dropdown-menu').css('z-index', '+=1');
      $(this).find('.dropdown-menu').stop(true, true).slideDown(300);
      $(this).addClass('open')
    }, function() {
      $(this).find('.dropdown-menu').css('z-index', '-=1');
      $(this).find('.dropdown-menu').stop(true, true).slideDown(300);
      $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(300);
      $(this).removeClass('open');

    //Enable popovers and tooltips
    $("[rel='tooltip']").tooltip();
    $("[rel='popover']").popover({trigger:'hover', html:true});
    });
});
