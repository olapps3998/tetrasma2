<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(5, "mmi_home_php", $Language->MenuPhrase("5", "MenuText"), "home.php", -1, "", AllowListMenu('{BD598998-6524-4166-9FBE-52F174C8EABD}home.php'), FALSE, TRUE);
$RootMenu->AddMenuItem(6, "mmci_Setup", $Language->MenuPhrase("6", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(12, "mmci_Chart_of_Account", $Language->MenuPhrase("12", "MenuText"), "", 6, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(1, "mmi_t_coal1", $Language->MenuPhrase("1", "MenuText"), "t_coal1list.php", 12, "", AllowListMenu('{BD598998-6524-4166-9FBE-52F174C8EABD}t_coal1'), FALSE, FALSE);
$RootMenu->AddMenuItem(2, "mmi_t_coal2", $Language->MenuPhrase("2", "MenuText"), "t_coal2list.php?cmd=resetall", 12, "", AllowListMenu('{BD598998-6524-4166-9FBE-52F174C8EABD}t_coal2'), FALSE, FALSE);
$RootMenu->AddMenuItem(4, "mmi_t_user", $Language->MenuPhrase("4", "MenuText"), "t_userlist.php", 6, "", AllowListMenu('{BD598998-6524-4166-9FBE-52F174C8EABD}t_user'), FALSE, FALSE);
$RootMenu->AddMenuItem(7, "mmci_Report", $Language->MenuPhrase("7", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(-2, "mmi_changepwd", $Language->Phrase("ChangePwd"), "changepwd.php", -1, "", IsLoggedIn() && !IsSysAdmin());
$RootMenu->AddMenuItem(-1, "mmi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mmi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
