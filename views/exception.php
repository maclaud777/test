<?php
/**
 * @var \core\Exception $exception
 */
?>
    <h1>Application Exception
        <small><?php echo $exception->getFile(); ?>, line <?php echo $exception->getLine(); ?></small>
    </h1>
    <p><?php echo $exception->getMessage(); ?></p>

<?php var_dump($exception); ?>