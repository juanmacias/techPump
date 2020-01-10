<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>TechPump Multisite Platform</title>

   <!-- Tell the browser to be responsive to screen width -->
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <?php foreach( $this->css_files['top'] as $css_file): ?>
       <link rel="stylesheet" href="<?= $css_file ?>">
   <?php endforeach; ?>
</head>
<body class="hold-transition sidebar-collapse">