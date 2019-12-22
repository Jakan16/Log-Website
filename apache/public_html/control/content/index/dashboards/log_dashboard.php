<?php
	function get_dashboard() 
	{
		return "<div class='well'>
					  <div class='alert alert-info'>
    <h3>View logs:</h3>   
      </div>
            <table class='table table-striped'>
    <thead>
      <tr>
        <th>id</th>
        <th>Time</th>
        <th>Log type</th>
        <th>Tags</th>
        <th>Agent</th>
        <th></th>
      </tr>
    </thead>
    <tbody id='log_dashboard_logs'>
      <tr>
        <td>Loading</td>
        <td></td>
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