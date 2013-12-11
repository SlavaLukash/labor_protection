<?php
	require("localization.php");

	require("database_pg.php");

	require("handler.php");


	$enable_compression = true;

	$report_key = sti_get_parameter_value("stimulsoft_report_key"); 
	$client_key = sti_get_parameter_value("stimulsoft_client_key","ViewerFx");

	$client_data = null;
	if (isset($HTTP_RAW_POST_DATA)) $client_data = $HTTP_RAW_POST_DATA;
	if ($client_data == null) $client_data = file_get_contents("php://input");


	/**
	 *  Directory, which contains the localization XML files.
	 */
	function sti_get_localization_directory()
	{
		return "localization";
	}


	/**
	 *  Returns .mrt or .mdc file by string ID that was set when running.
	 *  If necessary, it is possible to change the code for getting a report by its ID from file or from database.
	 */
	function sti_get_report($report_key)
	{
		/*switch ($report_key)
		{
			case "report1": return file_get_contents("/reports/Report.mrt");
			case "report2": return file_get_contents("/reports/Document.mdc");
		}*/

		if (file_exists("./reports/$report_key")) return file_get_contents("./reports/$report_key");

		// If there is no need to load the report, then the empty string will be sent
	       return "";
		
		// If you want to display an error message, please use the following format
		//return "ServerError: Report does not found " ;
	}


	/**
	 *  The code for saving a report can be placed in this function.
	 *  
	 *  Response to the client - report key and error code.
	 *  You can use the next error codes:
	 *     -1: the message box is not shown
	 *      0: shows the "Report is successfully saved" message
	 *  In other cases shows a window with the defined value
	 */
	function sti_save_report($report, $report_key, $new_report_flag)
	{
		// You can change the report key, if necessary
		//if ($new_report_flag == "True") $report_key = "MyReport.mrt";
		
		$error_code = "-1";
		if (file_put_contents("./reports/$report_key", $report) === false) $error_code = "Error when saving a report";
		
		return "<?xml version=\"1.0\" encoding=\"UTF-8\"?><SaveReport><ReportKey>$report_key</ReportKey><ErrorCode>$error_code</ErrorCode></SaveReport>";
	}


	/**
	 *  The function for changing values on parameters by their name in the SQL query.
	 *  Parameters can be set as {ParamName} in the SQL query.
	 *  By default values are taken according to the name of a parameter in the URL string or in the POST data.
	 */
	function sti_get_parameter($parameter_name, $default_value)
	{
		/*switch ($parameter_name)
		{
			case "ParameterName1": return "Value1";
			case "ParameterName2": return "Value2";
		}*/
		
		return $default_value;
	}


	/**
	 *  Getting the Connection String when requesting the client's Flash application to a database.
	 *  In this function you can change the Connection String of a report.
	 */
	function sti_get_connection_string($connection_type, $connection_string)
	{
		switch ($connection_type)
		{
			case "StiSqlDatabase": return "Data Source=SERVER\SQLEXPRESS;Initial Catalog=master;Integrated Security=True";
			case "StiMySqlDatabase": return "Server=localhost;Database=db_name;Port=3306;User=root;Password=;";
			case "StiOdbcDatabase": return "DSN=MS Access Database;DBQ=D:\NWIND.MDB;DefaultDir=D:;DriverId=281;FIL=MS Access;MaxBufferSize=2048;PageTimeout=5;UID=admin;";
			case "StiPostgreSQLDatabase": return "Server=localhost;Database=labor;Port=5432;User=postgres;Password=postgres123;";
			case "StiOracleDatabase": return "database=ORCL;user=SYSDBA;password=111;privilege=sysdba";
			case "StiFirebirdDatabase": return "server=localhost;database=/usr/local/firebird-2.1/data/test.fdb;user=SYSDBA;password=masterkey;";
		}
		
		//return $connection_string;
	}


	/**
	 *  Saving an exported report.
	 *  Response to the client - error code. Standard codes:
	 *      -1: the message box is not shown
	 *       0: shows the "Report is successfully saved" message
	 *  In other cases shows a window with the defined value
	 */
	function sti_export_report($format, $report_key, $file_name, $data)
	{
		if (file_put_contents("./exports/$file_name", $data) === false) return "Error when saving an exported report";
		return "-1";
	}


	/**
	 *  Send report by E-mail
	 *  Response to the client - error code. Standard codes:
	 *      -1: the message box is not shown
	 *       0: shows the "The email has been sent" message
	 *  In other cases shows a window with the defined value
	 */
	function sti_send_email_report($format, $report_key, $file_name, $data)
	{
		// Define the sender email
		$from = "webmaster@example.com";
		// Define the receiver email
		$to = "youraddress@example.com";
		// Define the email subject
		$subject = "Exported Report";
		// Define the email text body
		$body = "<p>This email contains the <b>$report_key</b> report file.</p>".
				"<p>Exported Report Format: <b>$format</b><p>";
		
		// Create a boundary string. It must be unique
		$separator = md5(date('r', time()));
		$headers = "";
		$eol = PHP_EOL;
		
		// Read the atachment file contents into a string, encode it with MIME base64, and split it into smaller chunks
		$attachment = chunk_split(base64_encode($data));
		
		// Define the headers we want passed. Note that they are separated with PHP_EOL
		$headers .= "From: ".$from.$eol;
		$headers .= "Reply-To: ".$from.$eol;
		$headers .= "MIME-Version: 1.0".$eol;
		$headers .= "Content-Type: multipart/mixed;charset=\"UTF-8\";boundary=\"".$separator."\"".$eol.$eol;
		$headers .= "Content-Transfer-Encoding: 7bit".$eol;
		$headers .= "This is a MIME encoded message.".$eol.$eol;
		$headers .= "--".$separator.$eol;
		$headers .= "Content-Type: application/octet-stream;name=\"".$file_name."\"".$eol;
		$headers .= "Content-Transfer-Encoding: base64".$eol;
		$headers .= "Content-Disposition: attachment".$eol.$eol;
		$headers .= $attachment.$eol.$eol;
		$headers .= "--".$separator.$eol;
		$headers .= "Content-Type: text/html;charset=\"UTF-8\";boundary=\"".$separator."\"".$eol.$eol;
		$headers .= $body.$eol.$eol;
		$headers .= "--".$separator.$eol;
		$headers .= "--".$separator."--";
		
		// Send the email
		$mail_sent = @mail($to, $subject, $body, $headers);
		
		// If the message is sent successfully print "-1". Otherwise print "Mail failed"
		return $mail_sent ? "-1" : "Mail failed";
	}


	// Processing client Flash application commands
	if (isset($client_key))
	{
		if (!function_exists("gzuncompress")) $enable_compression = false;
		
		if ($enable_compression && $client_key != "ViewerFx" && $client_key != "DesignerFx" && strlen($client_data) > 0)
		{
			$client_data = base64_decode($client_data);
			$client_data = gzuncompress($client_data);
		}
		
		$response = sti_client_event_handler($client_key, $report_key, $client_data, $enable_compression);
		
		if ($enable_compression && strlen($response) > 0 && $client_key != "ViewerFx" && $client_key != "DesignerFx")
		{
			$response = gzcompress($response);
			$response = base64_encode($response);
		}
		
		echo $response;
	}

?>