<!-- http://cssdeck.com/labs/twitter-bootstrap-contact-form -->
<link class="cssdeck" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.2.2/css/bootstrap.min.css">


<form method='get' class="well span8">
  <div class="row">
		<div class="span3">
		
			<label>First Name</label>
			<input type="text" name="FirstName" class="span3" placeholder="Your First Name">
			<label>Last Name</label>
			<input type="text" name="LastName"class="span3" placeholder="Your Last Name">
			<label>Company</label>
			<input type="text" name="company" class="span3" placeholder="Your Company">
			<label>Email Address</label>
			<input type="text" name="employeremail" class="span3" placeholder="Your email address">
			<label>Subject
			<select id="subject" name="subject" class="span3">
				<option value="na" selected="">Choose One:</option>
				<option value="Phone Interview">Phone Interview</option>
				<option value="In-Person Interview">In-Person Interview</option>
				<option value="Informational Phone Call">Informational Phone Call</option>
			</select>
			</label>
		</div>
		<div class="span5">
			<label>Message</label>
			<textarea name="message" id="message" class="input-xlarge span5" rows="10"></textarea>
		</div>
	
		<button type="submit" class="btn btn-primary pull-right">Send</button>
	</div>
</form>

<?php
$emailsubject = $_GET['subject']; 
$emailmessage = $_GET['message']; 
$company = $_GET['company'];

$to      = $seekerinfo['Email'];
$subject = $emailsubject;
$message = $emailmessage;
$headers = 	'From: JobSeeker' . "\r\n" .
    		'Reply-To: employeremail' . "\r\n" .
    		'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?> 
