var selected;
var prevSelected;
$(initMain)

function initMain(){
    $('.accordion').accordion({
        fillSpace:true
    });
    $('.report_param').button();
    $('.report_param').click(function(){
        if(selected!=undefined){
            selected.removeAttr('disabled');
            selected.removeClass("active");
            selected.mouseout();
        }
        selected = $(this);
        selected.attr('disabled', true);
        //selected.addClass("active");
            
    });
	$('#btn_Execute').button({
	   height:10
	});
	$('#btn_Execute').click(function(){
		$(".jqplot-target").empty();
		$.post('php/services/Reporting/Reporting.php', {query : selected.attr("param"), sDate : $("#param_sDate").val(), eDate: $("#param_eDate").val(), interval: $("#param_interval").val()}, function(data){				
			  $('.report_chart').html("");
			  console.log(data);
			  try{
				var obj = JSON.parse(data);
			  }
			  catch(err){
				alert(data);
			  }
			  
              initTable(obj);
            });
	});
    $('#param_sDate').datepicker({
                showAnim:'fold',
                dateFormat: 'yy-mm-dd'
    });
    $('#param_eDate').datepicker({
                showAnim:'fold',
                dateFormat: 'yy-mm-dd'
    });
}
function initTable(data){
	var tick = new Array();
	for (var i=0;i<data[0].keyValues.length;i++){
		tick.push(data[0].keyValues[i].key);
	}
	
	var series = new Array(data.length);
	for (var i=0;i<data.length;i++){
		series[i] = new Array();
		for (var j=0;j<data[i].keyValues.length;j++){
			series[i].push(data[i].keyValues[j].value);
		}
	}
	var labels = new Array(data.length);
	for (var i=0;i<data.length;i++){
		labels[i] = {label: data[i].id};
	}
	
    $.jqplot('report_chart', series, {
        title: "Report",
    seriesDefaults: {
            renderer:$.jqplot.BarRenderer,
            pointLabels:{show:true}
            // Show point labels to the right ('e'ast) of each bar.
            // edgeTolerance of -15 allows labels flow outside the grid
            // up to 15 pixels.  If they flow out more than that, they 
            // will be hidden.
        },
    series:labels,
        legend: {
          show: true,
          location: 'e',
          placement: 'outside'
        },   
        axes: {
            // Use a category axis on the x axis and use our custom ticks.
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: tick
            },
            // Pad the y axis just a little so bars can get close to, but
            // not touch, the grid boundaries.  1.2 is the default padding.
            yaxis: {
                pad: 1.2,
            }
        }
    });
}