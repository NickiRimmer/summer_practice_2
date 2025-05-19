<?php

$sess = false;
if (isset($_COOKIE[session_name()])){
	session_start();
	global $sess;
	$sess = true;
}



if ($_GET['q']=='profile'){
	if (!isset($_GET['id'])){
		header('Location: /404');
		exit;
	}
	if ($sess){
		if ($_GET['id']==$_SESSION['id']){
			header('Location: /my_profile');
		}
	}
	include('db.php');

	$user = get_user_info($_GET['id']);
	$pets = get_pets($_GET['id']);
	$posts = get_tips($_GET['id']);

	$isconf = false;
	
	include('./pages/profile.php');
}
elseif ($_GET['q'] == 'pet') {
	if (!isset($_GET['id'])){
		header('Location: /404');
		exit;
	}
	include('db.php');

	$user = get_pet($_GET['id']);
	$posts = get_posts($_GET['id']);
	$isconf = $sess && !empty($user) && $user['uid']==$_SESSION['id'];

	include('./pages/pet.php');
}
elseif ($_GET['q']=='login'){
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$username = $_POST['username'];
		$password = $_POST['password'];
		setcookie('username', $username, time()+60*60);

		if (empty($username) || empty($password)) {
			setcookie('error', 'Пожалуйста, заполните все поля.', time()+3600);
		} else {
			include('db.php');
			$user = get_user_by_login($username);
			if ($user && password_verify($password, $user['password'])) {
				session_start();
				$_SESSION['id'] = $user['user_id'];
				setcookie('error', 0, 1000);
				setcookie('username', 0, 1000);
				header('Location: /my_profile');
				exit;
			} else {
				setcookie('error', 'Неверное имя пользователя или пароль.', time()+3600);
			}
		}
		header('Location: /login');
	}
	else {
		$username = $_COOKIE['username'] ?? '';
		$error = $_COOKIE['error'] ?? '';
		setcookie('error', 0, 1000);
		setcookie('username', 0, 1000);
		include('./pages/login.php');
	}
}
elseif ($_GET['q']=='logout'){
	session_start();
	setcookie(session_name(), 0, 1000, '/');
	session_destroy();
	header('Location: /login');
}
elseif ($_GET['q']=='register'){
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		include('db.php');

		$username = $_POST['username'];
		$password = $_POST['password'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$bio = $_POST['bio'];
		setcookie('username', $username, time()+60*60);
		setcookie('first_name', $first_name, time()+60*60);
		setcookie('last_name', $last_name, time()+60*60);
		setcookie('bio', $bio, time()+60*60);

		if (empty($username) || empty($password) || empty($first_name) || empty($last_name) || empty($bio)) {
			setcookie('error', 'Пожалуйста, заполните все поля.', time()+3600);
		} 
		elseif (!empty(get_user_by_login($username))) {
			setcookie('error', 'Извините, такой логин уже используется', time()+3600);
		}
		else {
			session_start();
			$_SESSION['id'] = new_user($username, $password, $first_name, $last_name, $bio);
			setcookie('error', 0, 1000);
			setcookie('username', 0, 1000);
			setcookie('first_name', 0, 1000);
			setcookie('last_name', 0, 1000);
			setcookie('bio', 0, 1000);
			header('Location: /my_profile');
			exit;
			
		}
		header('Location: /register');
	}
	else {
		$username = $_COOKIE['username'] ?? '';
		$error = $_COOKIE['error'] ?? '';
		$first_name = $_COOKIE['first_name'] ?? '';
		$last_name = $_COOKIE['last_name'] ?? '';
		$bio = $_COOKIE['bio'] ?? '';
		setcookie('error', 0, 1000);
		setcookie('username', 0, 1000);
		setcookie('first_name', 0, 1000);
		setcookie('last_name', 0, 1000);
		setcookie('bio', 0, 1000);
		include('./pages/register.php');
	}
}
elseif ($_GET['q']=='main'){
	include('db.php');

	$posts = get_all_posts(50, $_GET['offset'] ?? 0);

	include('./pages/main.php');
}
elseif ($_GET['q']=='users'){
	include('db.php');

	$data = get_all_users();
	$isusers = true;

	include('./pages/all.php');
}
elseif ($_GET['q']=='pets'){
	include('db.php');
	
	$data = get_all_pets();
	$isusers = false;

	include('./pages/all.php');
}
elseif (!$sess){
	http_response_code(401);
	header('Location: /login');
	exit;
}
elseif ($_GET['q']=='my_profile'){
	if ($sess){
		include('db.php');

		$user = get_user_info($_SESSION['id']);
		$pets = get_pets($_SESSION['id']);
		$posts = get_tips($_SESSION['id']);
		$isconf = true;

		include('./pages/profile.php');
	}
	else {
		header('Location: /login');
	}
}//
elseif ($_GET['q']=='dialog'){
	if (!$sess){
		header('Location: /404');
		exit;
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$sender_id = $_SESSION['id'];
		$receiver_id = $_GET['id'];
		$message = $_POST['message'];
		
		if (!empty($message)) {
			include('db.php');

			new_message($receiver_id, $message);

		  	header("Location: dialog?id=" . $receiver_id);
		  	exit;
		} else {
		  	echo "Пожалуйста, введите сообщение.";
			header("Location: dialog?id=" . $receiver_id);
		}
	}
	else {
		include('db.php');
		$sender_id = $_SESSION['id'];
		$receiver_id = $_GET['id'];
		$messages = get_messages($receiver_id);
		include('./pages/dialog.php');
	}
}//
elseif ($_GET['q']=='dialogs'){
	if (!$sess){
		header('Location: /404');
		exit;
	}
	include('db.php');
	$dialogs = get_dialogs($_SESSION['id']);
	include('./pages/dialog_list.php');
}//
elseif ($_GET['q']=='new_tip'){
	if (!$sess){
		header('Location: /404');
		exit;
	}
	if ($_SERVER['REQUEST_METHOD']=='POST'){
		$text = $_POST['text'];
		setcookie('text', $_POST['text'], time()+3600);
		if (empty($text)){
			setcookie('error', 'Пожалуйста, заполните все поля', time() + 3600);
			header('Location: /new_tip');
		}
		else {
			include('db.php');
			new_tip($text);
			setcookie('error', 0, 1000);
			setcookie('text', 0, 3600);
		}
		header('Location: /my_profile');
	}
	else{
		include('./pages/new_tip.php');
	}
}//
elseif ($_GET['q']=='new_post'){
	if (!$sess){
		header('Location: /404');
		exit;
	}
	if ($_SERVER['REQUEST_METHOD']=='POST'){
		$pet = $_POST['pet'];
		$text = $_POST['text'];
		setcookie('pet', $_POST['pet'], time()+3600);
		setcookie('text', $_POST['text'], time()+3600);
		if (empty($pet) || empty($text)){
			setcookie('error', 'Пожалуйста, заполните все поля', time() + 3600);
			header('Location: /new_post');
		}
		else {
			include('db.php');
			new_post($pet, $text);
			setcookie('error', 0, 1000);
			setcookie('pet', 0, 3600);
			setcookie('text', 0, 3600);
		}
		header('Location: /pet?id=' . $pet);
	}
	else{
		include('db.php');
		$pets = get_pets($_SESSION['id']);
		include('./pages/new_post.php');
	}
}//
elseif ($_GET['q']=='new_pet'){
	if (!$sess){
		header('Location: /404');
		exit;
	}
	if ($_SERVER['REQUEST_METHOD']=='POST'){
		$name = $_POST['name'];
		$spec = $_POST['spec'];
		$bio = $_POST['bio'];
		setcookie('name', $_POST['name'], time()+3600);
		setcookie('spec', $_POST['spec'], time()+3600);
		setcookie('bio', $_POST['bio'], time()+3600);
		if (empty($name) || empty($spec) || empty($bio)){
			setcookie('error', 'Пожалуйста, заполните все поля', time() + 3600);
			header('Location: /new_pet');
		}
		else {
			include('db.php');
			new_pet($name, $spec, $bio, NULL);
			setcookie('error', 0, 1000);
			setcookie('name', 0, 3600);
			setcookie('spec', 0, 3600);
			setcookie('bio', 0, 3600);
		}
		header('Location: /my_profile');
	}
	else{
		$error = $_COOKIE['error'] ?? '';
		$name = $_COOKIE['name'] ?? '';
		$spec = $_COOKIE['spec'] ?? '';
		$bio = $_COOKIE['bio'] ?? '';
		setcookie('error', 0, 1000);
		setcookie('name', 0, 3600);
		setcookie('spec', 0, 3600);
		setcookie('bio', 0, 3600);
		include('./pages/new_pet.php');
	}
}//
elseif ($_GET['q']=='edit_profile'){
	if (!$sess){
		header('Location: /404');
		exit;
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		include('db.php');

		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$bio = $_POST['bio'];
		setcookie('first_name', $first_name, time()+60*60);
		setcookie('last_name', $last_name, time()+60*60);
		setcookie('bio', $bio, time()+60*60);

		if (empty($first_name) || empty($last_name) || empty($bio)) {
			setcookie('error', 'Пожалуйста, заполните все поля.', time()+3600);
		} 
		else {
			edit_user($_POST);
			setcookie('error', 0, 1000);
			setcookie('first_name', 0, 1000);
			setcookie('last_name', 0, 1000);
			setcookie('bio', 0, 1000);
			header('Location: /my_profile');
			exit;
		}
		header('Location: /edit_profile');
	}
	else {
		include('db.php');
		$uinf = get_user_info($_SESSION['id']);
		$error = $_COOKIE['error'] ?? '';
		$first_name = $_COOKIE['first_name'] ?? $uinf['first_name'];
		$last_name = $_COOKIE['last_name'] ?? $uinf['last_name'];
		$bio = $_COOKIE['bio'] ?? $uinf['bio'];
		setcookie('error', 0, 1000);
		setcookie('first_name', 0, 1000);
		setcookie('last_name', 0, 1000);
		setcookie('bio', 0, 1000);
		include('./pages/edit_profile.php');
	}
}//
elseif ($_GET['q']=='edit_pet'){
	if (!$sess){
		header('Location: /404');
		exit;
	}

	if ($_SERVER['REQUEST_METHOD']=='POST'){
		$name = $_POST['name'];
		$spec = $_POST['spec'];
		$bio = $_POST['bio'];
		setcookie('name', $_POST['name'], time()+3600);
		setcookie('spec', $_POST['spec'], time()+3600);
		setcookie('bio', $_POST['bio'], time()+3600);
		if (empty($name) || empty($spec) || empty($bio)){
			setcookie('error', 'Пожалуйста, заполните все поля', time() + 3600);
			header('Location: /edit_pet');
		}
		else {
			include('db.php');
			edit_pet($_GET['id'], $_POST);
			setcookie('error', 0, 1000);
			setcookie('name', 0, 3600);
			setcookie('spec', 0, 3600);
			setcookie('bio', 0, 3600);
		}
		header('Location: /my_profile');
	}
	else{
		include('db.php');
		$pinfo = get_pet($_GET['id']);
		$error = $_COOKIE['error'] ?? '';
		$name = $_COOKIE['name'] ?? $pinfo['name'];
		$spec = $_COOKIE['spec'] ?? $pinfo['spec'];
		$bio = $_COOKIE['bio'] ?? $pinfo['bio'];
		setcookie('error', 0, 1000);
		setcookie('name', 0, 3600);
		setcookie('spec', 0, 3600);
		setcookie('bio', 0, 3600);
		include('./pages/edit_pet.php');
	}
}//
elseif ($_GET['q']=='del_user'){
	if (!$sess){
		http_response_code(401);
		exit;
	}

	include('db.php');
	delete_user();
	header('Location: /register');
}//
elseif ($_GET['q']=='del_pet'){
	if (!$sess){
		http_response_code(401);
		exit;
	}

	include('db.php');
	delete_pet($_GET['id']);
	header('Location: /my_profile');
}//
else {
	http_response_code(404);
}
?>