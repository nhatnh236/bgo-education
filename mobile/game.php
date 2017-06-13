<?php
    ob_start();
    //session_start();
    require_once("../model/open_db.php");
    require_once("../model/model.php");
    session_start();
    require_once("access_hocsinh.php");
    require_once("include/is_mobile.php");
    $hsID=$_SESSION["ID_HS"];
    $monID=$_SESSION["mon"];
    $code=$_SESSION["code"];
    $lmID=$_SESSION["lmID"];

    $result0=get_id_group_hs($hsID);
    if(mysqli_num_rows($result0)!=0) {
        $data0 = mysqli_fetch_assoc($result0);
        $level=$data0["level"];
        $nID=$data0["ID_N"];
        $dubi=check_nhom_du_bi($nID);
    } else {
        $level=$nID=0;
        $dubi=false;
    }

    $mau="#FFF";
    $result0=get_hs_short_detail($hsID,$lmID);
    $data0=mysqli_fetch_assoc($result0);

    $now=date("Y-m-d");

    $check_game=check_game();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <title>GAME</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js">
    </script><![endif]-->

    <link rel="stylesheet" type="text/css" href="http://localhost/www/TDUONG/mobile/css/tongquan.css"/>
    <link rel="stylesheet" type="text/css" href="https://localhost/www/TDUONG/css/animate.css" />
    <link rel="stylesheet" type="text/css" href="https://localhost/www/TDUONG/css/hover.css" />
    <!--<link rel="stylesheet" type="text/css" href="https://localhost/www/TDUONG/css/materialize.min.css" />-->
    <link href="https://localhost/www/TDUONG/images/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
    <link rel="stylesheet" href="http://localhost/www/TDUONG/mobile/css/font-awesome.min.css">

    <style>
        <?php require_once("include/CSS.php"); ?>
        #COLOR {position:absolute;z-index:99;top:10px;left:10px;width:auto;height:auto;}#COLOR i {font-size:44px;color:#69b42e;cursor:pointer;}#COLOR i:hover {color:#246E2C;}#COLOR i:hover ul {display:block;}#COLOR ul {width:180px;height:180px;display:none;background:#FFF;padding-left:10px;padding-top:10px;border:1px solid #dfe0f4;}#COLOR ul li {float:left;width:50px;height:50px;margin-right:10px;margin-bottom:10px;}#COLOR ul li .user-color {width:100%;height:100%;cursor:pointer;opacity:0.4;}#COLOR ul li .user-color:hover {opacity:1;}#MAIN .main-div #main-info > div p, #MAIN .main-div .main-note p, #MAIN .main-div #main-info #main-1-mid ul li span, #MAIN .main-div #main-info #main-1-mid ul li i, #MAIN .main-div .main-num p, #MAIN .main-div #main-table table td span, #MAIN .main-div #main-chart button i, #MAIN .main-div ul > ol .main-title, #MAIN .main-div ul > ol .main-point, #MAIN .main-div .main-chart3 nav.chart-line ul li i, .progress-indicator>li, .progress-indicator>li .bubble, .ask:hover .sub-ask ul li, #MAIN .main-div .main-chart3 nav.chart-button > a, #MAIN .main-div #main-chart #chart-len ul li span {color:<?php echo $mau?>;line-height:22px;}#progress1>li .bubble{margin-top:6px;}#progress2>li .bubble{margin-top:3.5px;}.progress-indicator>li.completed .bubble{background-color:<?php echo $mau; ?>}.progress-indicator>li .bubble:after, .progress-indicator>li .bubble:before {background-color:<?php echo $mau; ?>;position:relative;}.progress-indicator>li .bubble:before {top:12px;}.progress-indicator>li .bubble:after {top:7px;}.progress-indicator>li.non-completed .bubble:after, .progress-indicator>li.non-completed .bubble:before {display:none;}.line-ver {border-left:1px dashed <?php echo $mau;?>;width:1px;position:absolute;z-index:-1;left:5.5px;}.progress-indicator>li.non-still .bubble {background-color:<?php echo $mau;?>;width:7px;height:7px;margin-left:3px;}.last-completed .bubble:before, .last-completed .bubble:after {display:none !important;}#MAIN .main-div .main-chart4 .chart-info {position:absolute;z-index:9;top:37%;}#MAIN .main-div .main-chart4 .chart-info p {font-size:2.75em;color:<?php echo $mau;?>;}#MAIN .main-div #main-info table tr td span i.check-buoi {font-size:1.25em;cursor:pointer;color:<?php echo $mau;?>;}#MAIN .main-div #main-info table tr td span i.codinh {color:#FFF;}#main-chart2 ul {width:90%;margin:auto;height:45px;}#main-chart2 ul li {float:left;text-align:center;padding:7px 0 7px 0;border-radius:20px;}#main-chart2 ul li p {color:<?php echo $mau;?>;font-size:1.375em;}#main-tb ul li {color:<?php echo $mau;?>;font-size:12px;padding:5px 10px 5px 10px;border-radius:10px;}#main-tb ul li .td-content p {line-height:22px;letter-spacing:0.5px;float:left;width:188px;}#main-tb ul li .td-content img {height:65px;float:left;width:65px;margin-right:10px;border:2px solid <?php echo $mau;?>;border-radius:1000px;}#main-tb ul li .td-action {margin-top:10px;text-align:right;clear:both;border-radius:10px;}#chart-li1 ul li {padding:5px 10px 5px 10px;}#chart-li1 ul li > div {display:inline-block;width:40%;}#chart-li1 ul li > div#main-star {text-align:center;width:100%;padding:15px 0 15px 0;position:relative;cursor:pointer;}#chart-li1 ul li > div#main-star i {font-size:6em;color:yellow;}#chart-li1 ul li > div#main-star p {position:absolute;z-index:9;color:#000;font-size:22px;font-weight:600;top:40%;}#chart-li1 ul li > div p {color:#FFF;font-size:12px;line-height: 22px;}.see-kq {width:70px;margin:5px auto 5px auto;font-weight:600;font-size:1.5em;background:rgba(0,0,0,0.15);}.win {color:red;}.lose {color:black;}.draw {color:yellow;}.ketqua {font-weight:600;font-size:1.25em;background:rgba(0,0,0,0.15);opacity:0.5;}#MAIN .main-div > ul > li > ul {border-radius:10px;padding:5px 0px 5px 0px;}
        /*.hideme {margin-left:-150%;opacity:0;}*/
    </style>

    <?php require_once("include/SCRIPT.php"); ?>
    <script>
        $(document).ready(function() {
            $(".popup").click(function() {
                $(this).fadeOut(250);
                $("#BODY").css("opacity", "1");
            });

            $("button#delete").click(function() {
                if(confirm("Bạn có chắc chắn xóa nhóm?")) {
                    return true;
                } else {
                    return false;
                }
            });

            $("button#out").click(function() {
                if(confirm("Bạn có chắc chắn?")) {
                    return true;
                } else {
                    return false;
                }
            });

            $("button#thamgia, button#tao, button#thamgiadubi").click(function() {
                if(confirm("Bạn sẽ bị trừ 50k tiền ăn và 10k tiền chơi!")) {
                    return true;
                } else {
                    return false;
                }
            });

            $("input#name-nhom").typeWatch({
                captureLength: 3,
                callback: function (value) {
                    $(".popup").fadeOut("fast");
                    $("#popup-loading").fadeIn("fast");
                    $.ajax({
                        async: true,
                        data: "name_edit=" + value + "&nID_edit=<?php echo encode_data($nID,$code); ?>",
                        type: "post",
                        url: "http://localhost/www/TDUONG/mobile/xuly-tongquan/",
                        success: function (result) {
                            $(".popup").fadeOut("fast");
                        }
                    });
                }
            });

            $("input#pass-nhom").typeWatch({
                captureLength: 3,
                callback: function (value) {
                    value = value.trim();
                    if(value == "") {
                        value = "none";
                    }
                    $(".popup").fadeOut("fast");
                    $("#popup-loading").fadeIn("fast");
                    $.ajax({
                        async: true,
                        data: "pass_edit=" + value + "&nID_edit=<?php echo encode_data($nID,$code); ?>",
                        type: "post",
                        url: "http://localhost/www/TDUONG/mobile/xuly-tongquan/",
                        success: function (result) {
                            $(".popup").fadeOut("fast");
                        }
                    });
                }
            });

            <?php if($check_game) { ?>

            $("button.kick-submit").click(function () {
                var hsID = $(this).attr("data-hsID");
                if(confirm("Bạn có chắc chắn kick bạn này?")) {
                    $(".popup").fadeOut("fast");
                    $("#popup-loading").fadeIn("fast");
                    $.ajax({
                        async: true,
                        data: "hsID_kick=" + hsID + "&nID_kick=<?php echo encode_data($nID,$code); ?>",
                        type: "post",
                        url: "http://localhost/www/TDUONG/mobile/xuly-tongquan/",
                        success: function (result) {
                            $(".popup").fadeOut("fast");
                            location.reload();
                        }
                    });
                }
            });

            <?php if($nID == 0) { ?>
            $("button.join-submit").click(function() {
                if(confirm("Bạn sẽ bị trừ 50k tiền ăn và 10k tiền chơi!")) {
                    var nID = $(this).attr("data-nID");
                    $(".popup").fadeOut("fast");
                    $("#popup-loading").fadeIn("fast");
                    $.ajax({
                        async: true,
                        data: "nID_in=" + nID + "&hsID_in=<?php echo encode_data($hsID, $code); ?>",
                        type: "post",
                        url: "http://localhost/www/TDUONG/mobile/xuly-tongquan/",
                        success: function (result) {
                            if (result == "none") {
                                alert("Gia nhập không thành công!");
                            }
                            $(".popup").fadeOut("fast");
                            location.reload();
                        }
                    });
                }
            });

            $("button.join-submit-pass").click(function() {
                if(confirm("Bạn sẽ bị trừ 50k tiền ăn và 10k tiền chơi!")) {
                    var nID = $(this).attr("data-nID");
                    var pass = $(this).closest("tr").find("td input.join-pass").val().trim();
                    if (pass != "") {
                        $(".popup").fadeOut("fast");
                        $("#popup-loading").fadeIn("fast");
                        $.ajax({
                            async: true,
                            data: "nID_pass=" + nID + "&pass=" + pass + "&hsID_pass=<?php echo encode_data($hsID, $code); ?>",
                            type: "post",
                            url: "http://localhost/www/TDUONG/mobile/xuly-tongquan/",
                            success: function (result) {
                                if (result == "none") {
                                    alert("Sai mật khẩu!");
                                }
                                $(".popup").fadeOut("fast");
                                location.reload();
                            }
                        });
                    }
                }
            });
            <?php } ?>
            <?php } ?>

            $("button.captain-submit").click(function() {
                if(confirm("Bạn có chắc chắn nhường quyền nhóm trưởng cho bạn này?")) {
                    var hsID = $(this).attr("data-hsID");
                    $("#popup-loading").fadeIn("fast");
                    $("#BODY").css("opacity", "0.1");
                    $.ajax({
                        async: true,
                        data: "nID_captain=<?php echo encode_data($nID,$code); ?>&hsID_captain=" + hsID,
                        type: "post",
                        url: "http://localhost/www/TDUONG/mobile/xuly-tongquan/",
                        success: function (result) {
                            location.reload();
                        }
                    });
                }
            });

            $(".main1-table tr.tr-me td.view-sl").click(function() {
                var nID = $(this).attr("data-nID");
                if (nID) {
                    $(".popup").fadeOut("fast");
                    $("#popup-loading").fadeIn("fast");
                    $("#BODY").css("opacity", "0.1");
                    $.ajax({
                        async: true,
                        data: "nID_list=" + nID,
                        type: "post",
                        url: "http://localhost/www/TDUONG/mobile/xuly-tongquan/",
                        success: function (result) {
                            $(".popup").fadeOut("fast");
                            $("#popup-view p.title").html(result);
                            $("#popup-view").fadeIn("fast");
                        }
                    });
                }
            });
        });
    </script>


</head>

<body>

<div class="popup animated bounceIn" id="popup-view">
    <div class="popup-close"><i class="fa fa-close"></i></div>
    <div>
        <p class="title"></p>
        <div>
            <button class="submit2 btn-exit"><i class="fa fa-check"></i></button>
        </div>
    </div>
</div>

<div class="popup animated bounceIn" id="popup-loading">
    <p><img src="https://localhost/www/TDUONG/images/ajax-loader.gif" /></p>
</div>

<div id="SIDEBACK"><div id="BODY">


    <div id="MAIN">

        <div class="main-div back animated bounceInUp" id="main-top">
            <div id="main-person">
                <?php
                $price=0;
                $result5=get_all_lop_mon2($monID);
                while($data5=mysqli_fetch_assoc($result5)) {
                    $price += 10000*count_hs_in_group($data5["ID_LM"]);
                }
                $price += 2000000;
                echo"<h1>KHO BÁU: ".format_price($price)."</h1>";
                ?>
                <div class="clear"></div>
            </div>
            <div id="main-avata">
                <img src="https://localhost/www/TDUONG/hocsinh/avata/<?php echo $data0["avata"]; ?>" />
                <a href="https://localhost/www/TDUONG/ho-so/" title="Hồ sơ cá nhân">
                    <p><?php echo $data0["cmt"];?> (<?php echo $data0["de"];?>)</p>
                    <i class="fa fa-pencil"></i>
                </a>
            </div>
            <div class="clear"></div>
        </div>

        <?php
            $error="";
            $name=NULL;
            $pass="none";
            if(isset($_POST["delete"]) && ($check_game || $dubi)) {
                $result1=get_game_group($nID);
                $data1=mysqli_fetch_assoc($result1);
                if($data1["ID_HS"]==$hsID && $level==1) {
                    delete_game_group($nID);
                    header("location:http://localhost/www/TDUONG/mobile/game/");
                    exit();
                }
            }
            if(isset($_POST["out"]) && ($check_game || $dubi)) {
                if($level==2) {
                    delete_hs_list_group($hsID,$nID);
                    header("location:http://localhost/www/TDUONG/mobile/game/");
                    exit();
                }
            }
            if(isset($_POST["thamgiadubi"]) && !$check_game) {
                $check=false;
                $stt=0;
                $query = "SELECT g.ID_N,g.name,COUNT(l.ID_STT) AS dem FROM game_group AS g 
                            INNER JOIN list_group AS l ON l.ID_N=g.ID_N 
                            WHERE g.state='dubi' AND g.ID_LM='$lmID'
                            GROUP BY g.ID_N
                            ORDER BY g.ID_N ASC";
                $result = mysqli_query($db, $query);
                while($data = mysqli_fetch_assoc($result)) {
                    $stt=substr($data["name"],11);
                    if($data["dem"]<10) {
                        add_list_group($hsID, 2, $data["ID_N"]);
                        $check=true;
                    }
                }
                $stt++;
                if(!$check) {
                    add_game_group("Nhóm dự bị $stt","none",$hsID,$lmID,"dubi");
                }
                header("location:http://localhost/www/TDUONG/mobile/game/");
                exit();
            }
            if(isset($_POST["thamgia"]) && $check_game) {
    //                    if(get_tien_hs($hsID)>=60000) {
                $check=false;
                $stt=0;
                $query = "SELECT g.ID_N,g.name,COUNT(l.ID_STT) AS dem FROM game_group AS g 
                            INNER JOIN list_group AS l ON l.ID_N=g.ID_N 
                            WHERE g.state='tudo' AND g.ID_LM='$lmID'
                            GROUP BY g.ID_N
                            ORDER BY g.ID_N ASC";
                $result = mysqli_query($db, $query);
                while($data = mysqli_fetch_assoc($result)) {
                    $stt=substr($data["name"],11);
                    if($data["dem"]<10) {
                        add_list_group($hsID, 2, $data["ID_N"]);
                        $check=true;
                    }
                }
                $stt++;
                if(!$check) {
                    add_game_group("Nhóm tự do $stt","none",$hsID,$lmID,"tudo");
                }
                header("location:http://localhost/www/TDUONG/mobile/game/");
                exit();
    //                    } else {
    //                        $error="<div class='popup' style='display:block'>
    //                            <p>Bạn không đủ tiền trong tài khoản!</p>
    //                        </div>";
    //                    }
            }
            if(isset($_POST["tao"]) && $nID==0 && $check_game) {
                if(isset($_POST["name"])) {
                    $name=addslashes($_POST["name"]);
                }
                if(isset($_POST["pass"])) {
                    $pass=addslashes($_POST["pass"]);
                } else {
                    $pass="none";
                }
                if($name) {
                    if(trim($pass) == "") {
                        $pass = "none";
                    }
//                    if(get_tien_hs($hsID)>=60000) {
                        add_game_group($name, $pass, $hsID, $lmID,"bt");
                        header("location:http://localhost/www/TDUONG/mobile/game/");
                        exit();
//                    } else {
//                        $error="<div class='popup' style='display:block'>
//                                    <p>Bạn không đủ tiền trong tài khoản!</p>
//                                </div>";
//                    }
                } else {
                    $error="<div class='popup' style='display:block'>
                                <p>Vui lòng nhập tên nhóm!</p>
                            </div>";
                }
            }

            echo $error;
        ?>

        <div class="main-div animated bounceInUp">
            <ul>
                <?php
                    $tien=get_tien_hs($hsID);
                    if($nID!=0) {
                    $result1=get_game_group($nID);
                    $data1=mysqli_fetch_assoc($result1);
                    if($level==1) {
                        $attr="";
                    } else {
                        $attr="disabled='disabled'";
                    }
                    ?>
                    <li id="chart-li1" class="li-3">
                        <div class="main-2 back"><h3>Nhóm</h3></div>
                        <ul style="margin-top:3px;">
                            <form action="http://localhost/www/TDUONG/mobile/game/" method="post">
                                <li>
                                    <div><p><i class="fa fa-credit-card" style="width:25px;"></i>Tên</p></div>
                                    <div style="width:58%;"><input type="text" id="name-nhom" <?php echo $attr; ?> value="<?php echo $data1["name"]; ?>" class="input" /></div>
                                </li>
                                <li>
                                    <div><p><i class="fa fa-lock" style="width:25px;"></i>Mật khẩu</p></div>
                                    <div style="width:58%;"><input type="text" id="pass-nhom" <?php echo $attr; ?> value="<?php echo $data1["password"]; ?>" class="input" /></div>
                                </li>
                                <li>
                                    <div><p><i class="fa fa-bank" style="width:25px;"></i>Ngày tạo</p></div>
                                    <div style="width:58%;"><input type="text" disabled="disabled" value="<?php echo format_dateup($data1["datetime"]); ?>" class="input" /></div>
                                </li>
                                <?php if($level==1 && ($check_game || $dubi)) { ?>
                                    <li>
                                        <div style="width:100%;margin-top:0;text-align:center;"><p>Nếu xóa nhóm, các thành viên của nhóm bạn sẽ bị đẩy ra</p></div>
                                    </li>
                                    <li>
                                        <div style="width:100%;margin-top:0;text-align:right;"><button class="submit" name="delete" id="delete">Xóa nhóm</button></div>
                                    </li>
                                <?php } else if($check_game || $dubi) { ?>
                                    <li>
                                        <div style="width:100%;margin-top:0;text-align:right;"><button class="submit" name="out" id="out">Rời nhóm</button></div>
                                    </li>
                                <?php } ?>
                            </form>
                        </ul>
                    </li>
                <?php } else { ?>
                    <li id="chart-li1" class="li-3">
                        <div class="main-2 back"><h3>Cá nhân</h3></div>
                        <ul style="margin-top:3px;">
                            <form action="http://localhost/www/TDUONG/mobile/game/" method="post">
                                <?php if($check_game) { ?>
                                    <li>
                                        <div style="width:100%;margin-top:0;text-align:center;"><p>Nếu bạn không tìm được nhóm thích hợp, hãy chọn Tham gia cá nhân để được random vào 1 nhóm tự do</p></div>
                                    </li>
                                    <li>
                                        <div style="width:100%;margin-top:0;text-align:right;"><button class="submit" name="thamgia" id="thamgia">Tham gia cá nhân</button></div>
                                    </li>
                                <?php } else { ?>
                                    <li>
                                        <div style="width:100%;margin-top:0;text-align:center;"><p>Tham gia dự bị, bạn vẫn có thể rời nếu không muốn chơi</p></div>
                                    </li>
                                    <li>
                                        <div style="width:100%;margin-top:0;text-align:right;"><button class="submit" name="thamgiadubi" id="thamgiadubi">Tham gia dự bị</button></div>
                                    </li>
                                <?php } ?>
                            </form>
                        </ul>
                    </li>
                    <li id="chart-li1" class="li-3" style="margin-top: 3px">
                        <div class="main-2 back"><h3>Tạo nhóm</h3></div>
                        <ul style="margin-top:3px;">
                            <form action="http://localhost/www/TDUONG/mobile/game/" method="post">
                                <?php if($tien >= 60000 && $check_game) { ?>
                                    <li>
                                        <div style="width:100%;margin-top:0;text-align:center;"><p>Tạo nhóm riêng của bạn kèm mật khẩu nếu muốn</p></div>
                                    </li>
                                    <li>
                                        <div style="width:100%;"><input type="text" name="name" id="name" placeholder="Tên nhóm" autocomplete="off" style="width:90%;padding:5%" class="input" /></div>
                                    </li>
                                    <li>
                                        <div style="width:100%;"><input type="text" name="pass" id="pass" placeholder="Mật khẩu (nếu muốn)" autocomplete="off" style="width:90%;padding:5%" class="input" /></div>
                                    </li>
                                    <li>
                                        <div style="width:100%;margin-top:0;text-align:right;"><button class="submit" name="tao" id="tao">Tạo</button></div>
                                    </li>
                                <?php } else if(!$check_game) {
                                    echo"<li><div style='width:100%;margin-top:0;text-align:center;'><p>DANH SÁCH ĐÃ ĐƯỢC CHỐT</p></li>";
                                }
                                ?>
                            </form>
                        </ul>
                    </li>
                <?php } ?>
                <li id="main-tb" class="li-3" style="margin-top: 3px">
                    <div class="main-2 back"><h3>Tài khoản</h3></div>
                    <ul style="margin-top:3px;">
                        <li>
                            <div style="width:100%;margin-top:0;text-align:center;"><p style="font-size: 22px;font-weight: 600;"><?php echo format_price($tien); ?></p></div>
                        </li>
                        <?php
                        if($tien>=60000) {
                            echo"<li><div style='width:100%;margin-top:0;text-align:center;'><p>Đủ điều kiện tham gia</p></li>";
                        } else if($nID!=0) {
                            echo"<li><div style='width:100%;margin-top:0;text-align:center;'><p>Đã trừ 50k tiền ăn và 10k tiền chơi</p></li>";
                        } else {
                            echo"<li><div style='width:100%;margin-top:0;text-align:center;'><p>Bạn không đủ tài khoản để tham gia trò chơi</p></li>";
                        }
                        ?>
                    </ul>
                </li>
            </ul>
            <div class="clear"></div>
        </div>

        <?php if($nID!=0) { ?>
            <div class="main-div animated bounceInUp">
                <div class="main-1 back" style="border-bottom:none;border-bottom-left-radius:0;border-bottom-right-radius:0;"><h3>Danh sách nhóm của bạn</h3></div>
                <div id="main-table" class="main1-table">
                    <table style="min-width: 700px;">
                        <tr id="table-head" class="back tr-big">
                            <th style="width: 5%;"><span>STT</span></th>
                            <th><span>Thành viên</span></th>
                            <th><span>Mã số</span></th>
                            <th><span>SĐT</span></th>
                            <th><span>Facebook</span></th>
                            <th><span></span></th>
                        </tr>
                        <?php
                        $stt=1;
                        $query5="SELECT h.ID_HS,h.cmt,h.fullname,h.sdt,h.facebook,l.level FROM list_group AS l
                        INNER JOIN hocsinh AS h ON h.ID_HS=l.ID_HS
                        WHERE l.ID_N='$nID'
                        ORDER BY l.level ASC";
                        $result5=mysqli_query($db,$query5);
                        while($data5=mysqli_fetch_assoc($result5)) {
                            $facebook=formatFacebook($data5["facebook"]);
                            if($facebook=="#")
                                $show="";
                            else $show="Xem";
                            echo "<tr class='tr-me back tr-fixed'>
                            <td><span>$stt</span></td>
                            <td><span>$data5[fullname]</span></td>
                            <td><span>$data5[cmt]</span></td>
                            <td><span>$data5[sdt]</span></td>
                            <td><a href='$facebook' style='color:#FFF;text-decoration: underline;' target='_blank'>$show</a></td>";
                            if($data5["level"]==1) {
                                echo"<td><span>Trưởng nhóm</span></td>";
                            } else if($level==1 && $data5["ID_HS"]!=$hsID) {
                                echo"<td>
                                    <button class='submit kick-submit' data-hsID='".encode_data($data5["ID_HS"],$code)."'>Kick</button>
                                    <button class='submit captain-submit' data-hsID='".encode_data($data5["ID_HS"],$code)."'>Captain</button>
                                </td>";
                            } else {
                                echo"<td><span></span></td>";
                            }
                            echo"</tr>";
                            $stt++;
                        }

                        ?>
                    </table>
                </div>
            </div>
        <?php } ?>
            <div class="main-div animated bounceInUp">
                <div class="main-1 back" style="border-bottom:none;border-bottom-left-radius:0;border-bottom-right-radius:0;"><h3>Danh sách các nhóm</h3></div>
                <div id="main-table" class="main1-table">
                    <table style="min-width: 700px;">
                        <tr id="table-head" class="back tr-big">
                            <th><span>Nhóm</span></th>
                            <th style="width: 5%;"><span>SL</span></th>
                            <th><span>Mật khẩu</span></th>
                            <th><span></span></th>
                        </tr>
                        <?php
                        $stt=1;
                        $query5="SELECT g.ID_N,g.name,g.password,COUNT(l.ID_STT) AS dem,h.fullname FROM game_group AS g
                        INNER JOIN list_group AS l ON l.ID_N=g.ID_N
                        INNER JOIN hocsinh AS h ON h.ID_HS=g.ID_HS
                        WHERE g.ID_LM='$lmID'
                        GROUP BY g.ID_N
                        ORDER BY dem DESC";
                        $result5=mysqli_query($db,$query5);
                        while($data5=mysqli_fetch_assoc($result5)) {
                            echo "<tr class='tr-me back tr-fixed'>
                                <td><span>$data5[name]</span></td>
                                <td class='view-sl' data-nID='".encode_data($data5["ID_N"],$code)."' style='cursor:pointer;'><span>$data5[dem]</span></td>";
                                if($nID!=0) {
                                    if ($data5["password"] == "none" || $data5["password"] == "") {
                                        echo"<td><span>Tự do</span></td><td></td>";
                                    } else {
                                        echo"<td><span>Có mật khẩu</span></td><td></td>";
                                    }
                                } else {
                                    if ($data5["password"] == "none" || $data5["password"] == "") {
                                        echo "<td><span>Tự do</span></td><td><span><button class='submit join-submit' data-nID='" . encode_data($data5["ID_N"], $code) . "'>Vào</button></span></td>";
                                    } else {
                                        echo "<td><input type='password' class='input join-pass' placeholder='Mật khẩu' /></td>
                                            <td><span><button class='submit join-submit-pass' data-nID='" . encode_data($data5["ID_N"], $code) . "'>Vào</button></span></td>";
                                    }
                                }
                            echo"</tr>";
                            $stt++;
                        }

                        ?>
                    </table>
                </div>
            </div>

    </div>

</div>

<?php require_once("include/MENU.php"); ?>

</body>
</html>

<?php
ob_end_flush();
require_once("../model/close_db.php");
?>
