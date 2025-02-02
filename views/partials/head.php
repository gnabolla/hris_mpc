<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'My Application') ?></title>
  <!-- Use BASE_URL to correctly locate assets -->
  <link href="<?= BASE_URL ?>/assets/vendor/fontawesome/css/all.min.css" rel="stylesheet">
  <link href="<?= BASE_URL ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= BASE_URL ?>/assets/css/master.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <script src="<?= BASE_URL ?>/assets/vendor/jquery/jquery.min.js"></script>
</head>
<body>
