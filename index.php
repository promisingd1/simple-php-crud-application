<?php
    require_once ('./functions.php');

    $info = '';

//    Setting default task as report.
    $task = $_GET['task'] ?? 'report';

    if ( 'seed' == $task ) {
        seed(DB_NAME);
        $info = 'Seed is successful';
    }

//    Retrieving data from input fields and generating report
	if ( isset( $_POST['submit'] ) ) {
		$firstName = filter_input( INPUT_POST, 'fname', FILTER_SANITIZE_STRING );
		$lastName  = filter_input( INPUT_POST, 'lname', FILTER_SANITIZE_STRING );
		$roll      = filter_input( INPUT_POST, 'roll', FILTER_SANITIZE_STRING );
		if ( $firstName != '' && $lastName != '' && $roll != '' ) {
			addNewStudent( $firstName, $lastName, $roll );
		}
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
    <?php if ('add' == $task) :
        ?>
        <div class="row">
            <div class="col offset-md-2">
                <form action="./index.php?task=report" method="post">
                    <div class="mb-3">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" aria-describedby="firstName">
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" aria-describedby="lastName">
                    </div>
                    <div class="mb-3">
                        <label for="roll" class="form-label">Roll</label>
                        <input type="number" class="form-control" id="roll" name="roll" aria-describedby="roll">
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Save</button>
                </form>
            </div>
        </div>
    <?php endif; ?>

</div>
</body>
</html>