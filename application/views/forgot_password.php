<div class="row">

	<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4 col-lg-2 col-lg-offset-5">
        <div class="logo text-center">
            <a href="/"><img src="/assets/images/logo.png" alt="<?=$this->site_name?>" class="img-responsive"></a>
        </div>
        
        <?=$message?>
        
        
        <p class="text-center text-dark text-bold text-extra-large margin-top-15">
            Forget Password?
        </p>
        <p class="text-center">
            Enter your e-mail address below to reset your password.
        </p>
       
        
        <!-- start: BOX -->
        <div class="box-login">
            <form class="form-login" id="auth-form" accept-charset="utf-8">
                <div class="msg"></div>
                <div class="form-group">
                    <input type="email" class="form-control required" required name="identity" placeholder="Email">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-red btn-block">
                        Submit
                    </button>
                </div>
                <div class="new-account text-center">
                    Don't have an account yet?
                    <a href="/auth/registration"> Create an account </a>
                </div>
                <input type="hidden" name="function" value="forgot_password" />
            </form>
            <hr>
            <div class="copyright">2016 &copy; <?=$this->site_name?>.</div>
        </div>
        <!-- end: BOX -->
    </div>

</div>




