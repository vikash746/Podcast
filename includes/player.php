<div id="podcastPlayer" class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 py-3 px-4 shadow-lg z-50">
    <div class="container mx-auto">
        <!-- Progress bar -->
        <div class="mb-3 px-2">
            <div class="h-1 bg-gray-200 rounded-full overflow-hidden cursor-pointer" id="progressBar">
                <div class="h-full bg-purple-600 rounded-full transition-all duration-300" id="progressFill" style="width: 0%"></div>
            </div>
            <div class="flex justify-between text-xs text-gray-500 mt-1">
                <span id="currentTime">0:00</span>
                <span id="duration">0:00</span>
            </div>
        </div>
        
        <div class="flex items-center justify-between">
            <!-- Episode info -->
            <div class="flex items-center space-x-3 w-1/4">
                <img id="episodeImage" src="assets/images/placeholder.jpg" alt="Episode" class="w-12 h-12 rounded">
                <div class="truncate">
                    <h4 id="episodeTitle" class="text-sm font-medium truncate">Select an Episode</h4>
                    <p id="podcastTitle" class="text-xs text-gray-500 truncate">-</p>
                </div>
            </div>
            
            <!-- Player controls -->
            <div class="flex items-center justify-center space-x-4 w-2/4">
                <button class="p-2 rounded-full hover:bg-purple-100 transition-colors duration-200 text-gray-600" id="shuffleBtn">
                    <i class="fas fa-random"></i>
                </button>
                <button class="p-2 rounded-full hover:bg-purple-100 transition-colors duration-200 text-gray-600" id="prevBtn">
                    <i class="fas fa-step-backward"></i>
                </button>
                <button id="playPauseBtn" class="p-3 rounded-full bg-purple-600 text-white hover:bg-purple-700 transition-colors duration-200">
                    <i class="fas fa-play" id="playIcon"></i>
                    <i class="fas fa-pause hidden" id="pauseIcon"></i>
                </button>
                <button class="p-2 rounded-full hover:bg-purple-100 transition-colors duration-200 text-gray-600" id="nextBtn">
                    <i class="fas fa-step-forward"></i>
                </button>
                <button class="p-2 rounded-full hover:bg-purple-100 transition-colors duration-200 text-gray-600" id="repeatBtn">
                    <i class="fas fa-redo-alt"></i>
                </button>
            </div>
            
            <!-- Volume control -->
            <div class="flex items-center space-x-2 w-1/4 justify-end">
                <button class="p-2 rounded-full hover:bg-purple-100 transition-colors duration-200 text-gray-600" id="volumeBtn">
                    <i class="fas fa-volume-up" id="volumeIcon"></i>
                </button>
                <input type="range" id="volumeSlider" min="0" max="100" value="80" class="w-24 appearance-none h-1 rounded-full bg-gray-200 focus:outline-none">
            </div>
        </div>
    </div>
    
    <!-- Hidden audio element -->
    <audio id="audioElement"></audio>
</div>
