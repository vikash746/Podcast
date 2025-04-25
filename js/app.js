document.addEventListener('DOMContentLoaded', function() {
    // Player elements
    const audioElement = document.getElementById('audioElement');
    const playPauseBtn = document.getElementById('playPauseBtn');
    const playIcon = document.getElementById('playIcon');
    const pauseIcon = document.getElementById('pauseIcon');
    const progressBar = document.getElementById('progressBar');
    const progressFill = document.getElementById('progressFill');
    const currentTimeEl = document.getElementById('currentTime');
    const durationEl = document.getElementById('duration');
    const volumeSlider = document.getElementById('volumeSlider');
    const volumeIcon = document.getElementById('volumeIcon');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const shuffleBtn = document.getElementById('shuffleBtn');
    const repeatBtn = document.getElementById('repeatBtn');
    
    // Player state
    let isShuffling = false;
    let repeatMode = 0; // 0: no repeat, 1: repeat all, 2: repeat one
    
    // Format time (converts seconds to MM:SS format)
    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    }
    
    // Initialize player
    if(audioElement) {
        // Play/Pause functionality
        if(playPauseBtn) {
            playPauseBtn.addEventListener('click', function() {
                if(audioElement.paused) {
                    audioElement.play();
                    playIcon.classList.add('hidden');
                    pauseIcon.classList.remove('hidden');
                } else {
                    audioElement.pause();
                    playIcon.classList.remove('hidden');
                    pauseIcon.classList.add('hidden');
                }
            });
        }
        
        // Update progress bar and time while playing
        audioElement.addEventListener('timeupdate', function() {
            if(isNaN(audioElement.duration)) return;
            
            const percent = (audioElement.currentTime / audioElement.duration) * 100;
            
            if(progressFill) {
                progressFill.style.width = `${percent}%`;
            }
            
            if(currentTimeEl) {
                currentTimeEl.textContent = formatTime(audioElement.currentTime);
            }
        });
        
        // When duration is available, update the duration display
        audioElement.addEventListener('loadedmetadata', function() {
            if(durationEl) {
                durationEl.textContent = formatTime(audioElement.duration);
            }
        });
        
        // When audio ends
        audioElement.addEventListener('ended', function() {
            playIcon.classList.remove('hidden');
            pauseIcon.classList.add('hidden');
            
            // Handle repeat modes
            if(repeatMode === 2) {
                // Repeat one
                audioElement.currentTime = 0;
                audioElement.play();
            } else if(repeatMode === 1) {
                // Repeat all - would need playlist implementation
                // For now, just restart
                audioElement.currentTime = 0;
                audioElement.play();
            }
        });
        
        // Click on progress bar to seek
        if(progressBar) {
            progressBar.addEventListener('click', function(e) {
                if(isNaN(audioElement.duration)) return;
                
                const rect = progressBar.getBoundingClientRect();
                const pos = (e.clientX - rect.left) / rect.width;
                audioElement.currentTime = pos * audioElement.duration;
            });
        }
        
        // Volume control
        if(volumeSlider) {
            volumeSlider.addEventListener('input', function() {
                const volume = volumeSlider.value / 100;
                audioElement.volume = volume;
                
                // Update volume icon
                if(volumeIcon) {
                    if(volume === 0) {
                        volumeIcon.className = 'fas fa-volume-mute';
                    } else if(volume < 0.5) {
                        volumeIcon.className = 'fas fa-volume-down';
                    } else {
                        volumeIcon.className = 'fas fa-volume-up';
                    }
                }
            });
        }
        
        // Shuffle button
        if(shuffleBtn) {
            shuffleBtn.addEventListener('click', function() {
                isShuffling = !isShuffling;
                shuffleBtn.classList.toggle('text-purple-600', isShuffling);
                shuffleBtn.classList.toggle('text-gray-600', !isShuffling);
            });
        }
        
        // Repeat button
        if(repeatBtn) {
            repeatBtn.addEventListener('click', function() {
                repeatMode = (repeatMode + 1) % 3;
                
                if(repeatMode === 0) {
                    // No repeat
                    repeatBtn.innerHTML = '<i class="fas fa-redo-alt"></i>';
                    repeatBtn.classList.remove('text-purple-600');
                    repeatBtn.classList.add('text-gray-600');
                } else if(repeatMode === 1) {
                    // Repeat all
                    repeatBtn.innerHTML = '<i class="fas fa-redo-alt"></i>';
                    repeatBtn.classList.add('text-purple-600');
                    repeatBtn.classList.remove('text-gray-600');
                } else {
                    // Repeat one
                    repeatBtn.innerHTML = '<i class="fas fa-redo-alt"></i><span class="absolute text-[8px] top-0 right-0 bg-purple-600 text-white rounded-full w-3 h-3 flex items-center justify-center">1</span>';
                    repeatBtn.classList.add('text-purple-600');
                    repeatBtn.classList.remove('text-gray-600');
                }
            });
        }
    }
    
    // Mobile menu toggle
    const menuToggle = document.querySelector('.fa-bars');
    if(menuToggle) {
        const mobileMenu = document.createElement('div');
        mobileMenu.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 hidden transition-opacity';
        mobileMenu.innerHTML = `
            <div class="h-full w-64 bg-white shadow-lg overflow-y-auto transform transition-transform -translate-x-full">
                <div class="p-4 border-b">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-xl font-bold text-purple-600">Pod</span>
                            <span class="text-xl font-bold text-gray-800">Play</span>
                        </div>
                        <button class="mobile-close p-2 rounded-full hover:bg-gray-100">
                            <i class="fas fa-times text-gray-600"></i>
                        </button>
                    </div>
                </div>
                <nav class="p-4">
                    <ul class="space-y-2">
                        <li><a href="index.php" class="block p-2 rounded hover:bg-purple-50 hover:text-purple-600 transition-colors">Home</a></li>
                        <li><a href="index.php?page=categories" class="block p-2 rounded hover:bg-purple-50 hover:text-purple-600 transition-colors">Discover</a></li>
                        <li><a href="index.php?page=library" class="block p-2 rounded hover:bg-purple-50 hover:text-purple-600 transition-colors">Library</a></li>
                        <li><a href="index.php?page=subscriptions" class="block p-2 rounded hover:bg-purple-50 hover:text-purple-600 transition-colors">Subscriptions</a></li>
                    </ul>
                </nav>
            </div>
        `;
        
        document.body.appendChild(mobileMenu);
        
        menuToggle.addEventListener('click', function() {
            mobileMenu.classList.remove('hidden');
            setTimeout(() => {
                mobileMenu.querySelector('div').classList.remove('-translate-x-full');
            }, 10);
        });
        
        const closeBtn = mobileMenu.querySelector('.mobile-close');
        closeBtn.addEventListener('click', function() {
            mobileMenu.querySelector('div').classList.add('-translate-x-full');
            setTimeout(() => {
                mobileMenu.classList.add('hidden');
            }, 300);
        });
    }
});
