<?php declare(strict_types=1);
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="exception">

<h4>An uncaught Exception was encountered</h4>

<p>Type: <?php echo get_class($exception); ?></p>
<p>Message: <?php echo $message; ?></p>
<p>Filename: <?php echo $exception->getFile(); ?></p>
<p>Line Number: <?php echo $exception->getLine(); ?></p>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === true) { ?>

	<p>Backtrace:</p>
	<?php foreach ($exception->getTrace() as $error) { ?>

		<?php if (isset($error['file']) && !str_starts_with($error['file'], realpath(BASEPATH))) { ?>

			<p>
			File: <?php echo $error['file']; ?><br />
			Line: <?php echo $error['line']; ?><br />
			Function: <?php echo $error['function']; ?>
			</p>
		<?php } ?>

	<?php } ?>

<?php } ?>

</div>