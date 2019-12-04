<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calculator</title>
</head>
<body>
<form action="" method="post">
    <input name="a" type="number" step="0.1" placeholder="Type the first number" required>
    <input name="sign" type="text" placeholder="Type an action sign" required>
    <input name="b" type="number" step="0.1" placeholder="Type the second number" required>
    <input name="send" type="submit" value="count">
</form>
</body>
</html>
<?php
if (isset($_POST['send'])) {
    class Incorrect_sign extends Exception{}
    class Divides_zero extends Exception{}
    class Divides_on_zero extends Exception{}
    function calculate($a, $b, $sign) {
        try {
            switch ($sign) {
                case '+':
                    $sum = $a + $b;
                    break;
                case '-':
                    $sum = $a - $b;
                    break;
                case '*':
                    $sum = $a * $b;
                    break;
                case '/':
                    $sum = $a / $b;
                    if ($a == 0) throw new Divides_zero("Error: u can't divide zero.");
                    else if ($b == 0) throw new Divides_on_zero("Error: u can't divide on zero.");
                    break;
                default:
                    throw new Incorrect_sign("Error: you typed and incorrect sign, use one of the following: +, -, * or /");
                    break;
            }
        } catch (Incorrect_sign $e) {
            return $e->getMessage();
        } catch (Divides_zero $e) {
            return $e->getMessage();
        } catch (Divides_on_zero $e) {
            return $e->getMessage();
        }

        return $sum;
    }

    echo calculate($_POST['a'], $_POST['b'], $_POST['sign']);
}
