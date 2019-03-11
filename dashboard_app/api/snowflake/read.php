<?php

require("../../config/Snowflake.php");

session_start();

$sql= "SELECT userid, username, department FROM DDP_STAGING_LEOCATE5.LEOCATE5.USERS WHERE username = 'dev'";

$rs=odbc_exec($conn_id,$sql);

// Test if username exists
if ($rs) {

  // Add message that users were foung
  while($result[] = odbc_fetch_array($rs)) {
  }
  odbc_free_result($rs);

  // Convert to JSON output
  echo json_encode($result);

}else{
    // Alert no user matching entered username
    $result['success'] = false;
    $result['msg'] = "No users found.";
}

odbc_close($conn_id);
