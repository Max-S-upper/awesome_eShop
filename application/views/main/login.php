<main class="login">
    <h1>Sign in:</h1>
    <form action="signed" method="post" class="emphasized-container">
        <?php if ($err): ?>
            <div class="errors-container">
                <strong>Whoops! Something went wrong.</strong>
                <ul>
                    <li><?= $err ?></li>
                </ul>
            </div>
        <?php endif; ?>
        <label class="email-container">
            <span>Email</span>
            <input type="email" name="email" required>
        </label>
        <label class="password-container">
            <span>Password</span>
            <input type="password" name="password" required>
        </label>
        <div class="submit-container">
            <input type="submit" value="Sign in" class="btn1">
        </div>
    </form>
</main>