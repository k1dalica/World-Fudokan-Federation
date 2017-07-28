<?php
class Redirect {
	public static function to($location = '/') {
		header("Location: $location");
		echo "<script>
			window.location='$location';
		</script>";
		exit();
	}
}