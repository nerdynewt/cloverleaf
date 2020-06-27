<!-- TO DO:
    - UPLOAD CLOUD SIGN IN THE BOX -->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Software Development Group NISER" />
        <meta name="description" content="Write your report in minutes using markdown" />
        <title>HOME | CLOVERLEAF</title>
        <!-- styles -->
        <link rel="stylesheet" href="styles/styles.css" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <div class="container">
            <!-- nav -->
            <div class="navbar">
                <div class="nav-left">
                    <div class="nav-link">
                        <a href="https://github.com/sdgniser/reportinator"><i class="fa fa-github fa-2x"></i></a>
                    </div>
                    <div class="nav-link">
                        <a href="about.html"><i class="fa fa-book fa-2x"></i></a>
                    </div>
                    <div class="nav-link">
                        <a href="https://github.com/sdgniser/reportinator/blob/master/LICENSE"><i class="fa fa-balance-scale fa-2x"></i></a>
                    </div>                    
                </div>
                <div class="nav-right">
                    <div class="nav-link">
                        <a href="https://sdgniser.github.io"><i class="fa fa-bolt"></i> sdgniser</a>
                    </div>
                </div>
            </div>
            <!-- form -->
            <div class="form">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <!-- drag and drop -->
                    <div class="draganddrop">
                        <div class=drag>
                            <input id="files" type="file" class="upload" name="file[]" value="" multiple/>
                        </div>
                        
                    </div>
                    <!-- number of uploads -->
                    <h5 id="number"></h5>
                    <!-- class selector -->
                    <h3>CHOOSE YOUR WARRIOR</h3>
                    <div class="cc-selector">
                        <input id="double" type="radio" name="class" value="double">
                        <label class="drinkcard-cc double" for="double"></label>
                        <input id="single" type="radio" name="class" value="single">
                        <label class="drinkcard-cc single"for="single"></label>
                    </div>
                    <!-- name and affiliation form -->
                    <div class="credentials">
                        <div class="name">
                            <input id="credentials" type="text" placeholder="YOUR NAME" name="username">
                        </div>
                        <div class="affil">
                            <input id="credentials" type="text" placeholder="YOUR COLLEGE" name="affiliation">
                        </div>
                    </div>
                    <!-- submit -->
                    <div class="submit">
                        <button type="submit" name="submit-button" value="submit">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
<script src="scripts/main.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</html>

<?php
function clean($string) {
	return preg_replace('/[^A-Za-z0-9\-i\ \,\(\)]/', '', $string);
}
function hyphenate($string) {
	$string = str_replace(' ', '-', $string);
	return strtolower($string);
}
function get_option($string) {
	$defaults = array(
		'username' => 'John Doe',
		'affiliation' => 'University',
		'class' => 'double'
	);
	if(!isset($_POST[$string]) OR $_POST[$string] == "") {
		$val = $defaults[$string];
	}
	else {
		$val = $_POST[$string];
	}
	return $val;

}
$user_name = clean(get_option('username'));
$user_affiliation = clean(get_option('affiliation'));
$folder_name = hyphenate($user_name);
$target_dir = "uploads/".$folder_name."/";
$log_file = $target_dir."reportinator.log";
$class_file = clean(get_option('class'));

if (isset($_POST['submit-button'])){
	shell_exec('rm -rf uploads/*');
	if (!file_exists($target_dir)) {
		mkdir($target_dir, 0777, true);
	}
	$countfiles = count($_FILES['file']['name']);
	for($i=0;$i<$countfiles;$i++){
		$filename = $_FILES['file']['name'][$i];
		move_uploaded_file($_FILES['file']['tmp_name'][$i],$target_dir.$filename);
	}
	$output=shell_exec('reportinator --name "'.$user_name.'" --affil "'.$user_affiliation.'" --source "'.$target_dir.'" --classfile "'.$class_file.'"');
	$output=shell_exec('cd uploads && zip -r '.$folder_name.'/'.$folder_name.'.zip '.$folder_name);
	echo '<a href="'.$target_dir.'output.pdf"> Download PDF</a><br>';
	echo '<a href="'.$target_dir.$folder_name.'.zip">Download Everything</a>';
}
?>
