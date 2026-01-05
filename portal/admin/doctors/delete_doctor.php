<?php

require_once '../../../core/init.php';


require_login();

if(!has_permission('doctors', 'can_delete')) {
    json_response("error", "Access Denied");
    exit;
}

require_role([1]);

$_POST = filteration($_POST);

if(!isset($_POST['csrf_token']) || !verify_csrf($_POST['csrf_token'])) {
    json_response("error", "Invalid CSRF Token");
    exit;
}

$ids = explode(',', $_POST['doctor_id']);  
$ids = array_filter($ids);

if(empty($ids)) {
    json_response("error", "Invalid request!");
}

$superAdmins = [];
$idsToDelete = [];

foreach ($ids as $id) {
    if (empty($get_user_id['data'][0]['user_id'])) continue;
    $get_user_id = select("SELECT user_id FROM doctors WHERE doctor_id = ?", [$id],"i");
    $user_id = $get_user_id['data'][0]['user_id'];
    if (is_superadmin('role_id', 'users', 'user_id', $user_id)) {
        $superAdmins[] = $id; 
    } else {
        $idsToDelete[] = $id; 
    }
}

$result = [];
$userIds = [];
if (!empty($idsToDelete)) {
    $placeholders = implode(',', array_fill(0, count($idsToDelete), '?'));
    $type = str_repeat('i', count($idsToDelete));

    $sql_get_users = "SELECT user_id FROM doctors WHERE doctor_id IN ($placeholders)";
    $res = select($sql_get_users, $idsToDelete, $type);

    if ($res['status'] == "success" && $res['rows'] > 0) {
        foreach ($res['data'] as $row) {
            $userIds[] = $row['user_id'];
        }
    }

    $sql = "DELETE FROM doctors WHERE doctor_id IN ($placeholders)";
    $result = delete($sql, $idsToDelete, $type);

    if (!empty($userIds)) {
        $placeholders_users = implode(',', array_fill(0, count($userIds), '?'));
        $datatypes_users = str_repeat('i', count($userIds));

        $sql_update_users = "UPDATE users SET status = 'inactive', role_id = 5 WHERE user_id IN ($placeholders_users)";
        update($sql_update_users, $userIds, $datatypes_users); 

        foreach($userIds as $user_id) {
            $sql_get_image = "SELECT profile_image FROM users WHERE user_id = ?";
            $get_image = select($sql_get_image, [$user_id], "i");

            if($get_image['status'] == "success" && $get_image['rows'] > 0) {
                $image = $get_image['data'][0]['profile_image'];

                if(!empty($image)) {
                    deletefile(realpath( '../../assets/uploads/doctor/profile_image/') . '/' . $image);
                    // if(!deletefile(realpath( '../../assets/uploads/doctor/profile_image/') . '/' . $image)) {
                    //     json_response("error", "invalid Filepath");
                    // }
                }
            }
        }
    }
}

if (!empty($superAdmins)) {
    $superMsg = "Super Admin are protected and cannot be deleted.";
    if (!empty($idsToDelete) && $result['status'] == "success") {
        $result['status'] = "success";
        $result['message'] = "Doctor deleted successfully. ";
    } else {
        $result['status'] = "error";
        $result['message'] = $superMsg;
    }
} else {
    if (empty($result)) {
        $result['status'] = "error";
        $result['message'] = "No records deleted.";
    } else {
        $result['message'] = ($result['status'] == "success") ? 
            "Doctor deleted successfully." 
            : $result['message'];
    }
}

json_response($result['status'], $result['message'], "", "");
?>
