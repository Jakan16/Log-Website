<?php
	function get_dashboard() 
	{
		return "<div class='well'>
					  <div class='alert alert-success'>
    <h3>Code management:</h3>   
      </div>
            <table class='table table-striped'>
    <thead>
      <tr>
        <th>Name</th>
        <th>Type</th>
        <th>View/edit code</th>
        <th>delete</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody id='code_dashboard_logs'>
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
  </div>

<!-- Modal -->
<div id='code_edit_modal' class='modal fade' role='dialog' style='margin-top:50px;'>
  <div class='modal-dialog modal-lg'>

    <!-- Modal content-->
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'>&times;</button>
        <h4 class='modal-title'>Code edit</h4>
              <div class='form-group'>
		  <label for='code_name_input'>Name:</label>
		  <input type='text' class='form-control' id='code_name_input'>
		</div>
      </div>
      <div style='height: 500px;' class='modal-body' id='code_edit_body'>
  <div id='editor'>
  </div>
    
<script src='/plugins/ace/src-noconflict/ace.js' type='text/javascript' charset='utf-8'></script>
<script>
    var editor = ace.edit('editor', {showPrintMargin: false,});
    editor.setTheme('ace/theme/monokai');
    editor.session.setMode('ace/mode/javascript');
</script>
      </div>
      <div class='modal-footer'>
        <button id='save_code_btn' onclick='save_code()' type='button' class='btn btn-success' data-dismiss='modal'>Save</button>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
      </div>
    </div>

  </div>
</div>
";
	}
?>