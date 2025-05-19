<?php
$user = 'root';
$pass = NULL;
$db = new PDO('mysql:host=localhost;dbname=social_network', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

function get_user($id){
    global $db;
    $get = 
        $db->prepare('SELECT * 
            FROM users 
            WHERE user_id = ?');
    $get->execute([$id]);
    return $get->fetch();
}

function get_user_by_login($login){
    global $db;
    $get = 
        $db->prepare('SELECT * 
            FROM users 
            WHERE login = ?');
    $get->execute([$login]);
    return $get->fetch();
}

function get_user_info($id){
    global $db;
    $get = 
        $db->prepare('SELECT * 
            FROM users_info 
            WHERE uid = ?');
    $get->execute([$id]);
    return $get->fetch();
}

function get_tips($id){
    global $db;
    $get = 
        $db->prepare('SELECT * 
            FROM tips 
            WHERE uid = ?');
    $get->execute([$id]);
    return $get->fetchAll();
}

function get_pets($id){
    global $db;
    $get = 
        $db->prepare('SELECT * 
            FROM pets 
            WHERE uid = ?');
    $get->execute([$id]);
    return $get->fetchAll();
}

function get_pet($pid){
    global $db;
    $get = $db->prepare('SELECT * FROM pets WHERE pet_id = ?');
    $get->execute([$pid]);
    return $get->fetch();
}

function get_dialogs($id){
    global $db;
    $get = 
        $db->prepare('SELECT DISTINCT inn.uid
        FROM
        (SELECT uid_to AS uid, max(datetime) as date
        FROM messages 
        WHERE uid_from = ?
        GROUP BY uid
        UNION 
        SELECT uid_from AS uid, max(datetime) as date
        FROM messages 
        WHERE uid_to = ?
        GROUP BY uid
        ORDER BY date) AS inn
        ORDER BY date');
    $get->execute([$id, $id]);
    $uids = $get->fetchAll();
    $dialogs = array();
    foreach ($uids as $uid){
        if (isset($uid['uid'])){
            $dialogs[] = get_user_info($uid['uid']);
        }
    }
    return $dialogs;
}

function get_messages($id){
    global $db;
    $get = 
        $db->prepare('SELECT * 
        FROM messages
        WHERE (uid_from = :sid AND uid_to = :id) OR (uid_from = :id AND uid_to = :sid)
        ORDER BY datetime');
    $get->execute(['id'=>$id, 'sid'=>$_SESSION['id']]);
    return $get->fetchAll();
}

function get_posts($pid){
    global $db;
    $get = 
        $db->prepare('SELECT * 
        FROM posts
        WHERE pid = :id
        ORDER BY datetime');
    $get->execute(['id'=>$pid]);
    return $get->fetchAll();
}

function new_post($pid, $text, $photo_url=NULL){
    global $db;
    $new = $db->prepare('INSERT INTO posts(pid, text, photo_url)
        VALUES (?, ?, ?)');
    $new->execute([$pid, $text, $photo_url]);
}

function new_pet($name, $spec, $bio, $photo_url){
    global $db;
    $new = $db->prepare('INSERT INTO pets(uid, name, spec, bio, photo_url)
        VALUES (?, ?, ?, ?, ?)');
    $new->execute([$_SESSION['id'], $name, $spec, $bio, $photo_url]);
}

function new_user($login, $password, $first_name, $last_name, $bio, $photo_url=NULL){
    global $db;
    $new_user = $db->prepare('INSERT INTO users(login, password)
        VALUES (?, ?)');
    $new_info = $db->prepare('INSERT INTO users_info(uid, first_name, last_name, bio, photo_url)
        VALUES (?, ?, ?, ?, ?)');
    $new_user->execute([$login, password_hash($password, PASSWORD_DEFAULT)]);
    $id = $db->lastInsertId();
    $new_info->execute([$id, $first_name, $last_name, $bio, $photo_url]);
    return $id;
}

function new_tip($text, $photo_url=NULL){
    global $db;
    $new = $db->prepare('INSERT INTO tips(uid, text, photo_url)
        VALUES (?, ?, ?)');
    $new->execute([$_SESSION['id'], $text, $photo_url]);
}

function new_message($id_to, $text){
    global $db;
    $new = $db->prepare('INSERT INTO messages(uid_from, uid_to, text)
        VALUES (?, ?, ?)');
    $new->execute([$_SESSION['id'], $id_to, $text]);
}

function edit_user($array){
    global $db;
    $info = get_user_info($_SESSION['id']);

    $first_name = $array['first_name'] ?? $info['first_name'];
    $last_name = $array['last_name'] ?? $info['last_name'];
    $bio = $array['bio'] ?? $info['bio'];
    $photo_url = $array['photo_url'] ?? $info['photo_url'];

    $new = $db->prepare('UPDATE users_info
        SET first_name = :fn, last_name = :ln, bio = :bio, photo_url = :pu
        WHERE uid = :id');
    $new->execute([':id'=>$_SESSION['id'], 'fn'=>$first_name, 'ln'=>$last_name, 'bio'=>$bio, 'pu'=>$photo_url]);
}

function edit_pet($pid, $array){
    global $db;
    $info = get_pet($pid);

    $name = $array['name'] ?? $info['name'];
    $spec = $array['spec'] ?? $info['spec'];
    $bio = $array['bio'] ?? $info['bio'];
    $photo_url = $array['photo_url'] ?? $info['photo_url'];

    $new = $db->prepare('UPDATE pets
        SET name = :n, spec = :s, bio = :b, photo_url=:p
        WHERE pet_id = :pid');
    $new->execute(['n'=>$name, 's'=>$spec, 'b'=>$bio, 'p'=>$photo_url, 'pid'=>$pid]);
}

function delete_user(){
    global $db;
    $del = $db->prepare('DELETE FROM users WHERE user_id = ?');
    $del->execute([$_SESSION['id']]);
    setcookie(session_name(), 0, 1000, '/');
    session_destroy();
}

function delete_pet($pid){
    global $db;
    $del = $db->prepare('DELETE FROM pets WHERE pet_id = ?');
    $del->execute([$pid]);
}

function get_all_posts($limit, $offset){
    global $db;
    $get = $db->prepare('SELECT p.text, p.photo_url, p.datetime, ps.name AS name
    FROM posts AS p
    JOIN
    pets AS ps ON p.pid = ps.pet_id
    UNION
    SELECT t.text, t.photo_url, t.datetime, CONCAT(u.first_name, " " , u.last_name) AS name
    FROM tips AS t
    JOIN
    users_info AS u ON u.uid = t.uid
    ORDER BY datetime DESC
        LIMIT ' . $limit . ' OFFSET ' . $offset);
    $get->execute([]);
    return $get->fetchAll();
}

function get_all_users() {
    global $db;
    $get = $db->query('SELECT * FROM users_info');
    return $get->fetchAll();
}

function get_all_pets() {
    global $db;
    $get = $db->query('SELECT * FROM pets');
    return $get->fetchAll();
}
?>