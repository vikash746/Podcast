<?php
$featured_podcast = getFeaturedPodcast();
$trending_podcasts = getTrendingPodcasts();
$recent_episodes = getRecentEpisodes();
$categories = getCategories();
?>

<!-- Featured Podcast -->
<div class="rounded-xl overflow-hidden bg-gradient-to-r from-purple-600/90 to-indigo-700 relative">
    <?php if($featured_podcast): ?>
    <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('assets/images/podcasts/<?php echo $featured_podcast['cover_image']; ?>')"></div>
    <div class="relative z-10 p-6 md:p-8 flex flex-col md:flex-row items-center gap-6 md:gap-10">
        <img 
            src="assets/images/podcasts/<?php echo $featured_podcast['cover_image']; ?>" 
            alt="<?php echo $featured_podcast['title']; ?>" 
            class="w-40 h-40 rounded-lg shadow-xl"
        >
        <div class="flex-1 text-white">
            <div class="flex items-center gap-2 mb-1">
                <span class="bg-white/20 backdrop-blur-sm text-xs px-3 py-1 rounded-full">
                    <?php echo $featured_podcast['category']; ?>
                </span>
                <div class="flex items-center gap-1">
                    <i class="fas fa-star text-yellow-400"></i>
                    <span class="text-xs font-medium"><?php echo number_format($featured_podcast['rating'], 1); ?></span>
                </div>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold mb-2"><?php echo $featured_podcast['title']; ?></h2>
            <p class="text-white/80 text-sm md:text-base mb-4 line-clamp-2 md:line-clamp-3">
                <?php echo $featured_podcast['description']; ?>
            </p>
            <p class="text-white/90 text-sm mb-4">Hosted by <span class="font-semibold"><?php echo $featured_podcast['host']; ?></span></p>
            <div class="flex flex-wrap gap-3">
                <a href="index.php?page=podcast&id=<?php echo $featured_podcast['id']; ?>" class="inline-flex items-center gap-2 bg-white text-purple-600 hover:bg-white/90 px-4 py-2 rounded font-medium transition-colors">
                    <i class="fas fa-play-circle"></i>
                    Play Latest
                </a>
                
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="relative z-10 p-6 md:p-8 text-center text-white">
        <h2 class="text-2xl font-bold">No Featured Podcast</h2>
        <p>Check back later for our featured content</p>
    </div>
    <?php endif; ?>
</div>

<!-- Categories -->
<div class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-900">Categories</h2>
        <a href="index.php?page=categories" class="text-purple-600 flex items-center gap-1 hover:underline">
            View all <i class="fas fa-chevron-right text-xs"></i>
        </a>
    </div>
    
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
        <?php foreach($categories as $category): ?>
        <a 
            href="index.php?page=category&id=<?php echo $category['id']; ?>" 
            class="flex flex-col items-center p-4 bg-white rounded-lg border border-gray-100 hover:border-purple-600/30 hover:shadow-md transition-all duration-200"
        >
            <div class="w-12 h-12 bg-purple-600/10 rounded-full flex items-center justify-center mb-2">
                <i class="<?php echo $category['icon']; ?> text-purple-600"></i>
            </div>
            <span class="text-gray-800 text-sm font-medium"><?php echo $category['name']; ?></span>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Trending Podcasts -->
<div class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-900">Trending Now</h2>
        <a href="index.php?page=trending" class="text-purple-600 flex items-center gap-1 hover:underline">
            View all <i class="fas fa-chevron-right text-xs"></i>
        </a>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        <?php foreach($trending_podcasts as $podcast): ?>
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden group">
            <div class="relative">
                <img 
                    src="assets/images/podcasts/<?php echo $podcast['cover_image']; ?>" 
                    alt="<?php echo $podcast['title']; ?>" 
                    class="w-full aspect-square object-cover"
                >
                <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <a href="index.php?page=podcast&id=<?php echo $podcast['id']; ?>" class="p-4 rounded-full bg-white/20 hover:bg-white/30 backdrop-blur-sm transition-colors">
                        <i class="fas fa-play text-white"></i>
                    </a>
                </div>
                <div class="absolute top-2 right-2 bg-purple-600/80 text-white text-xs py-1 px-2 rounded-full backdrop-blur-sm">
                    <?php echo $podcast['category']; ?>
                </div>
            </div>
            <div class="p-3">
                <h3 class="font-medium text-gray-900 truncate"><?php echo $podcast['title']; ?></h3>
                <p class="text-sm text-gray-500 truncate">By <?php echo $podcast['host']; ?></p>
                <p class="text-xs text-gray-400 mt-1"><?php echo $podcast['episode_count']; ?> episodes</p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Recent Episodes -->
<div class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-900">Recent Episodes</h2>
        <a href="index.php?page=recent" class="text-purple-600 flex items-center gap-1 hover:underline">
            View all <i class="fas fa-chevron-right text-xs"></i>
        </a>
    </div>
    
    <div class="space-y-3">
        <?php foreach($recent_episodes as $episode): ?>
        <div class="bg-white rounded-lg shadow-md hover:bg-gray-50 flex">
            <img 
                src="assets/images/podcasts/<?php echo $episode['cover_image']; ?>" 
                alt="<?php echo $episode['title']; ?>" 
                class="w-20 h-20 object-cover"
            >
            <div class="flex-1 p-3 flex flex-col justify-between">
                <div>
                    <h3 class="font-medium text-gray-900 truncate"><?php echo $episode['title']; ?></h3>
                    <p class="text-sm text-gray-500 truncate"><?php echo $episode['podcast_title']; ?> • <?php echo $episode['host']; ?></p>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center text-xs text-gray-500 space-x-3">
                        <span class="flex items-center gap-1">
                            <i class="fas fa-clock"></i> <?php echo $episode['duration']; ?>
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fas fa-headphones"></i> <?php echo number_format($episode['listens']); ?> listens
                        </span>
                    </div>
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="index.php?page=listen&id=<?php echo $episode['id']; ?>" class="p-2 rounded-full bg-purple-600/10 hover:bg-purple-600/20 transition-colors">
                        <i class="fas fa-play text-purple-600"></i>
                    </a>
                    <?php else: ?>
                    <a href="index.php?page=login" class="p-2 rounded-full bg-purple-600/10 hover:bg-purple-600/20 transition-colors">
                        <i class="fas fa-play text-purple-600"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
