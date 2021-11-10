<?php defined('COREPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Database Error</title>

	<style type="text/css">
		body {
			background-color: rgb(250, 250, 252);
			font: 16px/26px normal Helvetica, Arial, sans-serif;
		}

		a {
			color: #003399;
			background-color: transparent;
			font-weight: normal;
		}

		img {
			width: 20%;
		}

		h1 {
			color: #8c8b8b;
			background-color: transparent;
			font-size: 30px;
			font-weight: 500;
			margin: 0 0 14px 0;
			padding: 14px 15px 10px 15px;
			text-align: center;
		}

		h2,
		h3 {
			color: #8c8b8b;
			background-color: transparent;
			font-size: 25px;
			font-weight: 700;
			margin: 0 0 14px 0;
			padding: 14px 15px 10px 0px;
			text-align: center;
		}

		p {
			color: #8c8b8b;
			line-height: 26px;
			font-weight: 600;
		}

		code {
			font-family: monospace;
			font-size: inherit;
		}

		mark {
			background-color: #c0ffc8;
		}

		.center-div {
			margin: auto;
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
			width: 80%;
			height: 60%;
			overflow-y: scroll;
			background-color: #f2f2f2;
			border-radius: 3px;
			-moz-box-shadow: 0 0 3px #ccc;
			-webkit-box-shadow: 0 0 3px #ccc;
			box-shadow: 0 0 3px #ccc;
			overflow: auto;
		}

		.div-shadow {
			box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
			margin-top: 50px;
		}

		.body {
			position: relative;
			padding: 20px;
			margin: 5px;
			height: 80%;
		}

		.small {
			font-size: 0.5em;
			font-style: italic;
		}

		.mh {
			background-color: #9e9d9d;
			padding: 0.1em 0.2em;
			color: #8c8b8b;
		}

		.mtitle {
			padding: 0.1em 0.2em;
			color: #11a68d;
			font-weight: bolder;
			font-size: 1.000013em;
		}

		.mmessage {
			padding: 0.1em 0.2em;
			color: #b89611;
			font-weight: bolder;
			font-size: 1.000013em;
			font-style: italic;
		}

		.mdigit {
			padding: 0.1em 0.2em;
			color: #d13b04;
			font-weight: bolder;
			font-size: 1.000013em;
		}

		.text-center {
			text-align: center;
		}

		.error_code {
			display: flex;
			justify-content: center;
		}

		.error_code h1 {
			font-size: 100px;
			animation: type .5s alternate infinite;
		}

		@keyframes type {
			from {
				box-shadow: inset -3px 0px 0px #888;
			}

			to {
				box-shadow: inset -3px 0px 0px transparent;
			}
		}
	</style>
</head>

<body>
	<div class="center-div div-shadow">
		<div class="body" style="margin-top: 60px;">
			<h2><code><?php echo ucwords($heading); ?></code></h2>
			<div class="error_code">
				<h1>Error <?php echo http_response_code(); ?></h1>
			</div>
			<h3><code><span style="color:rgb(210, 210, 212)"><?php echo $message; ?></span></code></h3>
		</div>
	</div>
</body>

</html>