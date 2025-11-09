<!DOCTYPE html>
<html lang="sr">
<head>
  <meta charset="UTF-8">
  <title>SalaHub | Prijava</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

  <div class="bg-white p-8 rounded-lg shadow-lg w-96">
    <h1 class="text-2xl font-bold mb-4 text-center text-blue-700">SalaHub Login</h1>

    <?php if (!empty($error)): ?>
      <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-sm text-center">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="/SalaHub/public/login" class="space-y-4">
      <div>
        <label class="block text-gray-700">Email</label>
        <input type="email" name="email" class="w-full p-2 border rounded" required>
      </div>
      <div>
        <label class="block text-gray-700">Lozinka</label>
        <input type="password" name="password" class="w-full p-2 border rounded" required>
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
        Prijavi se
      </button>
    </form>
  </div>

</body>
</html>
