<div class="container">
    <div class="text-center mt-20">
        <h2>User Management</h2>
    </div>
    <div class="row mt-20">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <span class="anchor" id="formRegister"></span>
            <!--<hr class="mb-5">-->
            <!-- form card register -->
            <div class="card card-outline-secondary">
                <div class="card-header">
                    <h3 class="mb-0"><?php (!empty($user)) && print('Update')?> User Form</h3>
                </div>
                <div class="card-body">
                    <form autocomplete="off" class="form" method="post" enctype="multipart/form-data" id="registerform" role="form">
                        <input name="id" type="hidden" value="<?php (!empty($user)) && print($user['id'])?>">
                        <div class="form-group">
                            <input class="form-control" name="name" id="inputName" placeholder="Full name" type="text" value="<?php (!empty($user)) && print($user['name'])?>">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="uname" placeholder="User name" type="text" value="<?php (!empty($user)) && print($user['user_name'])?>">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="email" id="inputEmail3" placeholder="Email" required="" type="email" value="<?php (!empty($user)) && print($user['email'])?>">
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="Password" name="password" placeholder="Password" required="" type="password"> 
                            <small class="form-text text-muted" id="passwordHelpBlock">Your password must be 5 characters long.</small>
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="password_confirm" placeholder="Confirm Password " required="" type="password">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="mobile"  placeholder="Mobile Number" type="text" value="<?php (!empty($user)) && print($user['mobile'])?>">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="profile"  placeholder="profile" type="file" accept="image/x-png,image/gif,image/jpeg,image/jpg" <?php (empty($user)) && print("required")?>>
                            <input name="oldprofile" type="hidden" value="<?php (!empty($user)) && print($user['profile_img'])?>">
                        </div>
                        <?php if(!empty($user)): ?>
                        <div>
                            <img src="<?php (!empty($user)) && print(base_url('uploads/'.$user['profile_img']))?>" height="50">
                        </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <input class="form-control" name="dob"  placeholder="Date of birth" type="date" value="<?php (!empty($user)) && print($user['dob'])?>">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="address" placeholder="Address"><?php (!empty($user)) && print($user['address'])?></textarea>
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="city"  placeholder="City" type="text" value="<?php (!empty($user)) && print($user['city'])?>">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="state"  placeholder="State" type="text" value="<?php (!empty($user)) && print($user['state'])?>">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="country"  placeholder="Country" type="text" value="<?php (!empty($user)) && print($user['country'])?>">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-lg float-right" type="submit"><?php (!empty($user)) ? print("Update User") : print('Add User')?></button>
                        </div>
                    </form>
                </div>
            </div><!-- /form card register -->
        </div>
    </div>
</div>
