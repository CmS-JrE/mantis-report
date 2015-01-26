<html>
<head>
	<title>Report Issue</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="report.css">
</head>
<body>

<h1>Report Issue</h1>

<?php

$ini_array = parse_ini_file("report.ini");

$validationErrors = array();

if(!$_POST["Summary"]) {
	$validationErrors[] = "Missing summary";
}

if(!$_POST["Description"]) {
	$validationErrors[] = "Missing description";
}

if(count($validationErrors) > 0) {
	echo "<div class=\"alert alert-danger\">";
	echo "<p>A problem occurred:</p>";
	echo "<ul>";
	foreach($validationErrors as $validationError) {
		echo "<li>" . $validationError . "</li>";
	}
	echo "</ul>";
	echo "</div>";
} else {

	$additionalInformation = "Issue reported through anonymous form";
	
	if($_POST["contact"]) {
		$additionalInformation .= "\n\n" . "Contact information:" . "\n\n" . $_POST["contact"];
	}
	
	$issue = array(
		"project" => array("name" => $ini_array["project"]),
		"category" => $_POST["Category"],
		"summary" => $_POST["Summary"],
		"description" => $_POST["Description"],
		"additional_information" => $additionalInformation
	);
	
	$request = array(
		"username" => $ini_array["username"],
		"password" => $ini_array["password"],
		"issue" => $issue
	);
	
	try {
		$soapClient = new SoapClient($ini_array["mantisConnectUrl"] . "?wsdl");
		$result = $soapClient->__call("mc_issue_add", $request); 
		
		echo "<div class=\"alert alert-success\">";
		echo "<p>Created issue #" . $result . ".</p>";
		echo "<p>Thank you!</p>";
		echo "</div>";
	} catch (SoapFault $fault) {
		echo "<div class=\"alert alert-danger\">";
		echo "<p>A problem occurred:</p>";
		echo "<ul>";
		echo "<li>" . $fault->faultcode . "</li>";
		echo "<li>" . $fault->faultstring . "</li>";
		echo "</ul>";
		echo "<p>Please <a href=\"" . $ini_array["administratorHref"] . "\">contact the administrator of this form</a> for support on submitting your issue</p>";
		echo "</div>";
	} 
}

?>

<p>This is the information that you entered:</p>

<form class="form-horizontal">
	<div class="form-group">
		<label class="col-sm-2 control-label">Category:</label>
		<div class="col-sm-10">
			<p class="form-control"><?php echo $_POST["Category"] == "Defects" ? "Defect" : "Feature request"; ?></p>
		</div>
	</div>
	<?php if($_POST["Summary"]): ?>
	<div class="form-group">
		<label class="col-sm-2 control-label">Summary:</label>
		<div class="col-sm-10">
			<p class="form-control"><?php echo $_POST["Summary"]; ?></p>
		</div>
	</div>
	<?php endif ?>
	<?php if($_POST["Description"]): ?>
	<div class="form-group">
		<label class="col-sm-2 control-label">Description:</label>
		<div class="col-sm-10">
			<p class="form-control"><?php echo str_replace("\n", "<br/>", $_POST["Description"]); ?></p>
		</div>
	</div>
	<?php endif ?>
	<?php if($_POST["contact"]): ?>
	<div class="form-group">
		<label class="col-sm-2 control-label">Contact information:</label>
		<div class="col-sm-10">
			<p class="form-control"><?php echo str_replace("\n", "<br/>", $_POST["contact"]); ?></p>
		</div>
	</div>
	<?php endif ?>
</form>

<?php

if(count($validationErrors) > 0) {
	echo "<p><a href=\"report.html\">Go back to the form</a></p>";
}

?>

</body>
</html>