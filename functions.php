<?php

	const DB_NAME = '/home/promisedas/Promise/Programming Heaven/Web Development/php-projects/simple-php-crud-application/db.txt';


	function seed( $filename ) {
		$data = array(
			array(
				'id' => '1',
				'firstName' => 'John',
				'lastName' => 'Doe',
				'roll' => '7'
			),
			array(
				'id' => '2',
				'firstName' => 'Sam',
				'lastName' => 'Curran',
				'roll' => '10'
			),
			array(
				'id' => '3',
				'firstName' => 'Alex',
				'lastName' => 'Pope',
				'roll' => '15'
			),
			array(
				'id' => '4',
				'firstName' => 'Alan',
				'lastName' => 'Poe',
				'roll' => '5'
			),
			array(
				'id' => '5',
				'firstName' => 'John',
				'lastName' => 'Elton',
				'roll' => '8'
			),
			array(
				'id' => '6',
				'firstName' => 'Mike',
				'lastName' => 'Hussy',
				'roll' => '9'
			),
			array(
				'id' => '7',
				'firstName' => 'David',
				'lastName' => 'Beckham',
				'roll' => '11'
			),
			array(
				'id' => '8',
				'firstName' => 'Robert',
				'lastName' => 'Downey',
				'roll' => '12'
			),
			array(
				'id' => '9',
				'firstName' => 'Declan',
				'lastName' => 'Rice',
				'roll' => '3'
			),
			array(
				'id' => '10',
				'firstName' => 'Harry',
				'lastName' => 'Potter',
				'roll' => '4'
			),
		);

		$serializeData = serialize($data);
//		print_r($serializeData);
		file_put_contents($filename, $serializeData, LOCK_EX);
	}

	function generateReport( $filename ) {
		$serializeData = file_get_contents( $filename );
		$students      = unserialize( $serializeData );
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
                            <?php printf("%s %s", $student['firstName'], $student['lastName']); ?>
                        </td>
                        <td>
		                    <?php printf("%s", $student['roll'] ); ?>
                        </td>
                        <td>
                            <?php printf( "<a href='./index.php?task=edit&id=%s' class='text-decoration-none'>Edit | </a> <a href='./index.php?task=delete&id=%s' class='text-decoration-none'> Delete</a>", $student['id'], $student['id'] );
                            ; ?>
                        </td>
                    </tr>
					<?php
				}
			?>
        </table>
		<?php

	}