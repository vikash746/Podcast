<div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden my-10">
    <div class="p-6">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Welcome Back</h2>
            <p class="text-gray-600 mt-1">Login to continue your podcast journey</p>
        </div>
        
        <?php
        if(isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $result = loginUser($email, $password);
            
            if($result['success']) {
                echo '<div class="bg-green-100 text-green-800 p-3 rounded mb-4">' . $result['message'] . '</div>';
                echo '<script>window.location.href = "index.php";</script>';
            } else {
                echo '<div class="bg-red-100 text-red-800 p-3 rounded mb-4">' . $result['message'] . '</div>';
            }
        }
        ?>
        
        <form method="post" action="">
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-medium mb-1">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-600" 
                    required
                >
            </div>
            
            <div class="mb-4">
                <div class="flex justify-between items-center mb-1">
                    <label for="password" class="block text-gray-700 text-sm font-medium">Password</label>
                    <a href="#" class="text-xs text-purple-600 hover:underline">Forgot Password?</a>
                </div>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-600" 
                    required
                >
            </div>
            
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" class="rounded text-purple-600 focus:ring-purple-600 mr-2">
                    <span class="text-sm text-gray-600">Remember me</span>
                </label>
            </div>
            
            <button 
                type="submit" 
                name="login" 
                class="w-full py-2 px-4 bg-purple-600 text-white font-medium rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-opacity-50 transition-colors"
            >
                Login
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <p class="text-gray-600 text-sm">
                Don't have an account? 
                <a href="index.php?page=register" class="text-purple-600 hover:underline">Register</a>
            </p>
        </div>
    </div>
</div>
