<?php
/*
 * User class
 * @verion 1.0.0.0
 * @author Anonimus
 * @license GNU Public License
 */

class User {
    //@var string $user_table database users table
    public $user_table = "users";
    //@var string logged user data
    public $session_user_data = "session_user_data";
    /*     * *********************************************************************************************** 
     *  @method void  class construct method
     * ************************************************************************************************ */
    public function __construct() {
        
    }
    /*     * *********************************************************************************************** 
     *  @method int creates new user in database
     *  @param string $table name of database table
     *  @param array $userDataArray array that holds fields and values for database table
     * ************************************************************************************************ */
    public function createUser($userDataArray) {
        try {
            if (!empty($this->user_table)) {
                $insertedRowID = Db_Actions::DbInsert2($this->user_table, $userDataArray);
                return $insertedRowID;
            }
            else {
                throw new Exception('You must specify users table using <strong>user_table</strong> public variable');
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "<br />At Line: <strong>" . $e->getLine() . "</strong><br />In " . $e->getFile();
        }
        return 0;
    }
    /*     * *********************************************************************************************** 
     *  @method bool updates existing user data
     *  @param array $userDataArray array that holds fields and values for database table
     *  @param string $condition condition text default set to empty string
     * ************************************************************************************************ */
    public function updateUser($userDataArray, $condition = "") {
        try {
            if (!empty($this->user_table)) {
                $affected_row = Db_Actions::DbUpdate2($this->user_table, $userDataArray, $condition);
                if ($affected_row == 1) {
                    return true;
                }
                return false;
            }
            else {
                throw new Exception('You must specify users table using <strong>user_table</strong> public variable');
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "<br />At Line: <strong>" . $e->getLine() . "</strong><br />In " . $e->getFile();
        }
        return false;
    }
    /*     * *********************************************************************************************** 
     *  @method bool from database table
     *  @param array $userDataArray array that holds fields and values for database table
     *  @param string $condition condition text default set to empty string
     * ************************************************************************************************ */
    public function deleteUser($userDataArray, $condition = "") {
        try {
            if (!empty($this->user_table)) {
                $affected_row = Db_Actions::DbUpdate2($this->user_table, $userDataArray, $condition);
                if ($affected_row == 1) {
                    return true;
                }
                return false;
            }
            else {
                throw new Exception('You must specify users table using <strong>user_table</strong> public variable');
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "<br />At Line: <strong>" . $e->getLine() . "</strong><br />In " . $e->getFile();
        }
        return false;
    }
    /*     * *********************************************************************************************** 
     *  @method bool  
     * ********************************************************************************************** */
    public function loginUser() {
        try {
            if (!empty($this->user_table)) {
                Db_Actions::DbConnect();
                $email = Db_Actions::DbSanitizeData($_POST['param1']);
                $password = Db_Actions::DbSanitizeData($_POST['param2']);
                $userData = Db_Actions::DbSelectRow("SELECT * FROM " . $this->user_table . " WHERE email='" . $email . "' AND password=" . Db_Actions::$passwordHashEncryption . "('" . $password . "')");
                $_SESSION[$this->session_user_data] = $userData;
                if (Db_Actions::DbGetNumRows() == 1) {
                    echo "1";
                    return true;
                }
                else {
                    echo "2";
                    return false;
                }
            }
            else {
                throw new Exception('You must specify users table using <strong>user_table</strong> public variable');
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "<br />At Line: <strong>" . $e->getLine() . "</strong><br />In " . $e->getFile();
        }
        return false;
    }
    /*     * *********************************************************************************************** 
     *  @method void send forgoten password email  
     * ********************************************************************************************** */
    public function sendForgotenPasswordEmail() {
        $email = trim($_POST['user_email']);
        $query = "SELECT id FROM pixusers WHERE email='" . htmlspecialchars($email) . "'";
        Db_Actions::DbSelectRow($query);

        if (count(Db_Actions::DbGetNumRows()) === 1) {
            // Additional headers
            $from = "andres@pix.cl";
            $headers = 'To: <' . $email . '>' . "\r\n";
            $headers .= 'From: <' . $from . '>' . "\r\n";
            $headers .= 'Reply To: <' . $from . '>' . "\r\n";
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

            //Generate token
            $token = $this->GENERATE_SECURITY_TOKEN();
            //Store token in database
            $now = strtotime('now');
            $query = "UPDATE pixusers SET password_request='" . $token . "', password_request_date='" . $now . "' WHERE email='" . htmlspecialchars($email) . "'";
            Db_Actions::DbInsert($query);

            $message = "<h3>Password Recovery</h3>";
            $message .= "Request for password recovery has been sent from " . $_SERVER['REMOTE_ADDR'] . "<br /><br />";
            $message .= "<a href='http://www.pix.cl/pixfactory/renew-password.php?security_token=" . $token . "'>Follow this link to reset your password</a><br /><br />";
            $message .= "This link will expire after 24 hours.";

            mail($email, 'Password recovery request', $message, $headers, "-f andres@pix.cl");

            echo 1;
        }
        else {
            echo 2;
        }
    }
    /*     * *********************************************************************************************** 
     * @method string Generate security token
     * *********************************************************************************************** */
    public function GENERATE_SECURITY_TOKEN() {
        $chars = 'a,b,c,d,e,f,g,h,i,j,k,l,m,e,n,o,p,q,r,s,t,u,v,w,x,Y,z,1,2,3,4,5,6,7,8,9,0,!,@,#,$,%,^,&,*,A,B,C,D,E,F,G,H,I,J,K,L,M,E,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,_,-';
        $chars_array = explode(",", $chars);
        $token_length = 40;
        $token = '';
        for ($i = 0; $i < $token_length; $i++) {
            $rand_char = $chars_array[mt_rand(0, count($chars_array) - 1)];
            $token .= $rand_char;
        }
        $token = md5($token);
        return $token;
    }
     /************************************************************************************************* 
     * @method mixed Check for valid security token
     * *********************************************************************************************** */
    public function checkSecurityToken() {
        if (!isset($_GET['security_token'])) {
            exit('You do not have permissions to view this page');
        }
        else {

            //Get token
            $token = $_GET['security_token'];
            $query = "SELECT id,password_request_date FROM pixusers WHERE password_request='" . htmlspecialchars($token) . "'";
            $result = Db_Actions::DbSelectRow($query);

            if (count(Db_Actions::DbGetNumRows()) === 1) {
                //Check if token is not yet expired
                $token_date = $result->password_request_date;
                $date = date("d", (int) $token_date) . "-" . date("F", (int) $token_date) . "-" . date("Y", (int) $token_date);
                $valid_date = strtotime("$date +1 day");
                $now = strtotime('now');

                if ($now > $valid_date) {
                    exit('Your request has expired, please generate new request.');
                }
            }
            else {
                exit('You do not have permissions to view this page');
            }
        }
    }
     /************************************************************************************************* 
     * @method void Recover user password
     * *********************************************************************************************** */
    public function recoverUserPassword() {
        //Get token
        $token = $_POST['sec_token'];
        $new_password = $_POST['new_pass'];
        if (!empty($new_password)) {
            $query = "SELECT id FROM pixusers WHERE password_request='" . htmlspecialchars($token) . "'";
            $result = Db_Actions::DbSelectRow($query);
          
            if (count(Db_Actions::DbGetNumRows()) === 1){
                //Update the password
                Db_Actions::DbUpdate2("pixusers",array('password' => $new_password),'password_request="'.$token.'"');
                
                //Delete scurity token
                Db_Actions::DbUpdate2("pixusers",array('password_request' => "", 'password_request_date' => ''),'password_request="'.$token.'"');

                echo '1';
            }
        }
    }
}

$u = new User();
//Create new user
if (isset($_POST['reg']) && $_POST['reg'] == 1) {
    session_start();
    require_once("db_actions.php");
    $birthDate = preg_split("/\//", $_POST['birth_date']);
    $timestamp = gmmktime(0, 0, 0, $birthDate[1], $birthDate[0], $birthDate[2]);
    $u->createUser(array(
        "first_name" => $_POST['first_name'],
        "last_name" => $_POST['last_name'],
        "email" => $_POST['email'],
        "password" => $_POST['password'],
        "birth_date" => $timestamp,
        "gender" => $_POST['gender'],
        "profile_image" => $_POST['profile_image'],
        "date_registered" => strtotime("now")
    ));
    $_SESSION['fresh_register'] = "1";
    echo 1;
}
//Check if user is registering with twitter
if (isset($_POST['checkTwStatus']) && $_POST['checkTwStatus'] == 1) {
    session_start();
    if (isset($_SESSION['tw_activated']) && $_SESSION['tw_activated'] == 1) {
        unset($_SESSION['tw_activated']);
        echo "activated";
    }
    else {
        echo 0;
    }
}
//Login
if (isset($_POST['param1']) && isset($_POST['param2'])) {
    session_start();
    require_once("db_actions.php");
    $u->loginUser();
}

//Send password reset email
if (isset($_POST['pass_reset']) && $_POST['pass_reset'] == "1") {
    require_once("db_actions.php");
    $u->sendForgotenPasswordEmail();
}
//Change password from reset mail
if(isset($_POST['pass_change'])){
    require_once("db_actions.php");
    $u->recoverUserPassword();
}
?>