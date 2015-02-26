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

//Loads and builds a chart.js line graph in the given canvas id
function loadChart(id, url, callback){
    $.post(url, '', function(ret){
        var ctx = $("#"+id).get(0).getContext("2d");
        var data = { labels: [], 
                 datasets: [{
                    label: "Velocity",
                    fillColor: "rgba(0,0,0,0.2)",
                    strokeColor: "rgba(0,0,0,1)",
                    pointColor: "rgba(0,0,0,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(0,0,0,1)",
                    data: []
                }]};

        for (t in ret){
            data.labels.push(t);
            data.datasets[0].data.push(ret[t]);
        }

        new Chart(ctx).Line(data);

        if (callback){
            callback();
        }
    });
}

function streamData(spinner, url, id, last_id){
  $.get(url+(id == 0 ? '' : '/'+id)+'/'+last_id, '', function(data){
    if (data.status){
        $('#'+spinner).before(data.content);
        $('#tile'+data.id).fadeIn(700);
        streamData(spinner, url, id, data.id);
    } else {
        setTimeout(function(){
            $('#'+spinner).spin(false).hide();
        }, 200);
    }
  });
}

