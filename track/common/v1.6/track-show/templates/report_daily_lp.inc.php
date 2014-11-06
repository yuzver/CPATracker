<style>
.sortdata {
	display: none;
}
tr.sub td.name:before {
	content: '├';
}
tr.sub.last td.name:before {
	content: '└';
}
</style>
<?php
if (!$include_flag){exit();}
// Таблица отчёта

global $group_types;
global $table_n;
global $row_total_data;

if(!isset($table_n)) {
	$table_n = 0;
} else {
	$table_n++;
}

//dmp($var['arr_report_data']);


echo "<div class='row'>";
echo "<div class='col-md-12'>";
echo "<table class='table table-condensed table-striped table-bordered dataTableT dataTableT".$table_n."' style='margin-bottom:15px !important;'>";
	
	// Заголовок 
	
	
	
	echo "<thead>";
		echo "<tr>";
		
		if($var['report_params']['mode'] == 'popular') {
			echo "<th>Популярные</th><th>Значение</th>";
		} else {
			echo "<th>" . _e(col_name($var)) . "</th>";
		}
		
		foreach ($var['arr_dates'] as $cur_date) {
			$d = $var['timestep'] == 'monthly' ? $cur_date : date('d.m', strtotime($cur_date));
			echo "<th>"._e($d)."</th>";
		}
		echo "<th>Итого</th>";
		echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	
	$table_total_data  = array(); // суммирование 
	$column_total_data = array(); // суммирование колонок
	$arr_sparkline     = array();
	$i = 0;
	
	//dmp($var['arr_report_data']);
	
	foreach ($var['arr_report_data'] as $source_name => $r) {
		
		$row_total_data = array(); // суммирование по строкам
		$i++;
		
		$var['r'] = $r;
		$var['sub'] = 0;
		$var['parent'] = '';
		$var['class'] = '';
		
		echo tpx('report_daily_lp_row', $var);
		
		if(!empty($r['sub'])) {
			
			$row_total_data = array(); // суммирование по строкам
			
			$i = 1;
			$cnt = count($r['sub']);
			
			foreach($r['sub'] as $r0) {
				$var['r'] = $r0;
				$var['sub'] = 1;
				$var['class'] = 'sub';
				$var['parent'] = $r;
				
				if($cnt == $i) {
					$var['class'] .= ' last';
				}
				
				echo tpx('report_daily_lp_row', $var);
				$i++;
				
			}
		}
		
		/*
		//dmp($data);

		*/
	}
	echo "</tbody>";
	
	// Итоговая строка
	
	echo "<tfoot><tr><th ".($var['report_params']['mode'] == 'popular' ? ' colspan="2"' : '') ."><strong><i style='display:none;'>&#148257;</i>Итого</strong></th>";
	foreach ($var['arr_dates'] as $cur_date) {
			echo '<th>' . get_clicks_report_element($column_total_data[$cur_date]['click'], $column_total_data[$cur_date]['lead'], $column_total_data[$cur_date]['sale'], $column_total_data[$cur_date]['sale_lead']) . '</th>';
	}	
	echo '<th>' . get_clicks_report_element($table_total_data['click'], $table_total_data['lead'], $table_total_data['sale'], $table_total_data['sale_lead']) . '</th>';
	echo "</tr></tfoot>";
	echo "</table></div></div>";
	
	// Скрипты, отвечающие за сортировку и sparklines
?>
<script>
	/*
$(document).ready(function() {

    $('.dataTableT<?php echo $table_n; ?>').dataTable
    ({    	
    	"fnDrawCallback":function(){
	    if ( $('#writerHistory_paginate span span.paginate_button').size()) {
	      	if ($('#writerHistory_paginate')[0]) {
	      		$('#writerHistory_paginate')[0].style.display = "block";
		    } else {
		    	$('#writerHistory_paginate')[0].style.display = "none";
		   	}
	    }

		},
    	"aoColumns": [
            null,
            <?php if($var['report_params']['mode'] == 'popular') { ?>null,<?php } ?>
            <?php echo str_repeat('{ "asSorting": [ "desc", "asc"], "sType": "click-data" },', count($var['arr_dates']))?>
			{ "asSorting": [ "desc", "asc" ], "sType": "click-data" },            
        ],
		"bPaginate": <?php echo (count($arr_report_data) > 10) ? 'true' : 'false'; ?>,
	    "bLengthChange": false,
	    "bFilter": false,
	    "bSort": true,
	    "bInfo": false,
    "bAutoWidth": false
	})
} );*/
</script>
<script>
	$(document).ready(function() 
	{
		<?php
			foreach ($arr_sparkline as $i=>$val) {
		?>
		$("#sparkline_<?php echo $i?>").sparkline(
			[<?php echo implode (',', $arr_sparkline[$i]);?>], 
			{
		    	type: 'bar',
			    zeroAxis: false, 
			    barColor:'#AAA', 
			    disableTooltips:true, 
			    width:'40px'
			}
		);
		<?php
			}
		?>		
	});
</script>