<script>
<?php
// Her laves login scriptet. Det bliver indraget på siden hvis man ikke er logget ind.
if (!isset($_SESSION['login_user'])) {
?>
$(document).ready(function(){
    
    $("#loginbutton").click(function(event){
            
        event.preventDefault();
        
        var brugernavn = document.getElementById("brugernavn").value;
        var password = document.getElementById("password").value;
        var feedback = "";
        $.post("/core/authentication",
            {
            sendtBrugernavn: brugernavn,
            sendtPassword: password,
            },
            function(data,status){
            feedback = data;
            if (feedback == "succes") {
                document.location.href="/";
            }
            else if (feedback == "wrong") {
                $("#loginfeedback").html("<strong>Brugernavn og password passer ikke!</strong>");
            }
            else if (feedback == "empty") {
                $("#loginfeedback").html("<strong>Begge felter skal udfyldes!</strong>");
            }
            else if (feedback == "deactive") {
                $("#loginfeedback").html("<strong>Din bruger er deaktiveret, kontakt en adminstrator af siden</strong>");
            }
            else {
                $("#loginfeedback").html("<strong>Der er sket en fejl!</strong>");
            }
        });
        
    });
});
<?php
    }
?>
$(document).ready(function(){
    $(window).load(function(){
        calc_window();
    });
    
    window.onresize = calc_window;
    
    function calc_window() {
        var logo_height = $('#navi-inner').height() + 10;
        $("#navi").css("margin-bottom", logo_height );
    }
    
});
</script>
