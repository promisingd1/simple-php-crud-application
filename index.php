<?php
    require_once ('./functions.php');

    $info = '';

    $task = $_GET['task'] ?? 'report';

    if ( 'seed' == $task ) {
        seed(DB_NAME);
        $info = 'Seed is successful';
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<!--    Bootstrap CSS   -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>PHP CRUD App</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col offset-md-2">
            <h1>CRUD Project</h1>
            <p>Simple CRUD Project to implement PHP Basics</p>
            <?php include_once './inc/templates/nav.php'?>
            <hr>
            <?php
                if ( $info !== '' ) {
                    echo "<p>{$info}</p>";
                }
            ?>
        </div>
    </div>
	<?php
		if ( 'report' == $task ) :
			?>
            <div class="row">
                <div class="col offset-md-2">
                    <?php generateReport(DB_NAME); ?>
                </div>
            </div>
		<?php
		endif;
	?>
</div>
</body>
</html>