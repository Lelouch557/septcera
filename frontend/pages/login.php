<?php
session_start();
if(isset($_COOKIE['Language'])){
  REQUIRE_ONCE('../language/'.$_COOKIE['Language'].'/Global.php');
}else{
  REQUIRE_ONCE('../language/ENG/Global.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<title><?PHP echo 'IABAMUN'?></title>
	<link  rel="stylesheet" type="text/css" href="./css/index.css">
</head>
<body>
<?php

?>
	<div id="LoginDiv">
		<div id="LoginWrap">
 			<form id='FORM' autocomplete="off">
    		    <input name='name' onfocus='' required autocomplete='off' type="text" placeholder='<?PHP echo '***User_Name'  ?>' id="User_Name"/>
				<input name='pass' onfocus='' required autocomplete='off' type="password" placeholder='<?PHP echo '***Password'  ?>' id="Password"/>
				<input type="button" id='button'onclick='Inlog()' value="<?PHP echo 'Login' ?>"/>
				<a href="recover_ww.php">Recover password***</a>
  			</form>
		</div>
	</div>
</body>
<script>
		$SavedName = '';
		Messages = [];
		Messages[1] = 'VALI2';
		Messages[2] = '<?=  '***User_Name' ?>';
		Messages[3] = '<?=  '***Password' ?>';
		function Inlog(){
			$USR_N = $('#User_Name').val();
			$Pass = $('#Password').val();
			
			if($USR_N == '' || $Pass == ''){
				if(!$USR_N){
					$('#User_Name').attr('class','invalid');
					$('#User_Name').attr('placeholder',Messages[2]);
					$('#User_Name').attr('onfocus','Revert("User_Name")');
					
				}
				if(!$Pass){
					$('#Password').attr('class','invalid');
					$('#Password').attr('placeholder',Messages[3]);
					$('#Password').attr('onfocus','Revert("Password")');
				}
			}else{
				var formData = {name: $USR_N, password: $Pass};
				var jsonData = JSON.stringify(formData);

				$.ajax({
					url : "https://iabamun.nl/game/lab-andre/api/index.php/login", 
					type: "POST", 
					data : jsonData, 
					async : false, 

					success: function(data, textStatus, jqXHR) {
						if(data.response == 'Logged in'){
							window.location.href = 'home.php';
						}else{
							alert(Messages[1]);
						}
					},
				contentType:"application/json; charset=utf-8",
				dataType:"json"
				});
			}
		}
		$(document).keypress(function(e){
			if(e.which == 13){
				Inlog();
			}
		});
		function Revert(data){
			id = '#'+data;
			$(id).attr('onfocus','');
			$(id).attr('class','no');
			if(id=='#User_Name'){$(id).val($SavedName);}
			$(id).attr('placeholder',Messages[data]);
		}
  	</script>
</html>