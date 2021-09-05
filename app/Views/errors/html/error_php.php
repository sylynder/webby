<?php
defined('COREPATH') or exit('No direct script access allowed');
?>
<title>A PHP Error Exception</title>
<style type="text/css">
	body {
		background-color: rgb(72, 4, 156);
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
		top: 50px;
		right: 0;
		bottom: 0;
		left: 0;
		width: 50%;
		height: 80%;
		background-color: #292929;
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
</style>

<body>
	<div class="center-div div-shadow">
		<div class="body">

			<h1><code>A PHP error was encountered</code></h1>

			<div id="within" style="border:2px solid #48049c;padding-left:20px;margin:0 0 10px 0;">
				<code>
					<p><span class="mtitle">Severity:</span> <?php echo $severity; ?></p>
					<p><span class="mtitle">Message:</span><span class="mmessage"><?php echo $message; ?></span></p>
					<p><span class="mtitle">Filename:</span><span class="mmessage"><?php echo $filepath; ?></span></p>
					<p><span class="mtitle">Line Number:</span><span class="mdigit"><?php echo $line; ?></span></p>

					<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE) : ?>

						<p><span class="mh">Backtrace:<span></p>

						<?php foreach (debug_backtrace() as $error) : ?>

							<?php if (isset($error['file']) && strpos($error['file'], realpath(CIPATH)) !== 0) : ?>

								<p style="margin-left:10px">
									<span class="mtitle">File:</span> <span class="mmessage"><?php echo $error['file']; ?></span><br />
									<span class="mtitle">Line:</span> <span class="mdigit"><?php echo $error['line']; ?></span><br />
									<span class="mtitle">Function:</span> <?php echo $error['function']; ?>
								</p>

							<?php endif ?>

						<?php endforeach ?>

					<?php endif ?>

				</code>
			</div>

		</div>
	</div>
</body>
<br>