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

function tileView(){
    if ($("#tile-view").is(":visible")){
        return;
    }

    $("#list-view").fadeOut(200);
    $("#tile-view").delay(200).fadeIn();

    var m = 1+Math.random()*20;
    for (i=1; i < m; i++){
      $("#tile-view").delay(200).append('<button class="btn btn-lg" style="width: 200px; margin-bottom: 20px;">Item '+i+'</button>');
    }

    $("#list-view tbody > tr").remove();
}

function listView(){
    if ($("#list-view").is(":visible")){
        return;
    }

    $("#tile-view").fadeOut(200);
    $("#list-view").delay(200).fadeIn();

    var m = 1+Math.random()*20;
    for (i=1; i < m; i++){
      $("#list-view").delay(200).append('<tr><td>Item '+i+'</td></tr>');
    }

    $("#tile-view").empty();
}
