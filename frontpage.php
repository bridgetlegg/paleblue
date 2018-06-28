<html>
    <head>
        <title>Paleblue</title>
        <link rel="stylesheet" href="/styles.css">
    </head>
    
    <body>
        
        
        <button onclick="document.getElementById('signup').style.display='block'">Sign up</button>
        
        
        <!--- SIGN UP FORM STARTS HERE -->
        <div id="signup" class="popup">
           

        <form method = "POST">
            Username <br> <input type="text" name="username"> <br>
            Display name <br> <input type="text" name = "displayname"><br>
            Email address <br> <input type="text" name="email"> <br>
            Password [unhashed] <br> <input type="password" name="pwhash"><br>
            Confirm password <br> <input type="password" name="confirmpw"><br>
            <button>Sign up</button>
        
        <button type="button" onclick="document.getElementById('signup').style.display='none'" class="cancelbtn">Cancel</button>
        
        <br>
        
        
        <?php
            //initialise the variables
            $username = "";
            $displayname="";
            $email="";
            $pwhash="";
            $confirmpw="";
            
            //gather the data from the form
            if (!empty($_POST)) {
            $username = $_POST['username'];
            $displayname = $_POST['displayname'];
            $email = $_POST['email'];
            $pwhash = $_POST['pwhash'];
            $confirmpw = $_POST['confirmpw'];
            
            //if the displayname is blank, set it to equal the username
                if (strlen($displayname)==0) {
                    $displayname = $username;
                }
            
            

             
            
            //connect to the database 
		//you will need to paste the login details here, they cannot be uploaded for security reasons
            
            try {
                    $conn = new PDO("mysql:host=$servername;dbname=$database", $dbusername, $password);
                    // set the PDO error mode to exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    //echo "Connected successfully"; 
                } catch(PDOException $e) {    
                    echo "Connection failed: " . $e->getMessage();
                }
                //insert the values into the table
                $sql = "insert into testloginbase values ('" . $username . "', '" . $displayname . "', '" . $email . "', '" . $pwhash . "', '0' )";
                
                //check the username, email and password are reasonable values
                
                $username_length_toolong = strlen($username) > 20;
                
                $username_length_tooshort = strlen($username) < 4 && strlen($username) != 0;
                
                $username_blank = strlen($username) == 0;
                
                $password_length_toolong = strlen($pwhash) > 255;
                
                $password_length_tooshort = strlen($pwhash) < 8 && strlen($pwhash) != 0;
                
                $password_blank = strlen($pwhash) == 0;
                
                $email_blank = strlen($email) == 0;
                
                $email_bad = (strpos($email,"@") == false) || (strpos($email,".",strpos($email,"@")) == false); //must contain an @ sign, must contain a dot AFTER the @ sign
                
                $pw_mismatch = $pwhash !== $confirmpw;
                
                //need to also check that username and email are not already used
            

                $inputinvalid = $username_length_toolong || $username_length_tooshort || $username_blank || $password_length_toolong || $password_length_tooshort || $password_blank || $email_blank || $email_bad || $pw_mismatch;


                $inputvalid = !$inputinvalid;
                
                if ($inputvalid) {
                try{
                $conn->exec($sql);
                echo "Success! Your new username is " . $username . " and we will contact you on " . $email . " to complete the next step. <br>" ;
                } catch (PDOException $ee) {
                    if (!empty($_POST)) {
                        
                        if (strpos($ee, "for key 'PRIMARY'") !== false) {
                            echo "Error - A user already exists with this username.";
                        } else{
                    echo "There has been an error, you could not be added to the database. Please quote error reference: <br><i>" . $ee . "</i>";
                    }
                    }
                }
                }
                else {
                    echo "There is a problem with your input.<br>";
                    
                    //give a message to let the user know why their input is invalid
                    if ($username_blank) {
                        echo "Please enter a username.<br>";
                    } 
                    if ($username_length_tooshort) {
                        echo "The username entered is too short. Please enter at least 4 characters.<br>";
                    }
                    if($username_length_toolong) {
                        echo "The username entered is too long. Please do not exceed 20 characters.<br>";
                    }
                    if($password_blank) {
                        echo "Please enter a password.<br>";
                    }
                    if($password_length_tooshort) {
                        echo "Password too short. Please create a password which is at least 8 characters long. <br>";
                    }
                    if($password_length_toolong) {
                        echo "Your password is over 255 characters. Please enter a shorter password. <br>";
                    }
                    if($email_blank) {
                        echo "Please enter your email address. <br>";
                    }
                    if($email_bad) {
                        echo "Please enter a valid email address. <br>";
                    }
                    if($pw_mismatch) {
                        echo "Passwords do not match, please try again.";
                    }
                }
                
                }
              else {
                echo "Please fill in the form.";
            }  


        ?>
        </form>
        </div>
        <!-- end of signup box area (need all error message to appear *in* box) -->
        
        <!-- login form begins here-->
        
        <button onclick="document.getElementById('login').style.display='block'">Log in</button>
        
        <div id="login" class="popup">
            
                    <form method = "POST">
            Username <br> <input type="text" name="username"> <br>
            Password [unhashed] <br> <input type="password" name="pwraw"><br>
            <button>Log in</button>
        
        <button type="button" onclick="document.getElementById('login').style.display='none'" class="cancelbtn">Cancel</button>
        
        <br>
        
        </div>
        
        <!-- login form ends here-->
    </body>
    
</html>