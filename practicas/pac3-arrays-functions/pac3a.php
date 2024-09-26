
<!-- Usa el !template de album para generar un album con bootstrap. Cada foto debe ser un idolo tuyo con un pequeño texto explicando porqué-->
<!-- Añade un botón de eliminar identico al de ver y editar y no modifiques su funcionamiento. -->
<!-- Las cards se deben generar a partir de un array u objeto de arrays -->

<!-- Modifica el diseño a tu gusto  -->


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.72.0">
  <title>Album example · Bootstrap</title>

  <link rel="canonical" href="https://v5.getbootstrap.com/docs/5.0/examples/album/">



  <!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>


</head>



<body>
  <header>
    <div class="collapse bg-dark" id="navbarHeader">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 col-md-7 py-4">
            <h4 class="text-white">About</h4>
            <p class="text-muted">Add some information about the album below, the author, or any other background
              context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off
              to some social networking sites or contact information.</p>
          </div>
          <div class="col-sm-4 offset-md-1 py-4">
            <h4 class="text-white">Contact</h4>
            <ul class="list-unstyled">
              <li><a href="#" class="text-white">Follow on Twitter</a></li>
              <li><a href="#" class="text-white">Like on Facebook</a></li>
              <li><a href="#" class="text-white">Email me</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="navbar navbar-dark bg-dark shadow-sm">
      <div class="container">
        <a href="#" class="navbar-brand d-flex align-items-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="mr-2"
            viewBox="0 0 24 24">
            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
            <circle cx="12" cy="13" r="4" /></svg>
          <strong>Album DAW 2</strong>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader"
          aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </div>
  </header>

  <main>

    <section class="py-5 text-center container">
      <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
          <h1 class="font-weight-light">Album example</h1>
          <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator,
            etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
          <p>
            <a href="#" class="btn btn-primary my-2">Main call to action</a>
            <a href="#" class="btn btn-secondary my-2">Secondary action</a>
          </p>
        </div>
      </div>
    </section>

    <div class="album py-5 bg-light">
      <div class="container">

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

<?php 

$idolos = [
  [
    'Nombre' => 'Leo',
    'Apellidos' => 'Messi',
    'Imagen' => 'https://www.fcbarcelona.com/fcbarcelona/photo/2022/08/02/ae5252d1-b79b-4950-9e34-6e67fac09bb0/LeoMessi20092010_pic_fcb-arsenal62.jpg',
    'Descripcion' => 'Considerado uno de los mejores futbolistas de todos los tiempos, con múltiples Balones de Oro y una carrera exitosa en el FC Barcelona y la selección argentina.'
  ],
  [
    'Nombre' => 'Batman',
  
    'Imagen' => 'https://img.rtve.es/imagenes/batman-actores-cine-saber-ganar/1634549481092.jpg',
    'Descripcion' => 'El caballero oscuro de Gotham, protector de la ciudad y uno de los superhéroes más emblemáticos del mundo del cómic.'
  ],
  [
    'Nombre' => 'Michael ',
    'Apellidos' => 'Jordan',
    'Imagen' => 'https://upload.wikimedia.org/wikipedia/commons/a/a9/Michael_Jordan_in_2014.jpg',
    'Descripcion' => 'Reconocido como el mejor jugador de baloncesto de la historia, seis veces campeón de la NBA con los Chicago Bulls y embajador del deporte.'
  ],
  [
    'Nombre' => 'Serena ',
    'Apellidos' => 'Williams',
    'Imagen' => 'https://upload.wikimedia.org/wikipedia/commons/4/4f/Serena_Williams_at_2013_US_Open_4.jpg',
    'Descripcion' => 'Una de las tenistas más exitosas de la historia, con 23 títulos de Grand Slam en su carrera, conocida por su fuerza y determinación.'
  ],
  [
    'Nombre' => 'Albert ',
    'Apellidos' => 'Einstein',
    'Imagen' => 'https://upload.wikimedia.org/wikipedia/commons/d/d3/Albert_Einstein_Head.jpg',
    'Descripcion' => 'Físico teórico de origen alemán, famoso por su teoría de la relatividad y por ser uno de los científicos más influyentes del siglo XX.'
  ],
  [
    'Nombre' => 'Frida ',
    'Apellidos' => 'Kahlo',
    'Imagen' => 'https://upload.wikimedia.org/wikipedia/commons/d/d4/Frida_Kahlo_%28ca._1920%29.jpg',
    'Descripcion' => 'Artista mexicana conocida por sus autorretratos llenos de simbolismo y dolor, convirtiéndose en un icono feminista y cultural.'
  ],
  [
    'Nombre' => 'Nelson ',
    'Apellidos' => 'Mandela',
    'Imagen' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/0f/Nelson_Mandela-2008_%28edit%29.jpg/1200px-Nelson_Mandela-2008_%28edit%29.jpg',
    'Descripcion' => 'Líder sudafricano que luchó contra el apartheid, convirtiéndose en el primer presidente negro de Sudáfrica y un símbolo de paz y justicia.'
  ],
  [
    'Nombre' => 'Marie ',
    'Apellidos' => 'Curie',
    'Imagen' => 'https://upload.wikimedia.org/wikipedia/commons/6/69/Marie_Curie_c1920.jpg',
    'Descripcion' => 'Pionera en el campo de la radiactividad, primera mujer en ganar un Premio Nobel y la única en recibirlo en dos campos distintos (Física y Química).'
  ],
  [
    'Nombre' => 'Usain ',
    'Apellidos' => 'Bolt',
    'Imagen' => 'https://upload.wikimedia.org/wikipedia/commons/f/f6/Usain_Bolt_Rio_100m_final_2016b.jpg',
    'Descripcion' => 'El hombre más rápido del mundo, poseedor de múltiples récords mundiales en los 100 y 200 metros, y ganador de numerosos títulos olímpicos.'
  ]
];
// iclude 'idolos.php'; // Incluye el archivo de datos

foreach ($idolos as $idolo){
  $nombre = $idolo['Nombre'];
  $apellidos = $idolo['Apellidos'];
  $foto = $idolo['Imagen'];
  $descripcion = $idolo['Descripcion'];


echo '
          <div class="col">
            <div class="card shadow-sm">
              <img class="" src="' . $foto . '" style="object-fit:cover; aspect-ratio: 16/9" 

              >
              <div class="card-body">
              <h1>' . $nombre;

              if($apellidos) {
                echo ' ' . $apellidos; // Concatenas apellidos si existe
              }

              echo '</h1>
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                  content. This content is a little bit longer.</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                  </div>
                  <small class="text-muted">9 mins</small>
                </div>
              </div>
            </div>
          </div>
          
          
          ';
}

?>
        
        </div>
      </div>
    </div>

  </main>

  <footer class="text-muted py-5">
    <div class="container">
      <p class="float-right mb-1">
        <a href="#">Back to top</a>
      </p>
      <p class="mb-1">Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
      <p class="mb-0">New to Bootstrap? <a href="/">Visit the homepage</a> or read our <a
          href="/docs/5.0/getting-started/introduction/">getting started guide</a>.</p>
    </div>
  </footer>

</body>

</html>