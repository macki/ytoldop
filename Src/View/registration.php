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
			echo "<p>BŁĄD: Wypełnij wszystkie obowiązkowe dane.</p>";
			echo "<p><a href=\"index.php?page=registration\">Wróć</a></p>";
		}
		else
		{
			require_once("Src/Util/Checkemail.php");
						
			if(!validdata($_POST['nick']))
			{
				echo "<p>BŁĄD: Niektóre pola zawierają nieprawidłowe znaki.</p>";
				echo "<p><a href=\"index.php?page=registration\">Wróć</a></p>";
			}
			else if(!validemail($_POST['email']))
			{
				echo "<p>BŁĄD: Wpisany adres e-mail jest nieprawidłowy.</p>";
				echo "<p><a href=\"index.php?page=registration\">Wróć</a></p>";
			}
			else if($_POST['pass'] != $_POST['repass'])
			{
				echo "<p class=\"infoattention\">BŁĄD: Hasło jest błędnie powtórzone.</p>";
				echo "<p class=\"infoc\"><a href=\"index.php?page=registration\">Wróć</a></p>";
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
						echo "<p>BŁĄD: W bazie danych istnieje już podany nick.</p>";
						echo "<p><a href=\"index.php?page=registration\">Wróć</a></p>";
					}
					else if($newUser->ExistsByEmail())
					{
						echo "<p>BŁĄD: W bazie danych istnieje już podany adres e-mail.</p>";
						echo "<p><a href=\"index.php?page=registration\">Wróć</a></p>";
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
							
							$tosend = "Witaj ".$newUser->getNick().",\n\nDziękujemy za rejestrację w serwisie PODLOTY.pl.\nAby aktywować konto, kliknij na poniższy link aktywacyjny:\nhttp://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']."?page=registration&p=activation&u=".$newUser->getNick()."&k=".$newUser->getKey()."\n\n\n----------------------------------------------------------------\nUWAGA: Ten e-mail został wygenerowany automatycznie. Prosimy na niego nie odpowiadać. Jeżeli nie rejestrowałeś się na stronie www.podloty.pl prosimy o zingrowanie tego maila.";
							
							//TODO:
							//-PO WRZUCENIU NA SERWER OBSŁUGUJĄCY FUNKCJĘ MAIL() - ODKOMENTOWAĆ
							/*if(!mail($newUser->getEmail(), $subject, $tosend, $header))
							{
								DBoperationBasic::LogError($php_errormsg);
							}*/
							echo "TRESC MAILA: ".$tosend;

						
							echo "<p>Rejestracja przebiegła pomyślnie. <b>Na podany przez Ciebie adres e-mail został wysłany link aktywujący</b>, który powinien dotrzeć w przeciągu kilku minut.</p>";
							echo "<p>Kliknij w otrzymany link, w celu aktywacji konta.</p>";
						}
						else
						{
							echo "<p>Błąd podczas rejestracji. Spróbuj ponownie.</p>";
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
			echo "<p>Aktywacja przebiegła pomyślnie. <b>Teraz możesz się zalogować</b>.</p>";
		}
		else
		{
			echo "<p>Wystąpił błąd podczas aktywacji. Spróbuj ponownie lub skontaktuj się z administratorem.</p>";
		}
	}
	// *********************************************
	// REJESTRACJA - KROK 1 - wypełnienie formularza
	// *********************************************
	else
	{
	
	?>

	Aby założyć konto, wypełnij formularz:
		
	<form id="registrationForm" name="registrationForm" method="post" action="index.php?page=registration">

	<table>

		<tr><td>Nick: </td><td><input type="text" name="nick" /></td></tr>
		<tr><td>Hasło: </td><td><input type="password" name="pass" /></td></tr>
		<tr><td>Powtórz hasło: </td><td><input type="password" name="repass" /></td></tr>
		<tr><td>E-mail: </td><td><input type="text" name="email" /></td></tr>
		<input type="hidden" name="rejestracja_krok2" value="ok" />
		<input type="hidden" name="hash" value="<?php echo md5(time()*rand()) ?>" />
		<tr><td colspan="2"><input type="submit" name="submit" value="OK" /></td><td></td></tr>

	</table>

	</form>

	<?php

	}
}
else // Proba rejestracji zalogowanego usera - przekierowanie do strony głównej
{
	ob_end_clean();
	header("Location: index.php");
}

?>
