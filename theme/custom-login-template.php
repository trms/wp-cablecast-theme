<?php 
/*
Template Name: Custom Login Page
*/
?>
<div>
    <?php 
// Output the header
get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="container">
                <div class="w-1/3 my-0 mx-auto shadow-xl mt-8 p-8">
                    <h2 class="text-center mb-4 text-2xl font-bold">Login</h2>
                    <form name="loginform" id="loginform" action="<?php echo esc_url( wp_login_url() ); ?>"
                        method="post">
                        <p class="login-username flex flex-col gap-y-2">
                            <label class="font-bold" for="user_login">Username or Email Address</label>
                            <input type="text" name="log" id="user_login" autocomplete="username"
                                class="border border-gray-300 shadow" value="" size="20">
                        </p>
                        <p class="login-password flex flex-col gap-y-2 mt-4">
                            <label class="font-bold" for="user_pass">Password</label>
                            <input type="password" name="pwd" id="user_pass" class="border border-gray-300 shadow"
                                autocomplete="current-password" spellcheck="false" class="input" value="" size="20">
                        </p>
                        <p class="login-remember flex flex-col gap-y-2 mt-4"><label><input name="rememberme"
                                    type="checkbox" class="font-bold" id="rememberme" value="forever"> Remember
                                Me</label></p>
                        <p class="login-submit mt-8">
                            <input type="submit" name="wp-submit" id="wp-submit"
                                class="button button-primary bg-brand-accent p-2 text-white" value="Log In" disabled
                                style="cursor: default; background-color: #ccc;">
                            <input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url() ); ?>">
                        </p>
                    </form>
                </div>
            </div>
        </main><!-- #main -->
    </div>
</div><!-- #primary -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    var usernameInput = document.getElementById('user_login');
    var passwordInput = document.getElementById('user_pass');
    var loginButton = document.getElementById('wp-submit');

    usernameInput.addEventListener('input', toggleLoginButton);
    passwordInput.addEventListener('input', toggleLoginButton);

    function toggleLoginButton() {
        if (usernameInput.value.trim() !== '' && passwordInput.value.trim() !== '') {
            loginButton.removeAttribute('disabled');
            loginButton.style.cursor = 'pointer';
            loginButton.style.backgroundColor = '#3192C8'; // Change to the original button color
        } else {
            loginButton.setAttribute('disabled', 'disabled');
            loginButton.style.cursor = 'default';
            loginButton.style.backgroundColor = '#ccc'; // Change to gray background
        }
    }
});
</script>

<?php
// Output the footer
get_footer();
?>