<main class="signUp">
    <h1>Sign up:</h1>
    <form action="registered" method="post" class="emphasized-container">
        <?php if ($err): ?>
            <div class="errors-container">
                <strong>Whoops! Something went wrong.</strong>
                <ul>
                    <li><?= $err ?></li>
                </ul>
            </div>
        <?php endif; ?>
        <label class="name-container">
            <span>Name</span>
            <input type="text" name="name" required>
        </label>
        <label class="surname-container">
            <span>Surname</span>
            <input type="text" name="surname" required>
        </label>
        <label class="email-container">
            <span>Email</span>
            <input type="email" name="email" required>
        </label>
        <label class="password-container">
            <span>Password</span>
            <input type="password" name="password" required>
        </label>
        <label class="password-container">
            <span>Confirm password</span>
            <input type="password" name="confirm-password" required>
        </label>
        <div class="submit-container">
            <input type="submit" name="signUp" value="Sign up" class="btn1">
        </div>
    </form>
</main>