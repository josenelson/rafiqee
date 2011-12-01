<?php
	$start = new DateTime('30-07-2011 13:04');
	$end = new DateTime('12-09-2011 18:06');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
	</head>
	<body>
		<?php 
			echo $start->format("Y-m-d H:i:s");
			echo '<br/>';
			echo $end->format("Y-m-d H:i:s");
			echo '<br/>';
			$span = $end->diff($start);
			
			$total_hours = $span->h + $span->d * 24 + $span->m * 730;

			$interval = new DateInterval('PT1H');
			
			if($start > $end) die("Invalid dates");
			if($end->diff($start)->y > 0) die("Date range to long");
			if($end->diff($start)->m > 2) die("Date range to long");
			
			$values = array();
			
			while($start <= $end) {
				$start = date_add($start, date_interval_create_from_date_string('1 hour'));
				//$start = $start->add($interval);
				//$values[$start->format("Y-m-d H")] = $start->format("Y-m-d H");
				echo $start->format("Y-m-d H");
				echo '<br/>';
			}
			
			foreach($values as $value_id => $value) {
				echo $value;
				echo '<br/>';
			}
			
		?>
	</body>
</html>
