<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/functions.php';
$pageTitle = $pageTitle ?? 'Smart Transit Navigation System';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Smart Transit Navigation System">
<title><?= e($pageTitle) ?> | SmartTransit</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
<?php require __DIR__ . '/navbar.php'; ?>
