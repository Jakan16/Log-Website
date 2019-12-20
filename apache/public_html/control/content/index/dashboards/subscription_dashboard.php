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
                        <div class='well'>
                            <div class='alert alert-success'>
                            <h3>Set compute power</h3>
                            </div>
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
                    <div class='col-md-6'>
                        <div class='well'>
                            <div class='alert alert-success'>
                            <h3>Subscriptions Agents</h3>
                        </div>
                            <h4>Add new agent:</h4>
                                <form class='form-inline' name='createCompanyForm' action='/control/content/index/dashboards/functions/create_agent' onsubmit='return validateForm()' method='post'>
                                <div class='form-group'>
                                <label for='agent_name'>Agent name:</label>
                                <input type='text' class='form-control' name='agent_name' id='agent_name'>
                                <span id='errUser'></span>
                                </div>
                                <button type='submit' class='btn btn-success'>Create Agent</button>
                                </form>
                            <h4>Agent list:</h4>
                            " . $content_agent_list . "</tbody>
  </table>
                        </div>
                    </div>
                </div>
                </div>";
    }
?>