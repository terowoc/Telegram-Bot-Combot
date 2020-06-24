<?php
/**
 * @uzbcombot codi library
 * @author Abdulloh Azimboev <terowoc@mail.ru>
 * @contact https://t.me/terowoc 
 * @contact Channel https://t.me/terowocuz
 * @rules codni sotish yoki muallif huquqini buzish, yaxshi oqibatga olib kelmaydi!
 * @date 08:14 23-iyun. 2020 yil.
 */

##########
require __DIR__."/TelegramBot.php";
$config = require __DIR__."/_config.php";
###########
$bot = new TelegramBot($config['bot_token']);
$update = $bot->getData();
###########
function get($name){
	$get = file_get_contents($name);
	return $get;
	}
	function put($name, $nima){
		file_put_contents($name, $nima);
	}
###########
$text = $update['message']['text'];
$mesid = $update['message']['message_id'];
$chat_id = $update['message']['chat']['id'];
$type = $update['message']['chat']['type'];
###########
$ruid = $update['message']['reply_to_message']['from']['id'];
$rname= $update['message']['reply_to_message']['from']['first_name'];
$rmid= $update['message']['reply_to_message']['from']['message_id'];
$rlogin = $update['message']['reply_to_message']['from']['username'];
###########
$ufname = str_replace(["[","]","(",")","*","_","`"],["","","","","","",""],$update['message']['from']['first_name']);
$uname = $update['message']['from']['last_name'];
$ulogin = $update['message']['from']['username'];
$uid = $update['message']['from']['id'];
###########
$cqid = $update['callback_query'];
$id = $update['callback_query']['id'];
$mid2 = $update['callback_query']['message']['message_id'];
$uid2 = $update['callback_query']['from']['id'];
$cid2 = $update['callback_query']['message']['chat']['id'];
$data = $update['callback_query']['data'];
###########
mkdir("stat");
mkdir("obro/$chat_id");
$guruhlar = get("stat/group.list");
$userlar = get("stat/user.list");
###########
if(get("obro/$chat_id/$uid.obro")){
}else{    
put("obro/$chat_id/$uid.obro","0");
}
###########ComBot###########
if($text=="/start"){
	if($type=="private"){
	$bot->sendMessage([
'chat_id' => $chat_id, 
'text' => "Salom *$ufname*!", 
'parse_mode' => "markdown"
]);
$bot->sendMessage([
'chat_id' => $chat_id, 
'text' => "👾 *Combot* — bu telegramda sizning guruhingizdagi foydalanuvchilarning obrolarini hisoblovchi bot hisoblanadi!

💠 1. Botni guruhingizga qoshing!

💠 2. Botni guruhingizga to'liq *Adminstrator* etib tayinlang!

💠 3. Bot guruhingizda ishlashga tayyor!", 
'parse_mode' => "markdown",
'reply_markup' => json_encode([   
'inline_keyboard'=>[   
[['callback_data' => "hisobot", 'text' => "📊 Hisobot"],['callback_data' => "about", 'text' => "📃 Ma'lumot"]],
[['url' => "https://telegram.me/".$config['bot_user']."?startgroup=new", 'text' => "Guruhga qo'shish"]]
]
]),
]);
}else{
	$bot->sendMessage([
'chat_id' => $chat_id, 
'text' => "Salom *$ufname*!", 
'parse_mode' => "markdown"
]);
}
}

if(isset($text)){
  if($type == "group" or $type == "supergroup"){
    if(stripos($guruhlar,"$chat_id")!==false){
    }else{
    put("stat/group.list","$guruhlar\n$chat_id");
    }
  }else{
   if(stripos($userlar,"$chat_id")!==false){
    }else{
    put("stat/user.list","$userlar\n$chat_id");
   }
  }
}
if($data == "hisobot"){
$gr = substr_count($guruhlar,"\n"); 
$us = substr_count($userlar,"\n"); 
$obsh = $gr + $us;
$bot->editMessageText([
'chat_id'=>$cid2,
'message_id'=>$mid2,
'text'=> "👾*Combot* foydalanuvchilari:
├*👤A'zolar* -> $us ta
├*👥Guruhlar* -> $gr ta
└*🌎Umumiy* -> $obsh ta",
'parse_mode' => "markdown",
'reply_markup' => json_encode([   
'inline_keyboard'=>[   
[['callback_data' => "hisobot", 'text' => "♻️ Yangilash"]],
[['callback_data' => "exit", 'text' => "🚫 Bekor qilish"]],
]
]),
]);
}
if($data == "exit"){
$gr = substr_count($guruhlar,"\n"); 
$us = substr_count($userlar,"\n"); 
$obsh = $gr + $us;
$bot->editMessageText([
'chat_id'=>$cid2,
'message_id'=>$mid2,
'text'=> "👾 *Combot* — bu telegramda sizning guruhingizdagi foydalanuvchilarning obrolarini hisoblovchi bot hisoblanadi!

💠 1. Botni guruhingizga qoshing!

💠 2. Botni guruhingizga to'liq *Adminstrator* etib tayinlang!

💠 3. Bot guruhingizda ishlashga tayyor!",
'parse_mode' => "markdown",
'reply_markup' => json_encode([   
'inline_keyboard'=>[   
[['callback_data' => "hisobot", 'text' => "📊 Hisobot"],['callback_data' => "about", 'text' => "📃 Ma'lumot"]],
[['url' => "https://telegram.me/".$config['bot_user']."?startgroup=new", 'text' => "Guruhga qo'shish"]]
]
]),
]);
}
if($data == "about"){
$bot->editMessageText([
'chat_id'=>$cid2,
'message_id'=>$mid2,
'text'=> "👾 *Combot* — bu telegramda sizning guruhingizdagi foydalanuvchilarning obrolarini hisoblovchi bot hisoblanadi!
————————————
📃 Yo'riqnoma:
💠 1. Botni guruhingizga qoshing!

💠 2. Botni guruhingizga to'liq *Adminstrator* etib tayinlang!

💠 3. Bot guruhingizda ishlashga tayyor!
————————————
👨‍💻 Dasturchi: [".$config['admin_name']."](tg://user?id=".$config['admin_id'].")",
'parse_mode' => "markdown",
'disable_web_page_preview' => true,
'reply_markup' => json_encode([   
'inline_keyboard'=>[   
[['callback_data' => "buyruq", 'text' => "🔰 Buyruqlar"]],
[['callback_data' => "exit", 'text' => "🚫 Bekor qilish"]],
]
]),
]);
}
if($data == "buyruq"){
$bot->editMessageText([
'chat_id'=>$cid2,
'message_id'=>$mid2,
'text'=> "📃 *Buyruqlar:*
————————————————
!my - Sizning obrolaringiz.
!msg - Guruhda nechta habar yozilganini aytadi.
————————————————

👾 Botimizda tez orada yangilanishlar bo'ladi!",
'parse_mode' => "markdown",
'disable_web_page_preview' => true,
'reply_markup' => json_encode([   
'inline_keyboard'=>[
[['callback_data' => "exit", 'text' => "🚫 Bekor qilish"]],
]
]),
]);
}


if($type=="group" or $type=="supergroup"){
if($text=="+"){
if(!$ruid==null and $uid!=$ruid){
if($rlogin!=$config['bot_user']){
	$obro = get("obro/$chat_id/$ruid.obro");
	$get = $obro+1;
	put("obro/$chat_id/$ruid.obro","$get");
	$obro = get("obro/$chat_id/$ruid.obro");
if($obro<0){
put("obro/$chat_id/$ruid.obro","0");
}
$bot->sendMessage([
'chat_id' => $chat_id, 
'text' => "<a href = 'tg://user?id=$ruid'>$rname</a> sizning obroingiz <a href = 'tg://user?id=$uid'>$ufname</a> tomonidan oshirildi!
Sizning obroingiz soni: <b>$obro</b> ta", 
'parse_mode' => "html"
]);
}
}
}
if($text=="-"){
if($ruid!=null and $uid!=$ruid){
if($rlogin!=$config['bot_user']){
	$obro = get("obro/$chat_id/$ruid.obro");
	$get = $obro-1;
	put("obro/$chat_id/$ruid.obro","$get");
	$obro = get("obro/$chat_id/$ruid.obro");
if($obro<0){
put("obro/$chat_id/$ruid.obro","0");
}
$bot->sendMessage([
'chat_id' => $chat_id, 
'text' => "<a href = 'tg://user?id=$ruid'>$rname</a> sizning obroingiz <a href = 'tg://user?id=$uid'>$ufname</a> tomonidan tushurildi!
Sizning obroingiz soni: <b>$obro</b> ta", 
'parse_mode' => "html"
]);
}
}
}
if($text=="!my"){ 
$obro = get("obro/$chat_id/$uid.obro");
if($obro<0){
put("obro/$chat_id/$ruid.obro","0");
	}
	$bot->sendMessage([
'chat_id' => $chat_id, 
'text' => "<a href = 'tg://user?id=$uid'>$ufname</a> sizning obroingiz soni: <b>$obro</b> ta", 
'parse_mode' => "html",
]);
}
if ($text == "!msg"){
$bot->sendMessage([
'chat_id'=> $chat_id,
'text'=>"Guruhda jami *$mesid* ta xabar yozilgan!",
'parse_mode'=>"markdown",
'reply_to_message_id'=> $mesid,
]);
}
}
?>
