<?php

require_once("Src/Model/User.php");

if($_SESSION['podloty_loggedin'] != 'ok')
{
	// ******************************************************
	// REJESTRACJA - KROK 2 - walidacja i rejestracja w bazie
	// ******************************************************
	if($_POST['rejestracja_krok2'] == 'ok' && isset($_POST['nick'], $_POST['pass'], $_POST['repass'], $_POST['email']))
	{
		if(empty($_POST['nick']) || empty($_POST['pass']) || empty($_POST['repass']) || empty($_POST['email']))
		{
			echo "<p> Wypelnij wszystkie obowiazkowe dane.</p>";
			echo "<p><a href=\"index.php?page=registration\">wroc</a></p>";
		}
		else
		{
			require_once("Src/Util/Checkemail.php");
						
			if(!validdata($_POST['nick']))
			{
				echo "<p>blad niektore pola zawieraja nieprawidlowe znaki.</p>";
				echo "<p><a href=\"index.php?page=registration\">wroc</a></p>";
			}
			else if(!validemail($_POST['email']))
			{
				echo "<p>BĹ�Ä„D: Wpisany adres e-mail jest nieprawidlowy.</p>";
				echo "<p><a href=\"index.php?page=registration\">wroc</a></p>";
			}
			else if($_POST['pass'] != $_POST['repass'])
			{
				echo "<p class=\"infoattention\">blad. haslo jest blednie powtorzone.</p>";
				echo "<p class=\"infoc\"><a href=\"index.php?page=registration\">Wwroc‡</a></p>";
			}
			else
			{
				if(!isset($_SESSION[hash_u]))
				{
					$_SESSION[hash_u] = $_POST[hash];
					$moznazapisac = true;
				}
				else if($_SESSION[hash_u] == $_POST[hash])
				{
					$moznazapisac = false;
				}
				else
				{
					$_SESSION[hash_u] = $_POST[hash];
					$moznazapisac = true;
				}
				
				if($moznazapisac)
				{
					$newUser = new User($_POST['nick'], $_POST['email']);
					
					if($newUser->ExistsByNick())
					{
						echo "\n";
						echo " Blad: W bazie danych istnieje juz podany nick.";
						echo "<a href=\"index.php?page=registration\">Wroc</a>";
					}
					else if($newUser->ExistsByEmail())
					{
						echo "<BR>";
						echo "Blad W bazie danych istnieje juz podany adres e-mail.";
						echo "<a href=\"index.php?page=registration\">Wroc</a>";

					}
					else
					{
						$newUser->setPassword( sha1($_POST['pass']) );
						$newUser->setKey( sha1(time()*rand()) );
						
						if($newUser->InsertToDB())
						{
							$subject = 'PODLOTY.pl - aktywacja konta';
							$header .= "Content-type: text/plain; charset=utf-8\n"; 
							$header .= "Content-Transfer-Encoding: 8bit\n";
							$header .= "From: noreply@podloty.pl";
							
							$tosend = "Witaj ".$newUser->getNick().",\n\n Dziekujem za rejestracjÄ™ w serwisie PODLOTY.pl.\nAby aktywowaÄ‡ konto, kliknij na poniĹĽszy link aktywacyjny:\nhttp://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']."?page=registration&p=activation&u=".$newUser->getNick()."&k=".$newUser->getKey()."\n\n\n----------------------------------------------------------------\nUWAGA: Ten e-mail zostaĹ‚ wygenerowany automatycznie. Prosimy na niego nie odpowiadaÄ‡. JeĹĽeli nie rejestrowaĹ‚eĹ› siÄ™ na stronie www.podloty.pl prosimy o zingrowanie tego maila.";
							
							//TODO:
							//-PO WRZUCENIU NA SERWER OBSĹ�UGUJÄ„CY FUNKCJÄ� MAIL() - ODKOMENTOWAÄ†
							/*if(!mail($newUser->getEmail(), $subject, $tosend, $header))
							{
								DBoperationBasic::LogError($php_errormsg);
							}*/
							
							//TODO przeniesc do walidacji
							//-- create folder for user
							mkdir("././Photos/".$newUser->getNick(), 777);
							mkdir("././Photos/".$newUser->getNick()."/thumbnails/", 777);  
							
							echo "<br>";
							echo "TRESC MAILA: ".$tosend;
							echo "<br>";
												
							echo "<p>Rejestracja przebiegĹ‚a pomyĹ›lnie. <b>Na podany przez Ciebie adres e-mail zostaĹ‚ wysĹ‚any link aktywujÄ…cy</b>, ktĂłry powinien dotrzeÄ‡ w przeciÄ…gu kilku minut.</p>";
							echo "<p>Kliknij w otrzymany link, w celu aktywacji konta.</p>";
						}
						else
						{
							echo "<p>Blad podczas rejestracji. Sprobuj ponownie.</p>";
						}
					}
				}
				else
				{
					ob_end_clean();
					header("Location: index.php");
					exit;
				}
			}
		}
	}
	// ********************************
	// REJESTRACJA - KROK 3 - aktywacja
	// ********************************
	else if($_GET[p] == 'activation' && isset($_GET['u']) && isset($_GET['k']))
	{
		$newUser = new User();
		$newUser->setNick($_GET['u']);
		$newUser->setKey($_GET['k']);
		
				
		if($newUser->Activate())
		{
			//TODO przerzucic tutaj tworzenie folderu
			
			echo "<p>Aktywacja przebiega‚a pomys›lnie. <b>Teraz mozesz sie zalogowaÄ‡</b>.</p>";
		}
		else
		{
			echo "<p>WystÄ…piĹ‚ bĹ‚Ä…d podczas aktywacji. SprĂłbuj ponownie lub skontaktuj siÄ™ z administratorem.</p>";
		}
	}
	// *********************************************
	// REJESTRACJA - KROK 1 - wypeĹ‚nienie formularza
	// *********************************************
	else
	{
	
	?>

	.

	<form id="registrationForm" name="registrationForm" method="post" action="index.php?page=registration">

	<table>

		<tr><td>Nick: </td><td><input type="text" name="nick" /></td></tr>
		<tr><td>HasĹ‚o: </td><td><input type="password" name="pass" /></td></tr>
		<tr><td>PowtĂłrz hasĹ‚o: </td><td><input type="password" name="repass" /></td></tr>
		<tr><td>E-mail: </td><td><input type="text" name="email" /></td></tr>
		<input type="hidden" name="rejestracja_krok2" value="ok" />
		<input type="hidden" name="hash" value="<?php echo md5(time()*rand()) ?>" />
		<tr><td colspan="2"><input type="submit" name="submit" value="OK" /></td><td></td></tr>

	</table>

	</form>

	<?php

	}
}
else // Proba rejestracji zalogowanego usera - przekierowanie do strony gĹ‚Ăłwnej
{
	ob_end_clean();
	header("Location: index.php");
}

?>
