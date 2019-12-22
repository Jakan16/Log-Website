<script>
function view_code(code_id) 
{
    $.ajax({
        type: "POST",
        url: <?php echo '"'.SERIVCE_JOLIECLOUD_URL. '/retrieveCode"'; ?>,
        // The key needs to match your method's input parameter (case-sensitive).
        data: '{"offset": 0, "limit": 20, "authorization": "<?php echo $_SESSION["LOGIN_TOKEN"]; ?>" }',
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data){
            for (var i = data.count - 1; i >= 0; i--) {
                if (data.parsers[i]._id.$oid == code_id) 
                {
                    $("#code_name_input").val(data.parsers[i].name);
                    editor.setValue(atob(data.parsers[i].code));
                }
            }
        },
        failure: function(errMsg) 
        {
            alert(errMsg);
        }
    });
}


function delete_code(code_name) 
{

    var string_buliding = '{ \
            "authorization":"<?php echo $_SESSION["LOGIN_TOKEN"]; ?>", \
            "name":"'+code_name+'" \
        }';

    $.ajax({
        type: "POST",
        url: <?php echo '"'.SERIVCE_JOLIECLOUD_URL. '/deleteCode"'; ?>,
        // The key needs to match your method's input parameter (case-sensitive).
        data: string_buliding,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data){
            alert("Code has been deleted on the server");
            location.reload();
        },
        failure: function(errMsg) 
        {
            alert(errMsg);
        }
    });
}


function save_code() 
{
    var code_to_save =  btoa(editor.getValue());
    var code_name = $("#code_name_input").val();

    var string_buliding = '{ "parser":{ "name": "'+ code_name+'", "code": "' + code_to_save + '", "type": "jolie" }, "authorization":"<?php echo $_SESSION["LOGIN_TOKEN"]; ?>" }';

    $.ajax({
        type: "POST",
        url: <?php echo '"'.SERIVCE_JOLIECLOUD_URL. '/submitCode"'; ?>,
        // The key needs to match your method's input parameter (case-sensitive).
        data: string_buliding,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data){
            alert("Code has been submitted and saved");
            location.reload(); 
        },
        failure: function(errMsg) 
        {
            alert(errMsg);
        }
    });
}


function get_content_code_dashboard()
{
    var content = "";
    $.ajax({
        type: "POST",
        url: <?php echo '"'.SERIVCE_JOLIECLOUD_URL. '/retrieveCode"'; ?>,
        // The key needs to match your method's input parameter (case-sensitive).
        data: '{"offset": 0, "limit": 20, "authorization": "<?php echo $_SESSION["LOGIN_TOKEN"]; ?>" }',
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data){
            for (var i = data.count - 1; i >= 0; i--) {
            content += "<tr>  \
            <td>"+ data.parsers[i].name+ "</td> \
            <td>"+data.parsers[i].type+"</td> \
            <td><button type='button' onclick='view_code(\""+data.parsers[i]._id.$oid+"\")' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#code_edit_modal'>View/edit code</button></td> \
            <td><button type='button' onclick='delete_code(\""+data.parsers[i].name+"\")' class='btn btn-danger btn-sm'>Delete</button></td> \
            <td></td> \
            <td></td> \
            </tr>";
            //"+data.parsers[i].code+"
            }
            $("#code_dashboard_logs").html(content + "<tr><td>Create new</td><td></td><td><button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#code_edit_modal'>Create code</button></td><td></td><td></td><td></td></tr>");
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