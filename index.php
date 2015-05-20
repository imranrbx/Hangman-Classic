<?php session_start(); error_reporting(E_ALL);?>
<!DOCTYPE html">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="jquery.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="jquery.mobile.css">
<script src="jquery.mobile.js" type="text/javascript"></script>
<title>Hangman</title>
<style>
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url(images/loader-64x/Preloader_3.gif) center no-repeat #fff;
}
img{
  max-width:100%;
}
p{
  text-align: center;
  font-size:22px;
  font-weight: bold;
}
    .ui-grid-a .ui-block-a, .ui-grid-a .ui-block-b {
      width: 5% !important;
      text-align: center;
  
    }
@media screen and (min-width:769px) and (max-width:1280px){
  .ui-grid-a .ui-block-a, .ui-grid-a .ui-block-b {
    width: 10% !important;
    text-align: center;
}
}
@media screen and (min-width:480px) and (max-width:768px){
  .ui-grid-a .ui-block-a, .ui-grid-a .ui-block-b {
    width: 15% !important;
    text-align: center;
  }
}
@media screen and (min-width: 320px) and (max-width:479px){
  .ui-grid-a .ui-block-a, .ui-grid-a .ui-block-b {
    width: 25% !important;
    text-align: center;
  }
};

</style>
 <script>
  //paste this code under head tag or in a seperate js file.
  // Wait for window load

    $(window).load(function() {
    // Animate loader off screen
    $(".se-pre-con").fadeOut("slow");;
  });
</script>
<script type="application/javascript">
function submit_form($val)
{
  console.log('Submit Form Called');
  document.getElementById('userInput').value = $val;
  document.forms["inputForm"].submit();
}
function refresh_form()
{
  console.log('Refresh Form Called');

  document.forms["frm_refresh"].submit();
}
</script>
</head>
<body>

  <div data-role="page" data-theme="a">
    <div data-role="header" data-position="fixed">
      <h1>Hangman Classic</h1>
    </div>
<div data-role="content">
<div class="se-pre-con"></div>

<?php
    include 'config.php';
    include 'main.php';
    if(!isset($_SESSION['letter'])){
         $_SESSION['letter']=array();        
    }
  if (isset($_POST['newWord'])) unset($_SESSION['answer']);
  
    if (!isset($_SESSION['answer'])){
        $_SESSION['attempts'] = 0;
        $answer = fetchWordArray($WORDLISTFILE);
        $_SESSION['answer'] = $answer;
        $_SESSION['hidden'] = hideCharacters($answer);
        echo '<p style="text-align:center;">Attempts remaining: '.($MAX_ATTEMPTS - $_SESSION['attempts']).'</p>';
    }else {
        if (isset ($_POST['userInput']) AND trim($_POST['userInput'])!=''){
            $userInput = $_POST['userInput'];
            array_push($_SESSION['letter'], $userInput);
            $_SESSION['hidden'] = checkAndReplace(strtolower($userInput), $_SESSION['hidden'], $_SESSION['answer']);
            $status = checkGameOver($MAX_ATTEMPTS,$_SESSION['attempts'], $_SESSION['answer'],$_SESSION['hidden']);
        }
        $_SESSION['attempts'] = $_SESSION['attempts']+1;
        echo '<p style="text-align:center">Attempts remaining: '.($MAX_ATTEMPTS - $_SESSION['attempts'])."</p>";
    }
  ?>

<?php  $hidden = $_SESSION['hidden'];?>
<p style="text-align:center;">
<?php
    foreach ($hidden as $char) {
        if(is_array($_SESSION['letter']))
            array_push($_SESSION['letter'],$char);
         echo $char."  ";
    }
    $letters = getLetters($_SESSION['letter']); 
?>
</p>

<?php if(!isset($status) OR trim($status) > 2): ?>
  <div class="ui-grid-a">
<?php 
    for($i=0; $i<count($letters); $i++){ ?>
    <div class="ui-block-<?php echo $i/2 == 0 ? 'a' : 'b'; ?>">
 <a data-role="button" id="<?php echo strtolower($letters[$i]); ?>" onclick='submit_form("<?php echo strtolower($letters[$i]); ?>")' style='margin-left:5px;' href='javascript:;' data-val="<?php echo strtolower($letters[$i]); ?>" ><?php echo strtolower($letters[$i]); ?></a>

</div>
<?php } ?>
</div>
<form name = "inputForm" action = "" method = "post">
  <input id="userInput" name = "userInput" type = "hidden"  />
</form>
<?php elseif(isset($status) AND trim($status)=='0'): 

 echo "<p style='text-align:center;'><span style='font-weight:bold;color:orange;'>Game Over!</span><br> The correct word was <b>";
                 $letter = implode("",$_SESSION['answer']);
                echo $letter;                
                echo '</b></p><br><form name="frm_refresh" action = "" method = "post"><img src="images/loose.jpg" /><input onclick="refresh_form();" data-role="button" type = "button" name = "newWord" value = "Try another Word"/></form><br>';
                
                      session_destroy();
 elseif(isset($status) AND trim($status)=='1'):
 echo "<p style='text-align:center;'><span style='font-weight:bold;color:orange;'>Game Over!</span><br> The correct word is indeed <b>";
                $letter = implode("",$_SESSION['answer']);
                echo $letter;              
                echo '</b></p><br><form name="frm_refresh" action = "" method = "post">  <img src="images/win.jpg" /><input onclick="refresh_form();" data-role="button" type = "button" name = "newWord" value = "Try another Word"/></form><br>';
           
                   session_destroy();

 endif; ?>
</div>
<div data-role="footer" data-position="fixed"><h3>Hangman Classic for (AREEBA IMRAN)</h3></div>
</div>
</body>
</html>
