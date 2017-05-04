<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(5, "mi_home_php", $Language->MenuPhrase("5", "MenuText"), "home.php", -1, "", AllowListMenu('{BD598998-6524-4166-9FBE-52F174C8EABD}home.php'), FALSE, TRUE);
$RootMenu->AddMenuItem(6, "mci_Setup", $Language->MenuPhrase("6", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(14, "mi_t_coal4", $Language->MenuPhrase("14", "MenuText"), "t_coal4list.php?cmd=resetall", 6, "", AllowListMenu('{BD598998-6524-4166-9FBE-52F174C8EABD}t_coal4'), FALSE, FALSE);
$RootMenu->AddMenuItem(1, "mi_t_coal1", $Language->MenuPhrase("1", "MenuText"), "t_coal1list.php", 14, "", AllowListMenu('{BD598998-6524-4166-9FBE-52F174C8EABD}t_coal1'), FALSE, FALSE);
$RootMenu->AddMenuItem(2, "mi_t_coal2", $Language->MenuPhrase("2", "MenuText"), "t_coal2list.php?cmd=resetall", 14, "", AllowListMenu('{BD598998-6524-4166-9FBE-52F174C8EABD}t_coal2'), FALSE, FALSE);
$RootMenu->AddMenuItem(13, "mi_t_coal3", $Language->MenuPhrase("13", "MenuText"), "t_coal3list.php?cmd=resetall", 14, "", AllowListMenu('{BD598998-6524-4166-9FBE-52F174C8EABD}t_coal3'), FALSE, FALSE);
$RootMenu->AddMenuItem(4, "mi_t_user", $Language->MenuPhrase("4", "MenuText"), "t_userlist.php", 6, "", AllowListMenu('{BD598998-6524-4166-9FBE-52F174C8EABD}t_user'), FALSE, FALSE);
$RootMenu->AddMenuItem(7, "mci_Report", $Language->MenuPhrase("7", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(-2, "mi_changepwd", $Language->Phrase("ChangePwd"), "changepwd.php", -1, "", IsLoggedIn() && !IsSysAdmin());
$RootMenu->AddMenuItem(-1, "mi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
