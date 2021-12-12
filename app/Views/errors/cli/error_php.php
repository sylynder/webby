<?php defined('COREPATH') or exit('No direct script access allowed'); ?>

A PHP Error Was Encountered

Severity:    <?php echo $severity, "\n"; ?>
Message:     <?php echo $message, "\n"; ?>
Filename:    <?php echo $filepath, "\n"; ?>
Line Number: <?php echo $line; ?>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === true): ?>

Backtrace:
<?php	foreach (debug_backtrace() as $error): ?>
<?php		if (isset($error['file']) && strpos($error['file'], realpath(CIPATH)) !== 0): ?>
	File: <?php echo $error['file'], "\n"; ?>
	Line: <?php echo $error['line'], "\n"; ?>
	Function: <?php echo $error['function'], "\n\n"; ?>
<?php		endif ?>
<?php	endforeach ?>

<?php endif ?>
