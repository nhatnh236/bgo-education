<?php
	ob_start();
	session_start();
	require("../../model/open_db.php");
	require("../../model/model.php");
	require("../access_admin.php");

    if(isset($_POST["data1"])) {
        $data = $_POST["data1"];
        $data = json_decode($data, true);
        $n = count($data) - 1;
        $id = $data[$n]["id"];
        $content = "";
        for ($i = 0; $i < $n; $i++) {
            $buoi = $data[$i]["buoi"];
            $thu = $data[$i]["thu"];
            $status = $data[$i]["status"];
            if($status == 1) {
                if (check_chon_lich($buoi, $thu, $id)) {
                    $content .= ",('".$id."','".$buoi."','".$thu."')";
                }
            } else {
                deletelichtrogiang($buoi,$thu,$id);
            }
        }
        if($content != "") {
            $content = substr($content,1);
            addlichtrogiangmulti($content);
        }
        echo"ok";
    }

    if(isset($_POST["buoi"]) && isset($_POST["thu"]) && isset($_POST["id"])) {
        $buoi = $_POST["buoi"];
        $thu = $_POST["thu"];
        $id = $_POST["id"];
        if(valid_id($thu) && valid_id($id)) {
            if (check_chon_lich($buoi, $thu, $id)) {
                addlichtrogiang($buoi, $thu, $id);
                echo "ok";
            } else {
                echo "no";
            }
        }
    }

    if(isset($_POST["buoi3"]) && isset($_POST["thu3"]) && isset($_POST["id3"])) {
        $buoi = $_POST["buoi3"];
        $thu = $_POST["thu3"];
        $id = $_POST["id3"];
        if(valid_id($thu) && valid_id($id)) {
            deletelichtrogiang($buoi,$thu,$id);
            echo "ok";
        } else {
            echo "no";
        }
    }

    if(isset($_POST["ngay2"]) && isset($_POST["id2"])) {
        $ngay = $_POST["ngay2"];
        $id = $_POST["id2"];
        if (valid_id($id)) {
            $check=check_diem_danh($ngay,$id);
            if ($check != -1) {
                diemdanhtrogiangcong($ngay,get_buoi_diem_danh_trogiang($id,$ngay,$check),$id);
                echo "ok";
            } else {
                echo "no";
            }
        }
    }

    if(isset($_POST["ngay"]) && isset($_POST["id"]) && isset($_POST["bu"]) && isset($_POST["ngay_bu"]) ) {
        $ngay = $_POST["ngay"];
        $id = $_POST["id"];
        $bu=$_POST["bu"];
        $ngay_bu=$_POST["ngay_bu"];
        if (valid_id($id) ) {
            diemdanhtrogiangnghi($ngay,$id,$bu,$ngay_bu);
            echo "ok";
        } else {
            echo "no";
        }
    }
	
	if(isset($_POST["data"])) {
        $data=$_POST["data"];
        $data=json_decode($data, true);
        $n=count($data)-1;
		$oID=$data[$n]["oID"];
		$name=$data[$n]["name"];
        $phone=$data[$n]["phone"];
        $date_in=format_date_o($data[$n]["date_in"]);
        $mota=$data[$n]["mota"];
        $price=$data[$n]["price"];
        $code=$data[$n]["code"];
		if($code!="" && is_numeric($code)) {
			$code=md5($code);
		}
		if(!check_isset_trogiang($code)) {
			edit_trogiang($oID, $name, $phone, $date_in, $mota, $price, $code);
            for($i=0;$i<$n;$i++) {
                if(is_numeric($data[$i]["phan"]) && ($data[$i]["is_pay"]==0 || $data[$i]["is_pay"]==1) && $data[$i]["phan"]<=100 && $data[$i]["phan"]>=0) {
                    add_pay_trogiang($data[$i]["idA"], $data[$i]["is_pay"], $data[$i]["phan"], $oID);
                }
            }
			echo"ok";
		} else {
			echo"none";
		}
	}
	
	if(isset($_POST["oID0"])) {
		$oID=$_POST["oID0"];
        $query0="SELECT note2 FROM options WHERE ID_O='$oID'";
        $result0=mysqli_query($db,$query0);
        $data0=mysqli_fetch_assoc($result0);
        if($data0["note2"]==1) {
            $query = "UPDATE options SET note2='0' WHERE ID_O='$oID'";
        } else {
            $query = "UPDATE options SET note2='1' WHERE ID_O='$oID'";
        }
        mysqli_query($db,$query);
	}
	
	if(isset($_POST["name0"]) && isset($_POST["code0"])) {
		$name=$_POST["name0"];
		$code=md5($_POST["code0"]);
		if(!check_isset_trogiang($code)) {
			add_trogiang($name,$code);
            $id=mysqli_insert_id($db);
            $query = "INSERT INTO info_trogiang(mota,price,phone,date_in,ID_O)
                                        value('','','',now(),'$id')";
            mysqli_query($db,$query);
			echo"ok";
		} else {
			echo"none";
		}
	}

	if(isset($_POST["name"])) {
	    $name=$_POST["name"];
        addtrogiangnew($name, "123456", 0, date("Y-m-d"), "cham-cong");
    }

    if(isset($_POST["name_edit"]) && isset($_POST["id_edit"])) {
        $name=$_POST["name_edit"];
        $id=$_POST["id_edit"];
        edittrogiang($name, $id);
    }

    if(isset($_POST["id_xoa"])) {
        $id=$_POST["id_xoa"];
        deletetrogiang($id);
    }
	
	require("../../model/close_db.php");
	ob_end_flush();
?>