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
		'radio-control' => 'double.cls'
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

if (isset($_POST['submit'])){
	shell_exec('rm -rf uploads/*');
	if (!file_exists($target_dir)) {
		mkdir($target_dir, 0777, true);
	}
	$countfiles = count($_FILES['file']['name']);
	for($i=0;$i<$countfiles;$i++){
		$filename = $_FILES['file']['name'][$i];
		move_uploaded_file($_FILES['file']['tmp_name'][$i],$target_dir.$filename);
	}
	$output=shell_exec('reportinator --name "'.$user_name.'" --affil "'.$user_affiliation.'" --source "'.$target_dir.'"');
	echo get_option('username');
	echo '<a href="'.$target_dir.'output.pdf"> Download PDF</a>';
}

  ?>
