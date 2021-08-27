<li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="javascript:void(0);" data-toggle="dropdown">
        <div class="user-nav d-sm-flex d-none"><span class="user-name"><?php echo $user['fname']." ".$user['lname']; ?> <span class="badge badge-danger">(<?php 
            if($user['role'] == 'admin'){ echo "ผู้ดูแลระบบ"; }
            if($user['role'] == 'moderator'){ echo "ผู้รับผิดชอบส่วนกลาง"; }
            if($user['role'] == 'manager'){ echo "พยาบาลคลินิก"; }
            if($user['role'] == 'staff'){ echo "พี่เลี้ยง"; }
            if($user['role'] == 'patient'){ echo "ผู้ป่วย"; }
            ?>)</span></span>
            <!-- <span class="user-status text-muted">
            
            </span> -->
        </div>
        <?php 
            if($menu != 99){
                ?>
                <span><img class="round" src="<?php if(($user['profile_img'] != '') && ($user['profile_img'] != null)){ echo $user['profile_img']; }else{ echo "../../../app-assets/images/portrait/small/avatar-s-11.jpg"; }?>" alt="avatar" height="40" width="40"></span>    
                <?php
            }
        ?>
            
    </a>
    <div class="dropdown-menu dropdown-menu-right pb-0">
        <a class="dropdown-item" href="user-profile"><i class="bx bx-user mr-50"></i> ข้อมูลส่วนตัว</a>
        <div class="dropdown-divider mb-0"></div>
        <a class="dropdown-item" href="Javascript:signout()"><i class="bx bx-power-off mr-50"></i> ออกจากระบบ</a>
    </div>
</li>