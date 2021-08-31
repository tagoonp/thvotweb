<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">
                <li class="nav-item <?php if($menu == 0){ echo "active"; } ?>"><a href="./"><i class="menu-livicon" data-icon="desktop"></i><span class="menu-title text-truncate">หน้าแรก</span></a></li>
                <li class="nav-item <?php if($menu == 1){ echo "active"; } ?>"><a href="./alarm"><i class="menu-livicon" data-icon="alarm"></i><span class="menu-title text-truncate">ตั้งเวลา</span></a></li>
                <li class="nav-item <?php if($menu == 2){ echo "active"; } ?>"><a href="./observer"><i class="menu-livicon" data-icon="users"></i><span class="menu-title text-truncate">พี่เลี้ยง</span></a></li>
                <li class="nav-item <?php if($menu == 99){ echo "active"; } ?>"><a href="./user-profile"><i class="menu-livicon" data-icon="user"></i><span class="menu-title text-truncate">โปรไฟล์</span></a></li>
                <li class="nav-item <?php if($menu == 98){ echo "active"; } ?>"><a href="./user-profile"><i class="menu-livicon" data-icon="location-alt"></i><span class="menu-title text-truncate">บันทึกพิกัดบ้าน</span></a></li>
            </ul>