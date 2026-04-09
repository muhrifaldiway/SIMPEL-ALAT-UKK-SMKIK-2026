<?php if (isset($_SESSION['flash'])): ?>
    <div class="swal-overlay show" id="customAlert">
        <div class="swal-modal">
            <div class="swal-icon <?= $_SESSION['flash']['type']; ?>">
                <?php 
                    if($_SESSION['flash']['type'] == 'success') echo '✓';
                    elseif($_SESSION['flash']['type'] == 'error') echo '✗';
                    else echo '!'; // Untuk warning
                ?>
            </div>
            
            <h3 class="swal-title"><?= $_SESSION['flash']['title']; ?></h3>
            <p class="swal-text"><?= $_SESSION['flash']['message']; ?></p>
            
            <button class="swal-btn <?= $_SESSION['flash']['type'] == 'error' ? 'error' : ''; ?>" 
                    onclick="document.getElementById('customAlert').classList.remove('show')">
                OK Mengerti
            </button>
        </div>
    </div>
    
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>