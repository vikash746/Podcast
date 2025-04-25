<nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200 py-3">
    <div class="container mx-auto px-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="fas fa-bars w-6 h-6 cursor-pointer md:hidden text-purple-600"></i>
            <a href="index.php" class="flex items-center">
                <span class="text-xl font-bold text-purple-600">Pod</span>
                <span class="text-xl font-bold text-gray-800">Play</span>
            </a>
        </div>
        
        <div class="hidden md:flex items-center space-x-6">
            <a href="index.php" class="text-gray-700 hover:text-purple-600 transition-colors">Home</a>
            <a href="index.php?page=categories" class="text-gray-700 hover:text-purple-600 transition-colors">Trending</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="index.php?page=library" class="text-gray-700 hover:text-purple-600 transition-colors">Recent</a>
               
            <?php endif; ?>
        </div>
        
        <div class="flex items-center gap-3">
            <div class="relative hidden md:block">
                <input 
                    type="text" 
                    placeholder="Search podcasts..." 
                    class="w-48 lg:w-64 pl-10 pr-4 py-2 text-sm rounded-full border border-gray-300 focus:outline-none focus:border-purple-600"
                >
                <i class="fas fa-search absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
            </div>
            <i class="fas fa-search w-6 h-6 md:hidden text-gray-700"></i>
            <i class="fas fa-bell w-6 h-6 text-gray-700"></i>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="relative group">
                    <button class="rounded-full bg-gray-100 w-10 h-10 flex items-center justify-center">
                        <i class="fas fa-user text-gray-700"></i>
                    </button>
                    <div class="absolute right-0 mt-0 w-48 bg-white rounded-md shadow-lg hidden group-hover:block group-hover:delay-1000">
                        <div class="py-1">
                            <p class="px-4 py-2 text-sm text-gray-700 border-b border-gray-100">
                                Hello, <?php echo $_SESSION['username']; ?>
                            </p>
                            <a href="index.php?page=profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="index.php?page=settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            <a href="includes/logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <a href="index.php?page=login" class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-md hover:bg-purple-700 transition-colors">
                    Login
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>
