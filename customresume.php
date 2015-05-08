<?php

	session_start();



	if (isset($_GET['edit'])){

		$_SESSION['fromedit'] = true;

		$_SESSION['firstrun'] = true;

		header("Refresh: 0; createresume.php");

		exit();

	} 

	

	include 'dboperation.php';

	$userid = $_GET['userid'];

	$rs = selectSeekerById($userid);

	$seekerinfo = mysqli_fetch_assoc($rs);

	$returnarray = selectResume($userid);

	$resume = $returnarray['Resume'];

	$aboutme = $resume['AboutMe'];

	$qualifications = $returnarray['Education'];

	$workxp = $returnarray['WorkExperience'];

	

	$resumeid = $resume['ResumeId'];

	$eduids = array();

	$workids = array();

	$_SESSION['ids'] = array(

								"ResumeId" => $resumeid

							);

							

?>



<!DOCTYPE html>

<html lang="en">



<head>



    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">

    <meta name="author" content="Alex" >



    <title>View Resume</title>





    <!-- Custom CSS -->

    <link href="resumecss.css" rel="stylesheet">



</head>



<body>



<?php



if($_COOKIE['usertype'] == "employer"){

 

	echo "<form method='post' action='email.php'>"; 

		echo "<input type='submit' name='submit' value='Contact Them!'/>"; 

	echo "</form>"; 

	

} elseif($_COOKIE['usertype'] == "seeker"){

	echo "<form method='get' >"; 

		echo "<input type='submit' name='edit' value='Edit My Resume'/>"; 

	echo "</form>"; 

} 

if( !is_null( $returnarray['Resume'] ) ){





?>



    <!-- Navigation -->

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

        <div class="container">

        		<br><b>Select an option to view details</b>

            <!-- Collect the nav links, forms, and other content for toggling -->

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav">

                    <li>

                        <a href="#contact">Contact Details</a>

                    </li>

                    <li>

                        <a href="#aboutme">About Me</a>

                    </li>

                    <li>

                        <a href="#education">Education</a>

                    </li>

                    <li>

                        <a href="#workexperience">Work Experience</a>

                    </li>

                </ul>

                <a href='homepage.php' >Take me back to the home page</a><br><br>

            </div>

            <!-- /.navbar-collapse -->

        </div>

        <!-- /.container -->

    </nav>



    <!-- Full Width Image Header -->

    <header class="header-image">

        <div class="headline">

            <div class="container">

                <h1> <?php echo $seekerinfo['FirstName'] . " " . $seekerinfo['LastName'] . "'s <br> Resume"; ?> </h1>

            </div>

        </div>

    </header>



    <!-- Page Content -->

    <div class="container">



        <hr class="featurette-divider">



        <!-- First Featurette -->

        <div class="featurette" id="contact">

            <img class="featurette-image img-circle img-responsive pull-right" src="contact.jpg">

            <h2 class="featurette-heading">Contact Information </h2>

            <p class="lead"> 

            		<font face="verdana" size="5">

            		<?php

						$address = (!is_null($seekerinfo['Address']) && $seekerinfo['Address'] != "") ? "Mailing Address: " . $seekerinfo['Address'] . "<br>" : "";

						$pphone = (!is_null($seekerinfo['PrimaryPhone']) && $seekerinfo['PrimaryPhone'] != "") ? "Primary Phone Number: " . $seekerinfo['PrimaryPhone'] . "<br>" : ""; 

						$sphone = (!is_null($seekerinfo['SecondaryPhone']) && $seekerinfo['SecondaryPhone'] != "") ? "Secondary Phone Number: " . $seekerinfo['SecondaryPhone'] . "<br>" : "";

						echo "Email Address: " . $seekerinfo['Email'] . "<br>";	

						echo $address . $pphone . $sphone . "<br><br>";				

					?> 

					</font>

			</p>

        </div>



        <hr class="featurette-divider">



		<!-- Second Featurette  -->       

        <div class="featurette" id="aboutme">

            <img class="featurette-image img-circle img-responsive pull-left" src="aboutme.jpg">

            <h2 class="featurette-heading"></h2>

            <p class="lead">

            	<font face="verdana" size="5">

            	<?php

					echo $aboutme . "<br>";

				?>

				</font>

			</p>

        </div>



        <hr class="featurette-divider">



        <!-- Third Featurette      -->   

        <div class="featurette" id="education">

            <img class="featurette-image img-circle img-responsive pull-right" src="education.jpg">

            <h2 class="featurette-heading">Education </h2>

            <p class="lead">

            	<font face="verdana" size="5">

            	<?php

						foreach($qualifications as $edu){

							array_push($eduids,$edu['EducationId']);

							echo $edu['Institution'] . "<br>";

							echo $edu['Level'] . " in " . $edu['Major'] . "<br>";

							echo "From " . $edu['StartDate'] . " to " . $edu['EndDate'] . "<br>";

							$gpa = (!is_null($edu['GPA']) && $edu['GPA'] != 0) ? "GPA: " . $edu['GPA'] . "<br>" : "";

							$grade = (!is_null($edu['Grade']) && $edu['Grade'] != 0) ? "Grade: " . $edu['Grade'] . "<br>" : "";

							$comments = (!is_null($edu['Comments']) && $edu['Comments'] != 0) ? $edu['Comments'] . "<br>" : "";

							echo $gpa . " " . $grade;

							echo $comments;

						}

						

						$_SESSION['ids']['EduIds'] = $eduids

				?>

				</font> 

            </p>

        </div>



        <hr class="featurette-divider">

        

        <!-- Fourth Featurette   -->      

        <div class="featurette" id="workexperience">

            <img class="featurette-image img-circle img-responsive pull-right" src="workexperience.jpg">

            <h2 class="featurette-heading">Work Experience </h2>

            <p class="lead"> 

            		<font face="verdana" size="5">

            		<?php

						foreach($workxp as $xp){

							array_push($workids,$xp['WorkExpId']);

							echo $xp['Company'] . "<br>";

							echo $xp['JobTitle'] . "<br>";

							echo "From " . $xp['StartDate'] . " to " . $xp['EndDate'] . "<br>";

							$desc = (!is_null($xp['JobDesc']) && $xp['JobDesc'] != 0) ? "Job Description: <br>" . $xp['JobDesc'] . "<br>" : "";

							echo $desc;

						}

					

						$_SESSION['ids']['WorkIds'] = $workids

					?> 

					</font>

			</p>

        </div>



        <hr class="featurette-divider">

        

    <?php 

		} else {

			echo "<h1>No Resume</h1><form method='get'><fieldset>";

			echo "You have not created a resume yet.<br><br>";

			echo "<input type='submit' id='createresume' name='createresume' value='Click Here To Create a Resume'><br><br>";

			

			echo "<a href='homepage.php' >Take me back to the home page</a>";

			echo "</fieldset></form>";

			

		}

	

	?>



        <!-- Footer   -->      

        <footer>

            <div class="row">

                <div class="col-lg-12">

                    <p>Copyright &copy; JobSeeker 2015</p>

                </div>

            </div>

        </footer>



    </div>

    





</body>



</html>

