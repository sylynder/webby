<?php defined('COREPATH') or exit('No direct script access allowed'); ?>

<title>A PHP Error Exception</title>

<div class="w-div-shadow" style="
        border:2px solid #48049c;
        padding:20px;
        margin:10px 10px 10px 10px;
    ">
	<style>
		.w-h1 {
			color: #8c8b8b;
			background-color: transparent;
			font-size: 30px;
			font-weight: 500;
			margin: 0 0 14px 0;
			padding: 14px 15px 10px 15px;
			text-align: center;
		}

		.w-p {
			color: #8c8b8b;
			line-height: 26px;
			font-weight: 600;
		}

		.w-p:hover {
			background-color: rgba(72, 4, 156, 0.50);
			cursor: pointer;
		}

		.error-hover:hover {
			color: #02241e !important;
		}

		.error-hover span:hover {
			color: #02241e !important;
		}

		.w-p-error {
			margin-left: 10px;
			margin-bottom: 10px;
		}

		.w-p-error:hover {
			background-color: rgba(72, 4, 156, 0.25);
			cursor: pointer;
		}

		.w-code {
			font-family: monospace;
			font-size: inherit;
			overflow: auto;
		}

		.w-mark {
			background-color: rgba(72, 4, 156, 0.50);
		}

		.w-div-shadow {
			box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
			margin-top: 50px;
		}

		.w-small {
			font-size: 0.5em;
			font-style: italic;
		}

		.w-mh {
			padding: 0.1em 0.2em;
			color: #8c8b8b;
		}

		.w-title {
			padding: 0.1em 0.2em;
			color: #02241e;
			font-weight: bolder;
			font-size: 1.000013em;
		}

		.w-message {
			padding: 0.1em 0.2em;
			color: #a17600;
			font-weight: bolder;
			font-size: 1.000013em;
			font-style: italic;
		}

		.w-digit {
			padding: 0.1em 0.2em;
			color: #d13b04;
			font-weight: bolder;
			font-size: 1.000013em;
		}

		.w-text-center {
			text-align: center;
		}
	</style>

	<h1 class="w-title w-h1">A PHP Error Was Encountered</h1>

	<p class="w-p error-hover"><span class="w-title">Severity:</span> <?php echo $severity; ?></p>
	<p class="w-p error-hover"><span class="w-title">Message:</span> <span class="w-message"><?php echo $message; ?></span></p>

	<?php if (strpos($filepath, "eval()'d code") !== false) : ?>
		<p><span class="mtitle">Error Location:</span><span class="mmessage"><?php echo "Can possibly be from the current {View}, found in the current Controller: {" . ucwords($GLOBALS['class']) . "} inside the {" . ucwords($GLOBALS['method']) . "()} method." ?></span></p>
	<?php else : ?>

		<p class="w-p error-hover"><span class="w-title error-hover">Filename:</span><span class="w-message"><?php echo $filepath; ?></span></p>
		<p class="w-p error-hover w-mark"><span class="w-title error-hover"> Line Number:</span> <span class="w-digit"><?php echo $line; ?></span></p>

		<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE) : ?>

			<p class="w-p"><span class="w-mh">Backtrace:<span></p>
			<?php foreach (debug_backtrace() as $error) : ?>

				<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0) : ?>

					<p class="w-p-error">
						<span class="w-title">File:</span> <span class="w-message"><?php echo $error['file']; ?></span><br />
						<span class="w-title">Line:</span> <span class="w-digit"><?php echo $error['line']; ?></span><br />
						<span class="w-title">Function:</span> <?php echo $error['function']; ?>
					</p>

				<?php endif ?>

			<?php endforeach ?>

		<?php endif ?>

	<?php endif ?>

</div>