<main>
    <form action="signed" method="post">
        <input type="email" name="email" placeholder="email" required>
        <input type="password" name="password" placeholder="password" required>
        <input type="submit" value="Sign in">
    </form>
    <?php if ($err) echo $err; ?>
</main>