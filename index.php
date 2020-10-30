<?php
require_once __DIR__ . '/sentry.php';
try {
    header("location: connexion/co.php?co=newco");
} catch (Exception $e) {
    throw new Exception('Redirect from / : ' . $e);
}

?>