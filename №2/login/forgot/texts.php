<?php
$step1 = '<div class="form-container" id="step1">
<form action="forgot_back.php" method="post">
    <h1>Recover</h1>
    <p>Use your email to recover your password. We will send verification code on your email</p>
    <input type="text" placeholder="Email" name="recover_email">
    <button>Send code</button>
</form>
</div>';
$step2 = '<div class="form-container" id="step2">
<form action="forgot_back.php" method="post">
    <h1>Recover</h1>
    <p>Enter code which we sent on your email:</p>
    <input type="text" placeholder="Code" name="check_code">
    <button>Confirm</button>
</form>
</div>';
$step3 = '<div class="form-container" id="step3">
<form action="forgot_back.php" method="post">
    <h1>Recover</h1>
    <p>Enter a new password:</p>
    <input type="password" placeholder="New password" name="new_password">
    <p>Confirm new password:</p>
    <input type="password" placeholder="Confirm password" name="confirm_password">
    <button>Change password</button>
</form>
</div>';
