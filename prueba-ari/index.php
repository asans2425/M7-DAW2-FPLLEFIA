<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control d'Il·luminació</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }

        .container {
            border: 2px solid #333;
            padding: 20px;
            width: 300px;
            margin: auto;
            background-color: #f4f4f4;
        }

        .status {
            font-size: 20px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .button {
            padding: 10px 20px;
            font-size: 18px;
            margin: 5px;
            border: none;
            cursor: pointer;
        }

        .on {
            background-color: green;
            color: white;
        }

        .off {
            background-color: red;
            color: white;
        }
    </style>
</head>

<body>

    <h1>Control d'Il·luminació</h1>

    <div class="container">


        <form method="GET">
            <button class="button on" type="submit" name="llum" value="true">Encendre Llum</button>
            <button class="button off" type="submit" name="llum" value="false">Apagar Llum</button>
        </form>

        <p>
            <?php

            if (isset($_GET['llum']) && $_GET['llum'] == 'true') {
                echo 'La llum està encès.';
            } elseif (isset($_GET['llum']) && $_GET['llum'] == 'false') {
                echo 'La llum està apagada.';
            } else {
                echo 'La llum està apagada.';
            }

            ?>
        </p>




    </div>



</body>

</html>