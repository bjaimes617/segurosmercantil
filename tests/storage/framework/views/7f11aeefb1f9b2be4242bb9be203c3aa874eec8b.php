<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $__env->yieldContent('title'); ?></title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
        <?php echo Html::style('css/adminlte.css'); ?>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #d3d3d3;
                color: #000000;
                font-family: 'Nunito', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 20px;
                text-align: center;
            }            
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content" >
                <?php echo $__env->yieldContent('image'); ?>
                <div class="title">
                    <?php echo $__env->yieldContent('message'); ?>                    
                </div>
            </div>
        </div>
    </body>
</html>
<?php /**PATH /var/www/html/segurosmercantil/source/resources/views/errors/layout.blade.php ENDPATH**/ ?>