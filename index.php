<!DOCTYPE HTML>
<html>
<head>
    <title>Movies</title>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <link href="css/movie.css" rel="stylesheet" type="text/css">
    <link href="css/skeleton.css" rel="stylesheet" type="text/css">

</head>
<body>
<script type="text/javascript" src="./vendor/jquery/jquery-3.3.1.js"></script>
<nav>
    <?php
    include 'nav.html';
    ?>
</nav>
<main>
<?php
include 'class/DBUsage.php';

$con = new DBUsage('localhost', 'root', '', 'movie');

if(!isset($_GET['seite']))
{
    include 'src/show_movie.php';
} else
{
    switch($_GET['seite'])
    {
        case 'update_movie':
            include 'src/update_movie.php';
            break;
        case 'show_movie':
        default:
            include 'src/show_movie.php';
    }
}
?>
</main>
</body>
</html>
