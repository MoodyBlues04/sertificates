<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
    <header>
    </header>

    <div class="container d-flex row h-100 w-100">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar" style="margin-top: 20px;">
            <div class="sidebar-sticky">
                <h4>Actions</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="/?r=index">files list</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/?r=excel/upload">upload excel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/?r=pdf/upload">upload pdf</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/?r=pdf/fill-sertificats">fill sertificates</a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-8">
            <?php if (Yii::$app->session->hasFlash('success')) : ?>
                <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-check"></i>Success</h4>
                    <?= Yii::$app->session->getFlash('success') ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('error')) : ?>
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-check"></i>Error</h4>
                    <?= Yii::$app->session->getFlash('error') ?>
                </div>
            <?php endif; ?>

            <div class="container">
                <?= $content ?>
            </div>
        </main>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>