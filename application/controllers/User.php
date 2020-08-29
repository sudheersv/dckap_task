<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * @Author Sudheer SV
 */
class User extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("Common_model");
    }

    public function index() {
        if(empty($this->session->userdata('name'))){
            redirect(base_url('login'));
        }
        $this->data['page'] = 'users';
        $this->__output($this->data);    
    }
    
    public function updateUser($userId) {
        $user = current($this->Common_model->listData("tbl_users", array("id" => $userId)));
        $this->data['user'] = $user;
        $this->data['page'] = 'register';
        
        $this->__output($this->data);    
    }
    public function viewUser($userId) {
        $user = current($this->Common_model->listData("tbl_users", array("id" => $userId)));
        $this->data['user'] = $user;
        $this->data['page'] = 'viewUser';
        
        $this->__output($this->data);    
    }
    
    public function login() {
        
        $this->data['page'] = 'login';
        $this->__output($this->data);    
    }
    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url());
    }
    
    public function register() {
        
        $this->data['page'] = 'register';
        $this->__output($this->data);    
    }
    
    public function add_user() {
        //print_r($this->input->post(null)); die();
        
        
        $id = trim($this->input->post('id'));
        
        $name = trim($this->input->post('name'));
        $uname = trim($this->input->post('uname'));
        $email = trim($this->input->post('email'));
        $password = trim($this->input->post('password'));
        $mobile = trim($this->input->post('mobile'));
        $dob = trim($this->input->post('dob'));
        $address = trim($this->input->post('address'));
        $city = trim($this->input->post('city'));
        $state = trim($this->input->post('state'));
        $country = trim($this->input->post('country'));
        
        $user = $this->Common_model->listData("tbl_users", array("email" => $email));
        
        if(!empty($user) && empty($id))
        {
            $data = [
                "error" => 1,
                "msg" => "User already exists with this email",
            ];
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }
        
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size']     = '0';
//        $config['max_width'] = '1024';
//        $config['max_height'] = '768';
        $this->load->library('upload',$config);
//        pr($_FILES["profile"]); die();
        if(!empty($_FILES["profile"]['name'])){
            if(!$this->upload->do_upload('profile'))
            {
                $data = [
                    "error" => 1,
                    "msg" => "error in uploading image",
                ];
                header('Content-Type: application/json');
                echo json_encode($data);
                exit;
            }
            else{
                $uploadData = $this->upload->data();
                $file_name = $uploadData["file_name"];  
    //            print_r($this->upload->data()); die();
            }
        }else{
            
            $file_name = $this->input->post('oldprofile');  
        }
        
        
        
        $dbdata = array(
            "name" => $name,
            "user_name" => $uname,
            "email" => $email,
            "password" => md5($password),
            "mobile" => $mobile,
            "dob" => $dob,
            "address" => $address,
            "city" => $city,
            "profile_img" => $file_name,
            "state" => $state,
            "country" => $country,
        );
        if(empty($id))
        {
            $dbdata['created_at'] = getLocalTimeStamp();
            $dbdata['updated_at'] = getLocalTimeStamp();
            $id = $this->Common_model->addData("tbl_users", $dbdata);
            
            if($id){
                $data = [
                    "error" => 0,
                    "msg" => "User added.",
                ];
                header('Content-Type: application/json');
                echo json_encode($data);
                exit;
            }
        }else{
            $dbdata['updated_at'] = getLocalTimeStamp();
            $updated = $this->Common_model->updateData("tbl_users", $dbdata, array('id'=>$id));
            if($updated){
                
                $data = [
                    "error" => 0,
                    "msg" => "User details updated.",
                ];
                header('Content-Type: application/json');
                echo json_encode($data);
                exit;
            }
        }
        
            $data = [
                "error" => 1,
                "msg" => "Something went wrong.",
            ];
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
    }
    
    public function validateLogin() {
        $email = trim($this->input->post('email'));
        $password = trim($this->input->post('password'));
        $user = $this->Common_model->listData("tbl_users", array("email" => $email));
        
        if(empty($user))
        {
            $data = [
                "error" => 1,
                "msg" => "User doesn't exists with this email",
            ];
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }
        
        if($user[0]['is_active'] == '0')
        {
            $data = [
                "error" => 1,
                "msg" => "This user is inactive",
            ];
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }
        
        if(md5($password) != $user[0]["password"])
        {
            $data = [
                "error" => 1,
                "msg" => "Invalid password.",
            ];
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }
        $session_data = array(
            'name' =>  $user[0]["name"],
            'user_name' =>  $user[0]["user_name"],
            'email' =>  $user[0]["email"],
            'mobile' =>  $user[0]["mobile"],
        );
        $this->session->set_userdata($session_data);
        $data = [
                "error" => 0,
                "msg" => "Login success.",
            ];
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
    }
    
    public function pagination() {
        $page = $this->db->escape_str($this->input->post('page'));
        $per_page = $this->db->escape_str($this->input->post('per_page'));
        if ($page != 1) {
            $start = ($page - 1) * $per_page;
        } else {
            $start = 0;
        }

        $totalEntries = $this->Common_model->whereArray("tbl_users", array(), "*", [], "id", "", "", [], 'desc');
        $numPage = ceil(count($totalEntries) / $per_page);
        $limit = array("limit" => $per_page, 'start' => $start);
        $lists = $this->Common_model->whereArray('tbl_users', array(), '*', [], "id", "", "", $limit, 'desc');


        $entries = "";
        $Slno = 0;
        
        foreach ($lists as $list) {

            $UserId = $list['id'];
            $userCreatedDate = (!empty($list)) ? date("d-m-Y", strtotime($list['created_at'])) : '';
            $dob = (!empty($list)) ? date("d-m-Y", strtotime($list['dob'])) : '';
            $userStatus = ($list['is_active'] == '1') ? 'checked' : '';
            $Status = ($list['is_active'] == '1') ? '1' : '0';
           
            $Slno++;
            $delete = '';
            $delete = "<i class='fa fa-trash fa-lg mr-20 delete' onclick='deleteRecord(" .  '"' . $UserId . '"' . ")' style='color:red'></i>";
            $entries .= "<tr id='user_$Slno'>
                  <td>$Slno</td>
                  <td>" . $list['name'] . "</td>
                  <td>" . $list['email'] . "</td>
                  <td>" . $list['mobile'] . "</td>
                  <td>$dob</td>
                  <td>$userCreatedDate</td>
                  <td>
                      <div>
                        <label class='switch'>
                          <input type='checkbox' id='$UserId' onchange='recordStatus(" . '"' . $UserId . '"' . ',"' . $Status . '"' . ")'  name='recordStatus' data-size='sm' value='" . $list['is_active'] . "' $userStatus/>
                            <span class='slider'></span>
                        </label>
                      </div>
  
                  </td>
                  
                    <td>
                      <a href='" . base_url() . "user/viewUser/" . $UserId . "' style='border-bottom:none' style='color:yellow'>  <i class='fa fa-eye fa-lg mr-20 view' style='color:#00ff7e'></i></a>
                      <a href='" . base_url() . "user/updateUser/" . $UserId . "' style='border-bottom:none'><i class='fa fa-edit fa-lg mr-20 update' style='color:#0066ff'></i></a>
                          $delete
                    </td>
               </tr>";
        }
        echo json_encode(
                array(
                    'numPage' => $numPage,
                    'notifications' => $entries,
                    'totalrecords' => count($totalEntries)
                )
        );
    }
    
    public function search() {
        $limit = 20;
        $searchterm = $this->db->escape_str($this->input->post('searchterm'));
        $searchon = $this->db->escape_str($this->input->post('searchon'));

        $lists = $this->Common_model->searchData("tbl_users", array(), $searchon, $searchterm, $limit);

        $entries = "";
        $Slno = 0;
        //$CONTROLLERURL = URL . static::class;
        foreach ($lists as $list) {
            $UserId = $list['id'];
            $userCreatedDate = (!empty($list)) ? date("d-m-Y", strtotime($list['created_at'])) : '';
            $dob = (!empty($list)) ? date("d-m-Y", strtotime($list['dob'])) : '';
            $userStatus = ($list['is_active'] == '1') ? 'checked' : '';
            $Status = ($list['is_active'] == '1') ? '1' : '0';
           
            $Slno++;
            $delete = '';
            $delete = "<i class='fa fa-trash fa-lg mr-20 delete' onclick='deleteRecord(" .  '"' . $UserId . '"' . ")' style='color:red'></i>";
            
            $entries .= "<tr id='user_$Slno'>
                  <td>$Slno</td>
                  <td>" . $list['name'] . "</td>
                  <td>" . $list['email'] . "</td>
                  <td>" . $list['mobile'] . "</td>
                  <td>$dob</td>
                  <td>$userCreatedDate</td>
                  <td>
                      <div>
                        <label class='switch'>
                          <input type='checkbox' id='$UserId' onchange='recordStatus(" . '"' . $UserId . '"' . ',"' . $Status . '"' . ")'  name='recordStatus' data-size='sm' value='" . $list['is_active'] . "' $userStatus/>
                            <span class='slider'></span>
                        </label>
                      </div>
  
                  </td>
                  
                    <td>
                      <a href='" . base_url() . "user/viewUser/" . $UserId . "' style='border-bottom:none' style='color:yellow'>  <i class='fa fa-eye fa-lg mr-20 view' style='color:#00ff7e'></i></a>
                      <a href='" . base_url() . "user/updateUser/" . $UserId . "' style='border-bottom:none'><i class='fa fa-edit fa-lg mr-20 update' style='color:#0066ff'></i></a>
                          $delete
                    </td>
               </tr>";
        }
        echo json_encode(
                array(
                    'notifications' => $entries,
                    'totalrecords' => count($lists)
                )
        );
    }

    public function changeStatus() {
        $id = $this->input->post('userid');
        $status = $this->input->post('status');
        $updateData = ($status == "1") ? "0" : "1";
        $recordDeatils = array(
            'is_active' => $updateData,
            'updated_at' => getLocalTimeStamp()
        );

        $updateState = $this->Common_model->updateData('tbl_users', $recordDeatils, array('id' => $id));
        if($updateState)
        {
            $data = [
                "error" => 0,
                "msg" => "Status updated successfully.",
            ];
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }
        
        $data = [
                "error" => 1,
                "msg" => "Something went wrong.",
            ];
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
    }
    public function deleteUser() {
        $id = $this->input->post('userid');
        $user = $this->Common_model->listData("tbl_users", array("id" => $id));
        unlink('uploads/'.$user[0]['profile_img']);
        
        $update= $this->Common_model->deleteData('tbl_users',array('id' => $id));
        if($update)
        {
            $data = [
                "error" => 0,
                "msg" => "User deleted.",
            ];
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }
        
        $data = [
                "error" => 1,
                "msg" => "Something went wrong.",
            ];
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
    }
}