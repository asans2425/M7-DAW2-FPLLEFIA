<html>
    <head>
        <title>Practica 1</title>
        <style>
            header{
                display: flex;
                justify-content: space-evenly;
                align-items: center;
            }

            header img{
                width: 600px;
                height: 200px;
            }

            main{
                background-color: rgb(230, 230, 230);
            }
            .separar{
                display: flex;
            }

            .izquierda{
                width: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                margin: 20px;
            }
            .derecha{
                width: 50%;
                margin: 20px;
            }

            .derecha p{
                margin: 10px 300px 10px 30px;
            }

            footer{
                justify-content: center;
                text-align: center;
            }


        </style>
    </head>
    <body>
        <header>
            <img src="logo-fpllefia.jfif" alt="FotoLogo">
            <h1>Módulo 7 - Práctica 1. Mi primera aplicación en PHP</h1>
        </header>
        <main>
            <div class="separar">
                <div class="izquierda">
                    <img src="imagen2.png" alt="Foto mia">
                    <h3>Brian Camuñez</h3>
                </div>
                <div class="derecha">
                    <p>?php srive para decir que lo que empieces a poner sera del lenguaje php. function sayHello($name) echo "Hello $name!"; Esto es una funcion que que dice Hello. sayHello('remote world'); Esto llama a la funcion antes hecha y le pasa un valor. phpinfo(); Inicia la funcion</p>
                </div>
            </div>
        </main>
        <footer>
            <h3>Brian Camuñez</h3>
            <p>La fecha de hoy es: <?php echo date('Y-m-d');?></p>
        </footer>

    </body>
</html>