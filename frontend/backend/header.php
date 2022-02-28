<?php
class Header{
    public $db;

    public static function getHeader($links){

        $header='
        <!DOCTYPE html>
        <html>
        <head>
            <link rel="stylesheet" type="text/css" href="./CSS/Chat.css">
            <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>';
            foreach($links as $link){
                $header.="<link  rel='stylesheet' type='text/css' href='../css/$link.css'>";
            }
            foreach($links as $link){
                $header.="<script src='../javascript/$link.js'></script>";
            }
            $header.='
            <script src="../javascript/chat.js"></script>
        </head>
        <body>
            <div id="Links">
                <div class="LeftIcons">
                    <a   class="iconsA" href="home.php">
                        <img onhover="Hover()" src="../images/Village.png">
                        </img>  
                    </a>
                </div>
                <div class="LeftIcons">
                    <a   class="iconsA" href="Research.php">
                        <img onhover="Hover()" src="../images/ResearchIcon.png">
                        </img>  
                    </a>
                </div>
                <div class="LeftIcons">
                    <a   class="iconsA" href="City_Hall.php">
                        <img onhover="Hover()" src="../images/City_Hall_Icon.png">
                        </img>  
                    </a>
                </div>
                <div class="LeftIcons">
                    <a   class="iconsA" href="Rekruting.php">
                        <img onhover="Hover()" src="../images/HammerAndAnvil.png">
                        </img>
                    </a>
                </div>
                <div class="LeftIcons">
                    <a   class="iconsA" href="#">
                        <img onhover="Hover()" src="../images/Points.png" style="height:200%">
                        </img>
                    </a>
                </div>
                <div class="LeftIcons">
                    <a href="map.php"  class="iconsA" >
                        <img onhover="Hover()" src="../images/nesw.png">
                        </img>
                    </a>
                </div>
                <div class="LeftIcons">
                    <a href="messages.php"  class="iconsA" >
                        <img onhover="Hover()" src="../images/Message.png">
                        </img>
                    </a>
                </div>
                <div class="LeftIcons">
                    <a href="reports.php"  class="iconsA">
                        <img onhover="Hover()" src="../images/Report.png">
                        </img>
                    </a>
                </div> 
                <div class="LeftIcons">
                    <a href="Settings.php"  class="iconsA">
                        <img onhover="Hover()" src="../images/Gear.png">
                        </img>
                    </a>
                </div>
            </div>
        ';
        return $header;
    }
}
?>