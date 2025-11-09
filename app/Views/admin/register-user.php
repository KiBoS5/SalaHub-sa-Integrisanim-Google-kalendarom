<!DOCTYPE html>
<html lang="sr">
<head>
  <meta charset="UTF-8">
  <title>Registracija korisnika | SalaHub</title>
  <script src="https://cdn.tailwindcss.com"></script>
 

</head>
<body class="bg-gray-100 flex">

  <?php include __DIR__ . '/../layout/sidebar.php'; ?>

  <div class="flex-1 p-8">
    <h1 class="text-2xl font-bold text-blue-800 mb-6"> Registruj korisnika</h1>
   <?php if (!empty($error)): ?>
     <div class="mb-5 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded text-sm">
       <?= htmlspecialchars($error) ?>
     </div>
   <?php endif; ?>

<?php
$isEdit = isset($user);
$actionUrl = $isEdit ? BASE_URL . 'admin/edit-user' : BASE_URL . 'admin/register-user';
?>
    <form method="POST" action="<?= $actionUrl ?>"
          class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg space-y-5">


      <?php if ($isEdit): ?>
      <input type="hidden" name="id" value="<?= $user['id'] ?>">
      <?php endif; ?>

      <!-- Ime -->
      <div>
        <label class="block text-gray-700 mb-1 font-medium">Ime</label>
        <input type="text" name="ime" required
               class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400">
      </div>

      <!-- Prezime -->
      <div>
        <label class="block text-gray-700 mb-1 font-medium">Prezime</label>
        <input type="text" name="prezime" required
               class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400">
      </div>

      <!-- Email -->
      <div>
        <label class="block text-gray-700 mb-1 font-medium">Email</label>
        <input type="email" name="email" required
               class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400">
      </div>

      <!-- Telefon -->
      <div>
        <label class="block text-gray-700 mb-1 font-medium">Telefon</label>
        <input type="text" name="telefon" placeholder="npr. 0651234567"
               class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400">
      </div>

      <!-- Lozinka -->
      <div>
        <label class="block text-gray-700 mb-1 font-medium">Lozinka</label>
        <input type="password" name="lozinka" required minlength="6"
               class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400">
      </div>

      <!-- Potvrda lozinke -->
      <div>
        <label class="block text-gray-700 mb-1 font-medium">Potvrdi lozinku</label>
        <input type="password" name="lozinka_potvrda" required minlength="6"
               class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400">
      </div>

      <!-- Sektor -->
      <div>
        <label class="block text-gray-700 mb-1 font-medium">Sektor</label>
        <select name="sektor" required
                class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400">
          <option value="">-- Izaberi sektor --</option>
          <option value="IT">IT</option>
          <option value="HR">HR</option>
          <option value="Marketing">Marketing</option>
          <option value="Prodaja">Prodaja</option>
          <option value="Finansije">Finansije</option>
        </select>
      </div>

      <!-- Uloga -->
      <div>
        <label class="block text-gray-700 mb-1 font-medium">Uloga</label>
        <select name="uloga"
                class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400">
          <option value="user">Korisnik</option>
          <option value="admin">Administrator</option>
        </select>
      </div>

      <!-- Dugme -->
      <div class="pt-4">
        <button type="submit"
                class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition">
           <?= $isEdit ? 'Sačuvaj izmene' : 'Kreiraj korisnika' ?>
        </button>
      </div>

    </form>
  </div>
</body>
</html>
