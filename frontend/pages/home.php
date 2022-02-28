<?php
session_start();
$required = [
    '../backend/header',
    '../backend/general.config',
    '../backend/basic_functions'
];

foreach($required as $link){
    require_once($link.".php");
}
$header = Header::getHeader(['header', 'chat']);

//get header & footer
//get village Menu
//get valuta information
//get resources information
//get army information
//get village info
echo $header;
    ?>
    <div id="background">
    </div>
    
    <div id="chat">
            <div id="chat_wrapper">
                <div id="chat_title" onclick="toggle_chat_list()">
                    <label><?php echo'***Chat';?></label>
                </div>
                <div id="chats">
                    <?php
                    for($i=0;$i<count($Chat);$i++){
                        $query = $db->prepare('SELECT `User_Name`, `id` from `user` where id = ?');
                        if($_SESSION['User_ID']==$Chat[$i]['User1_ID']){
                            $query->bindPARAM(1,$Chat[$i]['User2_ID'],PDO::PARAM_INT);
                        }else{
                            $query->bindPARAM(1,$Chat[$i]['User1_ID'],PDO::PARAM_INT);
                        }
                        $query->execute();
                        $Name = $query->fetchall(PDO::FETCH_ASSOC);
                        echo'</pre><div class="chats" data-user="'.$Chat[$i]['Chat_ID'].'" onclick="ShowChatLog(this)"><label>'.$Name[0]['User_Name'].'<label></div>';
                    }?>
                </div>
                <div id="ChatCheck">
                </div>
                <div id="ChatLogCheck">
                </div>
                <div id="ChatLog">
                </div>
                <div id='TypBar'><input type='text' id='chatInput' /><div onclick='SendText()' id='Send'><?PHP echo '***Send';?></div></div>
            </div>
        </div>

    <div id="bottom">
    </div>
</body>
<script>
    ThisUser = <?= $_SESSION['user_id'];?>;
    function village($val){
        $.post(
            'different_village.php',
            {id: $val},
            function(){
                location.reload();
            }
        );
    }
</script>