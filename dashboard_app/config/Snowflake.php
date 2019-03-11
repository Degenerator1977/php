<?php

	// ODBC native
	$dsn = "Driver=SnowflakeDSIIDriver;Server=terramarnetworks.eu-central-1.snowflakecomputing.com;Warehouse=DASHBOARD_WH";
	$user = "RGRAHAM";
	$pwd = "Bebechou1988";

	$conn_id = odbc_connect($dsn, $user, $pwd);

	// Check connection
	if(!$conn_id)
    {
        printf("Connection Failed: %s\n", odbc_error());
        exit();
    }

?>
