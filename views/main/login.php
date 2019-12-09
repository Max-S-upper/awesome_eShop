<main class="login">
    <h1>Sign in:</h1>
    <form action="signed" method="post">
        <input type="email" name="email" placeholder="email" required>
        <input type="password" name="password" placeholder="password" required>
        <input type="submit" value="Sign in">
    </form>
    <p class="error"><?php if ($err) echo $err; ?></p>
</main>