<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">
                <li class="nav-item <?php if($menu == 0){ echo "active"; } ?>"><a href="./"><i class="menu-livicon" data-icon="desktop"></i><span class="menu-title text-truncate">กระดานภาพรวม</span></a></li>
                <li class=" navigation-header text-truncate"><span data-i18n="Apps">จัดการข้อมูล</span></li>
                <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title text-truncate" data-i18n="User">ผู้ใช้งานระบบ</span></a>
                    <ul class="menu-content">
                        <li class="<?php if($menu == 1){ echo "active"; } ?>"><a class="d-flex align-items-center" href="app-users-list"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="List">รายชื่อผู้ใช้งานระบบ</span></a></li>
                        <li class="<?php if($menu == 2){ echo "active"; } ?>"><a class="d-flex align-items-center" href="app-users-add"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="View">เพิ่มผู้ใช้งานใหม่</span></a></li>
                    </ul>
                </li>

                <li class="nav-item"><a href="#"><i class="menu-livicon" data-icon="heart"></i><span class="menu-title text-truncate" data-i18n="User">สถานบริการ</span></a>
                    <ul class="menu-content">
                        <li class="<?php if($menu == 3){ echo "active"; } ?>"><a class="d-flex align-items-center" href="app-facility-list"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="List">รายชื่อเปิดใช้งาน</span></a></li>
                        <li class="<?php if($menu == 4){ echo "active"; } ?>"><a class="d-flex align-items-center" href="app-facility-add"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="View">เพิ่มสถานบริการใหม่</span></a></li>
                        <li class="<?php if($menu == 11){ echo "active"; } ?>"><a class="d-flex align-items-center" href="app-facility-map"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Leaflet Maps">แผนที่สถานบริการ</span></a></li>
                    </ul>
                </li>

                <li class="nav-item"><a href="#"><i class="bx bxs-capsule"></i><span class="menu-title text-truncate" data-i18n="User">ฐานข้อมูลยา</span></a>
                    <ul class="menu-content">
                        <li class="<?php if($menu == 5){ echo "active"; } ?>"><a class="d-flex align-items-center" href="app-drug-list"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="List">รายการยา</span></a></li>
                        <li class="<?php if($menu == 6){ echo "active"; } ?>"><a class="d-flex align-items-center" href="app-drug-add"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="View">เพิ่มยาใหม่</span></a></li>
                    </ul>
                </li>
                
                <li class="navigation-header text-truncate"><span data-i18n="UI Elements">THVOT</span></li>
                <li class="nav-item"><a href="#"><i class="bx bx-handicap"></i><span class="menu-title text-truncate" data-i18n="Content">ผู้ป่วย</span></a>
                    <ul class="menu-content">
                        <li class="<?php if($menu == 7){ echo "active"; } ?>"><a class="d-flex align-items-center" href="app-patient-list"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Grid">รายชื่อผู้ป่วย</span></a></li>
                        <li class="<?php if($menu == 12){ echo "active"; } ?>"><a class="d-flex align-items-center" href="app-patient-add"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Typography">เพิ่มผู้ป่วยใหม่</span></a></li>
                    </ul>
                </li>

                <li class="nav-item"><a href="#"><i class="bx bxs-videos"></i><span class="menu-title text-truncate" data-i18n="Content">ระบบติดตาม</span></a>
                    <ul class="menu-content">
                        <li class="<?php if($menu == 8){ echo "active"; } ?>"><a class="d-flex align-items-center" href="app-video-list"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Typography">รายการส่งวีดีโอรอตรวจ</span></a></li>
                        <li class="<?php if($menu == 13){ echo "active"; } ?>"><a class="d-flex align-items-center" href="app-patient-add"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Typography">วีดีโอทั้งหมด</span></a></li>
                    </ul>
                </li>

                <li class="navigation-header text-truncate"><span data-i18n="Report">รายงาน</span></li>
                <li class="nav-item"><a href="#"><i class="menu-livicon" data-icon="line-chart"></i><span class="menu-title text-truncate" data-i18n="Content">ระบบรายงาน</span></a>
                    <ul class="menu-content">
                        <li class="<?php if($menu == 9){ echo "active"; } ?>"><a class="d-flex align-items-center" href="app-patient-list"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Grid">รายงานทั่วไป</span></a></li>
                        <li class="<?php if($menu == 10){ echo "active"; } ?>"><a class="d-flex align-items-center" href="app-video-list"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate" data-i18n="Typography">รายงานเชิงภูมิศาสตร์</span></a></li>
                    </ul>
                </li>

                <li class=" navigation-header text-truncate"><span data-i18n="UI Elements">การติดต่อสื่อสาร</span></li>

                <li class=" nav-item"><a href="#"><i class="bx bx-message-square-dots"></i><span class="menu-title text-truncate">ระบบการส่งข้อความ</span></a>
                    <ul class="menu-content">
                        <li><a class="d-flex align-items-center" href="auth-login" target="_blank"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate">THVOT Messaging</span></a></li>
                        <li><a class="d-flex align-items-center" href="auth-login" target="_blank"><i class="bx bx-right-arrow-alt"></i><span class="menu-item text-truncate">บันทึกการส่งข้อความ</span></a></li>
                    </ul>
                </li>
                
                <li class="navigation-header text-truncate"><span data-i18n="Charts &amp; Maps">อื่น ๆ</span></li>
                

                <li class="navigation-header text-truncate"><span data-i18n="Support">สนับสนุน</span>
                </li>
                <li class="nav-item"><a href="https://pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/documentation" target="_blank"><i class="menu-livicon" data-icon="morph-folder"></i><span class="menu-title text-truncate" data-i18n="Documentation">คู่มือการใช้งาน</span></a></li>
                <li class="nav-item"><a href="https://pixinvent.ticksy.com/" target="_blank"><i class="menu-livicon" data-icon="help"></i><span class="menu-title text-truncate" data-i18n="Raise Support">ติดต่อฝ่ายสนับสนุน</span></a></li>
            </ul>