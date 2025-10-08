<?php
/* Authentication type */
$cfg['Servers'][1]['auth_type'] = 'cookie';

/* Server parameters */
$cfg['Servers'][1]['host'] = 'db';  // Nom de votre service Docker pour MySQL
$cfg['Servers'][1]['port'] = '3306';  // Port MySQL (3306 par défaut)
$cfg['Servers'][1]['user'] = 'root';  // Utilisateur MySQL
$cfg['Servers'][1]['password'] = 'Ftg5g5gjYRT657evTRY6GR4ZDVT';  // Mot de passe MySQL
$cfg['Servers'][1]['compress'] = false;
$cfg['Servers'][1]['AllowNoPassword'] = false;

/* phpMyAdmin configuration storage settings */
$cfg['Servers'][1]['controlhost'] = 'db';
$cfg['Servers'][1]['controluser'] = 'root';
$cfg['Servers'][1]['controlpass'] = 'Ftg5g5gjYRT657evTRY6GR4ZDVT';

/* Default database */
$cfg['Servers'][1]['pmadb'] = 'Website';  // Nom de votre base de données
?>
