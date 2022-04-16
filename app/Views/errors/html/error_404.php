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

		.w-text-center {
			text-align: center;
		}

		.w-button {
			font-family: 'Montserrat', 'Arial', sans-serif;
			display: inline-block;
			font-size: 1.2em;
			font-weight: 600;
			padding: 1em 2em;
			margin-top: 1em;
			margin-bottom: 60px;
			-webkit-appearance: none;
			appearance: none;
			background-color: #48049c;
			color: #e3f6fa;
			border-radius: 4px;
			border: none;
			cursor: pointer;
			position: relative;
			transition: transform ease-in 0.1s, box-shadow ease-in 0.25s;
			box-shadow: 0 2px 25px rgba(204, 200, 180, 0.5);
		}

		.w-button:hover {
			background-color: #5b08c2;
			color: white;
		}

		.w-button:focus {
			outline: 0;
		}

		.w-button:before,
		.w-button:after {
			position: absolute;
			content: '';
			display: block;
			width: 140%;
			height: 100%;
			left: -20%;
			z-index: -1000;
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
				<?php
				http_response_code(404);
				echo http_response_code();
				?>
			</div>

			<div class="w-message-error w-webby-color" style="padding: 10px;">
				NOT FOUND
			</div><br>
		</div>
		<div style="text-align: center;">
			<h2><code><?php echo ucwords($heading); ?></code></h2>
			<code><?php echo $message; ?></code>
		</div>

		<div class="w-text-center" style="margin-top: 40px;">
			<a class="w-button" href="javascript:window.history.go(-1);">GO BACK</a>
		</div>
	</div>

</body>

</html>