<?php

class Epaper_model extends CI_Model {

    public function __construct() {
// Call the Model constructor
        parent::__construct();
        $this->db = $this->load->database('default', TRUE); //default db
    }

    function validate() {
        $password = $this->input->post('password');
        $email = $this->db->escape_str($this->input->post('email'));
        $sql = "select auth_key from users where (email='$email' or username='$email') and status='1'";
        $rel = $this->db->query($sql);
        if ($rel->num_rows != "") {
            foreach ($rel->result() as $rl):
                $authkey = $rl->auth_key;
            endforeach;
            $pass = md5($authkey . $password);
            $sql = "select * from users where password='$pass' and (email='$email' or username='$email')";
            $result = $this->db->query($sql);
            if ($result->num_rows != "") {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
function mobile_auth(){
if(isset($_POST['email'])){
$password = $_POST['password'];
        $email = $this->db->escape_str(trim($_POST['email']));
        $sql = "select auth_key from users where (email='$email' or username='$email') and status='1'";
        $rel = $this->db->query($sql);
        if ($rel->num_rows != "") {
            foreach ($rel->result() as $rl):
                $authkey = $rl->auth_key;
            endforeach;
            $pass = md5($authkey . trim($password));
            $sql = "select * from users where password='$pass' and (email='$email' or username='$email')";
            $result = $this->db->query($sql);
            if ($result->num_rows != "") {
                foreach($result->result() as $rl):
				$arr = array('user_login' => "YES", 'email' => $email, 'userID' => $rl->userID);
				endforeach;
            } else {
                $arr = array('user_login'=>"Wrong Email or Password");
            }
        } else {
             $arr = array('user_login'=>"Email Address is not registered");
        }
		}else{
		$arr = array('user_login'=>'NO');
		}

echo json_encode($arr);
}
function mobile_add_user() {
if(isset($_POST['email'])){
        $email = $this->db->escape_str(trim($_POST['email']));
        $fname = $this->db->escape_str(trim($_POST['fname']));
        $username = $this->db->escape_str(trim($_POST['username']));
        $lname = $this->db->escape_str(trim($_POST['lname']));
        $password = trim($_POST['password']);
        $random_string_length = 5;
        $authkey = $this->authkey($random_string_length);
        $datecreated = date('Y-m-d H:i:s');
        $newpass = md5($authkey . $password);
        $sql = "select * from users where email='$email'";
        $relt = $this->db->query($sql);
        if ($relt->num_rows == "") {
            $sql = "INSERT INTO users (username, fname, lname, email, auth_key, password,datecreated) VALUES ('$username','$fname','$lname','$email','$authkey','$newpass','$datecreated')";
            $this->db->query($sql);

            //Get Userid
            $sql = "select userID from users where email='$email'";
            $result = $this->db->query($sql);
            $userID = "";
            foreach ($result->result() as $rl):
                $userID = $rl->userID;
            endforeach;

            // create user session
            $username = $fname . ' ' . $lname;
            $this->send_created_acc_email($email, $username);
            $arr = array('username' => $username,
                'email' => $email,
                'userID' => $userID,
                'user' => 'user'
            );
            
        }else {
            $arr=array('message'=>'Your email address is already registered. Kindly contact us on online@standardmedia.co.ke for assistance');
               }
		}else{
		 $arr=array('message'=>'Could not register');
          }
		echo json_encode($arr);
    }
    function updatepass() {
        $random_string_length = 5;
        $authkey = $this->authkey($random_string_length);
        $pass = $this->db->escape_str(trim($this->input->post('pass')));
        $userID = $this->session->userdata('admin_id');
        $newpassword = md5($authkey . $pass);
        $sql = "UPDATE users SET auth_key='$authkey', password='$newpassword' where userID='$userID'";
        $this->db->query($sql);
    }

    function check_oldpw() {
        $oldpass = $this->db->escape_str(trim($this->input->post('oldpass')));
        $userID = $this->session->userdata('admin_id');
        $sql = "select auth_key,password from users where userID='$userID'";
        $relt = $this->db->query($sql);
        $password = "";
        $auth_key = "";
        foreach ($relt->result() as $rl):
            $auth_key = $rl->auth_key;
            $password = $rl->password;
        endforeach;
        if (md5($auth_key . $oldpass) == $password) {
            return true;
        }
    }

    function get_user() {
        $email = $this->db->escape_str($this->input->post('email'));
        $sql = "select * from users where email='$email'";
        return $this->db->query($sql);
    }

    function get_fb_user($email) {
        $sql = "select * from users where email='$email'";
        return $this->db->query($sql);
    }

    function check_fb_reg($email) {
        $sql = "select * from users where email='$email'";
        $relt = $this->db->query($sql);
        if ($relt->num_rows != "") {
            return true;
        } else {
            return false;
        }
    }

    function add_fb_user($email, $usern) {
        $name = explode(" ", trim($usern));
        $fname = $name[0];
        $lname = $name[1];
        $password = $this->authkey(8);
        $random_string_length = 5;
        $authkey = $this->authkey($random_string_length);

        $datecreated = date('Y-m-d H:i:s');
        $newpass = md5($authkey . $password);
        $sql = "INSERT INTO users (fname, lname, email, auth_key, password,datecreated) VALUES ('$fname','$lname','$email','$authkey','$newpass','$datecreated')";
        $this->db->query($sql);

        //Get Userid
        $sql = "select userID from users where email='$email'";
        $result = $this->db->query($sql);
        $userID = "";
        foreach ($result->result() as $rl):
            $userID = $rl->userID;
        endforeach;

        // create user session
        $username = $fname . ' ' . $lname;
        $this->send_created_acc_fb_email($email, $username, $password);
        $user = array('username' => $username,
            'email' => $email,
            'admin_id' => $userID,
            'user_logged_in' => TRUE,
            'user' => 'user'
        );
        $this->session->set_userdata($user);
        $this->session->set_flashdata('msg', 'Your account has been created successfully');
    }

    function get_newspaper() {
        $sql = "select * from tbl_newspaper";
        return $this->db->query($sql);
    }

    function emailnotify() {

        $userID = $this->session->userdata('admin_id');
        $sql = "select emailnotify from users where userID='$userID'";
        return $this->db->query($sql);
    }

    function unsubscribeuser() {
        $userID = $this->session->userdata('admin_id');
		$sql = "UPDATE  `standard_epaper_app`.`users` SET  `emailnotify` =  '0' WHERE  `users`.`userID` ='$userID'";
       $this->db->query($sql);
    }

    function subscribeuser() {
        $userID = $this->session->userdata('admin_id');
      $sql = "UPDATE  `standard_epaper_app`.`users` SET  `emailnotify` =  '1' WHERE  `users`.`userID` ='$userID'";
	      $this->db->query($sql);
    }

    function create_archive_order() {
        $paperid = $this->input->post('paper');
        $userID = $this->session->userdata('admin_id');
        $paperdate = $this->input->post('paperdate');
        $orderdate = date('Y-m-d H:i:s');
        $sql = "insert into tbl_archive_orders (userID, paperid, paperdate, orderdate, amount) VALUES ('$userID', '$paperid','$paperdate', '$orderdate','100')";
        $this->db->query($sql);
        $sql = "select archiveid from tbl_archive_orders where userID='$userID' order by archiveid desc limit 1";
        $relt = $this->db->query($sql);
        $ord = "";
        foreach ($relt->result() as $rl):
            $ord = $rl->archiveid;
        endforeach;
        return $ord;
    }

    function get_archive_order_summary($archiveid) {
        $userID = $this->session->userdata('admin_id');
        $sql = "SELECT * FROM tbl_archive_orders left join tbl_newspaper ON tbl_newspaper.paperid=tbl_archive_orders.paperid where archiveid='$archiveid' and userID='$userID'";
        return $this->db->query($sql);
    }

    function get_paper_subscription($subid) {
        $sql = "select * from tbl_rates left join tbl_newspaper on tbl_newspaper.paperid=tbl_rates.paperid where subid='$subid'";
        return $this->db->query($sql);
    }

    function forgot_pw() {
        $email = $this->db->escape_str(trim($this->input->post('email')));
        $sql = "select * from users where email='$email' or username='$email'";
        $relt = $this->db->query($sql);
        if ($relt->num_rows != "") {
            $password = $this->authkey(8);
            $random_string_length = 5;
            $authkey = $this->authkey($random_string_length);
            $newpass = md5($authkey . $password);
            $sql = "UPDATE users set auth_key='$authkey', password='$newpass' where email='$email'";
            $this->db->query($sql);
            // create user session
            foreach ($relt->result() as $rl):
                $username = $rl->username;
                $this->send_usernew_pass_email($email, $username, $password);
                $this->session->set_flashdata('msg', 'Your password reset is successfully. Please check your email (' . $this->obfuscate_email($email) . ') inbox for the new password.');
            endforeach;
        } else {
            $this->session->set_flashdata('errmsg', 'Your email address is not registered');
        }
    }

    function obfuscate_email($email) {
        $em = explode("@", $email);
        $name = implode(array_slice($em, 0, count($em) - 1), '@');
        $len = floor(strlen($name) / 2);

        return substr($name, 0, $len) . str_repeat('*', $len) . "@" . end($em);
    }

    function mobile_reg_pw() {
        $email = $this->db->escape_str(trim($this->input->post('email')));
        $sql = "select * from users where email='$email' or username='$email'";
        $relt = $this->db->query($sql);
        if ($relt->num_rows != "") {
            $password = $this->authkey(8);
            $random_string_length = 5;
            $authkey = $this->authkey($random_string_length);
            $newpass = md5($authkey . $password);
            $sql = "UPDATE users set auth_key='$authkey', password='$newpass' where email='$email'";
            $this->db->query($sql);
            // create user session
            foreach ($relt->result() as $rl):
                $username = $rl->username;
                $this->send_mobileuser_pass_email($email, $username, $password);
                $this->session->set_flashdata('msg', 'Your password generated successfully. Please check your email inbox for the new password.');
            endforeach;
        } else {
            $this->session->set_flashdata('errmsg', 'Your email address is not registered');
        }
    }

    function add_user() {
        $email = $this->db->escape_str($this->input->post('email'));
        $fname = $this->db->escape_str($this->input->post('fname'));
        $username = $this->db->escape_str($this->input->post('username'));
        $lname = $this->db->escape_str($this->input->post('lname'));
        $password = $this->db->escape_str($this->input->post('pass'));
        $random_string_length = 5;
        $authkey = $this->authkey($random_string_length);
        $datecreated = date('Y-m-d H:i:s');
        $newpass = md5($authkey . $password);
        $sql = "select * from users where email='$email'";
        $relt = $this->db->query($sql);
        if ($relt->num_rows == "") {
            $sql = "INSERT INTO users (username, fname, lname, email, auth_key, password,datecreated) VALUES ('$username','$fname','$lname','$email','$authkey','$newpass','$datecreated')";
            $this->db->query($sql);

            //Get Userid
            $sql = "select userID from users where email='$email'";
            $result = $this->db->query($sql);
            $userID = "";
            foreach ($result->result() as $rl):
                $userID = $rl->userID;
            endforeach;

            // create user session
            $username = $fname . ' ' . $lname;
            $this->send_created_acc_email($email, $username);
            $user = array('username' => $username,
                'email' => $email,
                'admin_id' => $userID,
                'user_logged_in' => TRUE,
                'user' => 'user'
            );
            $this->session->set_userdata($user);
            $this->session->set_flashdata('msg', 'Your account has been created successfully');
            return TRUE;
        }else {
            $this->session->set_flashdata('msg', 'Your email address is already registered. Kindly contact us on online@standardmedia.co.ke for assistance');
            return FALSE;
        }
    }

    function send_created_acc_email($address, $username) {
        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->clear();
        $this->email->to($address);
        $this->email->from('online@standardmedia.co.ke');
        $this->email->subject('Your Standard e-Paper account has been created');
        $msg = '<html>
    <body style="margin: 0px; padding: 0px">
       <div style="background: #EE1C23; margin-top: 0px; padding: 0px"><img src="' . base_url() . 'images/logo.png"></div>
       <div style="font-family: ' . "'Source Sans Pro'" . ', sans-serif;
    font-size: 13pt;
    line-height: 1.5em;
    color: #676d79;
    font-weight: 300; padding-top: 10px;">
      
       Dear <strong>' . $username . '</strong>,<br />
       <p>Your Standard Digital e-Paper account has been created successfully.</p>
       <p>To login to your account, visit <a href="' . base_url() . '" target="new">' . base_url() . '</a></p>
       Thanks,<br />
       <strong>The Standard Digital Team</strong>
       </div>
    </body>
</html>';
        $this->email->message($msg);
        $this->email->send();
    }

    function send_mobileuser_pass_email($address, $username, $password) {

        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->clear();
        $this->email->to($address);
        $this->email->from('online@standardmedia.co.ke');
        $this->email->subject('Standard e-Paper New Password');
        $msg = '<html>
    <body style="margin: 0px; padding: 0px">
       <div style="background: #EE1C23; margin-top: 0px; padding: 0px"><img src="' . base_url() . 'images/logo.png"></div>
       <div style="font-family: ' . "'Source Sans Pro'" . ', sans-serif;
    font-size: 13pt;
    line-height: 1.5em;
    color: #676d79;
    font-weight: 300; padding-top: 10px;">
      
       Dear <strong>' . $username . '</strong>,<br />
       <p>You have generated a new Standard Digital e-Paper account password.</p>
       <p>Your login credentials are<br />
       Email: <strong>' . $address . '</strong><br />
       Password: <strong>' . $password . '</strong></p>
       <p>To login to your account, visit <a href="' . base_url() . '" target="new">' . base_url() . '</a></p>
       Thanks,<br />
       <strong>The Standard Digital Team</strong>
       </div>
    </body>
</html>';
        $this->email->message($msg);
        $this->email->send();
    }

    function send_usernew_pass_email($address, $username, $password) {

        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->clear();
        $this->email->to($address);
        $this->email->from('online@standardmedia.co.ke');
        $this->email->subject('Standard e-Paper password reset');
        $msg = '<html>
    <body style="margin: 0px; padding: 0px">
       <div style="background: #EE1C23; margin-top: 0px; padding: 0px"><img src="' . base_url() . 'images/logo.png"></div>
       <div style="font-family: ' . "'Source Sans Pro'" . ', sans-serif;
    font-size: 13pt;
    line-height: 1.5em;
    color: #676d79;
    font-weight: 300; padding-top: 10px;">
      
       Dear <strong>' . $username . '</strong>,<br />
       <p>You have reset your Standard Digital e-Paper account password.</p>
       <p>Your login credentials are<br />
       Email: <strong>' . $address . '</strong><br />
       Password: <strong>' . $password . '</strong></p>
       <p>To login to your account, visit <a href="' . base_url() . '" target="new">' . base_url() . '</a></p>
       Thanks,<br />
       <strong>The Standard Digital Team</strong>
       </div>
    </body>
</html>';
        $this->email->message($msg);
        $this->email->send();
    }

    function send_created_acc_fb_email($address, $username, $password) {

        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->
                clear();
        $this->email->to($address);
        $this->email->from('online@standardmedia.co.ke');
        $this->email->subject('Your Standard  e-Paper account has been creat ed');
        $msg = '<html>
    <body style="margin: 0px; padding: 0px">
       <div style="background: #EE1C23; margin-top: 0px; padding: 0px"><img src="' .
                base_url() . 'images/logo.png"></div>
       <div style="font-family: ' . "'Source Sans Pro'" . ', sans-serif;
    font-size: 13pt;
    line-height: 1.5em;
    color: #676d79;
    font-weight: 300; padding-top: 10px;">
      
       Dear <strong>' . $username . '</strong>,<br />
       <p>Your Standard Digital e-Paper account has been created successfully.</p>
       <p>Your login credentials are<br />
       Email: <strong>' . $address . '</strong><br />
       Password: <strong>' . $password . '</strong></p>
       <p>To login to your account, visit <a href="' . base_url() .
                '" target="new">' . base_url()
                . '</a></p>
       Thanks,<br />
       <strong>The Standard Digital Team</strong>
       </div>
    </body>
</html>';
        $this->email->message($msg);
        $this->email->send();
    }

    function count_downloads($edition) {
        $datedownloaded = date('Y-m-d H:i:s');
        $userID = $this->session->userdata('admin_id');
        $uIPaddress = $this->getUserIP();
		//if(rand(1,300)%200==0){
       $sql = "INSERT INTO tbl_downloads (edition, datedownloaded, userID, IPaddress) values ('$edition','$datedownloaded','$userID','$uIPaddress')";
        $this->db->query($sql);
	  // }
    }

    function getUserIP() {
       /* $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
		*/
		$ip1 = $_SERVER['REMOTE_ADDR'] ;  


if (getenv('HTTP_X_FORWARDED_FOR')) {							
  $ip2 = getenv('HTTP_X_FORWARDED_FOR');  
} else { 
   $ip2 = getenv('REMOTE_ADDR');  
}	
$ip=	$ip1."-".$ip2;

        return $ip;
    }

    function authkey($random_string_length) {
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $string = '';
        for ($i = 0; $i < $random_string_length; $i++) {

            $string .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $string;
    }

    function verify_email() {
        $email = $this->db->escape_str($this->input->post('email'));
        $sql = "select * from users where email='$email'";
        $relt = $this->db->query($sql);
        if ($relt->num_rows != "") {
            return false;
        } else {
            return true;
        }
    }

    function get_epaper_rates($paperid) {
        $sql = "select * from tbl_rates where paperid='$paperid' order by  subid asc";
        return $this->db->query($sql);
    }

    function get_user_subs() {
        $userID = $this->session->userdata('admin_id');
        $sql = "select * from tbl_subscription left join tbl_rates on tbl_rates.subid = tbl_subscription.subid left join tbl_newspaper on tbl_newspaper.paperid=tbl_rates.paperid where tbl_subscription.userID='$userID' order by orderid desc";
        return $this->db->query($sql);
    }
  function get_user_subs_history() {
        $userID = $this->session->userdata('admin_id');
        $sql = "select * from tbl_subscription left join tbl_rates on tbl_rates.subid = tbl_subscription.subid left join tbl_newspaper on tbl_newspaper.paperid=tbl_rates.paperid where tbl_subscription.userID='$userID' order by orderid desc limit 30";
        return $this->db->query($sql);
    }
    function get_client_order($orderid) {
        $userID = $this->session->userdata('admin_id');
        $sql = "select * from tbl_subscription left join tbl_rates ON tbl_rates.subid=tbl_subscription.subid where userID='$userID' and tbl_subscription.orderid='$orderid' and tbl_subscription.status='0'";
        return $this->db->query($sql);
    }

    function get_client_order_summary($orderid) {
        $sql = "select *, tbl_rates.amount_usd as ausd, tbl_rates.amount_ksh as aksh from tbl_subscription left join (tbl_rates,users) on users.userID=tbl_subscription.userID and tbl_rates.subid=tbl_subscription.subid left join tbl_newspaper on tbl_newspaper.paperid=tbl_rates.paperid where tbl_subscription.orderid='$orderid'";
        return $this->db->query($sql);
    }

    function finishtrans() {
        
        
        //file_put_contents("/home/standard_digital/httpdocs/mpesa/logs/mpesa_ipn.log",$_POST['transaction']."test",FILE_APPEND); 
       
        if (isset($_POST['ref'])) {
            $transaction = $_POST['transaction'];
            $amount = $_POST['amount'];
            $orderid = substr($transaction, 3);
            $channel = "MPESA";
            $ref = $_POST['ref'];
            $sql = "select * from tbl_subscription where orderid='$orderid'";
            $relt = $this->db->query($sql);
            if ($relt->num_rows != "") {
                foreach ($relt->result() as $rlt) {
                    $dbamount = $rlt->amount;
                    $amountpaid = $rlt->amountpaid;
                    $balance = $rlt->balance;
                    $sub = $rlt->subid;
                    $newamount = $amountpaid + $amount;
                    $newbalance = $dbamount - $newamount;
                    if ($newamount >= $dbamount) {

                        $sql = "select * from tbl_rates where subid='$sub'";
                        $result = $this->db->query($sql);
                        foreach ($result->result() as $rl):
                            $no_of_days = $rl->no_of_days;
                        endforeach;
                        $startdate = date('Y-m-d');
                        $sdate = strtotime($startdate);
                        $edate = strtotime("+$no_of_days day", $sdate);
                        $enddate = date('Y-m-d', $edate);
                        $datemade = date('Y-m-d H:i:s');
                        $sql = "update tbl_subscription set amountpaid = '$newamount', balance='$newbalance', channel='$channel', status='1',datemade='$datemade' where orderid='$orderid'";
                        $this->db->query($sql);
                        
                        
                        echo "finished";
                        $sql = "select *, users.userID as xlid, tbl_rates.subid as nnsubid from tbl_subscription left join (users,tbl_rates) on (users.userID = tbl_subscription.userID and tbl_rates.subid = tbl_subscription.subid) where orderid='$orderid'";
                        $result = $this->db->query($sql);
                        foreach ($result->result() as $rl):
                            $address = $rl->email;
                            $username = $rl->username;
							$userID  = $rl->xlid;
                            $sbb = $rl->subscription;
							/*if($sub==2 || $sub==3 || $sub==4 || $sub==5){
							if(strtotime(date('Y-m-d'))<strtotime('2016-11-23')){
if($no_of_days>=30){
	//$naiend = strtotime("+14 day", $sdate);
	$mdate = date('Y-m-d');
	
		$naiend = date('Y-m-d',strtotime($mdate. "+14 days"));
	$dmx = "INSERT INTO tbl_subscription (userID, transactionid, subid, startdate, enddate, status, orderupdated, datemade, transaction_type)
	values ('$userID', 'promotional', '8', '$mdate','$naiend','1','$datemade','$datemade','indirect')";
	$this->db->query($dmx);
}
							}
					}
					*/     
                            $this->send_successfull_payment($address, $username, $sbb, $newamount, $transaction, $ref, $channel);

                        endforeach;
                    } else {
                        $sql = "update tbl_subscription set amountpaid = '$newamount', balance='$newbalance' where orderid='$orderid'";
                        $this->db->query($sql);
                        echo "balance";
                        
                         
                    }
                }
            } else {
                echo "could not complete";
              
            }
        } else {
            echo "transaction could not be completed";
             
        }
    }

    function finishtrans_archive() {
        //amount, 
        //  transaction - accountnumber
        // ref - mpesa reference
        if (isset($_POST['ref'])) {
            $transaction = $_POST['transaction'];
            $amount = $_POST['amount'];
            $archiveid = substr($transaction, 3);
            $channel = "MPESA";
            $ref = $_POST['ref'];
            $sql = "select * from tbl_archive_orders where archiveid='$archiveid'";
            $relt = $this->db->query($sql);
            if ($relt->num_rows != "") {
                foreach ($relt->result() as $rlt) {
                    $dbamount = $rlt->amount;
                    $amountpaid = $rlt->amountpaid;
                    $balance = $rlt->balance;
                    $newamount = $amountpaid + $amount;
                    $newbalance = $dbamount - $newamount;
                    if ($newamount >= $dbamount) {
                        $length = 15;
                        $papertoken = $this->generateRandomString($length);
                        $expirydate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) + (3600 * 12));
                        $sql = "UPDATE tbl_archive_orders set papertoken = '$papertoken',expirydate='$expirydate', amountpaid='$newamount', balance='$newbalance', channel='$channel',status='1' where archiveid='$archiveid'";
                        $this->db->query($sql);
                        echo "success";
                    } else {
                        $sql = "update tbl_archive_orders set amountpaid = '$newamount', balance='$newbalance' where archiveid='$archiveid'";
                        $this->db->query($sql);
                        echo "balance";
                    }
                }
            } else {
                echo "could not complete";
            }
        } else {
            echo "transaction could not be completed";
        }
    }

    function display_archive() {
        $userID = $this->session->userdata('admin_id');
        $datenow = date("Y-m-d H:i:s");
        $sql = "select * from tbl_archive_orders left join tbl_newspaper on tbl_newspaper.paperid=tbl_archive_orders.paperid where userID='$userID' and status='1' and expirydate>='$datenow'";
        return $this->db->query($sql);
    }

    function get_user_arc_set($papertoken) {
        $userID = $this->session->userdata('admin_id');
        $datenow = date("Y-m-d H:i:s");
        $sql = "select * from tbl_archive_orders left join tbl_newspaper on tbl_newspaper.paperid=tbl_archive_orders.paperid where userID='$userID' and status='1' and expirydate>='$datenow' and papertoken='$papertoken'";
        return $this->db->query($sql);
    }
 function get_user_arc_set_byid($paper) {
        $userID = $this->session->userdata('admin_id');
        $datenow = date("Y-m-d H:i:s");
        $sql = "select * from tbl_archive_orders left join tbl_newspaper on tbl_newspaper.paperid=tbl_archive_orders.paperid where userID='$userID' and status='1' and expirydate>='$datenow' and paperdate='$paper'";
        return $this->db->query($sql);
    }
    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function send_successfull_payment($address, $username, $sbb, $amount, $transaction, $ref, $channel) {
	$ndays = "";
	if($sbb=='Weekly'){
	$ndays = 2;
	}elseif($sbb=='Monthly'){
	$ndays = 4;
	}elseif($sbb=='Quartely'){
	$ndays = 12;
	}elseif($sbb=='Half Year'){
	$ndays = 24;
	}elseif($sbb=='Full Year'){
	$ndays = 48;
	}
	//to be removed in January
	//$sxdm = "During this festive season, your subscription has been extended by $ndays days. Merry Christmas and a Happy New Year";
	//
        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->clear();
        $this->email->to($address);
        $this->email->bcc('onlineaccounts@standardmedia.co.ke');
        $this->email->from('online@standardmedia.co.ke');
        $this->email->subject('Standard Digital e-Paper subscription');
        $msg = '<html>
    <body style="margin: 0px; padding: 0px">
       <div style="background: #EE1C23; margin-top: 0px; padding: 0px"><img src="' . base_url() . 'images/logo.png"></div>
       <div style="font-family: ' . "'Source Sans Pro'" . ', sans-serif;
    font-size: 13pt;
    line-height: 1.5em;
    color: #676d79;
    font-weight: 300; padding-top: 10px;">
      
       Dear <strong>' . $username . '</strong>,<br />
       <p>Your Standard Digital e-Paper payment has been made successfully.</p>
       <p><strong>Subscription:</strong> ' . $sbb . '</p>
       <p><strong>Transaction ID:<strong>  ' . $transaction . '</p>
       <p><strong>Transaction Reference Number:<strong>  ' . $ref . '</p>
       <p><strong>Amount Paid:<strong> Ksh. ' . number_format($amount, 2) . '</p>
       <p><strong>Payment Channel:<strong> ' . $channel . '</p>
       <p>To login to your account, visit <a href="' . base_url() . '" target="new">' . base_url() . '</a></p>
	  
       Thanks,<br />
       <strong>The Standard Digital Team</strong>
       </div>
    </body>
</html>';
        $this->email->message($msg);
        $this->email->send();
    }

    function confirm_order($orderid) {
        $sql = "select * from tbl_subscription where status='1 ' and orderid='$orderid'";
        $rest = $this->db->query($sql);
        $msg = "";
        if ($rest->num_rows == 1) {
            $msg = "Payment made successfully!";
            $return['ermsg'] = 1;
        } else {
            $sql = "select * from tbl_subscription where  orderid='$orderid'";
            $relt = $this->db->query($sql);
            foreach ($relt->result() as $r):
                $msg = "Please wait for 30 second then click on finish."
                        . "Total Amount: $r->amount."
                        . "Amount Paid: $r->amountpaid"
                        . "";
            endforeach;


            $return['ermsg'] = 0;
        }

        $return['message'] = $msg;
        $return["json"] = json_encode($return);


        echo json_encode($return);
    }

    function finish_archive($archiveid) {
        $sql = "select * from tbl_archive_orders where status='1 ' and archiveid='$archiveid'";
        $rest = $this->db->query($sql);
        $msg = "";
        if ($rest->num_rows == 1) {
            $msg = "Payment made successfully!";
            $return['ermsg'] = 1;
        } else {
            $sql = "select * from tbl_archive_orders where  archiveid='$archiveid'";
            $relt = $this->db->query($sql);
            foreach ($relt->result() as $r):
                $msg = "Please wait for 30 second then click on finish."
                        . "Total Amount: $r->amount."
                        . "Amount Paid: $r->amountpaid"
                        . "";
            endforeach;


            $return['ermsg'] = 0;
        }

        $return['message'] = $msg;
        $return["json"] = json_encode($return);


        echo json_encode($return);
    }

    function get_user_subscription() {
        $userID = $this->session->userdata('admin_id');
        $enddate = date('Y-m-d');
        $sql = "select * from tbl_subscription LEFT JOIN tbl_rates ON tbl_rates.subid=tbl_subscription.subid left join tbl_newspaper on tbl_newspaper.paperid=tbl_rates.paperid where userID='$userID' and enddate>='$enddate' and startdate<='$enddate' and tbl_subscription.status='1' order by orderid desc";
        return $this->db->query($sql);
    }
function get_number_ofdevices($edition){
        $userID = $this->session->userdata('admin_id');
$sql = "select distinct(IPaddress) from tbl_downloads where userID='$userID' and edition='$edition' limit 5";
$rel =  $this->db->query($sql);
return $rel;
}
    function create_order() {
        $sub = $this->input->post('sub');
        $userID = $this->session->userdata('admin_id');
        $today = date('Y-m-d');
        $enddate = "";
        $orderid = "";
        $sql = "select * from tbl_rates where subid='$sub'";
        $result = $this->db->query($sql);
        foreach ($result->result() as $rl):
            $no_of_days = $rl->no_of_days;
			if($no_of_days==1){
			$no_of_days=0;
			}
            $amount_ksh = $rl->amount_ksh;
			$paperid = $rl->paperid;
        endforeach;
		$enddate = date('Y-m-d');
        $date = date('Y-m-d');
		$newenddate = date('Y-m-d');
		//check if user has subscription
		$sql = "select enddate from tbl_subscription left join tbl_rates on tbl_rates.subid=tbl_subscription.subid left join tbl_newspaper on tbl_newspaper.paperid=tbl_rates.paperid where tbl_newspaper.paperid='$paperid' and tbl_subscription.userID='$userID' and tbl_subscription.status='1' and tbl_subscription.enddate>='$date'";
		$eprelt = $this->db->query($sql);
		//echo $sql;
		if($eprelt->num_rows==""){
        $date = strtotime(date('Y-m-d'));
        $date = strtotime("+$no_of_days day", $date);
        $enddate = date('Y-m-d', $date);
		}else{
		foreach($eprelt->result() as $ktn){
		$newenddate = $ktn->enddate;
		$date = $newenddate;
		$today = date('Y-m-d',strtotime($enddate. "+1 days"));
		//echo "<br />".$date;
		$enddate = date("Y-m-d",strtotime(trim($newenddate)));
		$enddate = date('Y-m-d',strtotime($enddate. "+$no_of_days days"));
		//echo "<br />".$enddate;
		//$enddate = strtotime(date("+$no_of_days day", $date));
		//$enddate = date('Y-m-d', $enddate);
		//echo $enddate;
		}
		}
        $sql = "insert into tbl_subscription (userID, subid,amount, startdate, enddate,transaction_type) VALUES ('$userID', '$sub','$amount_ksh','$today','$enddate','indirect')";
        $this->db->query($sql);
        $sql = "select * from tbl_subscription where userID='$userID' order by orderid desc limit 1";
        $relt = $this->db->query($sql);
        foreach ($relt->result() as $r):
            $orderid = $r->orderid;

        endforeach;
        return $orderid;
    }

    function check_sub($orderid) {

        $sql = "SELECT * from tbl_subscription where orderid='$orderid'";
        $relt = $this->db->
                query($sql);
        $status = "";
        if ($relt->num_rows != "") {
            foreach ($relt->result() as $rl) {
                $status = $rl->status;
            }
            if ($status == 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function get_sub($orderid) {
        $sql = "SELECT * from tbl_subscription left join tbl_rates on tbl_rates.subid=tbl_subscription.subid where orderid='$orderid'";
        return $this->db->query($sql);
    }

    function success() {

//************************ CHECK IF VALUES HAVE BEEN SET *****************
        if (isset($_POST['JP_PASSWORD'])) {

            $JP_TRANID = $_POST['JP_TRANID'];
            $JP_MERCHANT_ORDERID = $_POST['JP_MERCHANT_ORDERID'];
            $JP_ITEM_NAME = $_POST['JP_ITEM_NAME'];
            $JP_AMOUNT = $_POST['JP_AMOUNT'];
            $JP_CURRENCY = $_POST['JP_CURRENCY'];
            $JP_TIMESTAMP = $_POST['JP_TIMESTAMP'];
            $JP_PASSWORD = $_POST['JP_PASSWORD'];
            $JP_CHANNEL = $_POST['JP_CHANNEL'];

//$sharedkey, IS ONLY SHARED BETWEEN THE MERCHANT AND JAMBOPAY. THE KEY SHOULD BE SECRET ********************
//Make sure you get the key from JamboPay Support team
            $sharedkey = '6127482F-35BC-42FF-A466-276C577E7DF3';

            $str = $JP_MERCHANT_ORDERID . $JP_AMOUNT . $JP_CURRENCY . $sharedkey . $JP_TIMESTAMP;


//**************** VERIFY *************************
            if (md5(utf8_encode($str)) == $JP_PASSWORD) {
                $sql = "UPDATE tbl_subscription SET amount='$JP_AMOUNT', currency='$JP_CURRENCY', channel='$JP_CHANNEL',transactionid='$JP_TRANID', status='1' where orderid='$JP_MERCHANT_ORDERID'";
                $this->db->query($sql);
                return true;
                //VALID
                //if valid, mark order as paid
            } else {
                return false;
                //INVALID TRANSACTION
            }
        }
    }

    function process_paypal($orderid) {
        if (isset($_GET['tx'])) {
            $tx = $_GET['tx'];
            // Further processing
            // Init cURL
            $request = curl_init();

// Set request options
            curl_setopt_array($request, array
                (
                CURLOPT_URL => 'https://www.paypal.com/cgi-bin/webscr',
                CURLOPT_POST => TRUE,
                CURLOPT_POSTFIELDS => http_build_query(array
                    (
                    'cmd' => '_notify-synch',
                    'tx' => $tx,
                    'at' => "uINn4HzYAz0ADcgYq49qC5d4fjgaUAIAD1oBJkLTcKIkMjxazRCtkH2bciS",
                )),
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_HEADER => FALSE,
                    // CURLOPT_SSL_VERIFYPEER => TRUE,
                    // CURLOPT_CAINFO => 'cacert.pem',
                    //live: uINn4HzYAz0ADcgYq49qC5d4fjgaUAIAD1oBJkLTcKIkMjxazRCtkH2bciS
                    //sandbox: MlfEfTY4Uo-l2mV6iMqi-_CuCwkqQfB43ULXfr7CFQkxBQDzMWQQ-7yqHEi
            ));

// Execute request and get response and status code
            $response = curl_exec($request);
            $status = curl_getinfo($request, CURLINFO_HTTP_CODE);

// Close connection
            curl_close($request);
            if ($status == 200 AND strpos($response, 'SUCCESS') === 0) {
                $longstr = str_replace("\r", "", $response);
                $lines = split("\n", $longstr);
                $ppInfo = array();
                for ($i = 1; $i < count($lines); $i++) {
                    $parts = split("=", $lines[$i]);
                    if (count($parts) == 2) {
                        $ppInfo[$parts[0]] = urldecode($parts[1]);
                    }
                }
                if ($ppInfo["payment_status"] == 'Completed') {
                    // Further processing
                    $sql = "select * from tbl_subscription where orderid='$orderid'";
                    $relt = $this->db->query($sql);
                    if ($relt->num_rows != "") {
                        foreach ($relt->result() as $rlt) {
                            $amountpaid = $rlt->amount;
                            $balance = $rlt->balance;
                            $sub = $rlt->subid;
                            $sql = "select * from tbl_rates where subid='$sub'";
                            $result = $this->db->query($sql);
                            foreach ($result->result() as $rl):
                                $no_of_days = $rl->no_of_days;
                                //$amountpaid = $rlt->amount_ksh;
                            endforeach;
                            $startdate = date('Y-m-d');
                            $sdate = strtotime($startdate);
                            $edate = strtotime("+$no_of_days day", $sdate);
                            $enddate = date('Y-m-d', $edate);
                            $datemade = date('Y-m-d H:i:s');
                            $sql = "update tbl_subscription set amountpaid = '$amountpaid', balance='0', channel='PAYPAL', startdate='$startdate', enddate='$enddate', status='1', datemade='$datemade' where orderid='$orderid'";
                            $this->db->query($sql);
                            echo "finished";
                            $sql = "select *,users.userID as muid from tbl_subscription left join (users,tbl_rates) on (users.userID = tbl_subscription.userID and tbl_rates.subid = tbl_subscription.subid) where orderid='$orderid'";
                            $result = $this->db->query($sql);
                            foreach ($result->result() as $rl):
                                $address = $rl->email;
                                $username = $rl->username;
                                $sbb = $rl->subscription;
								$userID = $rl->muid;
                                $channel = "PAYPAL";
								/*	if($sub==2 || $sub==3 || $sub==4 || $sub==5){
							if(strtotime(date('Y-m-d'))<strtotime('2016-11-23')){
if($no_of_days>=30){
	//$naiend = strtotime("+14 day", $sdate);
	$mdate = date('Y-m-d');
	
		$naiend = date('Y-m-d',strtotime($mdate. "+14 days"));
	$dmx = "INSERT INTO tbl_subscription (userID, transactionid, subid, startdate, enddate, status, orderupdated, datemade, transaction_type)
	values ('$userID', 'promotional', '8', '$mdate','$naiend','1','$datemade','$datemade','indirect')";
	$this->db->query($dmx);
}
							}
					} */
                                $this->send_successfull_payment($address, $username, $sbb, $amountpaid, $orderid, $orderid, $channel);

                            endforeach;

                            $this->session->set_flashdata('msg', "Your payment has been successfully!");
                            echo "success";
                        }
                    }
                }else {
                    $this->session->set_flashdata('err', "Your Payment status is Pending on Paypal. 
				 Please ensure to login to your Epaper account before completing your payment on Paypal");
                    echo "failed";
                }
            } else {
                // Log the error, ignore it, whatever 
                $this->session->set_flashdata('err', "Error while processing your payment!");
                echo "failed";
            }
        } else {
            echo "failed";
            $this->session->set_flashdata('err', "Error while processing your payment!");
        }
    }
	function delete_old_download_data(){
$ddate = date('Y-m-d H:i:s', mktime(date('H'), date('i'), 0, date('m')-3, date('d'), date('Y')));
//echo $ddate;
$sql = "delete from tbl_downloads where datedownloaded<='$ddate'";
$this->db->query($sql);
}
function add_corporate(){
$sql = "select * from users where corporateid='11'";
$relt = $this->db->query($sql);
$cnt = 0;
foreach($relt->result() as $rl){
$userID = $rl->userID;
$sql ="select * from tbl_subscription where userID='$userID'";
$urelt = $this->db->query($sql);
if($urelt->num_rows!=""){
$cnt++;
echo $cnt.'<br/>';
$sql = "update tbl_subscription set corporateid='11' where userID='$userID' and status='1'";
$this->db->query($sql);
}

}
}
}

?>