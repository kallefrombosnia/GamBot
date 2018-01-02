<?php 
require("../config.php");

if($lang == "EN")
{
	$start['ok'] = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=green][b]You have been sucessfully registered and you can use gamble system right now! Good luck![/b][/color]");

	$start['bad'] = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=red][b]Something went wrong while register. Try again later or contact support![/b][/color]");

	$start['regalready'] = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=red][b]You are registered already.[/b][/color]");

	$bet['ok'] = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=green][b]Hello, I am GamBot. You can start with betting! Good luck.For more help type [i]!help[/i][/b][/color]");

	$gamble['coins'] = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=red][b]You dont have enough coins for this bet![/b][/color]");

	$gamble['won'] = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=green][b]You won ![/color][color=red] ".$won."[/color][/b]");

	$gamble['lost'] = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=red][b]You lose! Left in bank: ". $lost . "[/b][/color]");

	$gamble['number'] = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=red][b]Bet must be in number format![/b][/color]");

	$uc = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=red][b]Unknown command![/b][/color]");

	$ntr = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=red][b]Before using this command you need to register. That can be done by typing [i]!start[/i] in channel chat![/b][/color]");


}
elseif($lang == "BA") 
{
	$start['ok'] = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=green][b]Uspješno ste registrovani i možete koristiti kockarski sistem! Sretno![/b][/color]");

	$start['bad'] = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=red][b]Nešto je pošlo po zlu prilikom registracije. Pokušajte ponovo ili kontaktirajte administratore![/b][/color]");

	$start['regalready'] = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=red][b]Već ste registrovani.[/b][/color]");

	$bet['ok'] = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=green][b]Pozdrav ".$info["invokername"].", možete početi sa kockom!
		Sretno. Za više pomoći kucajte [i]!help[/i][/b][/color]");

	$gamble['coins'] = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=red][b]Nemaš dovoljno novca za ovaj krug![/b][/color]");

	$gamble['won'] = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=green][b]Pobijedio si![/color][color=red] ".$won."[/color][/b]");

	$gamble['lost'] = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=red][b]Izgubio si jbg! Preostalo u banci: ". $lost . "[/b][/color]");

	$gamble['number'] = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=red][b]Novac mora biti u obliku broja![/b][/color]");

	$uc = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=red][b]Nepoznata komanda![/b][/color]");

	$ntr = ("[COLOR=Blue][b][R4P3][/b][/color]:[color=red][b]Prije korištenja ove naredbe moraš se registrovati. To možeš učiniti pisanjem [i]!start[/i] u channel chatu![/b][/color]");	

}
else
{
	die("Unknown defined launguage");
}


?>