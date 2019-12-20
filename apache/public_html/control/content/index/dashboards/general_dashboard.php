<?php
    function get_dashboard() 
    {
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
                                    <th>agent id</th>
                                    <th></th>
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
                    <div class='well'>
                    <div class='alert alert-warning'>
    <h3>Agent status:</h3>
  </div>
      <table class='table table-striped'>
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td>
      </tr>
      <tr>
        <td>Mary</td>
        <td>Moe</td>
        <td>mary@example.com</td>
      </tr>
      <tr>
        <td>July</td>
        <td>Dooley</td>
        <td>july@example.com</td>
      </tr>
    </tbody>
  </table>
                    </div>
                </div></div>
                <div class='row'>
                    <div class='col-md-6'><div class='well'>
                      <div class='alert alert-success'>
    <h3>Subscription:</h3>   
      </div>
          <table class='table table-striped'>
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td>
      </tr>
      <tr>
        <td>Mary</td>
        <td>Moe</td>
        <td>mary@example.com</td>
      </tr>
      <tr>
        <td>July</td>
        <td>Dooley</td>
        <td>july@example.com</td>
      </tr>
    </tbody>
  </table>
  </div>
                    </div>
                    <div class='col-md-6'>
                    <div class='well'>
            <div class='alert alert-success'>
    <h3>Code managentment:</h3>   
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
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-6'><div class='well'>
                      <div class='alert alert-info'>
    <h3>Storage status:</h3>   
      </div>
      <h3>3% of 100%</h3>
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
                </div>";
    }
?>