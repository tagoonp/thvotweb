<li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="javascript:void(0);" data-toggle="dropdown">
        <div class="user-nav d-sm-flex d-none"><span class="user-name"><?php echo $user['fname']." ".$user['lname']; ?> <span class="badge badge-danger">(<?php 
        if($user['role'] == 'administrator'){ echo "ผู้ดูแลระบบ"; }
        if($user['role'] == 'moderator'){ echo "ผู้รับผิดชอบส่วนกลาง"; }
        if($user['role'] == 'manager'){ echo "ผู้รับผิดชอบส่วนงานสถานบริการ"; }
        if($user['role'] == 'staff'){ echo "ผู้ปฏิบัติงานบันทึกข้อมูล"; }
        if($user['role'] == 'patient'){ echo "ผู้ป่วย"; }
        ?>)</span></span><span class="user-status text-muted">
        
        </span></div><span><img class="round" src="<?php if(($user['profile_img'] != '') && ($user['profile_img'] != null)){ echo $user['profile_img']; }else{ echo "../../../app-assets/images/portrait/small/avatar-s-11.jpg"; }?>" alt="avatar" height="40" width="40"></span>
    </a>
    <div class="dropdown-menu dropdown-menu-right pb-0">
        <a class="dropdown-item" href="user-profile"><i class="bx bx-user mr-50"></i> แก้ไขข้อมูลส่วนตัว</a>
        <a class="dropdown-item" href="user-password"><i class="bx bx-envelope mr-50"></i> เปลี่ยนรหัสผ่าน</a>
        <a class="dropdown-item" href="user-security"><i class="bx bx-check-square mr-50"></i> ความปลอดภัย</a>
        <div class="dropdown-divider mb-0"></div>
        <a class="dropdown-item" href="../../../controller/auth?stage=logout"><i class="bx bx-power-off mr-50"></i> ออกจากระบบ</a>
    </div>
</li>