<?php
if (isset($_SESSION['user_id'])): ?>
            </main>
        </div>
    </div>
<?php endif; ?>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Script -->
    <script src="<?php echo isset($_SESSION['user_id']) ? '../../' : '../'; ?>public/js/script.js"></script>
    
    <footer class="bg-light text-center py-3 mt-5 border-top">
        <div class="container-fluid">
            <p class="text-muted mb-0">
                &copy; <?php echo date('Y'); ?> Buku Tamu Digital - SMK TI Airlangga
            </p>
        </div>
    </footer>
</body>
</html>