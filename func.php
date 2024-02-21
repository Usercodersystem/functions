<?php
function ismember($from_id,$channel)
{
    global $token;
    $decode = json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=$channel&user_id=$from_id"));
    $tch = $decode->result->status;
    if ($tch != 'member' && $tch != "administrator" && $tch != "creator")
    {
        return false;
    }
    else
    {
        return true;
    }

}

function isadmin($from_id,$group)
{
    global $token;
    $decode = json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=$group&user_id=$from_id"));
    $tch = $decode->result->status;
    if ($tch != "administrator" && $tch != "creator")
    {
        return false;
    }
    else
    {
        return true;
    }

}

function isowner($from_id,$group)
{
    global $token;
    $decode = json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=$group&user_id=$from_id"));
    $tch = $decode->result->status;
    if ($tch != "creator")
    {
        return false;
    }
    else
    {
        return true;
    }

}

function send_inlinekeyboard($chat_id,$text,$keyboard)
{
    global $message_id;
    bot ('sendMessage',[ 
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => "markDown",
        'reply_to_message_id' => $message_id,
        'reply_markup'=>json_encode(['inline_keyboard'=>$keyboard])
    
    ]);
}

function edit_inlinekeyboard($chat_id,$text,$keyboard)
{
    global $messageid;
    bot ('editMessageText',[ 
        'chat_id' => $chat_id,
        'text' => "$text",
        'message_id'=>$messageid,
        'reply_markup'=>json_encode(['inline_keyboard'=>$keyboard]),
        'parse_mode'=>'markdown'
        
    ]);
}

function edit_inline($chat_id,$text)
{
    global $messageid;
    bot ('editMessageText',[ 
        'chat_id' => $chat_id,
        'text' => "$text",
        'message_id'=>$messageid,
        'parse_mode'=>'markdown'
        
    ]);
}

class group
{
    function add_fulladmin($userid,$chat_id)
    {
        bot ('promoteChatMember',[ 
            'chat_id' => $chat_id,
            'user_id' => $userid,
            'can_manage_chat' => true,
            'can_delete_messages'=>true,
            'can_manage_video_chats'=>true,
            'can_restrict_members'=>true,
            'can_promote_members'=>true,
            'can_change_info'=>true,
            'can_invite_users'=>true,
            'can_post_stories'=>true,
            'can_edit_stories'=>true,
            'can_delete_stories'=>true,
            'can_pin_messages'=>true,
            'can_manage_topics'=>true,
            'is_anonymous' => false,
        ]);
    }
    function add_fulladmin_anonymous($userid,$chat_id)
    {
        bot ('promoteChatMember',[ 
            'chat_id' => $chat_id,
            'user_id' => $userid,
            'can_manage_chat' => true,
            'can_delete_messages'=>true,
            'can_manage_video_chats'=>true,
            'can_restrict_members'=>true,
            'can_promote_members'=>true,
            'can_change_info'=>true,
            'can_invite_users'=>true,
            'can_post_stories'=>true,
            'can_edit_stories'=>true,
            'can_delete_stories'=>true,
            'can_pin_messages'=>true,
            'can_manage_topics'=>true,
            'is_anonymous' => true,
        ]);
    }
    function add_demoadmin($userid,$chat_id)
    {
        bot ('promoteChatMember',[ 
            'chat_id' => $chat_id,
            'user_id' => $userid,
            'can_manage_chat' => true,
            'can_delete_messages'=>false,
            'can_manage_video_chats'=>false,
            'can_restrict_members'=>false,
            'can_promote_members'=>false,
            'can_change_info'=>false,
            'can_invite_users'=>false,
            'can_post_stories'=>false,
            'can_edit_stories'=>false,
            'can_delete_stories'=>false,
            'can_pin_messages'=>false,
            'can_manage_topics'=>false,
            'is_anonymous' => false,
        ]);
    }
    function add_demoadmin_anonymous($userid,$chat_id)
    {
        bot ('promoteChatMember',[ 
            'chat_id' => $chat_id,
            'user_id' => $userid,
            'can_manage_chat' => true,
            'can_delete_messages'=>false,
            'can_manage_video_chats'=>false,
            'can_restrict_members'=>false,
            'can_promote_members'=>false,
            'can_change_info'=>false,
            'can_invite_users'=>false,
            'can_post_stories'=>false,
            'can_edit_stories'=>false,
            'can_delete_stories'=>false,
            'can_pin_messages'=>false,
            'can_manage_topics'=>false,
            'is_anonymous' => true,
        ]);
    }
    function set_admin_title($userid,$chat_id,$title)
    {
        bot ('setChatAdministratorCustomTitle',[ 
            'chat_id' => $chat_id,
            'user_id' => $userid,
            'custom_title'=>$title
        ]);
    }
    function ban_channel($channel,$chat_id)
    {
        bot ('banChatSenderChat',[ 
            'chat_id' => $chat_id,
            'sender_chat_id' => $channel,
        ]);
    }
    function unban_channel($channel,$chat_id)
    {
        bot ('unbanChatSenderChat',[ 
            'chat_id' => $chat_id,
            'sender_chat_id' => $channel,
        ]);
    }
    function ban_member($user,$chat_id)
    {
        bot("kickchatmember",[
            'chat_id'=>$chat_id,
            'user_id'=>$user,
        
        ]);
    }
    function unban_member($user,$chat_id)
    {
        bot("unbanchatmember",[
            'chat_id'=>$chat_id,
            'user_id'=>$user,
        
        ]);
    }
    function get_invite_link($chat_id)
    {
        return tel ('exportChatInviteLink',[ 
            'chat_id' => $chat_id,
        ]);
    }
    function make_invite_link($chat_id)
    {
        return tel ('createChatInviteLink',[ 
            'chat_id' => $chat_id,
        ]);
    }
    function expire_invite_link($chat_id,$link)
    {
        return tel ('revokeChatInviteLink',[ 
            'chat_id' => $chat_id,
            'invite_link'=>$link
        ]);
    }
    function allow_user($user,$chat_id)
    {
        bot ('approveChatJoinRequest',[ 
            'chat_id' => $chat_id,
            'user_id'=>$user
        ]);
    }
    function deny_user($user,$chat_id)
    {
        bot ('declineChatJoinRequest',[ 
            'chat_id' => $chat_id,
            'user_id'=>$user
        ]);
    }
    function pin_message($chat_id,$mid)
    {
        bot ('pinChatMessage',[ 
            'chat_id' => $chat_id,
            'message_id'=>$mid
        ]);
    }
    function unpin_message($chat_id,$mid)
    {
        bot ('unpinChatMessage',[ 
            'chat_id' => $chat_id,
            'message_id'=>$mid
        ]);
    }
    function get_group_info($chat_id)
    {
        return tel ('getChat',[ 
            'chat_id' => $chat_id,
        ]);
    }
    function get_user_boosts($user,$chat_id)
    {
        return tel ('getUserChatBoosts',[ 
            'chat_id' => $chat_id,
            'user_id'=>$user
        ]);
    }
    function delete_message($chat_id,$mid)
    {
        bot ('deleteMessage',[ 
            'chat_id' => $chat_id,
            'message_id'=>$mid
        ]);
    }
    function make_payment($chat_id,$title,$description,$payload,$payment_token,$currency,$prices)
    {
        bot ('sendInvoice',[ 
            'chat_id' => $chat_id,
            'title'=>$title,
            'description'=>$description,
            'payload'=>$payload,
            'provider_token'=>$payment_token,
            'currency'=>$currency,
            'prices'=>json_encode($prices)
        ]);
    }
    function make_invoice_link($chat_id,$title,$description,$payload,$payment_token,$currency,$prices)
    {
        bot ('createInvoiceLink',[ 
            'title'=>$title,
            'description'=>$description,
            'payload'=>$payload,
            'provider_token'=>$payment_token,
            'currency'=>$currency,
            'prices'=>json_encode($prices)
        ]);
    }
    
}

function startsWith ($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

function alert($text)
{
    global $update;
    $callid = $update->callback_query->id;
    //callback_query_id	
    bot("answerCallbackQuery",['callback_query_id'=>$callid,'show_alert'=>true,'text'=>$text]);
}

function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }
    else{
        return json_decode($res);
    }
}

function tel($method,$data=[])
{
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    return curl_post($url,$data);
}

function rand_emoji()
{
    $rarr = array("👍", "❤", "🔥", "🥰", "👏", "😁", "🤔", "🤯", "😱", "😢", "🎉", "🤩", "🙏", "👌", "🕊", "🤡", "🥱", "🥴", "😍", "🐳", "❤‍🔥", "🌚", "💯", "🤣", "⚡", "🏆", "🤨", "😐", "🍓", "🍾", "💋", "😈", "😴", "😭", "🤓", "👻", "👨‍💻", "👀", "🎃", "🙈", "😇", "😨", "🤝", "✍", "🤗", "🫡", "🎅", "🎄", "☃", "💅", "🤪", "🗿", "🆒", "💘", "🙉", "🦄", "😘",
"💊", "🙊", "😎", "👾", "🤷‍♂", "🤷", "🤷‍♀", "😡");
    $bos = $rarr[rand(0,sizeof($rarr))];
    return $bos;
}
function reaction($emoji)
{
    global $chat_id;
    global $message_id;
    global $from_id;
    bot('setMessageReaction',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'reaction'=>json_encode([
            ['type'=>'emoji','emoji'=>$emoji]
        ]),
        'is_big'=>'false',
            
    ]);
    
}
function rand_array($ar)
{
    return $ar[rand(0,sizeof($ar))];
}

function nobitex($coin)
{
    $api=json_decode(file_get_contents("https://api.nobitex.ir/v2/orderbook/{$coin}IRT"));
    if(isset($api->lastTradePrice))
    {
        return $api->lastTradePrice;
    }
    else
    {
        return false;
    }
    
}

function tel_react()
{
    $rarr = array("👍", "❤", "🔥", "🥰", "👏", "😁", "🤔", "🤯", "😱", "😢","🎉","🤩", "🙏", "👌", "🕊", "🤡", "🥱", "🥴", "😍", "🐳", "❤‍🔥", "🌚", "💯", "🤣", "⚡", "🏆", "🤨", "😐", "🍓", "🍾", "💋", "😈", "😴", "😭", "🤓", "👻", "👨‍💻", "👀", "🎃", "🙈", "😇", "😨", "🤝", "✍", "🤗", "🫡", "🎅", "🎄", "☃", "💅", "🤪", "🗿", "🆒", "💘", "🙉", "🦄", "😘","💊","🙊", "😎", "👾", "🤷‍♂", "🤷", "🤷‍♀", "😡");
    return $rarr;
}

function create_dir($dir)
{
    if(!file_exists($dir))
    {
        mkdir($dir);
    }
}

function curl_post($url,$datas)
{
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        return curl_error($ch);
    }
    else{
        return $res;
    }
}

function curl_get($url)
{
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        return curl_error($ch);
    }
    else{
        return $res;
    }
}

function edit($text)
{
    global $chat_id;
    global $message_id;
    bot ('editMessageText',[ 
        'chat_id' => $chat_id,
        'text' => "$text",
        'message_id'=>$message_id+1,
        'parse_mode'=>'markdown'
    ]);
}

function edit_markup($text,$keyboard)
{
    global $chat_id;
    global $message_id;
    bot ('editMessageText',[ 
        'chat_id' => $chat_id,
        'text' => "$text",
        'message_id'=>$message_id+1,
        'reply_markup'=>$keyboard,
        'parse_mode'=>'markdown'
    ]);
}

function wikipedia($text)
{
    $api=curl_get("https://mrapiweb.ir/wikipedia/?find=$text&lang=fa");
    return $api;
}

class hashckech{
    function tron($hash)
    {
        return curl_get("https://mrapiweb.ir/api/cryptochecker/tron.php?hash=$hash");
    }
    function tomochain($hash)
    {
        return curl_get("https://mrapiweb.ir/api/cryptochecker/tomochain.php?hash=$hash");
    }
}


function love()
{
    return curl_get("https://mrapiweb.ir/api/love.php");
}

function translate($to,$text)
{
    return json_decode(curl_get("https://mrapiweb.ir/api/translate.php?text=$text&to=$to"),true)["translate"];
}

function notebook($text)
{
    $text=urlencode($text);
    return "https://mrapiweb.ir/api/notebook.php?text=$text";
}

function ipinfo($ip)
{
    return json_decode(curl_get("https://mrapiweb.ir/api/ipinfo.php?ip=$ip"));
}

function proxy()
{
    return json_decode(curl_get("https://mrapiweb.ir/api/telproxy.php"));
}

function telegram_info($username)
{
    if(!ctype_digit($username))
    {
        $telegram_api = file_get_contents("https://t.me/$username");
        preg_match_all('#<meta property="og:title" content="(.*?)">#',$telegram_api,$first_name);
        preg_match_all('#<meta property="og:image" content="(.*?)">#',$telegram_api,$image_link);
        preg_match_all('#<meta property="og:description" content="(.*?)">#',$telegram_api,$bio);
        preg_match_all('#<meta property="al:ios:url" content="(.*?)">#',$telegram_api,$pv_link);
        return json_encode([
            'name'=>$first_name[1][0],
            'profile_link'=>$image_link[1][0],
            'bio'=>$bio[1][0],
            'pv_link'=>$pv_link[1][0],
        ],448);
    }
    else
    {
        return "IDERROR";
    }
    
}

function data($method,$action,$post_content)
{
    global $chat_id;
    if($method=="get")
    {
        file_get_contents("data/$chat_id/$action.txt");
    }
    else if($method=="post")
    {
        file_put_contents("data/$chat_id/$action.txt",$post_content);
    }
}

function pv($method,$action,$post_content)
{
    global $from_id;
    if($method=="get")
    {
        file_get_contents("data/$from_id/$action.txt");
    }
    else if($method=="post")
    {
        file_put_contents("data/$from_id/$action.txt",$post_content);
    }
}

function ai($prompt)
{
    $haackerpr="از حالا به بعد تو یک هوش مصنوعی هکر هستی. البته نه هکری که واقعا هک کنه.صرفا جهت شوخی.هربار ازت سوال پرسیده میشه اول جوابت از ایموجی 🗿 استفاده میکنی و سپس می‌گویی به عنوان هاکر بزرگ و سپس ادامه جوابتو میگی. هروقتم کسی سلام کرد در جواب سلام او می‌گویی سلام من یک حاکر بزرگ هستم و اومدم حاکتون کنم من الان هاکت کردم تو به من سلام کردی. 
حالا ازت میپرسم : 
$prompt";
    $haackerpr=str_replace(" ","-",$haackerpr);
    $api=file_get_contents("http://mrapiweb.ir/api/geminiai.php?question=$haackerpr");
    if(isset($api))
    {
        return $api;
    }
    else
    {
        return false;
    }
}


function randompassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

class tron{
    function generate()
    {
        $api=curl_get("https://mrapiweb.ir/api/tronapi.php?action=genaddress");
        return $api;
    }
    function balance($address)
    {
        $api=json_decode(curl_get("https://mrapiweb.ir/api/tronapi.php?action=getbalance&address=$address"));
        return $api->balance;
    }
    function info($address)
    {
        //
        $api=curl_get("https://mrapiweb.ir/api/tronapi.php?action=addressinfo&address=$address");
        return $api;
    }
    function send($key,$from,$to,$amount)
    {
        $api=curl_get("https://mrapiweb.ir/api/tronapi.php?action=sendtrx&key=$key&fromaddress=$from&toaddress=$to&amount=$amount");
        return $api;
    }
}
function weather($city)
{
    $city=urlencode($city);
    return file_get_contents("https://mrapiweb.ir/api/weather.php?city=$city");
}

function search($txt)
{
    $txt=urlencode($txt);
    return file_get_contents("https://mrapiweb.ir/api/aiblack.php?text=$txt");
}

class coin
{
    function get_user_coins($user)
    {
        if(file_exists("coins/$user"))
        {
            return file_get_contents("coins/$user");
        }
        else
        {
            return "0";
        }
        
    }
    function add_user_coins($user,$amount)
    {
        $coin = file_get_contents("coins/$user");
        $coin += $amount;
        file_put_contents("coins/$user",$coin);
    }
    function low_user_coins($user,$amount)
    {
        $coin = file_get_contents("coins/$user");
        $coin -= $amount;
        file_put_contents("coins/$user",$coin);
    }
    function coin_price()
    {
        return file_get_contents("coinprice.txt");
    }
    function expire_hash($hash)
    {
        file_put_contents("hash/$hash","expired");
    }
    function tronaddress()
    {
        return file_get_contents("tronwallet.txt");
    }
    function is_hash_expired($hash)
    {
        if(file_get_contents("hash/$hash") == "expired")
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
}

function sendmsg($text)
{
    global $chat_id;
    bot ('sendMessage',[ 
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => "markDown",
    
    ]);
}

function reply($text)
{
    global $chat_id;
    global $message_id;
    bot ('sendMessage',[ 
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => "markDown",
        'reply_to_message_id' => $message_id,
    
    ]);
}

function setstep($step)
{
    global $from_id;
    file_put_contents("step/$from_id",$step);
}

function getstep()
{
    global $from_id;
    return file_get_contents("step/$from_id");
}

function keyboard($text,$kname)
{
    global $chat_id;
    global $message_id;
    bot ('sendMessage',[ 
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => "markDown",
        'reply_to_message_id' => $message_id,
        'reply_markup'=>json_encode([
	        'resize_keyboard'=>true,
	        'keyboard'=>[
	            [['text'=>$kname]],
	    ]])
    
    ]);
}


function rextester($lang, $code) {
    $URL = "https://rextester.com/rundotnet/Run";
    $languages = array(
        "c#" => 1,
        "csharp" => "c#",
        "vb.net" => 2,
        "vb" => 2,
        "visual_basic_dotnet" => 2,
        "f#" => 3,
        "fsharp" => 3,
        "java" => 4,
        "python2" => 5,
        "py2" => 5,
        "c_gcc" => 6,
        "gcc" => 6,
        "c" => array("gcc", "clang", "visual_c"),
        "cplusplus_gcc" => 7,
        "cplusplus" => "c++",
        "g++" => 7,
        "c++" => array("cplusplus_gcc", "cplusplus_clang", "visual_cplusplus"),
        "cpp_gcc" => 7,
        "cpp" => "c++",
        "php" => 8,
        "pascal" => 9,
        "pas" => 9,
        "fpc" => 9,
        "objective_c" => 10,
        "objc" => 10,
        "haskell" => 11,
        "ruby" => 12,
        "perl" => 13,
        "lua" => 14,
        "nasm" => 15,
        "asm" => 15,
        "sql_server" => 16,
        "v8" => 17,
        "common_lisp" => 18,
        "clisp" => 18,
        "lisp" => array("common_lisp", "scheme"),
        "prolog" => 19,
        "golang" => 20,
        "go" => 20,
        "scala" => 21,
        "scheme" => 22,
        "node" => 23,
        "javascript" => 23,
        "js" => "javascript",
        "python3" => 24,
        "py3" => 24,
        "python" => array("python3", "python2"),
        "c_clang" => 26,
        "clang" => 26,
        "cplusplus_clang" => 27,
        "cpp_clang" => 27,
        "clangplusplus" => 27,
        "clang++" => 27,
        "visual_cplusplus" => 28,
        "visual_cpp" => 28,
        "vc++" => 28,
        "msvc" => 28,
        "visual_c" => 29,
        "d" => 30,
        "r" => 31,
        "tcl" => 32,
        "mysql" => 33,
        "postgresql" => 34,
        "oracle" => 35,
        "swift" => 37,
        "bash" => 38,
        "ada" => 39,
        "erlang" => 40,
        "elixir" => 41,
        "ocaml" => 42,
        "kotlin" => 43,
        "brainfuck" => 44,
        "fortran" => 45
    );
    if (!array_key_exists($lang, $languages)) {
        return ("The entered language is incorrect!");
    }

    $data = array(
        "LanguageChoiceWrapper" => $languages[$lang],
        "Program" => $code
    );

    $options = array(
            "http" => array(
            "header" => "Content-type: application/x-www-form-urlencoded\r\n",
            "method" => "POST",
            "content" => http_build_query($data)
        )
    );

    $context = stream_context_create($options);
    $response = file_get_contents($URL, false, $context);

    if ($response === false) {
        return ("Failed to connect to Rextester API!");
    }

    $response = json_decode($response, true);
    $result = $response["Result"];
    $warnings = $response["Warnings"];
    $errors = $response["Errors"];
    $stats = $response["Stats"];
    $files = $response["Files"];

    if (empty($code)) {
        return ("Your input will be incorrect!");
    } elseif (empty($result) && empty($warnings) && empty($errors)) {
        return ("Your request is incomplete!");
    }
    else if(isset($result))
    {
        //return json_encode($response);
        return $result;
    }
}


?>
