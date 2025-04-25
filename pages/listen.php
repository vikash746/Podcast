<?php
if(!isset($_GET['id'])) {
    echo '<div class="text-center py-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Episode Not Found</h2>
            <p class="text-gray-600">Please select a valid episode</p>
            <a href="index.php" class="mt-4 inline-block px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                Go Home
            </a>
          </div>';
    exit;
}

$episode_id = $_GET['id'];
$episode = getEpisodeById($episode_id);

if(!$episode) {
    echo '<div class="text-center py-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Episode Not Found</h2>
            <p class="text-gray-600">The episode you\'re looking for doesn\'t exist</p>
            <a href="index.php" class="mt-4 inline-block px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                Go Home
            </a>
          </div>';
    exit;
}

// Update listen count
incrementListenCount($episode_id);

// Check if user has liked this episode
$isLiked = false;
if(isset($_SESSION['user_id'])) {
    $isLiked = isEpisodeLiked($_SESSION['user_id'], $episode_id);
}

// Handle like/unlike
if(isset($_POST['toggle_like']) && isset($_SESSION['user_id'])) {
    $result = toggleLike($_SESSION['user_id'], $episode_id);
    if($result['success']) {
        $isLiked = ($result['action'] === 'liked');
    }
}
?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Episode Details -->
    <div class="md:col-span-2">
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex flex-col sm:flex-row gap-5">
                    <img src="assets/images/podcasts/<?php echo $episode['cover_image']; ?>" alt="<?php echo $episode['title']; ?>" class="w-32 h-32 rounded-lg shadow-md">
                    
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold mb-1"><?php echo $episode['title']; ?></h1>
                        <a href="index.php?page=podcast&id=<?php echo $episode['podcast_id']; ?>" class="text-purple-600 hover:underline mb-3 inline-block">
                            <?php echo $episode['podcast_title']; ?>
                        </a>
                        <p class="text-gray-700 mb-2">Hosted by <?php echo $episode['host']; ?></p>
                        
                        <div class="flex flex-wrap items-center text-sm text-gray-500 gap-x-4 gap-y-2 mb-4">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-calendar-alt"></i>
                                <?php echo date('M d, Y', strtotime($episode['release_date'])); ?>
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-clock"></i>
                                <?php echo $episode['duration']; ?>
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-headphones"></i>
                                <?php echo number_format($episode['listens']); ?> listens
                            </span>
                        </div>
                        
                        <div class="flex flex-wrap gap-2">
                            <button id="playNowBtn" class="inline-flex items-center gap-2 bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors">
                                <i class="fas fa-play"></i> Play Now
                            </button>
                            
                            <form method="post" action="" class="inline">
                                <button 
                                    type="submit" 
                                    name="toggle_like" 
                                    class="inline-flex items-center gap-2 <?php echo $isLiked ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?> px-4 py-2 rounded-md transition-colors"
                                >
                                    <i class="<?php echo $isLiked ? 'fas' : 'far'; ?> fa-heart"></i> 
                                    <?php echo $isLiked ? 'Liked' : 'Like'; ?>
                                </button>
                            </form>
                            
                            <button class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition-colors">
                                <i class="fas fa-share-alt"></i> Share
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Episode Description -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">Episode Description</h2>
                <div class="prose max-w-none text-gray-700">
                    <p><?php echo $episode['description']; ?></p>
                </div>
                
                <h3 class="text-lg font-bold mt-6 mb-2">Show Notes</h3>
                <div class="prose max-w-none text-gray-700">
                    <?php 
                    // Show notes could be stored in the database or generated
                    $show_notes = !empty($episode['show_notes']) ? $episode['show_notes'] : "No show notes available for this episode.";
                    echo $show_notes;
                    ?>
                </div>
            </div>
        </div>
        
        <!-- Comments Section (if you want to add this) -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">Comments</h2>
                <!-- Comments implementation would go here -->
                <p class="text-gray-500 text-center py-4">Comments feature coming soon!</p>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="md:col-span-1">
        <!-- More from this podcast -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <div class="p-6">
                <h2 class="text-lg font-bold mb-4">More from this Podcast</h2>
                
                <?php 
                $more_episodes = getEpisodesByPodcastId($episode['podcast_id']);
                // Limit to 5 episodes and exclude current one
                $counter = 0;
                ?>
                
                
                
                <a href="index.php?page=podcast&id=<?php echo $episode['podcast_id']; ?>" class="text-purple-600 hover:underline text-sm flex items-center justify-center mt-4">
                    View all episodes <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>
        
        <!-- Similar Podcasts -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-lg font-bold mb-4">You May Also Like</h2>
                
                <?php 
                // Get similar podcasts (for demo purposes, just get trending)
                $similar_podcasts = getTrendingPodcasts(3);
                ?>
                
             
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set up the audio player for the current episode
    const playNowBtn = document.getElementById('playNowBtn');
    const audioElement = document.getElementById('audioElement');
    const episodeTitle = document.getElementById('episodeTitle');
    const podcastTitle = document.getElementById('podcastTitle');
    const episodeImage = document.getElementById('episodeImage');
    const playIcon = document.getElementById('playIcon');
    const pauseIcon = document.getElementById('pauseIcon');
    
    if(playNowBtn && audioElement) {
        playNowBtn.addEventListener('click', function() {
            // Set the audio source (in a real app, this would be from the database)
            audioElement.src = "assets/audio/<?php echo $episode['audio_file']; ?>";
            
            // Update player UI
            episodeTitle.textContent = "<?php echo addslashes($episode['title']); ?>";
            podcastTitle.textContent = "<?php echo addslashes($episode['podcast_title']); ?>";
            episodeImage.src = "assets/images/podcasts/<?php echo $episode['cover_image']; ?>";
            
            // Play the audio
            audioElement.play();
            
            // Toggle play/pause icons
            playIcon.classList.add('hidden');
            pauseIcon.classList.remove('hidden');
        });
    }
});
</script>
