<?php
	ob_start();
	//session_start();
	require_once("model/open_db.php");
	require_once("model/model.php");
	session_start();require_once("access_hocsinh.php");
	require_once("model/is_mobile.php");
	$hsID=$_SESSION["ID_HS"];
	$lopID=$_SESSION["lop"];
    $lmID=$_SESSION["lmID"];
	$code=$_SESSION["code"];
	$monID=$_SESSION["mon"];
	$mau="#FFF";
	$result0=get_hs_short_detail($hsID, $lmID);
	$data0=mysqli_fetch_assoc($result0);

    $num_ca=array();
    $query="SELECT c.ID_CA,COUNT(h.ID_STT) AS dem FROM cahoc AS c
    INNER JOIN cum AS u ON (u.ID_CUM=c.cum OR (u.link=c.cum AND u.link!='0')) AND u.ID_LM IN ('0','$lmID') AND u.ID_MON='$monID' 
    INNER JOIN ca_hientai AS h ON h.ID_CA=c.ID_CA AND h.cum=c.cum
    GROUP BY c.ID_CA";
    $result=mysqli_query($db,$query);
    while($data=mysqli_fetch_assoc($result)) {
        $num_ca[$data["ID_CA"]]=$data["dem"];
    }

    $demhs=count_hs_mon_lop($lmID);
    $demhs2=count_hs_mon($monID);
//    $demhs2=2000;
	
//	$ontime=check_on_catime($lmID);
//    $check_binh_voi=check_binh_voi2($hsID,$lmID);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>       
        
        <title>ĐỔI CA</title>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!--[if lt IE 9]>
    	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js">
        </script><![endif]-->
        
        <link rel="stylesheet" type="text/css" href="https://localhost/www/TDUONG/css/tongquan.css"/> 
        
        <link rel="stylesheet" type="text/css" href="https://localhost/www/TDUONG/css/animate.css" />  
        <link rel="stylesheet" type="text/css" href="https://localhost/www/TDUONG/css/hover.css" />    
        <!--<link rel="stylesheet" type="text/css" href="https://localhost/www/TDUONG/css/materialize.min.css" />-->     
        <link href="https://localhost/www/TDUONG/images/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
        <link rel="stylesheet" href="https://localhost/www/TDUONG/css/font-awesome.min.css">
        
        <style>
			<?php require_once("include/CSS.php"); ?>
			#COLOR {position:absolute;z-index:99;top:10px;left:10px;width:auto;height:auto;}#COLOR i {font-size:44px;color:#69b42e;cursor:pointer;}#COLOR i:hover {color:#246E2C;}#COLOR i:hover ul {display:block;}#COLOR ul {width:180px;height:180px;display:none;background:#FFF;padding-left:10px;padding-top:10px;border:1px solid #dfe0f4;}#COLOR ul li {float:left;width:50px;height:50px;margin-right:10px;margin-bottom:10px;}#COLOR ul li .user-color {width:100%;height:100%;cursor:pointer;opacity:0.4;}#COLOR ul li .user-color:hover {opacity:1;}#MAIN .main-div #main-info > div p, #MAIN .main-div .main-note p, #MAIN .main-div #main-info #main-1-mid ul li span, #MAIN .main-div #main-info #main-1-mid ul li i, #MAIN .main-div .main-num p, #MAIN .main-div #main-table table td span, #MAIN .main-div #main-chart button i, #MAIN .main-div ul > ol .main-title, #MAIN .main-div ul > ol .main-point, #MAIN .main-div .main-chart3 nav.chart-line ul li i, .progress-indicator>li, .progress-indicator>li .bubble, .ask:hover .sub-ask ul li, #MAIN .main-div .main-chart3 nav.chart-button > a, #MAIN .main-div #main-chart #chart-len ul li span {color:<?php echo $mau?>;line-height:22px;}#progress1>li .bubble{margin-top:6px;}#progress2>li .bubble{margin-top:3.5px;}.progress-indicator>li.completed .bubble{background-color:<?php echo $mau; ?>}.progress-indicator>li .bubble:after, .progress-indicator>li .bubble:before {background-color:<?php echo $mau; ?>;position:relative;}.progress-indicator>li .bubble:before {top:12px;}.progress-indicator>li .bubble:after {top:7px;}.progress-indicator>li.non-completed .bubble:after, .progress-indicator>li.non-completed .bubble:before {display:none;}.line-ver {border-left:1px dashed <?php echo $mau;?>;width:1px;position:absolute;z-index:-1;left:5.5px;}.progress-indicator>li.non-still .bubble {background-color:<?php echo $mau;?>;width:7px;height:7px;margin-left:3px;}.last-completed .bubble:before, .last-completed .bubble:after {display:none !important;}#MAIN .main-div .main-chart4 .chart-info {position:absolute;z-index:9;top:37%;}#MAIN .main-div .main-chart4 .chart-info p {font-size:2.75em;color:<?php echo $mau;?>;}#MAIN .main-div #main-info table tr td span i.check-buoi {font-size:22px;cursor:pointer;color:<?php echo $mau;?>;}#MAIN .main-div #main-info table tr td span i.codinh {color:#FFF;}#main-chart2 ul {width:90%;margin:auto;height:45px;}#main-chart2 ul li {float:left;text-align:center;padding:7px 0 7px 0;border-radius:20px;}#main-chart2 ul li p {color:<?php echo $mau;?>;font-size:1.375em;}table tr:last-child td:first-child, table tr:last-child td:last-child {border-bottom-left-radius:0;border-bottom-right-radius:0;}#MAIN > .main-div .main-1-left table tr td {overflow:hidden;position:relative;}#MAIN > .main-div .main-1-left table tr td > nav {width:100%;height:100%;}#MAIN > .main-div .main-1-left table tr td > div.tab-num {position:absolute;z-index:9;right:-20px;top:-5px;background:rgba(0,0,0,0.15);width:60px;height:30px;-ms-transform: rotate(45deg);-webkit-transform: rotate(45deg); transform: rotate(45deg);}#MAIN > .main-div .main-1-left table tr td > div.tab-num span {color:#FFF;line-height:35px;font-size:12px !important;}#MAIN > .main-div .main-1-left table tr td > nav > div {float:left;}#MAIN > .main-div .main-1-left table tr td > nav > div.tab-left {width:65%;}#MAIN > .main-div .main-1-left table tr td > nav > div.tab-right {width:25%;padding-left:5%;text-align:left;}#MAIN > .main-div .main-1-left table tr td > nav > div.tab-right i {font-size:22px;cursor:pointer;color:#FFF;}
			ul.ul-ca {height: 100%;width: 100%;}ul.ul-ca li {height:35px;line-height: 33px;padding-left: 10px;}ul.ul-ca li span i {font-size: 22px;cursor: pointer;margin-right: 15px;}
			
			
			/*#MAIN > .main-div .main-1-left table tr td > nav .tab-top {}#MAIN > .main-div .main-1-left table tr td > nav .tab-top span {font-weight:600;}#MAIN > .main-div .main-1-left table tr td > nav .tab-bot p {margin:10px 0 0 0;}#MAIN > .main-div .main-1-left table tr td > nav .tab-bot p i {font-size:22px;cursor:pointer;}#MAIN > .main-div .main-1-left table tr td > nav .tab-bot > span {display:block;}*/
			/*.hideme {margin-left:-150%;opacity:0;}*/
        </style>
        
        <?php require_once("include/SCRIPT.php"); ?>
        <script>
			$(document).ready(function() {
			<?php if($_SESSION["test"]==0 && $data0["taikhoan"]>=0) { ?>
				$(".btn_tam").click(function() {
					caID = $(this).attr("data-caID");
                    if(caID!="") {
                        $.ajax({
                            async: !1,
                            data: "caID1=" + caID,
                            type: "post",
                            url: "https://localhost/www/TDUONG/xuly-tam/",
                            success: function(a) {
                                switch (a) {
                                    case "vang":
                                        $(this).closest(".popup").find("button.submit2").hide();
                                        $(this).closest(".popup").find("p.title").html("Đang đổi ca...");
//                                        if(confirm("Lớp vắng, bạn có thể đăng ký tạm!")) {
                                            $("#popup-loading").fadeIn("fast");
                                            $("#BODY").css("opacity", "0.1");
                                            $.ajax({
                                                async: !1,
                                                data: "caID=" + caID + "&check=" + a,
                                                type: "post",
                                                url: "https://localhost/www/TDUONG/xuly-tam/",
                                                success: function(a) {
                                                    location.reload();
                                                }
                                            });
//                                        } else {
//                                            location.reload();
//                                        }
                                        break;
                                    case "quatai":
                                        alert("Lớp đã quá tải, bạn không thể đăng ký tạm!");
//                                        location.reload();
                                        break;
//                                        if(confirm("Lớp đang quá tải<?php //if($ontime || $check_binh_voi) {echo", bạn vẫn có thể đăng ký!";} else {echo", nếu đăng ký tạm bạn sẽ bị trừ 5k!";} ?>//")) {
//                                            $("#popup-loading").fadeIn("fast");
//                                            $("#BODY").css("opacity", "0.1");
//                                            $.ajax({
//                                                async: !1,
//                                                data: "caID=" + caID + "&check=" + a,
//                                                type: "post",
//                                                url: "https://localhost/www/TDUONG/xuly-tam/",
//                                                success: function (a) {
//                                                    location.reload();
//                                                }
//                                            });
//                                        } else {
//                                            location.reload();
//                                        }
//                                        break;
                                    case "max":
                                        alert("Lớp không còn sức chứa, bạn không thể đăng ký tạm!");
//                                        location.reload();
                                        break;
                                }
                                $(".popup").fadeOut("fast"), $("#BODY").css("opacity", "1");
                            }
                        });
                    }
				}), $(".btn_codinh").click(function() {
					caID = $(this).attr("data-caID");
                    if(caID!="") {
                        $.ajax({
                            async: !1,
                            data: "caID1=" + caID,
                            type: "post",
                            url: "https://localhost/www/TDUONG/xuly-dkcodinh/",
                            success: function(a) {
                                switch (a) {
                                    case "vang":
                                        $(this).closest(".popup").find("button.submit2").hide();
                                        $(this).closest(".popup").find("p.title").html("Đang đổi ca...");
//                                        if(confirm("Lớp vắng, bạn có thể chuyển bình thường!")) {
                                            $("#popup-loading").fadeIn("fast");
                                            $("#BODY").css("opacity", "0.1");
                                            $.ajax({
                                                async: !1,
                                                data: "caID=" + caID + "&check=" + a,
                                                type: "post",
                                                url: "https://localhost/www/TDUONG/xuly-dkcodinh/",
                                                success: function (a) {
                                                    location.reload();
                                                }
                                            });
//                                        } else {
//                                            location.reload();
//                                        }
                                        break;
                                    case "quatai":
                                        alert("Lớp đã quá tải, bạn không thể đăng ký tạm!");
//                                        location.reload();
                                        break;
//                                        if(confirm("Lớp đang quá tải<?php //if($ontime || $check_binh_voi) {echo", bạn vẫn có thể đăng ký!";} else {echo", nếu chuyển bạn sẽ bị trừ 30k!";} ?>//")) {
//                                            $("#popup-loading").fadeIn("fast");
//                                            $("#BODY").css("opacity", "0.1");
//                                            $.ajax({
//                                                async: !1,
//                                                data: "caID=" + caID + "&check=" + a,
//                                                type: "post",
//                                                url: "https://localhost/www/TDUONG/xuly-dkcodinh/",
//                                                success: function (a) {
//                                                    location.reload();
//                                                }
//                                            });
//                                        } else {
//                                            location.reload();
//                                        }
//                                        break;
                                    case "max":
                                        alert("Lớp không còn sức chứa, bạn không thể chuyển!");
//                                        location.reload();
                                        break;
                                }
                                $(".popup").fadeOut("fast"), $("#BODY").css("opacity", "1");
                            }
                        });
                    }
				}), $(".btn_back").click(function() {
					$("#popup-loading").fadeIn("fast"), $("#BODY").css("opacity", "0.1"), caID = $(this).attr("data-caID");
                    $(this).closest(".popup").find("button.submit2").hide();
                    $(this).closest(".popup").find("p.title").html("Đang đổi ca...");
                    if(caID!="") {
                        $.ajax({
                            async: !1,
                            data: "caID2=" + caID,
                            type: "post",
                            url: "https://localhost/www/TDUONG/xuly-dkcodinh/",
                            success: function (a) {
                                location.reload();
                            }
                        });
                    }
				}), $(".popup .popup-close").click(function() {
					$(".popup").fadeOut("fast"), $("#BODY").css("opacity", "1")
				}), $("#MAIN .main-div #main-info table tr td i.fa-square-o").click(function() {
                    $(".popup").fadeOut("fast");
					caID = $(this).attr("data-caID"), $(this).hasClass("codinh") ? ($(".btn_back").attr("data-caID", caID), $("#backca").fadeIn("fast")) : ($(".btn_codinh, .btn_tam").attr("data-caID", caID),($(this).attr("data-info") && $(this).attr("data-info2")) ? $("#info-ca").show().html("Bạn phải có mặt từ " + $(this).attr("data-info") + ". Thời gian làm bài là 90ph từ " + $(this).attr("data-info2")) : $("#info-ca").hide().html(""), $("#doica").fadeIn("fast")), $("#BODY").css("opacity", "0.1")
				}), $("#MAIN .main-div #main-info table tr td i.fa-check-square-o").click(function() {
					caID = $(this).attr("data-caID"), $(".btn_thoat2").attr("data-caID", caID), $("#thoatca").fadeIn("fast"), $("#BODY").css("opacity", "0.1")
				}), $(".btn_thoat2").click(function() {
					$("#popup-loading").fadeIn("fast"), $("#BODY").css("opacity", "0.1"), caID = $(this).attr("data-caID"), $.ajax({
						async: !1,
						data: "caID0=" + caID,
						type: "post",
						url: "https://localhost/www/TDUONG/xuly-codinh/",
						success: function(a) {
							alert("Lịch học của bạn sẽ chở về ban đầu!"), location.reload()
						}
					})
				}), $("#MAIN .main-div #main-info table tr td i.fa-ban").click(function() {
                        $(".popup").fadeOut("fast");
                        $("#noneca").fadeIn("fast");
                        $("#BODY").css("opacity", "0.1");
				});
			<?php } ?>
				var a = $("#tkb-hin").val();
				var b = $("#tkb-hin2").val();
				$("#tkb-show").html(a);
				$("#tkb-show2").html(b);
				var t = $("#kt-hin").val();
				$("#kt-show").html(t), $("#MAIN > .main-div .main-1-left table tr.con-ca").each(function(a, t) {
					$(t).find("td").hasClass("has-ca") || $(t).remove()
				})
				var max_dem = $("#max-dem").val();
				$(".table-tkb tr th").css("width", (100 / max_dem) + "%");
				$(".table-tkb tr.big-ca th").removeAttr("style").attr("colspan", max_dem);
				
				$(".btn-exit").click(function() {
					$(".popup").fadeOut("fast"), $("#BODY").css("opacity", "1")
				});
				
				$("#view-lichsu").click(function() {
                    $(".popup").fadeOut("fast");
					$("#popup-loading").fadeIn("fast");
					$("#BODY").css("opacity", "0.1");
					$.ajax({
						async: true,
						data: "action=lichsu-ca",
						type: "post",
						url: "https://localhost/www/TDUONG/xuly-dkcodinh/",
						success: function(result) {
							$("#lichsu-ca p.title").html(result);
							$("#popup-loading").fadeOut("fast");
							$("#lichsu-ca").fadeIn("fast");
						}
					})
				});
			});
		</script>
        <script type="text/javascript" src="https://localhost/www/TDUONG/js/canvasjs.min.js"></script>
	</head>

    <body>
    
    	<div class="popup animated bounceIn" id="lichsu-ca" style="top:20%;">
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
        
        <?php if($data0["taikhoan"]<0) { ?>
        <div class="popup animated bounceIn" style="display:block;">
            <div>
                <p class="title">Tài khoản của bạn đang bị âm, bạn không thể đổi ca!<br />(<?php echo format_price($data0["taikhoan"]); ?>)</p>
            </div>
      	</div>	
		<?php } ?>
        
        <div class="popup animated bounceIn" id="noneca">
            <div class="popup-close"><i class="fa fa-close"></i></div>
            <div>
                <p class="title">Bạn không thể đổi ca được, ca học đang diễn ra hoặc đã quá tải!</p>
                <div>
                    <button class="submit2 btn-exit"><i class="fa fa-check"></i></button>
                </div>
            </div>
      	</div>
    
    	<div class="popup animated bounceIn" id="doica">
        	<div class="popup-close"><i class="fa fa-close"></i></div>
        	<div>
                <p class="title" id="info-ca"></p>
            	<p class="title">Bạn muốn đổi cố định hay đổi tạm?</p>
                <div>
                	<button class="submit2 btn_codinh">Cố định</button>
                    <button class="submit2 btn_tam">Tạm</button>
                </div>
<!--                <input type="hidden" id="info-ca" value="" />-->
            </div>
        </div>
        
        <div class="popup animated bounceIn" id="backca">
        	<div class="popup-close"><i class="fa fa-close"></i></div>
        	<div>
            	<p class="title">Bạn muốn trở về ca cố định?</p>
                <div>
                	<button class="submit2 btn_back"><i class="fa fa-check"></i></button>
                </div>
            </div>
        </div>
        
        <div class="popup animated bounceIn" id="thoatca">
        	<div class="popup-close"><i class="fa fa-close"></i></div>
        	<div>
            	<p class="title">Bạn muốn thoát ca này?</p>
                <div>
                    <button class="submit2 btn_thoat2"><i class="fa fa-check"></i></button>
                </div>
            </div>
        </div>
                             
      	<div id="BODY">
            
            <div id="MAIN">
            	
              	<div class="main-div back animated bounceInUp" id="main-top">
                	<div class="ask">
                        <i class="fa fa-question-circle" style="color:<?php echo $mau;?>"></i>
                        <div class="sub-ask">
				<ul>
<!--                                <li><span><span style="font-size:8px">&#9899;</span> -20k nếu chuyển hẳn sang ca ĐÔNG hơn</span></li>-->
<!--                                <li><span><span style="font-size:8px">&#9899;</span> +5k nếu chuyển hẳn sang ca VẮNG hơn</span></li>-->
<!--                                <li><span><span style="font-size:8px">&#9899;</span> -10k nếu chuyển tạm sang ca ĐÔNG hơn</span></li>-->
<!--                                <li><span><span style="font-size:8px">&#9899;</span> +0k nếu chuyển tạm sang ca VẮNG hơn</span></li>-->
                                <!--<li><img src="https://localhost/www/TDUONG/images/dk_tam.png" style="width:60%;height:auto;float:left;" /><span style="float:left;line-height:30px;margin-left:10px;">Lịch học tạm</span></li>
                                <li></li>
                                <li><img src="https://localhost/www/TDUONG/images/dk_codinh.png" style="width:60%;height:auto;float:left;" /><span style="float:left;line-height:30px;margin-left:10px;">Lịch học cố định</span></li>-->
                                <li><span><span style="font-size:8px">&#9899;</span> Học sinh nhớ phải đổi ca trên máy trước khi đi học, nếu tự ý chuyển ca mà chưa đổi ca trên máy thì phạt 20k</span></li>
                                <li><span id='view-lichsu'><span style="font-size:8px;margin-right:5px;">&#9899;</span> Lịch sử đổi ca</span></li>
                            	<div class="clear"></div>
                            </ul>
                        </div>
                   	</div>
                	<div id="main-person">
                		<h1 style="line-height:98px;">Đổi lịch học và lịch thi</h1>
                        <div class="clear"></div>
                   	</div>
                    <div id="main-avata">
                    	<img src="https://localhost/www/TDUONG/hocsinh/avata/<?php echo $data0["avata"]; ?>" />
                        <a href="https://localhost/www/TDUONG/ho-so/" title="Hồ sơ cá nhân">
                        	<p><?php echo $data0["cmt"];?> (<?php echo $data0["de"];?>)</p>
                            <i class="fa fa-pencil"></i>
                        </a>
                   	</div>
                    <!--<div id="main-code"><h2><?php echo $data0["cmt"];?></h2></div>-->
                </div>

                <div class="main-div animated animated2 bounceInUp">
                    <div id="main-info">
                        <div class="main-1-left back" style="padding: 10px 0;">
                            <div>
                                <p class="main-title"><a href="https://localhost/www/TDUONG/xin-nghi-hoc/" style="color:#FFF;">Xin nghỉ học có phép</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                
                <div class="main-div animated bounceInUp">
                    <div id="main-info">
                    	<div class="main-1-left back" style="margin-right:2%;max-height:none;">
                        	<div>
                            	<p class="main-title">Lịch học cố định trong tuần</p>
                                <p id="tkb-show">Thứ 2 - Thứ 4 - Thứ 6</p>
                            </div>
                            <table class="table-tkb" style="border-spacing:0 3px;">
                                <?php
                                    $max=0;
                                    $cum_arr=$list_cum=$tkb=array();
                                    $result=get_all_cum_link($lmID,$monID);
                                    while($data=mysqli_fetch_assoc($result)) {
                                ?>
                                        <tr>
                                            <td colspan="2" style='text-transform:uppercase;'>
                                                <span><?php echo $data["name"]; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td style='text-align: left;padding-top: 0;padding-bottom: 0;'>
                                                <ul class='ul-ca'>
                                        <?php
                                        if($data["link"]!=0) {
                                            $data["ID_CUM"] = $data["link"];
                                        }
                                        $list_cum[]=$data["ID_CUM"];
                                        $cum_arr[$data["ID_CUM"]]=array();
                                        $query5="SELECT c.ID_CA,c.thu,c.siso,g.gio,g.buoi,a.ID_STT AS hientai,o.ID_STT AS codinh FROM cahoc AS c 
                                        INNER JOIN cagio AS g ON g.ID_GIO=c.ID_GIO AND g.ID_MON='$data[ID_MON]'
                                        LEFT JOIN ca_hientai AS a ON a.ID_CA=c.ID_CA AND a.ID_HS='$hsID' AND a.cum='$data[ID_CUM]'
                                        LEFT JOIN ca_codinh AS o ON o.ID_CA=c.ID_CA AND o.ID_HS='$hsID' AND o.cum='$data[ID_CUM]'
                                        WHERE c.cum='$data[ID_CUM]'
                                        ORDER BY c.thu ASC,g.buoi ASC,g.thutu ASC";
                                        $result5 = mysqli_query($db, $query5);
                                        $numtb=($demhs / mysqli_num_rows($result5)) + 25;
                                        while ($data5 = mysqli_fetch_assoc($result5)) {
                                            $has = $has_codinh = false;
                                            if(isset($data5["hientai"]) && is_numeric($data5["hientai"])) {
                                                $has = true;
                                            }
                                            if(isset($data5["codinh"]) && is_numeric($data5["codinh"])) {
                                                $has_codinh = true;
                                            }
                                            if($num_ca[$data5["ID_CA"]] <= $numtb || $num_ca[$data5["ID_CA"]] <= $data5["siso"]) {
                                                $num=$num_ca[$data5["ID_CA"]];
                                                $caID=encode_data($data5["ID_CA"],$code);
                                            } else {
                                                $num=-$num_ca[$data5["ID_CA"]];
                                                $caID=encode_data(0,$code);
                                            }
                                            $cum_arr[$data["ID_CUM"]][]=$num;
                                            $max = $max > abs($num) ? $max : abs($num);
                                            $check=check_dang_hoc($data5["gio"],$data5["thu"]);
                                            if($has) {
                                                if($has_codinh) {
                                                    echo"<li style='background:rgba(255,255,255,0.15);'>";
                                                } else {
                                                    echo"<li style='background:rgba(255,250,3,0.2);'>";
                                                }
                                                $tkb[]="Thứ ".$data5["thu"];
                                                echo"<span><i class='";if($has_codinh){echo"codinh";} echo" fa ";if($check || $num<0) echo"fa-ban"; else echo"fa-check-square-o";echo"'></i></span>";
                                            } else {
                                                echo"<li><span><i class='fa ";if($check || $num<0) echo"fa-ban"; else echo"fa-square-o";echo"' data-caID='".$caID."'></i></span>";
                                            }
                                            echo "<span>Thứ $data5[thu], $data5[gio]</span></li>";
                                        }
                                        ?>
                                                </ul>
                                            </td>
                                            <td style='width: 50%;padding-top: 0;padding-bottom: 0;'><div id='chart-codinh-<?php echo $data["ID_CUM"]; ?>' style='width:100%;height:<?php echo 43.5*count($cum_arr[$data["ID_CUM"]]); ?>px;'></div></td>
                                        </tr>
                                <?php } ?>
                            </table>
                            <input type="hidden" value="<?php echo implode(" - ",$tkb);?>" id="tkb-hin" />
                        </div>
                        <div class="main-1-left back">
                            <div>
                            	<p class="main-title">Ca thi vào chủ nhật</p>
								<p id="kt-show">8h - 10h</p>
                            </div>
                            <table class="table-tkb">
                                <tr>
                                    <td style='text-align: left;padding-top: 0;padding-bottom: 0;'>
                                        <ul class='ul-ca'>
                                <?php
                                    $kt=NULL;
                                    $list_cum[]=0;
                                    $query4="SELECT c.ID_CA,c.thu,c.siso,c.cum,g.gio,g.buoi,a.ID_STT AS hientai,o.ID_STT AS codinh FROM cahoc AS c 
                                    INNER JOIN cagio AS g ON g.ID_GIO=c.ID_GIO AND g.ID_LM='0' AND g.ID_MON='$monID'
                                    LEFT JOIN ca_hientai AS a ON a.ID_CA=c.ID_CA AND a.ID_HS='$hsID' AND a.cum=c.cum
                                    LEFT JOIN ca_codinh AS o ON o.ID_CA=c.ID_CA AND o.ID_HS='$hsID' AND o.cum=c.cum
                                    ORDER BY g.buoi ASC, g.thutu ASC";
                                    $result4=mysqli_query($db,$query4);
                                    $numtb=($demhs2 / mysqli_num_rows($result4)) + 25;
                                    while($data4=mysqli_fetch_assoc($result4)) {
                                        $has = $has_codinh = false;
                                        if(isset($data4["hientai"]) && is_numeric($data4["hientai"])) {
                                            $has = true;
                                        }
                                        if(isset($data4["codinh"]) && is_numeric($data4["codinh"])) {
                                            $has_codinh = true;
                                        }
                                        if($num_ca[$data4["ID_CA"]] <= $numtb || $num_ca[$data4["ID_CA"]] <= $data4["siso"]) {
                                            $num=$num_ca[$data4["ID_CA"]];
                                            $caID=encode_data($data4["ID_CA"],$code);
                                        } else {
                                            $num=-$num_ca[$data4["ID_CA"]];
                                            $caID=encode_data(0,$code);
                                        }
                                        $max = $max > abs($num) ? $max : abs($num);
                                        $cum_arr[0][]=$num;
                                        $check=check_dang_hoc($data4["gio"],$data4["thu"]);
                                        $temp=explode(" - ",$data4["gio"]);
                                        $pre_gio=get_gio_last($temp[0],15);
                                        if(substr($data4["buoi"],1,1)=="S") {
                                            $buoi="Sáng";
                                        } else if(substr($data4["buoi"],1,1)=="C") {
                                            $buoi="Chiều";
                                        } else {
                                            $buoi="Tối";
                                        }
                                        if($has) {
                                            if($has_codinh) {
                                                echo"<li style='background:rgba(255,255,255,0.15);'>";
                                            } else {
                                                echo"<li style='background:rgba(255,250,3,0.2);'>";
                                            }
                                            $kt=$data4["gio"];
                                            echo"<span><i class='";if($has_codinh){echo"codinh";} echo" fa ";if($check || $num<0) echo"fa-ban"; else echo"fa-check-square-o";echo"'></i></span>";
                                        } else {
                                            echo"<li><span><i class='fa ";if($check || $num<0) echo"fa-ban"; else echo"fa-square-o";echo"' data-caID='".$caID."' data-info='$pre_gio' data-info2='$data4[gio]'></i></span>";
                                        }
                                        echo "<span>$buoi $data4[gio]</span></li>";
                                    }
                                ?>
                                        </ul>
                                    </td>
                                    <td style='width: 50%;padding-top: 0;padding-bottom: 0;'><div id='chart-codinh-0' style='width:100%;height:<?php echo 37.5*count($cum_arr[0]); ?>px;'></div></td>
                                </tr>
                            </table>
                            <input type="hidden" value="<?php echo $kt; ?>" id="kt-hin" />
                        </div>
                    </div>
                </div>
                
                <div class="clear"></div>

                <?php require_once("include/IN.php"); ?>	               
            </div>
        	<div class="clear"></div>
        </div>
        <?php require_once("include/MENU.php"); ?>
        <script type="text/javascript">
            window.onload = function () {
                <?php
                    for($i=0;$i<count($list_cum);$i++) {
                ?>
                var chartCodinh<?php echo $list_cum[$i]; ?> = new CanvasJS.Chart('chart-codinh-<?php echo $list_cum[$i]; ?>',
                    {
                        backgroundColor: '',
                        axisY:{
                            interval: 30,
                            labelFontColor: '',
                            labelFontSize: 0,
                            labelFontWeight: 'normal',
                            labelFontFamily:'helvetica' ,
                            tickColor: '#D0AA86',
                            gridThickness: 0,
                            tickThickness: 0,
                            lineColor: 'rgba(255,255,255,0.15)',
                            gridColor: 'rgba(255,255,255,0.15)',
                            maximum: <?php echo $max; ?>
                        },
                        theme: 'theme2',
                        interactivityEnabled: true,
                        axisX:{
                            labelFontColor: '',
                            labelFontSize: 0,
                            labelFontWeight: 'normal',
                            labelFontFamily:'helvetica' ,
                            labelMaxWidth: 400,
                            interval:1,
                            gridColor: 'rgba(255,255,255,0.15)',
                            tickColor: '#D0AA86',
                            tickThickness: 0,
                            lineThickness: 0,
                            lineColor: 'rgba(255,255,255,0.15)'
                        },
                        animationEnabled: true,
                        dataPointWidth: 15,
                        toolTip:{
                            enabled: true,
                            shared: true,
                            backgroundColor: "#FFF",
                            borderColor: "",
                            borderThickness: 0,
                            fontColor: "#000",
                        },
                        legend:{
                            horizontalAlign: 'center',
                            verticalAlign: 'top',
                            fontFamily: 'helvetica',
                            fontSize: 12
                        },
                        data:[
                            {
                                type: 'bar',
                                showInLegend: false,
                                name: 'TỈ LỆ LÀM ĐƯỢC',
                                color: '<?php echo $mau; ?>',
                                indexLabelFontColor: '<?php echo $mau; ?>',
                                indexLabelPlacement: 'outside',
                                indexLabelOrientation: 'horizontal',
                                indexLabelFontFamily:'helvetica' ,
                                indexLabelFontSize: 14,
                                indexLabelFontWeight: 'normal',
                                toolTipContent: "Số lượng học sinh",
                                dataPoints: [
                                    <?php
                                        $n = count($cum_arr[$list_cum[$i]]);
                                        for($j=0;$j<$n;$j++) {
                                            $num=$cum_arr[$list_cum[$i]][$n-1-$j];
                                            if($num<0) {
                                                echo"{y: ".abs($num).", color: 'red'},";
                                            } else {
                                                echo"{y: ".abs($num)."},";
                                            }
                                        }
                                    ?>
                                ]
                            }
                        ]
                    });
                chartCodinh<?php echo $list_cum[$i]; ?>.render();
                <?php } ?>
            }
        </script>
    </body>
</html>

<?php
	ob_end_flush();
	require_once("model/close_db.php");
?>