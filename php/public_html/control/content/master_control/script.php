<script>
    function validateForm() {
        var ok = true;
        var user = document.forms["create"]["username"].value;
        if (user == "") {
            errUser
            $("#errUser").html("<b> <?php echo $lang_data_must_be_filled; ?> </b>");
            ok = false;
        }

        var pass = document.forms["create"]["password"].value;
        if (pass == "") {
            $("#errPass").html("<b> <?php echo $lang_data_must_be_filled; ?> </b>");
            ok  = false;
        }
        return ok;
    }
    function confirmDelete() {
        return confirm("Bekræft ved at klikke ok");
    }

    function get_company_list()
    {
        var content = "";
        $.ajax({
            type: "POST",
            url: <?php echo '"'.SERIVCE_AUTHSERVICE_URL. '"'; ?>,
            // The key needs to match your method's input parameter (case-sensitive).
            data: <?php echo '{"method": "getcompanies", "serverkey": "'.SERVER_AUTH_KEY.'"}';?> ,
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
                $("#company_list").html(content);
            },
            failure: function(errMsg) 
            {
                alert(errMsg);
            }
        });
    }
</script>
