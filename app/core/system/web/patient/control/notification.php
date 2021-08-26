<li class="dropdown dropdown-notification nav-item">
    <a class="nav-link nav-link-label" href="javascript:void(0);" data-toggle="dropdown"><i class="ficon bx bx-bell bx-tada bx-flip-horizontal"></i><?php 
                                    $strSQL = "SELECT COUNT(noti_id) cn FROM vot2_notification WHERE noti_specific_uid = '".$user['uid']."' AND noti_view = '0' AND noti_type = 'patient_message'";
                                    $resNoti = $db->fetch($strSQL, false);
                                    if($resNoti){
                                        if(($resNoti['cn'] != 0) && ($resNoti['cn'] != null)){ echo '<span class="badge badge-pill badge-danger badge-up">'.$resNoti['cn'].'</span>'; }
                                    }
                                    ?></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right" style="margin: 20px !important;">
                                <li class="dropdown-menu-header bg-dark">
                                    <div class="dropdown-header px-1 py-75 d-flex justify-content-between"><span class="notification-title">มี <?php 
                                    $strSQL = "SELECT COUNT(noti_id) cn FROM vot2_notification WHERE noti_specific_uid = '".$user['uid']."' AND noti_view = '0' AND noti_type = 'patient_message'";
                                    $resNoti = $db->fetch($strSQL, false);
                                    if($resNoti){
                                        if($resNoti['cn'] != null){ echo $resNoti['cn']; }else{ echo "0"; }
                                    }else{
                                        echo "0";
                                    }
                                    ?> การแจ้งเตือนใหม่</span><span class="text-bold-400 cursor-pointer">ทำเครื่องหมายอ่านแล้วทั้งหมด</span></div>
                                </li>
                                <li class="scrollable-container media-list">
                                    <?php 
                                    $strSQL = "SELECT * FROM vot2_notification WHERE noti_specific_uid = '".$user['uid']."' AND noti_type = 'patient_message' LIMIT 20";
                                    $resNoti = $db->fetch($strSQL, true, false);
                                    if(($resNoti) && ($resNoti['status'])){
                                        foreach ($resNoti['data'] as $row) {
                                            $bgNoti = '';
                                            if($row['noti_view'] == '1'){ $bgNoti = 'read-notification'; }
                                            ?>
                                            <a class="d-flex justify-content-between cursor-pointer" href="javascript:void(0);">
                                                <div class="media d-flex align-items-center">
                                                    <div class="media-left pr-0">
                                                        <div class="avatar bg-primary bg-lighten-5 mr-1 m-0 p-25"><span class="avatar-content text-primary font-medium-2">LD</span></div>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="media-heading"><span class="text-bold-500">New customer</span> is registered</h6><small class="notification-text">1 hrs ago</small>
                                                    </div>
                                                </div>
                                            </a>
                                            <?php
                                        }
                                        
                                    }else{
                                        ?>
                                        <a class="d-flex justify-content-between cursor-pointer" href="javascript:void(0);" style="width: 100%;">
                                            <div class="text-center pt-3 pb-3" style="width: 100%;">
                                                ไม่มีรายการแจ้งเตือน
                                            </div>
                                        </a>
                                        <?php
                                    }
                                    ?></li>
                            </ul>
                        </li>