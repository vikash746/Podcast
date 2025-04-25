<div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden my-10">
    <div class="p-6">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Create an Account</h2>
            <p class="text-gray-600 mt-1">Start your podcast listening journey</p>
        </div>
        
        <?php
        if(isset($_POST['register'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            
            if($password !== $confirm_password) {
                echo '<div class="bg-red-100 text-red-800 p-3 rounded mb-4">Passwords do not match</div>';
            } else {
                $result = registerUser($username, $email, $password);
                
                if($result['success']) {
                    echo '<div class="bg-green-100 text-green-800 p-3 rounded mb-4">' . $result['message'] . '</div>';
                    echo '<script>
                        setTimeout(function() {
                            window.location.href = "index.php?page=login";
                        }, 2000);
                    </script>';
                } else {
                    echo '<div class="bg-red-100 text-red-800 p-3 rounded mb-4">' . $result['message'] . '</div>';
                }
            }
        }
        ?>
        
        <form method="post" action="">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-medium mb-1">Username</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-600" 
                    required
                >
            </div>
            
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
                <label for="password" class="block text-gray-700 text-sm font-medium mb-1">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-600" 
                    required
                >
            </div>
            
            <div class="mb-6">
                <label for="confirm_password" class="block text-gray-700 text-sm font-medium mb-1">Confirm Password</label>
                <input 
                    type="password" 
                    id="confirm_password" 
                    name="confirm_password" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-600" 
                    required
                >
            </div>
            
            <button 
                type="submit" 
                name="register" 
                class="w-full py-2 px-4 bg-purple-600 text-white font-medium rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-opacity-50 transition-colors"
            >
                Register
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <p class="text-gray-600 text-sm">
                Already have an account? 
                <a href="index.php?page=login" class="text-purple-600 hover:underline">Login</a>
            </p>
        </div>
    </div>
</div>
