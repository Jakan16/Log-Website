<?php
    function get_dashboard() 
    {
        $subscription_data = array("method" => "getsubscription", "token" => $_SESSION["LOGIN_TOKEN"]);                                                                    
        $subscription_result = call_authentication_service($subscription_data);

        $agent_data = array("method" => "agentlist", "token" => $_SESSION["LOGIN_TOKEN"]);                                                                    
        $agent_list = call_authentication_service($agent_data);

        $content_agent_list = "<table class='table table-striped'>
    <thead>
      <tr>
        <th>id</th>
        <th>name</th>
        <th>License key</th>
      </tr>
    </thead>
    <tbody>";
        foreach($agent_list["listofagents"] as $row) {
            $content_agent_list .= "<tr><td>" . $row['ID'] . "</td><td>" . $row['name'] . "</td><td>" . $row['LicenseKey'] . "</td></tr>";  
        }


        return "<div class='container-fluid'>
                <div class='row'>
                    <div class='col-md-6'>
                        <div class='well'><a href='/control/index?select=alarm'> <div class='alert alert-danger'>
                                <h3>Alarms</h3>
                              </div></a>
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
                            </div>
                    </div>
                    <div class='col-md-6'> 
    <div class='well'><a href='/control/index?select=subscription'>
                      <div class='alert alert-success'>
    <h3>Subscription (Agent list):</h3>   
      </div></a>
$content_agent_list
    </tbody>
  </table>
  </div>
    
                </div></div>
                <div class='row'>
                    <div class='col-md-6'>
                    <div class='well'><a href='/control/index?select=code'>
            <div class='alert alert-success'>
    <h3>Code management:</h3>   
      </div></a>
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
                    </div>
                    <div class='col-md-6'>
                    <div class='well'><a href='/control/index?select=subscription'>
                            <div class='alert alert-success'>
                            <h3>Current subscribed compute power</h3>
                            </div></a>
                              <form class='form' action='/control/content/index/dashboards/functions/update_subscription' method='post'>
                                <div class='form-group'>
                                  <label for='cpu_usage_input'>Max CPU (in percent)</label>
                                  <input class='form-control' id='cpu_usage_input'name='cpu_usage_input' min='0' max='100' value='".$subscription_result["cpu"]."' type='number'>
                                </div>
                                <div class='form-group'>
                                  <label for='ram_usage_input'>Max ram (in MB)</label>
                                  <input class='form-control' id='ram_usage_input' name='ram_usage_input' min='0' max='2000' value='".$subscription_result["ram"]."' type='number'>
                                </div>
                                <div class='form-group'>
                                  <input type='submit' class='btn btn-success' value='Save settings'>
                                </div>
                              </form>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-6'>
                                        <div class='well'>
                      <div class='alert alert-info'>
    <h3>Your company key:</h3>
    ".LOGIN_COMPANY_KEY."
  </div>
                        </div>
                    </div>
                    <div class='col-md-6'>
                    <div class='well'>
                      <div class='alert alert-info'>
    <h3>Customer support:</h3>
    Placeholer contact information.<br>
    <br>
    7-19 telephone <br>
    24/7 mail system <br> 
  </div>
                        </div>
                    </div>
                </div>
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