<?php
# # # # # # # # # # # # # # # #
#
#   Inspiration fra Heinz K.
#   Redigeret af Mathias G. til funktioner som dobbelt auth, registrering, roller mm.
#
# # # # # # # # # # # # # # # #


class auth
{
    /* - GLOBAL VARIABLES - */
    private $db;

    public $auth_user_name;
    public $auth_password;
    public $auth_user_id;
    public $login_path;
    public $logout;
    public $auth_role;
    public $registerForm;

    public $errorMsg;
    public $auth_register_firstname;
    public $auth_register_lastname;
    public $auth_register_user_name;
    public $auth_register_password;
    public $auth_confirm_register_password;

    public $timeout;

    /* - CLASS CONSTANTS - */
    const ISLOGGEDIN = 1;
    const ERR_NOUSERFOUND = 1;
    const ERR_NOSESSIONFOUND = 2;
    const ERR_USEREXISTS = 3;
    const ERR_PASSWORDNOMATCH = 4;

    /* - CREATE GLOBAL DATABASE ID - */
    public function __construct()
    {
        //Call Database
        global $db;
        $this->db = $db;
        //Start Session
	    if (session_status() == PHP_SESSION_NONE) {
		    session_start();
	    }
        //Set User Name & Password from POST variables
        $this->auth_user_name = filter_input(INPUT_POST, "login_user_name", FILTER_SANITIZE_STRING);
        $this->auth_password = filter_input(INPUT_POST, "login_password", FILTER_SANITIZE_STRING);

        $this->auth_register_firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_STRING);
        $this->auth_register_lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_STRING);
        $this->auth_register_user_name = filter_input(INPUT_POST, "register_user_name", FILTER_SANITIZE_STRING);
        $this->auth_register_password = filter_input(INPUT_POST, "register_password", FILTER_SANITIZE_STRING);
        $this->auth_confirm_register_password = filter_input(INPUT_POST, "confirm_register_password", FILTER_SANITIZE_STRING);

        $this->logout = filter_input(INPUT_GET, "logout", FILTER_SANITIZE_STRING);
        $this->register = filter_input(INPUT_GET, "register", FILTER_SANITIZE_STRING);

        $this->login_path = DOCROOT . "/cms/incl/login.php";
        //Unset POST login variables
        unset($_POST['login_user_name']);
        unset($_POST['login_password']);

        $this->timeout = 1800;
    }

    // - START LOGIN & AUTHENTICATE SESSION
    public function authenticate($require_auth) {
        //If username and password is set in POST, start Login method
        if ($this->logout) {
            $this->logout();
        }
        if ($this->auth_register_user_name && $this->auth_register_password){
            $this->register();
        }
        if ($this->auth_user_name && $this->auth_password){
            $this->login($require_auth);
        }
        //Otherwise check if still logged in
        else {
            if (!$this->check_session()){
                if ($require_auth == true) {
                    if (isset($_GET['action']) && $_GET['action'] == "register") {
                        echo $this->register_form();
                        exit();
                    } else {
                        echo $this->login_form();
                        exit();
                    }
                }
            }
        }
    }

    private function register() {

        $params = array($this->auth_register_user_name);
        $sql = "SELECT *
                FROM user 
                WHERE email = ?";
        // If user does not exist
        if (!$row = $this->db->fetch_array($sql, $params)) {
            //Check if passwords match
            if ($this->auth_register_password == $this->auth_confirm_register_password) {
                $this->auth_regiser_password_hashed = password_hash($this->auth_register_password, PASSWORD_BCRYPT);
                $params = array(
                    $this->auth_register_firstname,
                    $this->auth_register_lastname,
                    $this->auth_register_user_name,
                    $this->auth_regiser_password_hashed
                );
                $sql = "INSERT INTO user (firstname, lastname, email, password) 
                        VALUES (?,?,?,?)";
                $this->db->query($sql, $params);
                header("Location: login.php");
                exit();
            }
            // If passwords does not match, throw an error
            else {
                $this->errorMsg = "Kodeord passer ikke sammen";
                return false;
            }
        }
        // If user exists, throw an error
        else {
            $this->errorMsg = "Bruger eksisterer allerede";
            return false;
        }
    }

    /**-----------------------------------------------------------------------
     *---------------------------LOGIN AREA (start)-------------------------*/

    // - INITIATE USER LOGIN
    private function login($require_auth) {
        //Look for this username in the database
        $params = array($this->auth_user_name);
        $sql = "SELECT *
                FROM user 
                WHERE email = ?";
        //If theres a User with this name
        if ($row = $this->db->fetch_array($sql, $params)) {
            //And if password matches
            if (password_verify($this->auth_password.$row[0] ['salt'], $row[0] ['password'])) {
                $params = array(
                            $row[0] ['id'],     //User ID
                            session_id(),       //Session ID
                            self::ISLOGGEDIN,   //Login Status
                            time()              //Timestamp for last action
                );
                $sql = "INSERT INTO user_session (user_id, session_id, logged_in, last_action) 
                        VALUES (?,?,?,?)";
                $this->db->query($sql, $params);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                //User now officially logged in
            }
            //If password doesn't match
            else {
                if ($require_auth) {
                    //Send user back to login with error
                    echo $this->login_form(self::ERR_NOUSERFOUND);
                    exit();
                }
                else {
                    $this->errorMsg = "Email eller password er forkert";
                    return false;
                }
            }
        }
        //If there isn't a User with this name
        else {
            if ($require_auth) {
                //Send user back to login with error
                echo $this->login_form(self::ERR_NOUSERFOUND);
                exit();
            }
            else {
                $this->errorMsg = "Email eller password er forkert";
                return false;
            }
        }
    }

    // - LOGOUT
    public function logout() {
        $params = array(session_id());
        $sql = "UPDATE user_session
                SET logged_in = 0
                WHERE session_id = ?";
        $this->db->query($sql, $params);
        session_unset();
        session_destroy();
        session_start();
        session_regenerate_id();
    }


    /**---------------------------LOGIN AREA (end)----------------------------
     * -----------------------------------------------------------------------
     *--------------------------CHECKUP AREA (start)------------------------*/

    // - CHECK IF SESSION IS STILL LOGGED IN
    private function check_session() {
        $params = array(session_id());
        $sql = "SELECT user_id, last_action 
                FROM user_session 
                WHERE session_id = ? 
                AND logged_in = 1";
        if($row = $this->db->fetch_array($sql, $params)) {
            $this->auth_user_id = $row [0] ['user_id'];
            $sql = "SELECT role.name
            FROM user 
            JOIN role
            ON user.role_id = role.id
            WHERE user.id = $this->auth_user_id";
            $this->auth_role = $this->db->fetch_value($sql);

            $sql = "SELECT firstname FROM user WHERE id = $this->auth_user_id";
            $this->auth_firstname = $this->db->fetch_value($sql);

            // Check last action
            if($row[0]["last_action"] > (time() - $this->timeout)) {
                $this->updateSession();
                return $this->auth_user_id;
            } else {
                $this->logout();
            }
        }
    }

    // UPDATE SESSSION WHEN ACTIVE
    public function updateSession() {
        $params = array(
            session_id()
        );
        $sql = "UPDATE user_session SET last_action = UNIX_TIMESTAMP() WHERE session_id = ?";
        $this->db->query($sql, $params);
    }


    /**--------------------------CHECKUP AREA (end)---------------------------
     * -----------------------------------------------------------------------
     *---------------------------ERROR AREA (start)-------------------------*/

    // - REDIRECT TO THE LOGIN SITE
    public function login_form($errCode = 0)
    {
        ob_start();
        include_once $this->login_path;
        $str_buffer = ob_get_clean();
        $str_error_msg = self::get_error($errCode);
        // Replaces the @ERRORMSG@ written in the login.php, with the error message or nothing
        $str_buffer = str_replace("@ERRORMSG@", $str_error_msg, $str_buffer);
        return $str_buffer;
    }
    public function register_form($errCode = 0)
    {
        ob_start();
        $str_buffer = ob_get_clean();
        $str_error_msg = self::get_error($errCode);
        // Replaces the @ERRORMSG@ written in the login.php, with the error message or nothing
        $str_buffer = str_replace("@ERRORMSG@", $str_error_msg, $str_buffer);
        return $str_buffer;
    }

    // - ERROR DESCRIPTIONS
    public function get_error($int)
    {
        switch ($int) {
            default:
                $str_error = "";
                break;

            case self::ERR_NOUSERFOUND:
                $str_error = "Brugernavn eller adgangskode er ikke korrekt";
                break;

            case self::ERR_NOSESSIONFOUND:
                $str_error = "No session found";
                break;

            case self::ERR_USEREXISTS:
                $str_error = "En bruger med denne Email eksisterer allerede";
                break;

            case self::ERR_PASSWORDNOMATCH:
                $str_error = "Kodeordene passer ikke sammen";
                break;
        }
        return $str_error;
}
    /**---------------------------ERROR AREA (end)----------------------------
     * ---------------------------------------------------------------------*/

}