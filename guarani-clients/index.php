<?php
require_once 'config.php';

// Fetch all clients
$result = $mysqli->query("SELECT * FROM clientes ORDER BY id DESC");
$clientes = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GRUPO GUARANI - Gestión de Clientes</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles.css">
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/0787d9ec00.js" crossorigin="anonymous"></script>
    <!-- Font family Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <style>
        /* Puedes agregar estilos personalizados si lo deseas */
        .table-hover tbody tr:hover {
            background-color: rgb(195, 192, 189);
        }

        i:hover {
            background-color: inherit;
            padding: 5px;
            border-radius: 100%;
            border: solid 1px black;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Encabezado con fondo degradado -->
    <header class="bg-white text-[#800000] py-4">
        <div class="container mx-auto flex justify-between items-center px-4">
            <div class="flex items-center">
                <img src="assets/guarani-logo.png" alt="GRUPO GUARANI" class="w-[15%] mr-3">
                <h1 class="text-3xl font-bold ms-3">Gestión de clientes</h1>
            </div>
            <a href="add.php"
                class="bg-white text-xl text-green-600  hover:bg-green-50 transition-colors font-semibold py-2 px-4 rounded shadow flex items-center">
                <i class="fa-solid px-3 fa-user-plus"></i> Añadir cliente
            </a>
        </div>
    </header>

    <main class="container mx-auto p-4">
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-center">
            <div class="w-full sm:w-1/2 mb-4 sm:mb-0">
                <input type="text" id="searchInput" placeholder="Buscar clientes..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="overflow-x-auto shadow-lg rounded-lg">
            <table class="min-w-full bg-white table-hover">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-3 px-4 text-left font-semibold">Nombre</th>
                        <th class="py-3 px-4 text-left font-semibold">Apellidos</th>
                        <th class="py-3 px-4 text-left font-semibold">NIF/NIE</th>
                        <th class="py-3 px-4 text-left font-semibold">Domicilio</th>
                        <th class="py-3 px-4 text-left font-semibold">Población</th>
                        <th class="py-3 px-4 text-left font-semibold">Teléfono</th>
                        <th class="py-3 px-4 text-left font-semibold">CP</th>
                        <th class="py-3 px-4 text-center font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody id="clientesTableBody">
                    <?php foreach ($clientes as $cliente): ?>
                        <tr class="border-b transition duration-200 ease-in-out hover:bg-gray-50">
                            <td class="py-3 px-4"><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($cliente['apellidos']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($cliente['nif']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($cliente['domicilio']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($cliente['poblacion']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($cliente['telefono']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($cliente['cp']); ?></td>
                            <td class="py-3 px-4 text-center d d-flex ">
                                <a href="edit.php?id=<?php echo $cliente['id']; ?>"
                                    class="inline-block text-blue-500 hover:text-blue-700 mr-2"
                                    title="Editar">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="delete.php?id=<?php echo $cliente['id']; ?>"
                                    class="inline-block text-red-500 hover:text-red-700"
                                    title="Eliminar"
                                    onclick="return confirm('¿Estás seguro de que quieres eliminar este cliente?');">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        // Buscador en tiempo real
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const clientesTableBody = document.getElementById('clientesTableBody');
            const rows = clientesTableBody.getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
                const searchTerm = searchInput.value.toLowerCase();

                for (let i = 0; i < rows.length; i++) {
                    const row = rows[i];
                    const cells = row.getElementsByTagName('td');
                    let found = false;

                    for (let j = 0; j < cells.length; j++) {
                        const cellText = cells[j].textContent.toLowerCase();
                        if (cellText.indexOf(searchTerm) > -1) {
                            found = true;
                            break;
                        }
                    }

                    row.style.display = found ? '' : 'none';
                }
            });
        });
    </script>
</body>

</html>