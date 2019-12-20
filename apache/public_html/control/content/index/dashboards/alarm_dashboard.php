<?php
  require_once $_SERVER['DOCUMENT_ROOT']. "control/content/index/dashboards/alarm_dashboard_script.php";
	
  function get_dashboard() 
	{
		return "<div class='well'>
					  <div class='alert alert-danger'>
    <h3>Triggered alarms:</h3>   
      </div>
            <table class='table table-striped'>
    <thead>
      <tr>
        <th>alarm id</th>
        <th>time</th>
        <th>name</th>
        <th>Severity</th>
        <th>Investigate</th>
      </tr>
    </thead>
    <tbody id='alarm_dashboard_alarms'>
      <tr>
        <td>Loading</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>
  </div>";
	}
?>