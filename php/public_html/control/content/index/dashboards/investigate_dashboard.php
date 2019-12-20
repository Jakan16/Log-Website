<?php
	function get_dashboard() 
	{
		return "<div class='well'>
            <h2>Alarm information:</h2>
            <div id='alarm_information_div'>
            </div>
            </div>

    <div class='well'>
					  <div class='alert alert-warning'>
    <h3>Relevant logs:</h3>   
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
    </tbody>
  </table>
<Hr \>
  <div class='alert alert-info'>
  <h2>Conclusion</h2>
  </div>
    <form>
    <div class='form-group'>
      <label for='comment'>Comment:</label>
      <textarea class='form-control' rows='5' id='comment'></textarea>
    </div>
    <div class='btn-group'>
      <button type='submit' class='btn btn-danger'>Escalate</button>
      <button type='submit' class='btn btn-success'>Resolved</button>
    </div>
  </form>

  </div>";
	}
?>