<?php
/**
 * @var \App\Models\User $user
 */

use Core\Router;

?>
<p>Username: <?=$user->username?></p>
<p>Balance: <?=$user->getBalance()?></p>

<form action="<?php echo Router::createUrl('pay'); ?>" method="POST">
    <input type="number" step="0.01" min="0.01" max="9999999" name="amount" id="amount" placeholder="0.00" required autofocus>
    <button name="action">Ok</button>
</form>