<?php 
ini_set('max_execution_time', '0'); 

if(file_exists('error.txt')){ 
  unlink('error.txt');//將檔案刪除
}
if(file_exists('error1.txt')){ 
  unlink('error1.txt');//將檔案刪除
}
if(file_exists('error2.txt')){ 
  unlink('error2.txt');//將檔案刪除
}
if(file_exists('error3.txt')){ 
  unlink('error3.txt');//將檔案刪除
}
if(file_exists('error4.txt')){ 
  unlink('error4.txt');//將檔案刪除
}
if(file_exists('error5.txt')){ 
  unlink('error5.txt');//將檔案刪除
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>DA DA 智能理財</title>

  <!-- Custom fonts for this theme -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Theme CSS -->
  <link href="css/freelancer.min.css" rel="stylesheet">
          <!-- ================= Favicon ================== -->
        <!-- Standard -->
        <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
        <!-- Retina iPad Touch Icon-->
        <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
        <!-- Retina iPhone Touch Icon-->
        <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
        <!-- Standard iPad Touch Icon-->
        <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
        <!-- Standard iPhone Touch Icon-->
        <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">
      
    <meta name="HandheldFriendly" content="true"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="https://www.chartjs.org/docs/latest/gitbook/images/apple-touch-icon-precomposed-152.png">
    <link rel="shortcut icon" href="https://www.chartjs.org/docs/latest/gitbook/images/favicon.ico" type="image/x-icon">  
    <link rel="next" href="https://www.chartjs.org/docs/latest/charts/polar.html" />      
    <link rel="prev" href="https://www.chartjs.org/docs/latest/charts/radar.html" />
    <link rel="stylesheet" href="https://www.chartjs.org/docs/latest/gitbook/gitbook-plugin-chartjs/style.css">
    <script src="https://www.chartjs.org/docs/latest/gitbook/gitbook-plugin-chartjs/Chart.bundle.js"></script>
    <script src="https://www.chartjs.org/docs/latest/gitbook/gitbook-plugin-chartjs/chartjs-plugin-deferred.js"></script>
    

</head>

<body id="page-top">
<?php
$_SESSION["yourname"] = $_POST["yourname"];
$_SESSION["password"] = $_POST["password"];
$_SESSION["age"] = $_POST["age"];
$_SESSION["retireAge"] = $_POST["retireAge"];
$_SESSION["expectAge"] = $_POST["expectAge"];
$_SESSION["expenses"] = $_POST["expenses"];
$_SESSION["risk"] = $_POST["risk"];
$_SESSION["in_per_year"] = $_POST["in_per_year"];
$_SESSION["want_calc"] = $_POST["want_calc"];
$_SESSION["want_see"] = $_POST["want_see"];//ymdnum
$_SESSION["ymd"] = $_POST["ymd"];

        $servername = "localhost";
        $username = "root";
        $password = "esfortest";
        $dbname = "etf";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // $sql = "SELECT id , port, distance  FROM test_table  WHERE id='1234'";
        $a = $_POST["age"];
        $b = $_POST["retireAge"];
        $c = $_POST["expectAge"];
        $d = $_POST["expenses"];
        $f = $_POST["in_per_year"];
        $e = $_POST["risk"];
        $g = $_POST["want_calc"];
        $h = $_POST["want_see"];
        $sqlyourname = $_POST["yourname"];
        $sqlpassword = $_POST["password"];
        
        $sql = "INSERT INTO user_data (name,id,age,retireAge,expectAge,expenses,want_calc,want_see)VALUES ('$sqlyourname','$sqlpassword','$a','$b','$c','$d','$g','$h' )";
        $sqlr = "INSERT INTO user_datar (name,id,age,retireAge,expectAge,expenses,want_calc,want_see)VALUES ('$sqlyourname','$sqlpassword','$a','$b','$c','$d','$g','$h' )";

        $resultyy = $conn->query($sql);
        $resultyyr = $conn->query($sqlr);
        $conn->close();
 ?>
        
         <?php
//每年固定投入金額
$y_in_money = $_POST["in_per_year"]*10000;
// $y_in_money = 60000;

//投入年份數
$years = $_SESSION["retireAge"] - $_SESSION["age"]+1;
$yyyy = $years-1;

//需要的退休金金額
 $need_pension = $_POST["expenses"] * ($_SESSION["expectAge"] - $_SESSION["retireAge"]) * 12 * 10000 * pow(1+1.72/100,$years-1);//需要準備的退休金
$need_pension = ceil($need_pension);

$first_input = $_SESSION["risk"];
$want_see_far = $_SESSION["want_calc"];

unset($out);
$var = 6;
$var1 = 12;
$mode = 3;
//選股 C:/Users/User/Anaconda3/python.exe
exec("/usr/bin/python3 functions/choose.py {$yyyy} {$need_pension} {$y_in_money} {$mode} {$first_input} {$want_see_far} {$sqlyourname} {$sqlpassword}",$out,$ret);
$var=explode(" ",$out[0]);//選股結果
$n = count($var);//選出幾個

//各股比例
$weight = explode(" ",$out[1]);

$reward = $out[2];

$stringB = "%";
$std_dev = ($out[3]*100).$stringB;

$nodiv_r = $out[6];

$div = $out[7];

$expect = $out[8];

$best_v3_year = $out[9];
$best_v3_month = $out[10];
$best_v3_day = $out[11];

//一次投入金額
$one_in_money = $need_pension / pow((double)$reward/100+1,$years-1);
$one_in_money = ceil($one_in_money);


//年齡陣列
$y = array(0=>$_SESSION["age"]);
for ( $i=1 ; $i<$years ; $i++ ){
    $y[$i] = $i+$_SESSION["age"];
}
$y1 = implode(",",$y);

//累計投入金額陣列
$in_money = array(0=>$first_input*10000);
for ( $i=1 ; $i<$years ; $i++ ){
    $in_money[$i] = ($i)*$y_in_money+$first_input*10000;
}
$in_money1 = implode(",",$in_money);

//資產總額陣列
// $total_money = array(0=>0);
// for ( $i=1 ; $i<$years ; $i++ ){
//   if($i==1){
//     $total_money[$i] = $total_money[$i-1]*((double)$reward/100+1) + $first_input*10000;
//     // $total_money[$i] = $total_money[$i-1]*((double)$nodiv_r+1)*((double)$div/100+1) + $y_in_money;
//     $total_money[$i] = round($total_money[$i]);
//   }
//   else{
//     $total_money[$i] = $total_money[$i-1]*((double)$reward/100+1) + $y_in_money;
//     // $total_money[$i] = $total_money[$i-1]*((double)$nodiv_r+1)*((double)$div/100+1) + $y_in_money;
//     $total_money[$i] = round($total_money[$i]);
//   }
    
// }
// $total_money[count($total_money)-2] = $total_money[count($total_money)-2] + 1058722;
// $total_money[count($total_money)-1] = $need_pension + 38722;

$total_money = array(0=>$first_input*10000);
$temp_arr = array(0=>$first_input*10000);
$rrr = (double)$reward/100/12;
$in_per_month = $y_in_money/12;
$count_len=0;
for ( $i=1 ; $i<$years*12+1 ; $i++ ){
  $temp = $temp_arr[count($temp_arr)-1]*(1+$rrr)+$in_per_month;
  $temp_arr[$i] = $temp;
  if ($i%12==0){
    $count_len++;
    $total_money[$count_len] = round($temp);
  }
      
}
$total_money1 = implode(",",$total_money);   

  if (strcmp( $_SESSION["ymd"], '年' ) == 0){//歷史回測單位為年，轉為月
    $want_see_type = 1;
    $his_m = $h*12;
  }
  elseif(strcmp( $_SESSION["ymd"] , '月' ) == 0){
    $his_m = $h;
    $want_see_type = 2;
  }

  // $his_m=50;
  $his_m+=1;
  // $his_y=ceil($his_m/12);
  if( $his_m >= 12)
  {
    $his_y=ceil($his_m/12);
  }
  else
  {
    $his_y=0;
  }

  $o0 = implode(",",$var);
  $o1 = implode(",",$weight);
  unset($out);
  exec("/usr/bin/python3 functions/historical_m_total.py {$o0} {$o1} {$his_m} {$y_in_money} {$best_v3_day} {$best_v3_month} {$best_v3_year}",$out,$ret);
  // $his_reward = explode(" ",$out[0]);//歷年報酬率
  $his_total_money = explode(" ",$out[0]);
  $his_analy = explode(" ",$out[1]);
  $his_analy_fmoney = explode(" ",$out[2]);
  $his_analy_inmoney = explode(" ",$out[3]);
  $his_event = explode(" ",$out[4]);

  //月份陣列 歷史
  if( $his_m >= 12)
  {
    $now_y = $best_v3_year+1;
  }
  else
  {
    $now_y = $best_v3_year;
  }
  $now_m = $best_v3_month;//7
  // $his_y=5;
  $start_y = $now_y-$his_y;
  $start_m = $now_m+1-($his_m%12);
  if($start_m==13){
      $start_m=1;
  }
  elseif($start_m<1){
    $start_m += 12;
    $start_y -=1 ;
  }
      
  $yy = array( 0=>(string)($start_y*100+$start_m) );
  
  $ccc=1;
  $yyy=$start_y;
  $mmm=$start_m;
  while($ccc<$his_m){
      if($mmm==12){
          $mmm=1;
          $yyy++;
      }
      else{
          $mmm++;
      }
      $yy[$ccc] = (string)($yyy*100+$mmm);
      $ccc++;
  }
  
  $yy1 = implode(",",$yy);
  // $his_reward1 = implode(",",$his_reward);
  
  //累計投入金額陣列 歷史
  $in_money2 = array(0=>0);
  for ( $i=1 ; $i<$his_m ; $i++ ){
    $in_money2[$i] = $i*$y_in_money/12;
  }
  $in_money3 = implode(",",$in_money2);
  
  //資產總額2陣列 歷史回測
  // $his_total_money = array(0=>0);
  // for ( $i=1 ; $i<$his_m ; $i++ ){
  //     // $his_total_money[$i] = (pow((double)$reward/100+1,$i)-1) * $y_in_money / ((double)$reward/100);
  //     $his_total_money[$i] = $his_total_money[$i-1]*((double)$his_reward[$i-1]+1) + $y_in_money/12;
  //     $his_total_money[$i] = round($his_total_money[$i],2);
  // }
  $his_total_money1 = implode(",",$his_total_money);






$servername = "localhost";
$username = "root";
$password = "esfortest";
$dbname = "etf";
$usertable="detail";

// $conn->close();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$ccc=1;
for ($i=0;$i<count($weight)-1;$i++){

  $weight[$i] = round($weight[$i],5);
  $ccc=$ccc-$weight[$i];
}
$weight[count($weight)-1]=$ccc;



$count_percent_stockstock = 0;
$stockstock = array(0=>0);
$stockstock_name = array(0=>0);
$count_stockstock = 0;
$stockstock_percent = array(0=>0);
for ( $i=0 ; $i<$n ; $i++ ){
    mysqli_query($conn,"SET NAMES 'utf8'");
    $sql = "SELECT * FROM $usertable where name = '".$var[$i] ."'";
    // echo $sql;
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result);
    if($row[14]=='STOCK'){
    // if(preg_match("/股/",$row[3] ) and ($row[14]=='ETF') ){
        $wght = $weight[$i]*100;
        $count_percent_stockstock += $wght;
        $stockstock[$count_stockstock] = $row[0];
        $stockstock_percent[$count_stockstock] = $wght;
        $stockstock_name[$count_stockstock++] = $row[1];
    }

}

$count_percent_stock = 0;
$stock = array(0=>0);
$stock_name = array(0=>0);
$count_stock = 0;
$stock_percent = array(0=>0);
for ( $i=0 ; $i<$n ; $i++ ){
    mysqli_query($conn,"SET NAMES 'utf8'");
    $sql = "SELECT * FROM $usertable where name = '".$var[$i] ."'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result);
    // if($row[3]=='股票型'){
    if(preg_match("/股/",$row[3] ) and ($row[14]=='ETF') ){
        $wght = $weight[$i]*100;
        $count_percent_stock += $wght;
        $stock[$count_stock] = $row[0];
        $stock_percent[$count_stock] = $wght;
        $stock_name[$count_stock++] = $row[1];
    }

}


$count_percent_bond = 0;
$bond = array(0=>0);
$bond_name = array(0=>0);
$count_bond = 0;
$bond_percent = array(0=>0);
for ( $i=0 ; $i<$n ; $i++ ){
    mysqli_query($conn,"SET NAMES 'utf8'");
    $sql = "SELECT * FROM $usertable where name = '".$var[$i] ."'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result);
    //if($row[3]=='債券型'){
    if(preg_match("/債/",$row[3] )and ($row[14]=='ETF') ){
        $wght = $weight[$i]*100;
        $count_percent_bond += $wght;
        $bond[$count_bond] = $row[0];
        $bond_percent[$count_bond] = $wght;
        $bond_name[$count_bond++] = $row[1];
        
    }
    
}

$count_percent_other = 0;
$other = array(0=>0);
$other_name = array(0=>0);
$count_other = 0;
$other_percent = array(0=>0);
for ( $i=0 ; $i<$n ; $i++ ){
    mysqli_query($conn,"SET NAMES 'utf8'");
    $sql = "SELECT * FROM $usertable where name = '".$var[$i] ."'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result);
    //if($row[3]=='債券型'){
    if(!(preg_match("/債/",$row[3] )) and !(preg_match("/股/",$row[3] )) and ($row[14]=='ETF')){
        $wght = $weight[$i]*100;
        $count_percent_other += $wght;
        $other[$count_other] = $row[0];
        $other_percent[$count_other] = $wght;
        $other_name[$count_other++] = $row[1];
        
    }
    
}


unset($out);
exec("/usr/bin/python3 functions/risk_analysis.py {$o0} {$o1} {$best_v3_day} {$best_v3_month} {$best_v3_year}",$out,$ret);
$mdds = explode(" ",$out[0]);
$stddevs = explode(" ",$out[1]);
$sharpes = explode(" ",$out[2]);
$stddevs2 = explode(" ",$out[3]);

?>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg text-uppercase fixed-top" id="mainNav" style = "background: 	#2E8B57;">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="start-pages/start.php">DA DA 智能理財</a>
      <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#portfolio">金流模擬</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">投資組合</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">歷史回測</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Masthead -->
  <header class="masthead text-white text-center" style = "background: #FFBF00;">
    <div class="container d-flex align-items-center flex-column">

      <!-- Masthead Avatar Image -->
      <img class="masthead-avatar mb-5" src="img/bee_2.png" alt="">

      <!-- Masthead Heading -->
      <h2 class="masthead-heading text-uppercase mb-0">提早規劃退休生活</h2><br>
      <h2 class="masthead-heading text-uppercase mb-0">享受自在後半人生</h2>

      <!-- Icon Divider -->
      <div class="divider-custom divider-light">
        <div class="divider-custom-line"></div>
        <div class="divider-custom-icon">
          <i class="fas fa-star"></i>
        </div>
        <div class="divider-custom-line"></div>
      </div>

      <!-- Masthead Subheading -->
      <p class="masthead-subheading font-weight-light mb-0">用規劃，讓退休生活無限可能</p>

    </div>
  </header>
  <br><br>
  <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">input (Monthly)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo number_format($y_in_money/12); ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">first time's input</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo number_format($first_input*10000);?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">expect reward</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo ($expect);?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Requests</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo number_format($need_pension);?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

  <!-- Portfolio Section -->
  <section class="page-section portfolio" id="portfolio">
    <div class="container">

      <!-- Portfolio Section Heading -->
      <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">金流模擬</h2>

      <!-- Icon Divider -->
      <div class="divider-custom">
        <div class="divider-custom-line"></div>
        <div class="divider-custom-icon">
          <i class="fas fa-star"></i>
        </div>
        <div class="divider-custom-line"></div>
      </div>

      <div class="row">
                            <!-- column -->
                            <div class="col-lg-1">
                            </div>
                            <div class="col-lg-10">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">投資金流模擬<?php// print_r($yy); ?></h4>
                                        <!-- <div id="morris-bar-chart"></div> -->
                                        <div><h6>依據您所輸入的參數為您選擇了最適合您的投資組合;投資期間經過 <?php echo($years-1); ?> 年後,您的投組價值將有機會達<?php echo($total_money[$years-1]); ?>元。</h6></div>
                                        
                                        <p><div class="chartjs-wrapper"><canvas id="chartjs-0" class="chartjs" width="undefined" height="undefined"></canvas>
                                            <script>new Chart(document.getElementById("chartjs-0"),
                                            {"type":"line",
                                            "data":{"labels":<?php echo "[ $y1 ]"; ?>,
                                            "datasets":[{"label":"資產總額","data": <?php echo "[ $total_money1 ]"; ?>,"fill":false,"borderColor":"rgb(75, 192, 192)","lineTension":0.1},
                                                        {"label":"累計投入本金","data": <?php echo "[ $in_money1 ]"; ?>,"fill":false,"borderColor":"rgb(255, 0, 0)","lineTension":0.1}]},"options":{}});
                                            </script>
                                        </div></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1">
                            </div>
  </section>

  <!-- About Section -->
  <section class="page-section mb-0" id="about" style = "background: #FFBF00;">
    <div class="container">

      <!-- About Section Heading -->
      <h2 class="page-section-heading text-center text-uppercase ">投資組合</h2>

      <!-- Icon Divider -->
      <div class="divider-custom divider-light">
        <div class="divider-custom-line"></div>
        <div class="divider-custom-icon">
          <i class="fas fa-star"></i>
        </div>
        <div class="divider-custom-line"></div>
      </div>

      <div class="row">
                            <div class="col-lg-1">
                            </div>
                            <div class="col-lg-3">
                                <div class="card text-center" height="100%">
                                        <div id="pieChartdiv" style="width: 100%; height: 395px">
                                            <div class="chartjs-wrapper"><canvas id="chartjs-4" class="chartjs" width="100%" height="130px"></canvas>
                                            <script>new Chart(document.getElementById("chartjs-4"),
                                            {"type":"doughnut","data":{"labels":["ETF股票型","ETF債券型","ETF其他型"],
                                            "datasets":[{"label":"My First Dataset","data":[<?php print_r($count_percent_stockstock);?>,<?php print_r($count_percent_stock);?>,<?php print_r($count_percent_bond);?>,<?php print_r($count_percent_other);?>],
                                            "backgroundColor":["rgb(255, 99, 132)","rgb(54, 162, 235),","rgb(255, 222, 132)","rgb(158, 99, 132)"]}]}});</script></div>
                                        </div>
                                    <br>
                                    <p class="lead">年化報酬率<?php print_r($reward);?></p>
                                    <br>
                                    <p class="lead">年化標準差<?php print_r($std_dev);?></p>
                                    <br>                                    
                            </div>
                            <br>
                            <div class="col-lg-12">
                              <div class="panel-group" id="accordion">
                                <div class="card text-center">
                                  
                                      <div class="panel panel-default" id="headingOne">
                                          <div class="panel-heading">
                                              <h4 class="panel-title">
                                              <!-- <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                    投資組合風險程度
                                                  </button> -->
                                                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"  aria-controls="collapseOne">
                                                  投資組合風險程度
                                                  </a>
                                              </h4>
                                          </div>
                                          <!-- <div id="collapseOne" class="collapse" aria-labelledby="headingOne"> -->
                                          <div id="collapseOne" class="panel-collapse collapse in">
                                              <div class="panel-body">
                                                投資組合風險程度為
                                                <?php 
                                                if($std_dev<5){
                                                  echo('保守型');
                                                }
                                                elseif($std_dev>=5 and $std_dev<10){
                                                  echo('穩健型');
                                                }
                                                else {
                                                  echo('積極型，建議可延長投資年限或增加投資金額');
                                                }
                                                
                                                ?>
                                              </div>
                                          </div>
                                      </div>
                                  </div>  
                                </div>     
                                </div>
                                <!-- /# card -->
                            </div>
                            <!-- /# column -->
                            <div class="col-lg-7">
                                <div class="card">
                                    <div class="card-title">
                                        <h3>選股結果 <br/></h3>
                                    </div>
                                    <p> </p>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                        
                                            <h4>ETF股票型  <?php print_r($count_percent_stock); ?> %</h4>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2">ETF</th>
                                                        <th>比例</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <?php
                                                            $count_percent = 0;
                                                            for ( $i=0 ; $i<$count_stock ; $i++ ){
                                                                echo("<tr> <td>$stock[$i]</td> <td> $stock_name[$i]</td> <td>$stock_percent[$i]%</td> </tr>");
                                                            }
                                                        ?>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                            <h4>ETF債券型  <?php print_r($count_percent_bond); ?> %</h4>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2">ETF</th>
                                                        <th>比例</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <?php
                                                            
                                                            for ( $i=0 ; $i<$count_bond ; $i++ ){
                                                                echo("<tr> <td>$bond[$i]</td> <td> $bond_name[$i]</td> <td>$bond_percent[$i]%</td> </tr>");
                                                            }
                                                        ?>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                            <h4>ETF其他型  <?php print_r($count_percent_other); ?> %</h4>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2">ETF</th>
                                                        <th>比例</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <?php
                                                            
                                                            for ( $i=0 ; $i<$count_other ; $i++ ){
                                                                echo("<tr> <td>$other[$i]</td> <td> $other_name[$i]</td> <td>$other_percent[$i]%</td> </tr>");
                                                            }
                                                        ?>
                                                        
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-lg-1">
                            </div>
                            <div class="col-lg-1">
                            </div> -->

                        </div>
  </section>
  <!-- About Section -->
  <!-- <section class="page-section bg-primary mb-0" id="about"> -->
  

  <!-- Contact Section -->
  <section class="page-section" id="contact">
    <div class="container">

      <!-- Contact Section Heading -->
      <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">歷史回測</h2>

      <!-- Icon Divider -->
      <div class="divider-custom">
        <div class="divider-custom-line"></div>
        <div class="divider-custom-icon">
          <i class="fas fa-star"></i>
        </div>
        <div class="divider-custom-line"></div>
      </div>

      <!-- Contact Section Form -->
      <div class="row">
      <div class="col-lg-1">
                            </div>
                            <div class="col-lg-10">
                                <div class="card alert">
                                    <div class="card-title">
                                        <h4>歷史回測</h4>
                                    </div>
                                    <?php 
                                    $nnn = count($his_total_money)-1;
                                    $final_money = $his_total_money[$nnn];
                                    $final_in_money = $in_money2[$nnn];
                                    $rrr = ($final_money-$final_in_money)/$final_in_money*100;
                                    // echo(round($rrr,5)."%");
                                    ?>
                                    <div><h6>過去<?php  echo( (string)$_SESSION['want_see'] . (string)$_SESSION['ymd']); ?>的歷史回測結果，
                                    共投入了<?php echo($final_in_money)?>元，資產終值為<?php echo($final_money)?>元，
                                    總報酬率是 <?php echo(round($rrr,3)."%");?>。
                                    </h6></div>
                                    <div class="chartjs-wrapper"><canvas id="chartjs-1" class="chartjs" width="undefined" height="undefined"></canvas>
                                        <script>new Chart(document.getElementById("chartjs-1"),
                                            {"type":"line",
                                            "data":{"labels":<?php echo "[ $yy1 ]"; ?>,
                                            "datasets":
                                            [{"label":"資產總額","data": <?php echo "[ $his_total_money1 ]"; ?>,"fill":false,"borderColor":"rgb(75, 192, 192)","lineTension":0.1},
                                                        {"label":"累計投入本金","data": <?php echo "[ $in_money3 ]"; ?>,"fill":false,"borderColor":"rgb(255, 0, 0)","lineTension":0.1}]},
                                                        "options":{}});
                                        </script>
                                    </div>
                                    <br>
                                    
                                    <div class="panel-group" id="accordion">
                                      <div class="panel panel-default">
                                          <div class="panel-heading">
                                              <h4 class="panel-title">
                                                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-controls="collapseTwo">
                                                  投資組合分析
                                                  </a>
                                              </h4>
                                          </div>
                                          <div id="collapseTwo" class="panel-collapse collapse in">
                                              <div class="panel-body">
                                              <table class="table">
                                                <thead>
                                                    <tr>  <th>時間長度</th>  <th>近3月</th>  <th>近6月</th>  <th>近1年</th>  <th>近2年</th>  <th>近3年</th>  </tr>
                                                </thead>
                                                <tbody>
                                                    <tr> 
                                                      <td> 投入資金 </td>
                                                      <?php
                                                          for($i=0;$i<5;$i++){
                                                            echo( "<td> $his_analy_inmoney[$i] </td>"   );

                                                          }   
                                                      ?>
                                                      </tr>
                                                    <tr> 
                                                      <td> 資產總額 </td>
                                                      <?php
                                                          for($i=0;$i<5;$i++){
                                                            echo( "<td> $his_analy_fmoney[$i] </td>"   );
                                                            
                                                          }   
                                                      ?>
                                                      </tr>
                                                    <tr> 
                                                      <td> 總報酬率 </td>
                                                      <?php
                                                          for($i=0;$i<5;$i++){
                                                            echo( "<td> $his_analy[$i] </td>"   );
                                                            
                                                          }   
                                                      ?>
                                                      </tr>
                                                    <tr> 
                                                      <td>標準差 </td>
                                                      <?php
                                                          for($i=0;$i<5;$i++){
                                                            echo( "<td> $stddevs2[$i] </td>"   );
                                                            
                                                          }   
                                                      ?>
                                                      </tr>
                                                    
                                                </tbody>
                                            </table>
                                            </div>
                                          </div>
                                      </div>
                                      <div>
                                      <br>
                                      <div class="panel panel-default">
                                          <div class="panel-heading">
                                              <h4 class="panel-title">
                                                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-controls="collapseThree">
                                                  重大歷史事件表現
                                                  </a>
                                              </h4>
                                          </div>
                                          <div id="collapseThree" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                              <table class="table">
                                                <thead>
                                                    <tr>  <th>事件</th>  <th>時間</th>  <th>總報酬率</th>  </tr>
                                                </thead>
                                                <tbody>
                                                    <tr> <td>國際油價暴跌</td> <td>2014/6/20 ~ now</td> <td><?php echo($his_event[0]) ?></td>  </tr>
                                                    <tr> <td>Fed啟動升息循環</td> <td>2015/12/17 ~ now</td> <td><?php echo($his_event[1]) ?></td>   </tr>
                                                    <tr> <td>英國脫歐</td> <td>2016/6/23 ~ now</td> <td><?php echo($his_event[2]) ?></td>   </tr>
                                                    <tr> <td>中美貿易戰</td> <td>2018/3/22 ~ now</td> <td><?php echo($his_event[3]) ?></td>   </tr>
                                                    
                                                </tbody>
                                              </table>
                                            </div>
                                          </div>
                                      </div>

                                      <br>
                                      <div class="panel panel-default">
                                          <div class="panel-heading">
                                              <h4 class="panel-title">
                                                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-controls="collapseFour">
                                                  投資組合風險評估 
                                                  </a>
                                              </h4>
                                          </div>
                                          <div id="collapseFour" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                              <div class="card-body">
                                              <div class="table-responsive">
                                              <table class="table">
                                                <thead>
                                                    <tr> <th>時間長度</th> <th>最大回撤率</th>          <th>標準差</th>                      <th>夏普值</th>                     </tr>
                                                </thead>
                                                <tbody>
                                                    <tr> <td>本月</td>      <td><?php echo($mdds[0]) ?></td> <td><?php echo($stddevs[0]) ?></td>  <td><?php echo($sharpes[0]) ?></td> </tr>
                                                    <tr> <td>本季</td>      <td><?php echo($mdds[1]) ?></td> <td><?php echo($stddevs[1]) ?></td>  <td><?php echo($sharpes[1]) ?></td> </tr>
                                                    <tr> <td>本年度</td>    <td><?php echo($mdds[2]) ?></td> <td><?php echo($stddevs[2]) ?></td>  <td><?php echo($sharpes[2]) ?></td> </tr>
                                                    <tr> <td>成立至今</td> <td><?php echo($mdds[3]) ?></td> <td><?php echo($stddevs[3]) ?></td>  <td><?php echo($sharpes[3]) ?></td> </tr>
                                                    
                                                </tbody>
                                              </table>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                                <!-- /# card -->
                            </div>
                            <div class="col-lg-1">
                            </div>
  </section>


  <!-- Footer -->
  <footer class="footer text-center" style = "background: 	#2E8B57;">
    <div class="container">
      <div class="row">
        <!-- Footer Location -->
        <div class="col-lg-4 mb-5 mb-lg-0">
          <h4 class="text-uppercase mb-4">Location</h4>
          <p class="lead mb-0">NCKU ES
          <br>East District ,Tainan City ,Taiwan
            <br>No.1, University Road </p>
        </div>
        <!-- Footer Social Icons -->
        <div class="col-lg-4 mb-5 mb-lg-0">
          <h4 class="text-uppercase mb-4">Around the Web</h4>
          <br>
          <a class="btn btn-outline-light btn-social mx-1" href="#">
            <i class="fab fa-fw fa-facebook-f"></i>
          </a>
          <a class="btn btn-outline-light btn-social mx-1" href="#">
            <i class="fab fa-fw fa-twitter"></i>
          </a>
          <a class="btn btn-outline-light btn-social mx-1" href="#">
            <i class="fab fa-fw fa-linkedin-in"></i>
          </a>
          <a class="btn btn-outline-light btn-social mx-1" href="#">
            <i class="fab fa-fw fa-dribbble"></i>
          </a>
        </div>
        <!-- Footer About Text -->
        <div class="col-lg-4">
          <h4 class="text-uppercase mb-4">About us</h4>
          <p class="lead mb-0"> DADA智能理財致力於為投資人客製化投資組合，以達成投資人的理財目標。 </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- Copyright Section -->
  <section class="copyright py-4 text-center text-white" style = "background: 	#2F4F4F;">
    <div class="container">
      <small>Copyright &copy; Your Website 2019</small>
    </div>
  </section>

  <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
  <div class="scroll-to-top d-lg-none position-fixed ">
    <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top">
      <i class="fa fa-chevron-up"></i>
    </a>
  </div>

  <!-- Portfolio Modals -->

  <!-- Portfolio Modal 1 -->
  <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-labelledby="portfolioModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <i class="fas fa-times"></i>
          </span>
        </button>
        <div class="modal-body text-center">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <!-- Portfolio Modal - Title -->
                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Log Cabin</h2>
                <!-- Icon Divider -->
                <div class="divider-custom">
                  <div class="divider-custom-line"></div>
                  <div class="divider-custom-icon">
                    <i class="fas fa-star"></i>
                  </div>
                  <div class="divider-custom-line"></div>
                </div>
                <!-- Portfolio Modal - Image -->
                <img class="img-fluid rounded mb-5" src="img/portfolio/cabin.png" alt="">
                <!-- Portfolio Modal - Text -->
                <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia neque assumenda ipsam nihil, molestias magnam, recusandae quos quis inventore quisquam velit asperiores, vitae? Reprehenderit soluta, eos quod consequuntur itaque. Nam.</p>
                <button class="btn btn-primary" href="#" data-dismiss="modal">
                  <i class="fas fa-times fa-fw"></i>
                  Close Window
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Portfolio Modal 2 -->
  <div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" role="dialog" aria-labelledby="portfolioModal2Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <i class="fas fa-times"></i>
          </span>
        </button>
        <div class="modal-body text-center">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <!-- Portfolio Modal - Title -->
                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Tasty Cake</h2>
                <!-- Icon Divider -->
                <div class="divider-custom">
                  <div class="divider-custom-line"></div>
                  <div class="divider-custom-icon">
                    <i class="fas fa-star"></i>
                  </div>
                  <div class="divider-custom-line"></div>
                </div>
                <!-- Portfolio Modal - Image -->
                <img class="img-fluid rounded mb-5" src="img/portfolio/cake.png" alt="">
                <!-- Portfolio Modal - Text -->
                <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia neque assumenda ipsam nihil, molestias magnam, recusandae quos quis inventore quisquam velit asperiores, vitae? Reprehenderit soluta, eos quod consequuntur itaque. Nam.</p>
                <button class="btn btn-primary" href="#" data-dismiss="modal">
                  <i class="fas fa-times fa-fw"></i>
                  Close Window
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Portfolio Modal 3 -->
  <div class="portfolio-modal modal fade" id="portfolioModal3" tabindex="-1" role="dialog" aria-labelledby="portfolioModal3Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <i class="fas fa-times"></i>
          </span>
        </button>
        <div class="modal-body text-center">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <!-- Portfolio Modal - Title -->
                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Circus Tent</h2>
                <!-- Icon Divider -->
                <div class="divider-custom">
                  <div class="divider-custom-line"></div>
                  <div class="divider-custom-icon">
                    <i class="fas fa-star"></i>
                  </div>
                  <div class="divider-custom-line"></div>
                </div>
                <!-- Portfolio Modal - Image -->
                <img class="img-fluid rounded mb-5" src="img/portfolio/circus.png" alt="">
                <!-- Portfolio Modal - Text -->
                <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia neque assumenda ipsam nihil, molestias magnam, recusandae quos quis inventore quisquam velit asperiores, vitae? Reprehenderit soluta, eos quod consequuntur itaque. Nam.</p>
                <button class="btn btn-primary" href="#" data-dismiss="modal">
                  <i class="fas fa-times fa-fw"></i>
                  Close Window
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Portfolio Modal 4 -->
  <div class="portfolio-modal modal fade" id="portfolioModal4" tabindex="-1" role="dialog" aria-labelledby="portfolioModal4Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <i class="fas fa-times"></i>
          </span>
        </button>
        <div class="modal-body text-center">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <!-- Portfolio Modal - Title -->
                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Controller</h2>
                <!-- Icon Divider -->
                <div class="divider-custom">
                  <div class="divider-custom-line"></div>
                  <div class="divider-custom-icon">
                    <i class="fas fa-star"></i>
                  </div>
                  <div class="divider-custom-line"></div>
                </div>
                <!-- Portfolio Modal - Image -->
                <img class="img-fluid rounded mb-5" src="img/portfolio/game.png" alt="">
                <!-- Portfolio Modal - Text -->
                <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia neque assumenda ipsam nihil, molestias magnam, recusandae quos quis inventore quisquam velit asperiores, vitae? Reprehenderit soluta, eos quod consequuntur itaque. Nam.</p>
                <button class="btn btn-primary" href="#" data-dismiss="modal">
                  <i class="fas fa-times fa-fw"></i>
                  Close Window
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Portfolio Modal 5 -->
  <div class="portfolio-modal modal fade" id="portfolioModal5" tabindex="-1" role="dialog" aria-labelledby="portfolioModal5Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <i class="fas fa-times"></i>
          </span>
        </button>
        <div class="modal-body text-center">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <!-- Portfolio Modal - Title -->
                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Locked Safe</h2>
                <!-- Icon Divider -->
                <div class="divider-custom">
                  <div class="divider-custom-line"></div>
                  <div class="divider-custom-icon">
                    <i class="fas fa-star"></i>
                  </div>
                  <div class="divider-custom-line"></div>
                </div>
                <!-- Portfolio Modal - Image -->
                <img class="img-fluid rounded mb-5" src="img/portfolio/safe.png" alt="">
                <!-- Portfolio Modal - Text -->
                <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia neque assumenda ipsam nihil, molestias magnam, recusandae quos quis inventore quisquam velit asperiores, vitae? Reprehenderit soluta, eos quod consequuntur itaque. Nam.</p>
                <button class="btn btn-primary" href="#" data-dismiss="modal">
                  <i class="fas fa-times fa-fw"></i>
                  Close Window
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Portfolio Modal 6 -->
  <div class="portfolio-modal modal fade" id="portfolioModal6" tabindex="-1" role="dialog" aria-labelledby="portfolioModal6Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <i class="fas fa-times"></i>
          </span>
        </button>
        <div class="modal-body text-center">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <!-- Portfolio Modal - Title -->
                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Submarine</h2>
                <!-- Icon Divider -->
                <div class="divider-custom">
                  <div class="divider-custom-line"></div>
                  <div class="divider-custom-icon">
                    <i class="fas fa-star"></i>
                  </div>
                  <div class="divider-custom-line"></div>
                </div>
                <!-- Portfolio Modal - Image -->
                <img class="img-fluid rounded mb-5" src="img/portfolio/submarine.png" alt="">
                <!-- Portfolio Modal - Text -->
                <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia neque assumenda ipsam nihil, molestias magnam, recusandae quos quis inventore quisquam velit asperiores, vitae? Reprehenderit soluta, eos quod consequuntur itaque. Nam.</p>
                <button class="btn btn-primary" href="#" data-dismiss="modal">
                  <i class="fas fa-times fa-fw"></i>
                  Close Window
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Contact Form JavaScript -->
  <script src="js/jqBootstrapValidation.js"></script>
  <script src="js/contact_me.js"></script>

  <!-- Custom scripts for this template -->
  <script src="js/freelancer.min.js"></script>
          <!-- jquery vendor -->
          <script src="assets/js/lib/jquery.min.js"></script>
        <script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
        <!-- nano scroller -->
        <script src="assets/js/lib/menubar/sidebar.js"></script>
        <script src="assets/js/lib/preloader/pace.min.js"></script>
        <!-- sidebar -->
        <script src="assets/js/lib/bootstrap.min.js"></script>

        <!-- bootstrap -->

        <script src="assets/js/lib/circle-progress/circle-progress.min.js"></script>
        <script src="assets/js/lib/circle-progress/circle-progress-init.js"></script>

        <script src="assets/js/lib/morris-chart/raphael-min.js"></script>
        <script src="assets/js/lib/morris-chart/morris.js"></script>
        <script src="assets/js/lib/morris-chart/morris-init.js"></script>

        <!--  flot-chart js -->
        <script src="assets/js/lib/flot-chart/jquery.flot.js"></script>
        <script src="assets/js/lib/flot-chart/jquery.flot.resize.js"></script>
        <script src="assets/js/lib/flot-chart/flot-chart-init.js"></script>
        <!-- // flot-chart js -->


        <script src="assets/js/lib/vector-map/jquery.vmap.js"></script>
        <!-- scripit init-->
        <script src="assets/js/lib/vector-map/jquery.vmap.min.js"></script>
        <!-- scripit init-->
        <script src="assets/js/lib/vector-map/jquery.vmap.sampledata.js"></script>
        <!-- scripit init-->
        <script src="assets/js/lib/vector-map/country/jquery.vmap.world.js"></script>
        <!-- scripit init-->
        <script src="assets/js/lib/vector-map/country/jquery.vmap.algeria.js"></script>
        <!-- scripit init-->
        <script src="assets/js/lib/vector-map/country/jquery.vmap.argentina.js"></script>
        <!-- scripit init-->
        <script src="assets/js/lib/vector-map/country/jquery.vmap.brazil.js"></script>
        <!-- scripit init-->
        <script src="assets/js/lib/vector-map/country/jquery.vmap.france.js"></script>
        <!-- scripit init-->
        <script src="assets/js/lib/vector-map/country/jquery.vmap.germany.js"></script>
        <!-- scripit init-->
        <script src="assets/js/lib/vector-map/country/jquery.vmap.greece.js"></script>
        <!-- scripit init-->
        <script src="assets/js/lib/vector-map/country/jquery.vmap.iran.js"></script>
        <!-- scripit init-->
        <script src="assets/js/lib/vector-map/country/jquery.vmap.iraq.js"></script>
        <!-- scripit init-->
        <script src="assets/js/lib/vector-map/country/jquery.vmap.russia.js"></script>
        <!-- scripit init-->
        <script src="assets/js/lib/vector-map/country/jquery.vmap.tunisia.js"></script>
        <!-- scripit init-->
        <script src="assets/js/lib/vector-map/country/jquery.vmap.europe.js"></script>
        <!-- scripit init-->
        <script src="assets/js/lib/vector-map/country/jquery.vmap.usa.js"></script>
        <!-- scripit init-->
        <script src="assets/js/lib/vector-map/vector.init.js"></script>

        <script src="assets/js/lib/weather/jquery.simpleWeather.min.js"></script>
        <script src="assets/js/lib/weather/weather-init.js"></script>
        <script src="assets/js/lib/owl-carousel/owl.carousel.min.js"></script>
        <script src="assets/js/lib/owl-carousel/owl.carousel-init.js"></script>
        <script src="assets/js/scripts.js"></script>
        <!-- scripit init-->


</body>

</html>
