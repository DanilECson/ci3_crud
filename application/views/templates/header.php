<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo isset($title) ? $title . ' | CRUD App Test' : 'CRUD App Test'; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header class="bg-dark text-white py-3 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h4 mb-0">CRUD App Test</h1>
            </div>
            <nav>
                <?php if ($this->session->userdata('user_id') !== false): ?>
                    <span class="text-white mr-3">Hello, <?php echo htmlspecialchars($this->session->userdata('user_name'), ENT_QUOTES, 'UTF-8'); ?></span>
                    <a class="text-white mr-3" href="<?php echo site_url('dashboard'); ?>">Home</a>
                    <a class="text-white mr-3" href="<?php echo site_url('profile'); ?>">Profile</a>
                    <a class="text-white" href="<?php echo site_url('logout'); ?>">Logout</a>
                <?php else: ?>
                    <a class="text-white mr-3" href="<?php echo site_url('login'); ?>">Login</a>
                    <a class="text-white" href="<?php echo site_url('signup'); ?>">Sign Up</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="container">