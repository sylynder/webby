<?php defined('COREPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Error</title>
	<style>
		.w-div-shadow {
			box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
			margin-top: 50px;
		}

		.w-webby-color {
			color: #6d00cc;
		}

		.w-flex-center {
			align-items: center;
			display: flex;
			justify-content: center;
		}

		.w-position-r {
			position: relative;
		}

		.w-code-error {
			border-right: 3px solid;
			font-size: 55px;
			padding: 0 10px 0 10px;
			text-align: center;
		}

		.w-message-error {
			font-size: 40px;
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="w-div-shadow" style="
        border:2px solid #48049c;
        padding:20px;
        margin:100px 10px 10px 10px;
    ">
		<div class="w-flex-center w-position-r full-height">
			<div class="w-code-error" style="color: red;">
				<?php echo http_response_code(); ?>
			</div>
			
			<div class="w-message-error w-webby-color" style="padding: 10px;">
				INTERNAL SERVER ERROR
			</div><br>
		</div>
		<div style="text-align: center;">
			<h2><code><?php echo ucwords($heading); ?></code></h2>
			<code><?php echo $message; ?></code>
		</div>
	</div>

</body>

</html>