<?php
// User authentication functions
function registerUser($username, $email, $password) {
    global $conn;
    
    // Check if email already exists
    $check_query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if(mysqli_num_rows($result) > 0) {
        return ["success" => false, "message" => "Email already exists"];
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $insert_query = "INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);
    
    if(mysqli_stmt_execute($stmt)) {
        return ["success" => true, "message" => "Registration successful"];
    } else {
        return ["success" => false, "message" => "Registration failed"];
    }
}

function loginUser($email, $password) {
    global $conn;
    
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if(mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        if(password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            return ["success" => true, "message" => "Login successful"];
        }
    }
    
    return ["success" => false, "message" => "Invalid email or password"];
}

// Podcast related functions
function getFeaturedPodcast() {
    global $conn;
    
    $query = "SELECT * FROM podcasts WHERE is_featured = 1 LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    
    return null;
}

function getTrendingPodcasts($limit = 4) {
    global $conn;
    
    $query = "SELECT * FROM podcasts ORDER BY listens DESC LIMIT ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $podcasts = [];
    while($row = mysqli_fetch_assoc($result)) {
        $podcasts[] = $row;
    }
    
    return $podcasts;
}

function getRecentEpisodes($limit = 5) {
    global $conn;
    
    $query = "SELECT e.*, p.title as podcast_title, p.host, p.cover_image FROM episodes e 
              JOIN podcasts p ON e.podcast_id = p.id 
              ORDER BY e.release_date DESC LIMIT ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $episodes = [];
    while($row = mysqli_fetch_assoc($result)) {
        $episodes[] = $row;
    }
    
    return $episodes;
}

function getCategories() {
    global $conn;
    
    $query = "SELECT * FROM categories ORDER BY name";
    $result = mysqli_query($conn, $query);
    
    $categories = [];
    while($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    
    return $categories;
}

function getPodcastById($id) {
    global $conn;
    
    $query = "SELECT * FROM podcasts WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if(mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    
    return null;
}

function getEpisodesByPodcastId($podcast_id) {
    global $conn;
    
    $query = "SELECT * FROM episodes WHERE podcast_id = ? ORDER BY release_date DESC";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $podcast_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $episodes = [];
    while($row = mysqli_fetch_assoc($result)) {
        $episodes[] = $row;
    }
    
    return $episodes;
}

function toggleLike($user_id, $episode_id) {
    global $conn;
    
    // Check if already liked
    $check_query = "SELECT * FROM likes WHERE user_id = ? AND episode_id = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $episode_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if(mysqli_num_rows($result) > 0) {
        // Unlike
        $delete_query = "DELETE FROM likes WHERE user_id = ? AND episode_id = ?";
        $stmt = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $episode_id);
        mysqli_stmt_execute($stmt);
        return ["success" => true, "action" => "unliked"];
    } else {
        // Like
        $insert_query = "INSERT INTO likes (user_id, episode_id, created_at) VALUES (?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $episode_id);
        mysqli_stmt_execute($stmt);
        return ["success" => true, "action" => "liked"];
    }
}

function isEpisodeLiked($user_id, $episode_id) {
    global $conn;
    
    $query = "SELECT * FROM likes WHERE user_id = ? AND episode_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $episode_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return mysqli_num_rows($result) > 0;
}

function getEpisodeById($id) {
    global $conn;
    
    $query = "SELECT e.*, p.title as podcast_title, p.host, p.cover_image 
              FROM episodes e 
              JOIN podcasts p ON e.podcast_id = p.id 
              WHERE e.id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if(mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    
    return null;
}

// Update listen count
function incrementListenCount($episode_id) {
    global $conn;
    
    $query = "UPDATE episodes SET listens = listens + 1 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $episode_id);
    return mysqli_stmt_execute($stmt);
}
?>
