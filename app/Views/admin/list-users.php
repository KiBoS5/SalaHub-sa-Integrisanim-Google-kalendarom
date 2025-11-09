<!DOCTYPE html>
<html lang="sr">
<head>
  <meta charset="UTF-8">
  <title>Lista korisnika | SalaHub</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
tr.neaktivan {
  background-color: #f5f5f5;
  opacity: 0.6;
}
</style>

</head>
<body class="bg-gray-100 flex">

  <?php include __DIR__ . '/../layout/sidebar.php'; ?>

  <div class="flex-1 p-8">
    <h1 class="text-2xl font-bold text-blue-800 mb-6"> Lista korisnika</h1>

<form method="GET" class="mb-6 flex flex-wrap gap-4 items-end">
  <div>
    <label class="block text-sm text-gray-700">Sektor</label>
    <select name="sektor" class="p-2 border rounded w-48">
      <option value="">-- Svi sektori --</option>
      <option value="IT" <?= (($_GET['sektor'] ?? '') === 'IT') ? 'selected' : '' ?>>IT</option>
      <option value="HR" <?= (($_GET['sektor'] ?? '') === 'HR') ? 'selected' : '' ?>>HR</option>
      <option value="Marketing" <?= (($_GET['sektor'] ?? '') === 'Marketing') ? 'selected' : '' ?>>Marketing</option>
      <option value="Prodaja" <?= (($_GET['sektor'] ?? '') === 'Prodaja') ? 'selected' : '' ?>>Prodaja</option>
    </select>
  </div>

  <div>
    <label class="block text-sm text-gray-700">Uloga</label>
    <select name="uloga" class="p-2 border rounded w-48">
      <option value="">Sve</option>
      <option value="admin" <?= (($_GET['uloga'] ?? '') === 'admin') ? 'selected' : '' ?>>Admin</option>
      <option value="user" <?= (($_GET['uloga'] ?? '') === 'user') ? 'selected' : '' ?>>Korisnik</option>
    </select>
  </div>

  <div>
    <label class="block text-sm text-gray-700">Ime / Email</label>
    <input type="text" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
           placeholder="Pretraga..." class="p-2 border rounded w-48">
  </div>

  <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
     Filtriraj
  </button>
</form>


    <table class="min-w-full bg-white rounded shadow">
      <thead class="bg-gray-200 text-gray-700">
        <tr>
          <th class="p-3 text-left">ID</th>
          <th class="p-3 text-left">Ime</th>
          <th class="p-3 text-left">Prezime</th>
          <th class="p-3 text-left">Email</th>
          <th class="p-3 text-left">Telefon</th>
          <th class="p-3 text-left">Sektor</th>
          <th class="p-3 text-left">Uloga</th>
          <th class="p-3 text-center">Akcije</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $u): ?>
        <tr class="border-b hover:bg-gray-50" <?= ($u['status'] === 'neaktivan') ? 'neaktivan' : '' ?>">
          <td class="p-3"><?= $u['id'] ?></td>
          <td class="p-3"><?= htmlspecialchars($u['ime']) ?></td>
          <td class="p-3"><?= htmlspecialchars($u['Prezime']) ?></td>
          <td class="p-3"><?= htmlspecialchars($u['email']) ?></td>
          <td class="p-3"><?= htmlspecialchars($u['Telefon']) ?></td>
          <td class="p-3"><?= htmlspecialchars($u['Sektor']) ?></td>
          <td class="p-3"><?= htmlspecialchars($u['uloga']) ?></td>
          <td class="p-3 text-center space-x-2">
  <!-- Izmena -->
  <a href="<?= BASE_URL ?>admin/edit-user?id=<?= $u['id'] ?>"
     class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition">
     Izmeni
  </a>

  <!-- Brisanje -->
  <a href="<?= BASE_URL ?>admin/delete-user?id=<?= $u['id'] ?>"
     onclick="return confirm('Da li ste sigurni da želite obrisati ovog korisnika?')"
     class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">
     Obriši
  </a>

  <!-- Deaktivacija -->
  <?php if (($u['status'] ?? 'aktivan') !== 'neaktivan'): ?>
    <a href="<?= BASE_URL ?>admin/deactivate-user?id=<?= $u['id'] ?>"
       class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
       Deaktiviraj
    </a>
  <?php else: ?>
    <span class="px-3 py-1 bg-gray-300 text-gray-700 rounded">Deaktiviran</span>
  <?php endif; ?>
</td>

        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="mt-6 flex justify-center space-x-2">
      <?php for ($i = 1; $i <= $pages; $i++): ?>
        <a href="?page=<?= $i ?>"
           class="px-3 py-1 border rounded <?= $i == $page ? 'bg-blue-600 text-white' : 'bg-white text-blue-600 hover:bg-blue-100' ?>">
          <?= $i ?>
        </a>
      <?php endfor; ?>
    </div>
  </div>
</body>
</html>
