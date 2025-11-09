<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="sr">
<head>
  <meta charset="UTF-8">
  <title>Moj profil | SalaHub</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

  <?php
    // Uključi odgovarajući sidebar prema ulozi
    if ($_SESSION['user_role'] === 'admin') {
        include __DIR__ . '/layout/sidebar.php';
    } else {
        include __DIR__ . '/layout/user-sidebar.php';
    }
  ?>

  <div class="flex-1 p-10">
    <h1 class="text-3xl font-bold text-blue-700 mb-8">👤 Moj profil</h1>

    <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-lg">
      <div class="flex items-center gap-6 mb-6">
        <div class="w-20 h-20 bg-blue-500 text-white rounded-full flex items-center justify-center text-3xl font-bold">
          <?= strtoupper(substr($user['ime'], 0, 1)) ?>
        </div>
        <div>
          <p class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($user['ime']) ?></p>
          <p class="text-gray-500"><?= htmlspecialchars($user['email']) ?></p>
          <p class="text-sm text-gray-400 mt-1"><?= htmlspecialchars($user['uloga']) ?></p>
        </div>
      </div>

      <div class="space-y-4">
        <p><span class="font-semibold text-gray-700">ID korisnika:</span> <?= $user['id'] ?></p>
        <p><span class="font-semibold text-gray-700">Email:</span> <?= htmlspecialchars($user['email']) ?></p>
        <p><span class="font-semibold text-gray-700">Uloga:</span> <?= htmlspecialchars($user['uloga']) ?></p>
      </div>

      <div class="mt-8">
        <a href="<?= BASE_URL ?>logout" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Odjavi se</a>
      </div>
    </div>
  </div>

</body>
</html>
