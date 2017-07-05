<div class="row">

	<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4 col-lg-2 col-lg-offset-5">
        <div class="logo text-center">
            <a href="/"><img src="/assets/images/logo.png" alt="<?=$this->site_name?>" class="img-responsive"></a>
        </div>
        <p class="text-center text-dark text-bold text-extra-large margin-top-15">
            Welcome to <?=$this->site_name?>
        </p>
        <p class="text-center">
            Lorem ipsum dolor sit amet, consect adipiscing elit. Mauris tempus dui a feugiat porta. Sed efficitur mattis lorem, eu molestie risus.
        </p>
        <p class="text-center">
            Please enter your email and password to log in.
        </p>

        <!-- start: BOX -->
        <div class="box-login">
            <form class="form-login" id="auth-form" accept-charset="utf-8"> 
                <div class="msg"><?=$message?></div>
                <div class="form-group">
                    <input type="email" class="form-control required" required name="identity" placeholder="Email">
                </div>
                <div class="form-group form-actions">
                    <input type="password" class="form-control required" required name="password" placeholder="Password">
                </div>
                <div class="text-center">
                    <a href="/auth/forgot_password"> I forgot my password </a>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-red btn-block">
                        Login
                    </button>
                    <div class="checkbox clip-check check-primary">
                        <input type="checkbox" id="remember" value="1">
                        <label for="remember"> Keep me signed in </label>
                    </div>
                </div>
                <div class="new-account text-center">
                    Don't have an account yet?
                    <a href="/auth/registration"> Create an account </a>
                </div>
                <input type="hidden" name="function" value="login" />
            </form>
            <hr>
            <div class="copyright">2016 &copy; <?=$this->site_name?>.</div>
        </div>
        <!-- end: BOX -->
    </div>
    
</div>



