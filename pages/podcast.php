<?php
if(!isset($_GET['id'])) {
    echo '<div class="text-center py-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Podcast Not Found</h2>
            <p class="text-gray-600">Please select a valid podcast</p>
            <a href="index.php" class="mt-4 inline-block px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                Go Home
            </a>
          </div>';
    exit;
}

$podcast_id = $_GET['id'];
$podcast = getPodcastById($podcast_id);

if(!$podcast) {
    echo '<div class="text-center py-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Podcast Not Found</h2>
            <p class="text-gray-600">The podcast you\'re looking for doesn\'t exist</p>
            <a href="index.php" class="mt-4 inline-block px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                Go Home
            </a>
          </div>';
    exit;
}

$episodes = getEpisodesByPodcastId($podcast_id);
?>

<div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-purple-600 to-indigo-700 p-6">
        <div class="flex flex-col md:flex-row gap-6">
            <img src="assets/images/podcasts/<?php echo $podcast['cover_image']; ?>" alt="<?php echo $podcast['title']; ?>" class="w-40 h-40 rounded-lg shadow-lg">
            <div class="text-white">
                <h1 class="text-2xl md:text-3xl font-bold mb-2"><?php echo $podcast['title']; ?></h1>
                <p class="text-white/80 mb-1">Hosted by <?php echo $podcast['host']; ?></p>
                <div class="flex items-center gap-3 mb-4">
                    <span class="bg-white/20 text-xs px-2 py-1 rounded-full"><?php echo $podcast['category']; ?></span>
                    <div class="flex items-center">
                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                        <span><?php echo number_format($podcast['rating'], 1); ?></span>
                    </div>
                    <span><?php echo count($episodes); ?> episodes</span>
                </div>
                <p class="text-white/90 mb-4"><?php echo $podcast['description']; ?></p>
                <div class="flex gap-3">
                    
                    <button class="inline-flex items-center gap-2 bg-white/20 text-white px-4 py-2 rounded-md hover:bg-white/30 transition-colors">
                        <i class="fas fa-share-alt"></i> Share
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-md p-6">
    <h2 class="text-xl font-bold mb-4">All Episodes</h2>
    
    <?php if(empty($episodes)): ?>
    <div class="text-center py-10">
        <p class="text-gray-600">No episodes available yet</p>
    </div>
    <?php else: ?>
    <div class="space-y-4">
        <?php foreach($episodes as $index => $episode): ?>
        <div class="border-b border-gray-100 pb-4 last:border-0">
            <div class="flex gap-4">
                <div class="w-16 h-16 bg-gray-100 rounded-md flex items-center justify-center flex-shrink-0">
                    <span class="text-xl text-gray-500 font-medium">#<?php echo count($episodes) - $index; ?></span>
                </div>
                <div class="flex-1">
                    <h3 class="font-medium text-lg"><?php echo $episode['title']; ?></h3>
                    <p class="text-gray-600 text-sm mb-2 line-clamp-2"><?php echo $episode['description']; ?></p>
                    <div class="flex items-center text-sm text-gray-500 gap-4">
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
                </div>
                <div class="flex items-center">
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="index.php?page=listen&id=<?php echo $episode['id']; ?>" class="p-3 rounded-full bg-purple-600 text-white hover:bg-purple-700 transition-colors">
                        <i class="fas fa-play"></i>
                    </a>
                    <?php else: ?>
                    <a href="index.php?page=login" class="p-3 rounded-full bg-purple-600 text-white hover:bg-purple-700 transition-colors">
                        <i class="fas fa-play"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
