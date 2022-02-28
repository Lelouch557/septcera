active = false; 
old = '';

$(document).ready(function(){
    var url = "https://iabamun.nl/game/lab-andre/api/index.php/chat";
    $.get(url, {},
    function(data){
        var HTML = "";
        
        for(i in data["response"]){
            
            HTML = HTML + "<div class=\"chats\" data-chat=\"" +  data["response"][i]["Chat_ID"] + "\" data-user=\"" +  data["response"][i]["User_ID"] + "\" onclick=\"ShowChatLog(this)\"><label>" + data["response"][i]["name"] + "<label></div>";
        }

        $('#chats').html(HTML);
    });
});

function GetMessages(TID){

    var HTML = "";

    var url = "https://iabamun.nl/game/lab-andre/api/index.php/chat/" + $(TID).attr("data-chat");
    $.get(url, {},
    function(data){
        var HTML = "";
        
        for(i in data["response"]){
            HTML += "<div class='";
            
            if(data["response"][i]["User_ID"] == $(TID).attr("data-user")){
                HTML += "other_person";
            }else{
                HTML += "this_person";
            }

            if(i==0){
                HTML += "' id='first";
            }

            HTML += "'>" + data["response"][i]["message"] + "</div>";
        }

        $('#ChatLog').html(HTML);
        $("#ChatLog").scrollTop(99999999999);
    });
}

function ShowChatLog(TID){
    if($(TID).hasClass("selected")){

        $('#chats').animate({right:"0px"});
        $(old).removeClass('selected');
        $(TID).removeClass('selected');
    }else{
        $('#chats').animate({right:"450px"});
        $('#TypBar').css({display:"block"});    
        $(old).removeClass('selected');
        $(TID).addClass('selected');
        GetMessages(TID);
    }

    if(active){
        clearInterval(blapi);
    }


    blapi = setInterval(function(){
        GetMessages(TID);
    },1500);

    setTimeout( function(){$("#ChatLog").scrollTop(99999999999);},100);

    active = true;
    old = TID;
}

function SendText(){
    chatInput = $('#chatInput').val();

    if(chatInput != ''){
        console.log(UserID);
        console.log(chatInput);
        console.log(ThisUser);

        $.post("./Chat/SendText.php",
            {c1:UserID,
            c2:chatInput,
            c3:ThisUser},
            function(data){
            }
        );

        $('#chatInput').val('');
    }
}
$('#chatInput').keypress(function(e) {
    if(e.which == 13) {
        SendText();
    }
});

function toggle_chat_list(){
    if($('#ChatCheck').css('display')!='block'){
        $('#chat').animate({bottom:"0px"},400);
        $('#ChatCheck').css("display","block");
    }else{
        $('#chat').animate({bottom:"-369px"},400);
        $('#ChatCheck').css("display","none");
    }
}