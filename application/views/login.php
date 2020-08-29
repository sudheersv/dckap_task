<div class="container">
    <div class="text-center mt-20">
        <h2>User Management</h2>
    </div>
    <div class="row mt-20">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <span class="anchor" ></span> 
            <!-- form card login -->
            <div class="card card-outline-secondary">
                <div class="card-header">
                    <h3 class="mb-0">Login</h3>
                </div>
                <div class="card-body">
                    <form  id="formLogin" method="post" autocomplete="off">
                        <div class="form-group">
                            <input class="form-control" id="uname1" name="email" placeholder="Email"  type="text">
                        </div>
                        <div class="form-group">
                            <input autocomplete="new-password" class="form-control" placeholder="Password" name="password" type="password">
                        </div>
                        <div class="form-check small">
                            <label class="form-check-label">
                                <h4>If you don't have account please <a href="<?php echo base_url('register') ?>" style="color: blue">Add User</a></h4>
                                <!--<input class="form-check-input" type="checkbox">--> 
                                <!--<span>Remember me on this computer</span>-->
                            </label>
                        </div>
                        <button class="btn btn-success btn-lg float-right" type="submit">Login</button>
                    </form>
                </div><!--/card-block-->
            </div><!-- /form card login -->
        </div>
    </div>    
</div>    