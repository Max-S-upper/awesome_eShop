$(document).ready(() => {
    $(".pushLogin").click(() => {
        let $loginContainer = $(".login-container");
        $loginContainer.removeClass('hidden');
        setTimeout(() => $loginContainer.removeClass('transparent'), 100);
    });

    let $closeLogin = () => {
        let $loginContainer = $(".login-container");
        $loginContainer.addClass('transparent');
        $loginContainer.on('transitionend webkitTransitionEnd oTransitionEnd', () => {
            $loginContainer.addClass('hidden');
            $loginContainer.off('transitionend webkitTransitionEnd oTransitionEnd');
        });
    }

    $(".close-login").click($closeLogin);

    $(".login-submit").click(() => {
        let $email = $(".email-container input").val();
        let $password = $(".password-container input").val();
        $.ajax({
            url: 'http://eshop.com/authorization',
            type: 'post',
            data: {
                'email': $email,
                'password': $password
            },
            success: ($answer) => {
                console.log($answer);
                if ($answer) {
                    let $errorsContent = `<strong>Whoops! Something went wrong.</strong>
                                            <ul>
                                                <li>${$answer}</li>
                                            </ul>`;
                    $(".login-container .errors-container").html($errorsContent);
                }

                else {
                    $closeLogin;
                    // $('header').remove();
                    $('header').load('http://eshop.com/application/views/includes/header_signed.php', function() {
                        setTimeout($closeLogin, 100);
                    });
                }
            }
        });
    });
});