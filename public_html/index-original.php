<?php
session_start();

if( isset( $_REQUEST['control'] ) ) {
	if( $_REQUEST['control'] == 'reset' ) {
		session_destroy();
		return;
	}

	if( !isset( $_SESSION['family']['count'] ) )
		$_SESSION['family']['count'] = 0;

	if( $_REQUEST['control'] == 'add_dad' ) {
		if( isset( $_SESSION['family']['dad'] ) ) {
			echo 'ERROR: The family already has a dad. (No support for modern families yet. :))';
		} else {
			$_SESSION['family']['dad'] = 1;
			$_SESSION['family']['count']++;
		}
	}

	if( $_REQUEST['control'] == 'add_mum' ) {
		if( isset( $_SESSION['family']['mum'] ) ) {
			echo 'ERROR: The family already has a mum. (No support for modern families yet. :))';
		} else {
			$_SESSION['family']['mum'] = 1;
			$_SESSION['family']['count']++;
		}
	}

	if( $_REQUEST['control'] == 'add_child' ) {
		if( ! isset( $_SESSION['family']['mum'] ) || ! isset( $_SESSION['family']['dad'] ) ) {
			echo 'ERROR: No child without a mum and a dad.';
		} else {
			if( ! isset( $_SESSION['family']['children'] ) ) {
				$_SESSION['family']['children'] = 1;
			} else {
				$_SESSION['family']['children']++;
			}
			$_SESSION['family']['count']++;
		}
	}

	if( $_REQUEST['control'] == 'add_cat' ) {
		if( ! isset( $_SESSION['family']['mum'] ) && ! isset( $_SESSION['family']['dad'] ) ) {
			echo 'ERROR: No cat without a mum or a dad.';
		} else {
			if( ! isset( $_SESSION['family']['cat'] ) ) {
				$_SESSION['family']['cat'] = 1;
			} else {
				$_SESSION['family']['cat']++;
			}

			$_SESSION['family']['count']++;
		}
	}

	if( $_REQUEST['control'] == 'add_dog' ) {
		if( ! isset( $_SESSION['family']['mum'] ) && ! isset( $_SESSION['family']['dad'] ) ) {
			echo 'ERROR: No dog without a mum or a dad.';
		} else {
			if( ! isset( $_SESSION['family']['dog'] ) ) {
				$_SESSION['family']['dog'] = 1;
			} else {
				$_SESSION['family']['dog']++;
			}
			$_SESSION['family']['count']++;
		}
	}

	if( $_REQUEST['control'] == 'add_goldfish' ) {
		if( ! isset( $_SESSION['family']['mum'] ) && ! isset( $_SESSION['family']['dad'] ) ) {
			echo 'ERROR: No goldfish without a mum or a dad.';
		} else {
			if( ! isset( $_SESSION['family']['goldfish'] ) ) {
				$_SESSION['family']['goldfish'] = 1;
			} else {
				$_SESSION['family']['goldfish']++;
			}
			$_SESSION['family']['count']++;
		}
	}

	return;
}


function c() {
	$sum = 0;

	if( isset( $_SESSION['family']['mum'] ) )
		$sum += 200;
	if( isset( $_SESSION['family']['dad'] ) )
		$sum += 200;

	if( isset( $_SESSION['family']['children'] ) ) {
		if( $_SESSION['family']['children'] > 2 ) {
			$sum += $_SESSION['family']['children'] * 100;
		} else {
			$sum += $_SESSION['family']['children'] * 150;
		}
	}

	if( isset( $_SESSION['family']['cat'] ) )
		$sum += $_SESSION['family']['cat'] * 10;

	if( isset( $_SESSION['family']['dog'] ) )
		$sum += $_SESSION['family']['dog'] * 15;

	if( isset( $_SESSION['family']['goldfish'] ) )
		$sum += $_SESSION['family']['goldfish'] * 2;

	return $sum;
}

function sum() {
	if( !isset( $_SESSION['family'] ) ) {
		echo ' ';
		return;
	}

	if( $_SESSION['family']['count'] > 0 ) {
		echo '<h2>Family</h2>';

		echo '<ul>';
		if( isset( $_SESSION['family']['mum'] ) )
			echo '<li>Mum: ' . $_SESSION['family']['mum'] . '</li>';
		if( isset( $_SESSION['family']['dad'] ) )
			echo '<li>Dad: ' . $_SESSION['family']['dad'] . '</li>';
		if( isset( $_SESSION['family']['children'] ) )
			echo '<li>Children: ' . $_SESSION['family']['children'] . '</li>';
		if( isset( $_SESSION['family']['cat'] ) )
			echo '<li>Cats: ' . $_SESSION['family']['cat'] . '</li>';
		if( isset( $_SESSION['family']['dog'] ) )
			echo '<li>Dogs: ' . $_SESSION['family']['dog'] . '</li>';
		if( isset( $_SESSION['family']['goldfish'] ) )
			echo '<li>Goldfish: ' . $_SESSION['family']['goldfish'] . '</li>';


		echo '<li><b>Total Members</b>: ' . $_SESSION['family']['count'] . '</li>';
		echo '<li><b>Monthly Food Costs</b>: ' . c() . ' $ </li>';


		echo '</ul>';
	}
}

if( isset( $_REQUEST['refresh'] ) ) {
	echo sum();
	return;
}
?>

<html>
<head>
	<title>Family Simulator</title>
</head>
<body>
<h1>Family Simulator</h1>
<form>
<input type="submit" name="add_mum" value="Add Mum" />
<input type="submit" name="add_dad" value="Add Dad" />
<input type="submit" name="add_child" value="Add Child" />
<input type="submit" name="add_cat" value="Add Cat" />
<input type="submit" name="add_dog" value="Add Dog" />
<input type="submit" name="add_goldfish" value="Add Goldfish" />
<input type="submit" name="reset" value="Reset" />
</form>

<div>
	<?php echo sum() ?>
</div>


<script src="jquery-1.12.4.min.js"></script>
<script type="text/javascript">
	(function( $ ) {
		$( 'input' ).on( 'click', function() {
			$( 'input' ).removeAttr('data-clicked');
			$( this ).attr('data-clicked', 'clicked');
		})
		$( 'form' ).on( 'submit', function( e ) {
			e.preventDefault();

			$.ajax({
				method: "POST",
				data: { control: $( '[data-clicked]' ).attr( 'name' ) }
			}).done(function( error ) {
				if( error ) {
					alert( error );
				} else {
					$.ajax({
						method: "POST",
						data: { refresh: 1 }
					}).done(function( sum ) {
						if( sum ) {
							$( 'div' ).html( sum );
						}
					});
				}
			});
		} );
	})(jQuery);
</script>
</body>
</html>

