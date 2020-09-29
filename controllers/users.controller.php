<?php

class UsersController
{
    /*=============================================
        LOG IN
	=============================================*/
    public function ctrLogin()
    {
        # Check if there is post variable called email, that comes from the form
        if (isset($_POST["email"])) {
            # Session variables
            $_SESSION['logged_in'] = "ok";

            # Log in 
            echo '<script>
                window.location = "operations-index";
            </script>';
        }
    }
}
