<?php
session_start();

/* =========================
   SUPPRESSION SESSION
========================= */
session_unset();
session_destroy();

/* =========================
   REDIRECTION LOGIN
========================= */
header("Location: /StandComputer/connexion");
exit();
?>

