<?php
$title = "Login - Buku Tamu Digital";
require_once __DIR__ . '/../templates/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="text-center">
                    <i class="fas fa-book"></i> Login Buku Tamu Digital<br>
                    <small class="text-muted">SMK TI Airlangga</small>
                </h4>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="index.php?action=login">
                    <div class="mb-3">
                        <label for="username" class="form-label">
                            <i class="fas fa-user"></i> Username
                        </label>
                        <input type="text" class="form-control" id="username" name="username" required 
                               value="<?php echo $_POST['username'] ?? ''; ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>

                <hr>
                <div class="text-center">
                    <h6>Akun Demo:</h6>
                    <p class="mb-1">
                        <strong>Admin:</strong> admin / admin123
                    </p>
                    <p class="mb-0">
                        <strong>Staff:</strong> staff / staff123
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>