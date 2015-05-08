<?php
	session_start();
	include 'dboperation.php';
	$aboutmedefault = "Enter a brief description of yourself here";
	$aboutmestick = isset( $_POST['aboutme'] ) ? $_POST['aboutme'] : "Enter a brief description of yourself here";
	if( isset( $_POST['addqualification'] ) ){
		$_SESSION['numEducation']++;
	} else if( isset ( $_POST['addwork'] ) ) {
		$_SESSION['numWork']++;
	} else if ( isset( $_POST['createresume'] ) ){
		$qualifications = array();
		$numEducation = $_SESSION['numEducation'];
		for($i = 0; $i < $numEducation; $i++){
			$gpa = isset( $_POST['gpa' . $i] ) ? $_POST['gpa' . $i] : "null";
			$grade = isset( $_POST['grade' . $i] ) ? $_POST['grade' . $i] : "null";
			$default = "Enter any other information here";
			$comments = ( $_POST['comments' . $i] != "" && $_POST['comments' . $i] != $default) ? $_POST['comments' . $i] : "null";
			$qualification = array(
				"Institution" => $_POST['institution' . $i],
   	 		"QualName" => $_POST['qualification' . $i],
   	 		"Level" => $_POST['level' . $i],
   	 		"Major" => $_POST['major' . $i],
   	 		"StartDate" => $_POST['startdate' . $i],
   	 		"EndDate" => $_POST['enddate' . $i],
   	 		"GPA" => $gpa,
   	 		"Grade" => $grade,
   	 		"Comments" => $comments
			);
			$qualifications[$i] = $qualification;
		}
		$workxp = array();
		$numWork = $_SESSION['numWork'];
		for($i = 0; $i < $numWork; $i++){
			$default = "Enter a brief description of your role";
			$jobdesc = ( $_POST['jobdesc' . $i] != "" && $_POST['jobdesc' . $i] != $default) ? $_POST['comments' . $i] : "null";
			$role = array(
				"JobTitle" => $_POST['jobtitle' . $i],
   	 		"Company" => $_POST['company' . $i],
   	 		"StartDate" => $_POST['startdatew' . $i],
   	 		"EndDate" => $_POST['enddatew' . $i],
   	 		"JobDesc" => $jobdesc
			);
			$workxp[$i] = $role;
		}
		$aboutme = ( $_POST['aboutme'] != "" && $_POST['aboutme'] != $aboutmedefault) ? $_POST['aboutme'] : "null";
		insertResume($aboutme,$qualifications,$workxp);
			
	} else {
		$_SESSION['numEducation'] = 1;
		$_SESSION['numWork'] = 1;
	}
?>

<!DOCTYPE html>

	<html lang="en">
	
	<head>
	     <meta charset="utf-8" >
	     <title>Create New Resume</title>
	     <link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
	
		<h1>New Resume</h1>
			
		<form name="resumeform" id="resumeform" method="post" onsubmit="return validateResumeForm()">
	
			
			<fieldset>
				
				<input type="hidden" name="op" value="insert">			
				
				<div style="float:left; overflow:hidden; ">
					<h1>About Me:</h1> <br><textarea id="aboutme" name="aboutme" form="resumeform"><?php echo $aboutmestick ?> </textarea><p id="aboutmeerror"></p><br><br>
					<?php
						displayEducation();
						displayWork();
					?> 
					<br><br>
					<input type="submit" id="createresume" name="createresume" value="Submit Completed Resume"><br><br>
					
					<a href="index.php" >Take me back to the home page</a>												
					
				</div>
	
			</fieldset>	
			
		</form>
		
	</body>
	
</html>

<?php



function displayEducation(){

	$numEducation = $_SESSION['numEducation'];
	
	$eduString = "<b>Education</b><br>";
	
	for($i = 0; $i < $numEducation; $i++){	
		$institution = isset($_POST['institution'.$i]) ? $_POST['institution'.$i] : "";
		$qualification = isset($_POST['qualification'.$i]) ? $_POST['qualification'.$i] : "";	
		$level = isset($_POST['level'.$i]) ? $_POST['level'.$i] : "Bachelor";	
		$major = isset($_POST['major'.$i]) ? $_POST['major'.$i] : "Other";			
		$startdate = isset($_POST['startdate'.$i]) ? $_POST['startdate'.$i] : "YYYY-MM-DD";
		$enddate = isset($_POST['enddate'.$i]) ? $_POST['enddate'.$i] : "YYYY-MM-DD";	
		$gpa = isset($_POST['gpa'.$i]) ? $_POST['gpa'.$i] : "";	
		$grade = isset($_POST['grade'.$i]) ? $_POST['grade'.$i] : "";	
		$comments = isset($_POST['comments'.$i]) ? $_POST['comments'.$i] : "Enter any other information here";	
		$eduString .= "<fieldset>" 
							. "*Organization/Institution name: <input type='text' id='institution$i' name='institution$i' value='$institution' ><p id='institutionerror$i'></p><br>"
							. "*Qualification Name: <input type='text' id='qualification$i' name='qualification$i' value='$qualification' ><p id='qualificationerror$i'></p><br>"
							. "*Level: <select required name='level$i' id='level$i' >
									<option value='' > Select One </option>
									<option value='High School Diploma or Equivalent' > High School Diploma or Equivalent </option>
									<option value='Associate' > Associate </option>
									<option value='Bachelor' > Bachelor </option>
									<option value='Graduate' > Graduate</option>
									<option value='Master' > Master </option>
									<option value='Doctoral' > Doctoral</option>
							  </select><br>"
							. "*Major: <select required name='major$i' id='major$i' >
									<option value='' > Select One </option>
									<option value='Accounting' > Accounting </option>
									<option value='Advertising' > Advertising </option>
									<option value='Business Economics' > Business Economics</option>
									<option value='E-commerce' > E-commerce </option>
									<option value='Finance' > Finance </option>
									<option value='Hospital and Health Care Administration' > Hospital and Health Care Administration </option>
									<option value='International Business' > International Business </option>
									<option value='Management' > Management</option>
									<option value='Marketing' > Marketing </option>
									<option value='Operations Management' > Operations Management </option>
									<option value='Real Estate' > Real Estate </option>
									<option value='Database Management' > Database Management </option>
									<option value='Digital Arts' > Digital Arts</option>
									<option value='Programming' > Programming </option>
									<option value='Software Development' > Software Development </option>
									<option value='Engineering' > Engineering </option>
									<option value='Communications' > Communications </option>
									<option value='Counseling' > Counseling </option>
									<option value='Education' > Education </option>
									<option value='English' > English </option>
									<option value='Foreign Languages' > Foreign Languages </option>
									<option value='Literature' > Literature </option>
									<option value='Philosophy' > Philosophy</option>
									<option value='Biology' > Biology </option>
									<option value='Chemistry' > Chemistry </option>
									<option value='Mathematics' > Mathematics </option>
									<option value='Physics' > Physics </option>
									<option value='American Studies' > American Studies </option>
									<option value='Economics' > Economics </option>
									<option value='History' > History </option>
									<option value='Political Science' > Political Science </option>
									<option value='Psychology' > Psychology </option>
									<option value='Sociology' > Sociology </option>
									<option value='Other' > Other </option>
							  </select><br>"
							. "*Start Date: <input type='date' id='startdate$i' name='startdate$i' value='$startdate' ><p id='startdateerror$i'></p><br>"
							. "*End Date: <input type='date' id='enddate$i' name='enddate$i' value='$enddate' ><p id='enddateerror$i'></p><br>"
							. "GPA: <input type='number' step='0.01' name='gpa$i' id='gpa$i' value='$gpa' ><p id='gpaerror$i'></p><br>"
							. "Grade: <input type='number' step = '0.01' name='grade$i' id='grade$i' value='$grade' ><p id='gradeerror$i'></p><br>"
							. "Comments: <br><textarea name='comments$i' id='comments$i' form='resumeform'>$comments</textarea><p id='commentserror$i'></p><br>"
							. "</fieldset>";
	}
	$disabled = $numEducation >= 4 ? "disabled" : "";
	$msg = $numEducation >= 4 ? "Only your four most recent qualifications are required" : "";
	$eduString .=	"<input type='submit' id='addqualification' name='addqualification' value='Add Another Qualification' $disabled>$msg<br>";
	
	echo $eduString;
	
}

function displayWork(){

	$numWork = $_SESSION['numWork'];
	
	$workString = "<b>Work Experience</b><br>";
	
	for($i = 0; $i < $numWork; $i++){	
		$jobtitle = isset($_POST['jobtitle'.$i]) ? $_POST['jobtitle'.$i] : "";
		$company = isset($_POST['company'.$i]) ? $_POST['company'.$i] : "";	
		$startdate = isset($_POST['startdatew'.$i]) ? $_POST['startdatew'.$i] : "YYYY-MM-DD";
		$enddate = isset($_POST['enddatew'.$i]) ? $_POST['enddatew'.$i] : "YYYY-MM-DD";	
		$jobdesc = isset($_POST['jobdesc'.$i]) ? $_POST['jobdesc'.$i] : "Enter a brief description of your role";	
		$workString .= "<fieldset>" 
							. "*Job Title: <input type='text' id='jobtitle$i' name='jobtitle$i' value='$jobtitle' ><p id='jobtitleerror$i'></p><br>"
							. "*Company Name: <input type='text' id='company$i' name='company$i' value='$company' ><p id='companyerror$i'></p><br>"
							. "*Start Date: <input type='date' id='startdatew$i' name='startdatew$i' value='$startdate' ><p id='startdateerrorw$i'></p><br>"
							. "*End Date: <input type='date' id='enddatew$i' name='enddatew$i' value='$enddate' ><p id='enddateerrorw$i'></p><br>"

							. "Job Description: <br><textarea name='jobdesc$i' id='jobdesc$i' form='resumeform'>$jobdesc</textarea><p id='jobdescerror$i'></p><br>"
							. "</fieldset>";
	}
	$disabled = $numWork >= 4 ? "disabled" : "";
	$msg = $numWork >= 4 ? "Only your four most recent qualifications are required" : "";
	$workString .=	"<input type='submit' id='addwork' name='addwork' value='Add Further Work Experience' $disabled>$msg<br>";
	
	echo $workString;
	
}

?>

				

