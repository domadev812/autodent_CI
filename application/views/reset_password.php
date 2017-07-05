
<div class="row">

	<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4 col-lg-2 col-lg-offset-5">
        <div class="logo text-center">
            <a href="/"><img src="/assets/images/logo.png" alt="AutoDent" class="img-responsive"></a>
        </div>
        <p class="text-center text-dark text-bold text-extra-large margin-top-15">
            Change Password
        </p>
        
        <?if(!empty($error)):?>
         
        <p class="text-center text-large margin-top-15">
           <i><?=$error?></i>
        </p>
        <hr>
        <div class="copyright">2016 &copy; AutoDent.</div>
        
        <?else:?>
        
        <p class="text-center">
            The password should be at least <?=$min_password_length?> characters long
        </p>
        
        <!-- start: BOX -->
        <div class="box-login">
            <form class="form-login" id="auth-form" accept-charset="utf-8">          
            	<div class="msg"></div>
            	
                <div class="form-group form-actions">
                    <input type="password" class="form-control required" required name="new" pattern="^.{<?=$min_password_length?>}.*$" placeholder="New Password" />
                </div>               
                <div class="form-group form-actions">
                    <input type="password" class="form-control required" required name="new_confirm" pattern="^.{<?=$min_password_length?>}.*$" placeholder="Confirm New Password" />
                </div>
                
               
                <div class="form-actions">
                    <button type="submit" class="btn btn-red btn-block">
                        Change
                    </button>
                </div>

                <input type="hidden" name="function" value="reset_password" />
                <input type="hidden" name="user_id" value="<?=$user_id?>" />
                <input type="hidden" name="code" value="<?=$code?>" />
                <?=form_hidden($csrf)?>
            </form>
            <hr>
            <div class="copyright">2016 &copy; AutoDent.</div>
        </div>
        <!-- end: BOX -->
        
        <?endif;?>
        
    </div>
    
</div>



