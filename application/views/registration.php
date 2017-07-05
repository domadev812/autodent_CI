

<div class="row">

	<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4 col-lg-2 col-lg-offset-5">
        <div class="logo text-center">
           <a href="/"><img src="/assets/images/logo.png" alt="AutoDent" class="img-responsive"></a>
        </div>
        <p class="text-center text-dark text-bold text-extra-large margin-top-15">
            Sign Up
        </p>
        <p class="text-center">
            Enter your personal details below:
        </p>
        <!-- start: REGISTER BOX -->
        <div class="box-register">
            <form id="auth-form" class="form-login">
                
                <div class="msg"></div>
                
                <div class="form-group">
                    <input type="text" class="form-control required" required name="first_name" placeholder="First Name">
                </div>                
                <div class="form-group">
                    <input type="text" class="form-control required" required name="last_name" placeholder="Last Name">
                </div>
                <p>
                    Enter your account details below:
                </p>
                <div class="form-group">
                    <input type="email" class="form-control required" name="email" required placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control required" id="password" name="password"  pattern="^.{<?=$min_password_length?>}.*$" required placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control required" name="password_confirm"  pattern="^.{<?=$min_password_length?>}.*$" required placeholder="Confirm Password">
                </div>
                <p class="text-center">
            		The password should be at least <?=$min_password_length?> characters long
        		</p>
                
                <div class="form-actions">
                    <p class="text-center">
                        Already have an account?
                        <a  href="/auth/login">
                            Log-in
                        </a>
                    </p>
                    <button type="submit" class="btn btn-red btn-block">
                        Submit
                    </button>
                </div>
                <input type="hidden" name="function" value="registration" />
            </form>
            <hr>
            <div class="copyright">2016 &copy; <?=$this->site_name?>.</div>

        </div>
        <!-- end: REGISTER BOX -->
    </div>
    
</div>