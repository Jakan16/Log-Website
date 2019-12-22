<?php
/* Sandsized CMS - By Guld-berg.dk software technologies
*  Developed by Jørn Guldberg
*  Copyright (C) Jørn Guldberg - Guld-berg.dk All Rights Reserved. 
*/

/*
*  This file is listen all the validations function found in the CMS.
*  It is included in the file where data is needed to be validated.
*  The function returns an array where the:
*  First element true or false, if the input is valid
*  Second returning the input in a safemanner, THE FUNCTIONS CAN MODIFY INPUT, MAKE SURE TO USE THE SAFE OUTPUT
*  Third element is the fail msg, if any.
*/


function validate_email($user_input) {
	global $lang_data_must_be_filled, $lang_data_input_to_long, $lang_data_input_not_valid_mail;
	$user_output = '';
	$ok = true;
	if (empty($user_input)) {
	    $feedback_msg = "<b>$lang_data_must_be_filled</b>";
	    $ok = false;
	}
	else {
	    $user_output = clean_input_text($user_input);
	    if (strlen($user_output)<64){
	        // check if e-mail address is well-formed
	        if (!filter_var($user_output, FILTER_VALIDATE_EMAIL)) {
	            $feedback_msg = "<b>$lang_data_input_not_valid_mail</b>";
	            $ok = false;
	        }
	    }
	    else {
	        $feedback_msg = "<b>$lang_data_input_to_long 64 </b>";
	        $ok = false;
	    }
	}
	return array($ok, $user_output, $feedback_msg);
}

?>