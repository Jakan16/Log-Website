<script>
    function validateContactForm() {
        var ok = true;
        
        var mail = document.forms["contactForm"]["mail"].value;
        if (mail == "") {
            $("#errMail").html("<b> <?php echo $lang_data_must_be_filled; ?> </b>");
            ok = false;
        }
        
        var name = document.forms["contactForm"]["name"].value;
        if (name == "") {
            $("#errName").html("<b> <?php echo $lang_data_must_be_filled; ?> </b>");
            ok = false;
        }
        var comment = document.forms["contactForm"]["comment"].value;
        if (comment == "") {
            $("#errComment").html("<b> <?php echo $lang_data_must_be_filled; ?> </b>");
            ok = false;
        }
        return ok;
    }
</script>