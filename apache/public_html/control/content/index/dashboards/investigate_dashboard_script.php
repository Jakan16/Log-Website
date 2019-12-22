<script>
function set_log_modal_info(id) 
{
    var string_builder = '{"method": "get", "request": {"path": "/'+id+'"}}';
    $.ajax({
        type: "POST",
        url: <?php echo '"'.SERIVCE_LOGSTORE_URL.'/gateway"'; ?>,
        // The key needs to match your method's input parameter (case-sensitive).
        // “path”: “?customer_id=id”
        data: string_builder,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data){
            $("#log_modal_info").text(data.content);

        },
        failure: function(errMsg) 
        {
            alert(errMsg);
        }
    });

    
}


function get_alarm_information(alarm_id)
{
    var content = "";
    $.ajax({
        type: "GET",
        url: <?php echo '"'.SERIVCE_ALARMSERVICE_URL.'/alarms/"'; ?> + alarm_id,
        // The key needs to match your method's input parameter (case-sensitive).
        // “path”: “?customer_id=id”
        data: '',
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data){
            content = "<b>Name:</b> " + data.name + "<br><b>timestamp:</b> " +data.timestamp;
            

            for (var j = 0; data.log_ids[j] != undefined; j++) 
            {
                get_log_information(data.log_ids[j]);
            }
            
            $("#alarm_information_div").html(content);
        },
        failure: function(errMsg) 
        {
            alert(errMsg);
        }
    });
}

function get_log_information(id)
{
    var content = "";
    var string_builder = '{"method": "get", "request": {"path": "/'+id+'"}}';
    $.ajax({
        type: "POST",
        url: <?php echo '"'.SERIVCE_LOGSTORE_URL.'/gateway"'; ?>,
        // The key needs to match your method's input parameter (case-sensitive).
        // “path”: “?customer_id=id”
        data: string_builder,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data){
            content += "<tr>  \
            <td>"+ data.log_id+ "</td> \
            <td>"+data.timestamp+"</td> \
            <td>"+data.log_type+"</td><td>";

            for (var j = 0; data.tags[j] != undefined; j++) 
            {
                content += data.tags[j] + ", ";
            }

            content += "</td><td>"+data.agent_id+"</td> \
            <td><button onclick='set_log_modal_info(\""+ data.log_id+"\")' type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='#log_info_modal'>Open Log</button></td> \
            </tr>";
            $("#log_dashboard_logs").append(content);
        },
        failure: function(errMsg) 
        {
            alert(errMsg);
        }
    });
}

</script>
<!-- Modal -->
<div id='log_info_modal' class='modal fade' role='dialog' style='margin-top:50px;'>
  <div class='modal-dialog'>

    <!-- Modal content-->
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'>&times;</button>
        <h4 class='modal-title'>Log information</h4>
      </div>
      <div class='modal-body' id='log_modal_info'>
        <p>Get and display the information about the log</p>
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
      </div>
    </div>

  </div>
</div>