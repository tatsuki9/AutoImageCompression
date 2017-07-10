<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <?php echo Asset::css('bootstrap.css'); ?>
</head>
<body>
<header>
    <div class="container">
    </div>
</header>
<div class="container">
    <div class="row">
        <div class="col-md-12">
        </div>
    </div>
    <hr/>
    <footer>
        <p class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</p>
        <p>
            <a href="http://fuelphp.com">FuelPHP</a> is released under the MIT license.<br>
            <small>Version: <?php echo Fuel::VERSION; ?></small>
        </p>
    </footer>
</div>
</body>
</html>