<?php

	const DB_NAME = '/home/promisedas/Promise/Programming Heaven/Web Development/php-projects/simple-php-crud-application/data/db.txt';


// Seeding function
	function seed( $filename ) {
		$data = array(
			array(
				'id'        => '1',
				'firstName' => 'John',
				'lastName'  => 'Doe',
				'roll'      => '7'
			),
			array(
				'id'        => '2',
				'firstName' => 'Sam',
				'lastName'  => 'Curran',
				'roll'      => '10'
			),
			array(
				'id'        => '3',
				'firstName' => 'Alex',
				'lastName'  => 'Pope',
				'roll'      => '15'
			),
			array(
				'id'        => '4',
				'firstName' => 'Alan',
				'lastName'  => 'Poe',
				'roll'      => '5'
			),
			array(
				'id'        => '5',
				'firstName' => 'John',
				'lastName'  => 'Elton',
				'roll'      => '8'
			),
			array(
				'id'        => '6',
				'firstName' => 'Mike',
				'lastName'  => 'Hussy',
				'roll'      => '9'
			),
			array(
				'id'        => '7',
				'firstName' => 'David',
				'lastName'  => 'Beckham',
				'roll'      => '11'
			),
			array(
				'id'        => '8',
				'firstName' => 'Robert',
				'lastName'  => 'Downey',
				'roll'      => '12'
			),
			array(
				'id'        => '9',
				'firstName' => 'Declan',
				'lastName'  => 'Rice',
				'roll'      => '3'
			),
			array(
				'id'        => '10',
				'firstName' => 'Harry',
				'lastName'  => 'Potter',
				'roll'      => '4'
			),
		);

		$serializeData = serialize( $data );
		file_put_contents( $filename, $serializeData, LOCK_EX );
	}

	/*
	 * Gernerating Report
	 * */
	function generateReport( $filename ) {
		$serializedData = file_get_contents( $filename );
		$students       = unserialize( $serializedData );
		?>
        <table class="table table-striped table-hover">
            <tr class="table-dark">
                <th>Name</th>
                <th>Roll</th>
                <th>Action</th>
            </tr>

			<?php
				foreach ( $students as $student ) {
					?>
                    <tr>
                        <td>
							<?php printf( "%s %s", $student['firstName'], $student['lastName'] ); ?>
                        </td>
                        <td>
							<?php printf( "%s", $student['roll'] ); ?>
                        </td>
                        <td>
							<?php printf( "<a href='./index.php?task=edit&id=%s' class='text-decoration-none'>Edit | </a> <a href='./index.php?task=delete&id=%s' class='text-decoration-none delete'> Delete</a>", $student['id'], $student['id'] ); ?>
                        </td>
                    </tr>
					<?php
				}
			?>
        </table>
		<?php

	}

	function addNewStudent( $firstName, $lastName, $roll ): bool {
		$serializedData = file_get_contents( DB_NAME );
		$students       = unserialize( $serializedData );
		$newId          = getNewId($students);

//		Validating whether same roll exists in the database
		$found = false;
		foreach ($students as $_student) {
		    if ( $_student['roll'] == $roll ) {
		        $found  = true;
		        break;
            }
        }

		if ( !$found ) {
			$student = array(
				'id'        => $newId,
				'firstName' => $firstName,
				'lastName'  => $lastName,
				'roll'      => (string) $roll
			);
			array_push( $students, $student );
			$serializedData = serialize( $students );
			file_put_contents( DB_NAME, $serializedData, LOCK_EX );
			return true;
		}

		return false;
	}

	function getNewId($students) {
		return max(array_column($students, 'id')) + 1;
    }

	function getStudent( $id ) {
		$serializedData = file_get_contents( DB_NAME );
		$students       = unserialize( $serializedData );

		foreach ( $students as $student ){
		    if ( $student['id'] == $id ) {
		        return $student;
            }
        }

        return  false;
	}

	function updateExistingStudent( $id, $firstName, $lastName, $roll ): bool {
		$serializedData = file_get_contents( DB_NAME );
		$students       = unserialize( $serializedData );

//		Validating whether same roll exists in the database and comparing the roll with id of other students
		$found = false;
		foreach ($students as $_student) {
			if ( $_student['roll'] == $roll && $_student['id'] != $id ) {
				$found  = true;
				break;
			}
		}

		if ( !$found ) {
			$students[$id -1]['firstName'] = $firstName;
			$students[$id -1]['lastName'] = $lastName;
			$students[$id -1]['roll'] = (string) $roll;

			$serializedData = serialize( $students );
			file_put_contents( DB_NAME, $serializedData, LOCK_EX );
			return true;
        }

		return  false;
	}

	function printStudentArray() {
		$serializedData = file_get_contents( DB_NAME );
		$students       = unserialize( $serializedData );
		print_r($students);
    }

    function deleteStudent($id) {
	    $serializedData = file_get_contents( DB_NAME );
	    $students       = unserialize( $serializedData );

	    foreach ($students as $offset=>$student) {
	        if ($student['id'] === $id ) {
	            unset($students[$offset]);
            }
	    }

	    unset($students[$id -1]);
	    $serializedData = serialize( $students );
	    file_put_contents( DB_NAME, $serializedData, LOCK_EX );
    }