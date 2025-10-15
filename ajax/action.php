<?php


include('db.php');


$check = $conn->query("SELECT * FROM comment ORDER BY id DESC");
 


if(isset($_POST['content']))
{
$content = isset($_POST['content']) ? trim($_POST['content']) : '';
if ($content !== '') {
	$stmt = $conn->prepare("INSERT INTO comment (msg) VALUES (:msg)");
	$stmt->execute([':msg' => $content]);
}

$news_query = $conn->query("SELECT * FROM comment ORDER BY id DESC");
$row=$news_query->fetch();
}



?>

<div class="showbox"> <?php echo htmlspecialchars($row['msg'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?> </div>
