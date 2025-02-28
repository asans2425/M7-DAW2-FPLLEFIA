<header class="bg-white shadow">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <div class="flex items-center">
                <a href="index.php" class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                        <line x1="9" y1="9" x2="9.01" y2="9"></line>
                        <line x1="15" y1="9" x2="15.01" y2="9"></line>
                    </svg>
                    <span class="ml-2 text-xl font-bold text-gray-800">Peregrang App</span>
                </a>
            </div>

            <nav class="hidden md:flex space-x-6">
                <a href="index.php?page=home" class="<?php echo $page == 'home' ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600'; ?>">Inicio</a>
                <a href="index.php?page=leagues" class="<?php echo $page == 'leagues' ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600'; ?>">Ligas</a>
                <a href="index.php?page=matches" class="<?php echo $page == 'matches' ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600'; ?>">Partidos</a>
                <a href="index.php?page=rankings" class="<?php echo $page == 'rankings' ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600'; ?>">Rankings</a>
            </nav>

            <div class="flex items-center">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php $user = getUserData($_SESSION['user_id']); ?>
                    <div class="relative group">
                        <button class="flex items-center focus:outline-none">
                            <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-200">
                                <?php if (!empty($user['avatar'])): ?>
                                    <img src="uploads/avatars/<?php echo $user['avatar']; ?>" alt="Avatar" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-400 p-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                <?php endif; ?>
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-700 hidden md:block"><?php echo $user['username']; ?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden group-hover:block">
                            <a href="index.php?page=profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mi Perfil</a>
                            <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cerrar Sesión</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="text-gray-600 hover:text-primary-600">Iniciar Sesión</a>
                    <a href="register.php" class="ml-4 px-4 py-2 rounded-md bg-primary-600 text-white hover:bg-primary-700">Registrarse</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>