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
    $("[data-toggle='tooltip']").tooltip();
    $("[data-toggle='popover']").popover({trigger:'hover', html:true});
    });

});

//Loads and builds a chart.js line graph in the given canvas id
function loadChart(id, url, callback, size){
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

        var c = 0;
        for (t in ret){
            if (size || c % 4 == 0)
                data.labels.push(t);
            else
                data.labels.push("");
            data.datasets[0].data.push(ret[t]);
            c++;
        }

        if (size){
            ctx.canvas.width = data.labels.length*25;
            new Chart(ctx).Line(data, {pointHitDetectionRadius: 5,
                    tooltipTemplate: "<%= value %> at <%= label %>"});
        }else{
            new Chart(ctx).Line(data, {showTooltips: false, pointDot: false,
                    tooltipTemplate: "<%= value %> at <%= label %>"});
        }

        if (callback){
            callback(data.labels.length);
        }
    });
}

//Global check for stream. Set globally every time this function is called
var gTimestamp = $.now();

//Public function
function streamData(spinner, url, id){
    gTimestamp = $.now();
    doStreamData(spinner, url, id, 0, gTimestamp);
}

//Private recursive function
function doStreamData(spinner, url, id, last_id, timestamp){
  if (timestamp != gTimestamp){
    $('#'+spinner).spin(false).hide();
    $('#insert').hide();
    return;
  }

  $.get(url+(id == 0 ? '' : '/'+id)+'/'+last_id, '', function(data){
    if (timestamp == gTimestamp && data.status){
        if(data.isTileView){
          $('#'+spinner).before(data.content);
          $('#tile'+data.id).fadeIn(700);
        }
        else{
          $('#insert').before(data.content);
          $('#list'+data.id).fadeIn(700);
        }
        doStreamData(spinner, url, id, data.id, timestamp);
    } else {
        $('#'+spinner).spin(false).hide();
        $('#insert').hide();
    }
  });
}
