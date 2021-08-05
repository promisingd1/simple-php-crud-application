<?php
	require_once( './functions.php' );

	$info = '';

	//    Setting default task as report.
	$task = $_GET['task'] ?? 'report';

	//    Displaying error message
	$error = $_GET['error'] ?? '0';

	// Seeding data
	if ( 'seed' == $task ) {
		seed( DB_NAME );
		$info = 'Seed is successful';
	}

	$firstName = '';
	$lastName  = '';
	$roll      = '';

	if ( isset( $_POST['submit'] ) ) {
		//    Retrieving data from input fields
		$firstName = filter_input( INPUT_POST, 'fname', FILTER_SANITIZE_STRING );
		$lastName  = filter_input( INPUT_POST, 'lname', FILTER_SANITIZE_STRING );
		$roll      = filter_input( INPUT_POST, 'roll', FILTER_SANITIZE_STRING );
		$id        = filter_input( INPUT_POST, 'id', FILTER_SANITIZE_STRING );

		if ( $id ) {
//		    Update existing student
			if ( $firstName != '' && $lastName != '' && $roll != '' ) {
				$result = updateExistingStudent( $id, $firstName, $lastName, $roll );

				if ( $result ) {
					header( "location: ?task=report" );
				} else {
					$error = '1';
				}
			}

		} else {
//            Create new student
			if ( $firstName != '' && $lastName != '' && $roll != '' ) {
				$result = addNewStudent( $firstName, $lastName, $roll );

				if ( $result ) {
					header( "location: ?task=report" );
				} else {
					$error = '1';
				}
			}
		}
	}

	//		Deleteing data
	if ('delete' == $task) {
		$id        = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_STRING );

		if ( $id > 0 ) {
			deleteStudent($id);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>PHP CRUD App</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col offset-md-2">
            <h1>CRUD Project</h1>
            <p>Simple CRUD Project to implement PHP Basics</p>
			<?php include_once './inc/templates/nav.php' ?>
            <hr>
			<?php
				if ( $info !== '' ) {
					echo "<p>{$info}</p>";
				}
			?>
        </div>
    </div>
	<?php
		//        Code to display if @task is set to report
		if ( 'report' == $task ) :
			?>
            <div class="row">
                <div class="col offset-md-2">
					<?php generateReport( DB_NAME ); ?>
                </div>
            </div>
		<?php
		endif;
	?>

	<?php
		//        Message to show when @error occurred
		if ( '1' == $error ) :
			?>
            <div class="row my-3">
                <div class="col offset-md-2">
                    <blockquote class="blockquote text-danger">
                        <h4>
                            Duplicate Roll Number. Roll number must be unique.
                        </h4>
                    </blockquote>
                </div>
            </div>
		<?php endif; ?>

	<?php
		//        Code to display when @task is set to add new user
		if ( 'add' == $task ) :
			?>
            <div class="row">
                <div class="col offset-md-2">
                    <form method="post">
                        <div class="mb-3">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $firstName
							?>" aria-describedby="firstName">
                        </div>
                        <div class="mb-3">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $lastName
							?>" aria-describedby="lastName">
                        </div>
                        <div class="mb-3">
                            <label for="roll" class="form-label">Roll</label>
                            <input type="number" class="form-control" id="roll" name="roll" value="<?php echo $roll
							?>" aria-describedby="roll">
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Save</button>
                    </form>
                </div>
            </div>
		<?php endif; ?>

	<?php
		//        Code to display when @task is set to edit
		if ( 'edit' == $task ) :
			$id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_STRING );
			$student = getStudent( $id );
			if ( $student ) :
				?>
                <div class="row">
                    <div class="col offset-md-2">
                        <form method="post">
                            <input type="hidden" value="<?php echo $id ?>" name="id">
                            <div class="mb-3">
                                <label for="fname" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="fname" name="fname"
                                       value="<?php echo $student['firstName']
								       ?>" aria-describedby="firstName">
                            </div>
                            <div class="mb-3">
                                <label for="lname" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lname" name="lname"
                                       value="<?php echo $student['lastName']
								       ?>" aria-describedby="lastName">
                            </div>
                            <div class="mb-3">
                                <label for="roll" class="form-label">Roll</label>
                                <input type="number" class="form-control" id="roll" name="roll"
                                       value="<?php echo $student['roll']
								       ?>" aria-describedby="roll">
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Update</button>
                        </form>
                    </div>
                </div>
			<?php
			endif;
		endif;
	?>
   <!-- <pre>
        <?php /*printStudentArray(); */?>
    </pre>-->
</div>
<script src="script.js"></script>
</body>
</html>