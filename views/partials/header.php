    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="float-left">
                        <div class="hamburger sidebar-toggle m-t-5">
                            <span class="line"></span>
                            <span class="line"></span>
                            <span class="line"></span>
                        </div>
                    </div>
                    <div class="float-right"> 
                        <div class="dib">
                            <div class="header-icon">
                                <span class="user-avatar text-uppercase"><?php echo $firstname.' '.$middlename.' '.$lastname; ?></span>
                            </div>
                        </div>
                        <div class="dib">
                            <div class="header-icon">
                                <?php if($profile == 'Default.png'){
                                    echo '<img src="'.BASE_URL.'public/assets/images/'.$profile.'" class="profile-header" alt="profile" />';
                                }else{
                                    echo '<img src="'.BASE_URL.'storage/profiles/'.$profile.'" class="profile-header" alt="profile" />';
                                }  
                                ?>
                            </div>
                        </div>             
                    </div>
                </div>
            </div>
        </div>
    </div>