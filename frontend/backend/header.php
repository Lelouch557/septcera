<?php
class Header{
    public $db;

    public static function getHeader($links){
        $file_location = "https://iabamun.nl/game/lab-andre/frontend";
        $header='
        <!DOCTYPE html>
        <html>
        <head>
            <link rel="stylesheet" type="text/css" href="./CSS/Chat.css">
            <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>';
            foreach($links as $link){
                $header.="<link  rel='stylesheet' type='text/css' href='$file_location/css/$link.css'>";
            }
            foreach($links as $link){
                $header.="<script src='$file_location/javascript/$link.js'></script>";
            }
            $header.="
            <script src='$file_location/javascript/chat.js'></script>
        </head>
        <body>
            <div id='Links'>
                <div class='LeftIcons'>
                    <a   class='iconsA' href='$file_location/pages/home.php'>
                        <img onhover='Hover()' src='$file_location/images/Village.png'>
                        </img>  
                    </a>
                </div>
                <div class='LeftIcons'>
                    <a   class='iconsA' href='$file_location/pages/Research.php'>
                        <img onhover='Hover()' src='$file_location/images/ResearchIcon.png'>
                        </img>  
                    </a>
                </div>
                <div class='LeftIcons'>
                    <a   class='iconsA' href='$file_location/pages/City_Hall.php'>
                        <img onhover='Hover()' src='$file_location/images/City_Hall_Icon.png'>
                        </img>  
                    </a>
                </div>
                <div class='LeftIcons'>
                    <a   class='iconsA' href='$file_location/pages/Rekruting.php'>
                        <img onhover='Hover()' src='$file_location/images/HammerAndAnvil.png'>
                        </img>
                    </a>
                </div>
                <div class='LeftIcons'>
                    <a href='#' class='iconsA' >
                        <img onhover='Hover()' src='$file_location/images/Points.png' style='height:200%'>
                        </img>
                    </a>
                </div>
                <div class='LeftIcons'>
                    <a href='$file_location/pages/map.php'  class='iconsA' >
                        <img onhover='Hover()' src='$file_location/images/nesw.png'>
                        </img>
                    </a>
                </div>
                <div class='LeftIcons'>
                    <a href='$file_location/pages/messages.php'  class='iconsA' >
                        <img onhover='Hover()' src='$file_location/images/Message.png'>
                        </img>
                    </a>
                </div>
                <div class='LeftIcons'>
                    <a href='$file_location/pages/settings/settings.php'  class='iconsA'>
                        <img onhover='Hover()' src='$file_location/images/Gear.png'></img>
                    </a>
                </div>
                <div class='LeftIcons'>
                    <a href='$file_location/pages/account/logout.php'  class='iconsA'>
                        <img onhover='Hover()' src='$file_location/images/logout.png'></img>
                    </a>
                </div>
            </div>
        ";
        return $header;
    }
}
?>