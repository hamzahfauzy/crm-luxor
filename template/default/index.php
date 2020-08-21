<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $this->title ?></title>
    <link href="<?= asset('css/app.css') ?>" type="text/css" rel="stylesheet"/>
    <link href="<?= asset('css/font-awesome.min.css') ?>" type="text/css" rel="stylesheet"/>
    <link href="<?= asset('css/style.css') ?>" type="text/css" rel="stylesheet"/>
    <?php foreach($this->css as $css): ?>
    <link href="<?= $css ?>" type="text/css" rel="stylesheet"/>
    <?php endforeach; ?>
    <style type="text/css">
    li.dropdown ul {
        display: none;
    }
    li.dropdown:hover > ul {
        display: block;
        position: absolute;
        z-index: 1;
        background-color: #f6922d;
        padding: 0;
        margin:0;
    }
    </style>
</head>
<body>
    <div class="container" style="min-height: 100%">
        <div class="wrapper">
            <?php require 'layouts/header.php'; ?>
            <?= $content; ?>
        </div>
        <?php require 'layouts/footer.php'; ?>
    </div>
    
    <?php foreach($this->js as $js): ?>
    <script src="<?= $js ?>"></script>
    <?php endforeach; ?>
</body>
</html>