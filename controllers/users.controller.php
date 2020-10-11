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
            $_SESSION['user_id'] = 111;

            # Log in 
            echo '<script>
                window.location = "operations-index";
            </script>';
        }
    }
}
