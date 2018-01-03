<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//define(LDAP_OPT_DIAGNOSTIC_MESSAGE, 0x0032);

class Ldap extends CI_Controller {
	public function __construct() { 
        parent::__construct(); 
        
      
     }
     public function test4_ldap(){
        //連到AD Server的帳號密碼
        $account="192.168.0.105\pinina";
        $password="#EDCvfr41024";
        $server="ADLight.tccg.gov.tw";
        //連線到AD server
        $conn=ldap_connect($server) or die("Could not connect to LDAP server");
        //以下兩行務必加上，否則AD無法在不指定OU下，作搜尋的動作
        ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($conn, LDAP_OPT_REFERRALS, 0);
        //連線bind帳號密碼
        $ldap_bd=ldap_bind($conn,$account,$password);
        //檢查帳號密碼是否正確
        if ($ldap_bd) {
            echo "Auth passed!";
        } else {
            echo "Auth failed!";
        }
     }

     public function test3_ldap(){
        $username = 'pinina'; // username to check
        $password = '#EDCvfr41024'; // password to check

        /**
         * Is it an Active Directory?
         *
         * <pre>
         * true = yes
         *        set the following values:
         *        SDB_AUTH_LDAP_HOST
         *        SDB_AUTH_LDAP_SSL
         *        SDB_AUTH_LDAP_BASE
         *        SDB_AUTH_LDAP_SEARCH
         *        SDB_AUTH_LDAP_USERDOMAIN
         * false = no, you have to supply an hostname
         *         and configure the following values:
         *         SDB_AUTH_LDAP_HOST
         *         SDB_AUTH_LDAP_PORT
         *         SDB_AUTH_LDAP_SSL
         *         SDB_AUTH_LDAP_BASE
         *         SDB_AUTH_LDAP_SEARCH
         *         SDB_AUTH_LDAP_USERDOMAIN
         * </pre>
         * @see SDB_AUTH_LDAP_HOST
         */
        define('SDB_AUTH_IS_AD', true);
        /**
         * Domain name of the LDAP Host or of the AD-Domain
         */
        define('SDB_AUTH_LDAP_HOST', 'ADLight.tccg.gov.tw');
        /**
         * LDAP Port?
         *
         * if {@link SDB_AUTH_IS_AD} = true, then the port will be read form DNS.
         */
        define('SDB_AUTH_LDAP_PORT', '389');
        /**
         * Use LDAPS (true) oder LDAP (false) connection?
         */
        define('SDB_AUTH_LDAP_SSL', false);
        /**
         * LDAP Base
         */
        define('SDB_AUTH_LDAP_BASE', 'CN=Users,DC=tccg.gov.tw,DC=de');
        /**
         * LDAP Search, to find a user
         *
         * %s will be replaced by the username.<br>
         * z.B. CN=%s
         */
        define('SDB_AUTH_LDAP_SEARCH', '(&(sAMAccountName=%s)(objectclass=user)(objectcategory=person))');
        /**
         * Die LDAP Domain des Benutzers
         *
         * if the username doesnt contain a domain append this domain to it.<br>
         * in case this is empty, nothing will be appended.
         */
        define('SDB_AUTH_LDAP_USERDOMAIN', 'tccg.gov.tw');
        /**
         * Path to LDAP Search
         *
         * Will give back better error messages
         * ( leave empty in case you don't want to have it. )
         */
        define('SDB_AUTH_LDAP_SEARCHBIN', '/usr/bin/ldapsearch');




                $ldap_error_codes=array(
                '525' => 'Username doesnt exist.',
                '52e' => 'Wrong password.',
                '530' => 'You cannot login at this time.',
                '531' => 'You cannot login from this host.',
                '532' => 'Your password was expired.',
                '533' => 'Your account has been deactivated.',
                '701' => 'Your account was expired.',
                '773' => 'Please set another password (at your workstation) before you login.',
                '775' => 'Your account has been locked.',
                );


          if(SDB_AUTH_LDAP_SSL) $dcs=dns_get_record("_ldaps._tcp.".SDB_AUTH_LDAP_HOST, DNS_SRV); else $dcs=dns_get_record("_ldap._tcp.".SDB_AUTH_LDAP_HOST, DNS_SRV);
          shuffle($dcs);

          $_LDAP_ATTRS=array('cn', 'sn', 'description', 'givenName', 'distinguishedName', 'displayName', 'memberOf', 'name', 'sAMAccountName', 'sAMAccountType', 'objectClass', 'objectCategory');
          if(SDB_AUTH_LDAP_USERDOMAIN!='' && strstr($username, '@')===false) {
                $username=$username.'@'.SDB_AUTH_LDAP_USERDOMAIN;
          }
          $status=array();
          $status['CN']='';
          $status['displayName']='';
          $status['description']='';
          $status['distinguishedName']='';
          $status['groups']=array();
          $status['RC']=array();
          $status['connected']=false;
          $status['user_exists']=false;
          $status['is_in_team']=false;

        foreach($dcs as $_LDAP_HOST) {
        $_LDAP_PORT=$_LDAP_HOST['port'];
        $_LDAP_HOST=$_LDAP_HOST['target'];
        // check connection first ( http://bugs.php.net/bug.php?id=15637 )
        $sock=@fsockopen($_LDAP_HOST, $_LDAP_PORT, $errno, $errstr, 1);
        @fclose($sock);
        if($errno!=0) continue;

        // then do a "connect"... ( the real connect happens with bind )
        $ds=@ldap_connect(( SDB_AUTH_LDAP_SSL ? "ldaps://" : "ldap://" ).$_LDAP_HOST.":".$_LDAP_PORT."/");
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        // are we connected? actually, this will always return true
        if(is_resource($ds)) {
            $status['connected']=true;
            // login sucessful? actually also connection test
            if(@ldap_bind($ds, $username, $password)) {
                // search
                $sr=ldap_search($ds, SDB_AUTH_LDAP_BASE, sprintf(SDB_AUTH_LDAP_SEARCH, $usernode), $_LDAP_ATTRS);
                // suche successful?
                if(is_resource($sr)) {

                    // fetch entries
                    $info = ldap_get_entries($ds, $sr);
                    if(isset($info['count']) && $info['count']>0) {
                        $status['user_exists']=true;
                    }
                    // close search result
                    ldap_free_result($sr);
                    $status['CN']=$info[0]['cn'][0];
                    $status['description']=$info[0]['description'][0];
                    $status['displayName']=$info[0]['displayname'][0];
                    $status['distinguishedName']=$info[0]['distinguishedname'][0];
                    // is the user in the dexteam?
                    for($i=0; $i<$info[0]['memberof']['count']; $i++) {
                        $status['groups'][]=$info[0]['memberof'][$i];
                        // IS IN TEAM CHECK 
                        if(substr($info[0]['memberof'][$i], 0, strlen('CN=DexTeam,'))=='CN=DexTeam,') $status['is_in_team']=true; 
                    }

                    $status['RC']['code']=ldap_errno($ds);
                    $status['RC']['string']=ldap_error($ds);
                    ldap_close($ds);
                    break;
                }
                else {
                    $status['RC']['code']=ldap_errno($ds);
                    $status['RC']['string']=ldap_error($ds);
                    ldap_close($ds);
                    break;
                }
            }
            else {
                $status['RC']['code']=ldap_errno($ds);
                $status['RC']['string']=ldap_error($ds);
                // do we want better error messages?
                if(SDB_AUTH_LDAP_SEARCHBIN!='' && is_executable(SDB_AUTH_LDAP_SEARCHBIN)) {
                    $status['RC']['ldapsearchrc']='';
                    $status['RC']['ldapsearchtxt']=array();
                    exec(SDB_AUTH_LDAP_SEARCHBIN.' -x -H '.escapeshellarg(( SDB_AUTH_LDAP_SSL ? "ldaps://" : "ldap://" ).$_LDAP_HOST.":".$_LDAP_PORT."/").' -D '.escapeshellarg($username).' -w '.escapeshellarg($password).' 2>&1', $status['RC']['ldapsearchtxt'], $status['RC']['ldapsearchrc']);
                    if($status['RC']['ldapsearchrc']!=0) {
                        if(preg_match("/data ([^, ]+),/", $status['RC']['ldapsearchtxt'][1], $matches)) {
                            if(isset($ldap_error_codes[$matches[1]])) {
                                $status['RC']['code']=$matches[1];
                                $status['RC']['string']=$ldap_error_codes[$matches[1]];
                            }
                        }
                        unset($status['RC']['ldapsearchrc']);
                        unset($status['RC']['ldapsearchtxt']);
                    }
                }
                ldap_close($ds);
                break;
            }
        }
        else {
            continue;
        }
        }
     }

     public function test2_ldap(){
        $domain = 'ADLight.tccg.gov.tw'; //設定網域名稱
        $dn="cn=pinina,ou=020014,ou=387020000a,ou=387000000a,ou=taichung,dc=tccg,dc=gov,dc=tw";
         
        $user = 'pinina'; //設定欲認證的帳號名稱
        $password = '@WSXcde31024'; //設定欲認證的帳號密碼
         
        // 使用 ldap bind 
        $ldaprdn = $user . '@' . $domain; 
        // ldap rdn or dn 
        $ldappass = $password; // 設定密碼
         
        // 連接至網域控制站
        //$ldapconn = ldap_connect($domain) or die("無法連接至 $domain");
        $ldapconn = ldap_connect($domain) or die("無法連接至 $domain");
        
         
        // 如果要特別指定某一部網域主控站(DC)來作認證則上面改寫為
        //$ldapconn = ldap_connect('dc.domain.com) or die("無法連接至 dc.domain.com"); 
        // 或 
        // $ldapconn = ldap_connect('dc2.domain.com)or die("無法連接至 dc2.domain.com"); 
        //ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);
         
        //以下兩行務必加上，否則 Windows AD 無法在不指定 OU 下，作搜尋的動作
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
        ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);
        

         
        if ($ldapconn) 
        { 
             // binding to ldap server
             echo("連結$domain
            ".$ldaprdn.",".$ldappass."
            ");
             //$ldapbind = ldap_bind($ldapconn, $user, $password);     
             //$ldapbind = ldap_bind($ldapconn, "ADLight.tccg.gov.tw\pinina", $password);
             $ldapbind = ldap_bind($ldapconn, "CN=pinina,DC=tccg,DC=gov,DC=tw", '@WSXcde31024');
             //$ldapbind = ldap_bind($ldapconn, "cn=pinina,o=tccg.gov.tw", $password);
             //$ldapbind = ldap_bind($ldapconn, "pinina@tccg.gov.tw", $password);
             //$ldapbind = ldap_bind($ldapconn, "tccg.gov.tw\pinina", $password);

             //$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);     
             //$ldapbind = ldap_bind($ldapconn);     
             // verify binding     
            if ($ldapbind) {         
              $filter = "(sAMAccountName=$user)";        
              $result = @ldap_search($ldapconn, $dn, $filter);        
              if($result==false) 
               echo "認證失敗(找不到 $user)";        
              else
              {            
               echo "認證成功...";             
               //取出帳號的所有資訊             
               $entries = ldap_get_entries($ldapconn, $result);
               $data = ldap_get_entries( $ldapconn, $result );
                
               echo $data ["count"] . " entries returned\n";
                
               for($i = 0; $i <= $data ["count"]; $i ++) {
                for($j = 0; $j <= $data [$i] ["count"]; $j ++) {
                 echo "[$i:$j]=".$data [$i] [$j] . ": " . $data [$i] [$data [$i] [$j]] [0] . "\n";
                }
               }        
            }    
        } 
         else
         {         
          echo "認證失敗...";     
         } 
        }
        //關閉LDAP連結
        echo(ldap_error($ldapconn)."<br>");
        ldap_close($ldapconn);
     }

	public function test_ldap(){
		// $ds = ldap_connect("localhost");
        // $ds = ldap_connect("192.168.0.105");//民政局ldap server
        $ds = ldap_connect("192.168.0.105");
		echo "connect result is " . $ds . "<br />";

        // Set some ldap options for talking to 
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

        if ($ds) { 
            echo "Binding ..."; 
            // $r=ldap_bind($ds);     // this is an "anonymous" bind, typically read-only access
            $r=ldap_bind($ds, "pinina@ADLight.tccg.gov.tw", '@WSXcde31024');
            // $bind=ldap_bind($ds, "CN=pinina,OU=020014,OU=387020000A,OU=387000000A,OU=Taichung,CN=ADLight,DC=tccg,DC=gov,DC=tw", '@WSXcde31024');
            // $bind=ldap_bind($ds, "cn=pinina,ou=020014,ou=387020000A,ou=387000000A,ou=Taichung,cn=ADLight,dc=tccg,dc=gov,dc=tw@ADLight.tccg.gov.tw", '@WSXcde31024');
            
// if ($bind) {
    if (ldap_get_option($ds, LDAP_OPT_DIAGNOSTIC_MESSAGE, $extended_error)) {
        echo "Error Binding to LDAP: $extended_error". "<br />";
    } else {
        echo "Error Binding to LDAP: No additional information is available.". "<br />";
    }
// }else{
//     echo "bind return false";
// }

            echo "Bind result is " . $bind . "<br />";

            echo "Searching for (sn=S*) ...";
            // Search surname entry
            $sr=ldap_search($ds, "o=My Company, c=US", "sn=S*");  
            echo "Search result is " . $sr . "<br />";

            echo "Number of entries returned is " . ldap_count_entries($ds, $sr) . "<br />";

            echo "Getting entries ...<p>";
            $info = ldap_get_entries($ds, $sr);
            echo "Data for " . $info["count"] . " items returned:<p>";

            for ($i=0; $i<$info["count"]; $i++) {
                echo "dn is: " . $info[$i]["dn"] . "<br />";
                echo "first cn entry is: " . $info[$i]["cn"][0] . "<br />";
                echo "first email entry is: " . $info[$i]["mail"][0] . "<br /><hr />";
            }

            echo "Closing connection";
            ldap_close($ds);

        } else {
            echo "<h4>Unable to connect to LDAP server</h4>";
        }		
	}
}
