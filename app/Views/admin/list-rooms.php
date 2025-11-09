<!DOCTYPE html>
<html lang="sr">
<head>
  <meta charset="UTF-8">
  <title>Lista sala | SalaHub</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
tr.deaktivna {
  background-color: #f5f5f5;
  opacity: 0.6;
}
</style>

</head>
<body class="bg-gray-100 flex">

  <?php include __DIR__ . '/../layout/sidebar.php'; ?>

  <div class="flex-1 p-8">
    <h1 class="text-2xl font-bold text-blue-800 mb-6"> Lista sala</h1>

<form method="GET" class="mb-6 flex flex-wrap gap-4 items-end">
  <div>
    <label class="block text-sm text-gray-700">Lokacija</label>
    <input type="text" name="lokacija" value="<?= htmlspecialchars($_GET['lokacija'] ?? '') ?>"
           class="p-2 border rounded w-48" placeholder="npr. Zgrada A">
  </div>

  <div>
    <label class="block text-sm text-gray-700">Status</label>
    <select name="status" class="p-2 border rounded w-48">
      <option value="">-- Svi statusi --</option>
      <option value="slobodna" <?= (($_GET['status'] ?? '') === 'slobodna') ? 'selected' : '' ?>>Slobodna</option>
      <option value="zauzeta" <?= (($_GET['status'] ?? '') === 'zauzeta') ? 'selected' : '' ?>>Zauzeta</option>
      <option value="neaktivna" <?= (($_GET['status'] ?? '') === 'neaktivna') ? 'selected' : '' ?>>Neaktivna</option>
    </select>
  </div>

  <div>
    <label class="block text-sm text-gray-700">Ima TV?</label>
    <select name="tv" class="p-2 border rounded w-24">
      <option value="">Sve</option>
      <option value="1" <?= (($_GET['tv'] ?? '') === '1') ? 'selected' : '' ?>>Da</option>
      <option value="0" <?= (($_GET['tv'] ?? '') === '0') ? 'selected' : '' ?>>Ne</option>
    </select>
  </div>

  <div>
    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
       Filtriraj
    </button>
  </div>
</form>


<table class="min-w-full bg-white rounded shadow">
  <thead class="bg-gray-200 text-gray-700">
    <tr>
      <th class="p-3 text-left">ID</th>
      <th class="p-3 text-left">Naziv</th>
      <th class="p-3 text-left">Lokacija</th>
      <th class="p-3 text-left">Kapacitet</th>
      <th class="p-3 text-left">TV</th>
      <th class="p-3 text-left">Projektor</th>
      <th class="p-3 text-left">Pametna tabla</th>
      <th class="p-3 text-left">Mikrofon</th>
      <th class="p-3 text-left">Kamera</th>
      <th class="p-3 text-left">Dodatna oprema</th>
      <th class="p-3 text-left">Status</th>
      <th class="p-3 text-left">Dostupna</th>
      <th class="p-3 text-center">Akcije</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rooms as $r): ?>
    <tr class="border-b hover:bg-gray-50 <?= ($r['Status'] === 'neaktivna') ? 'deaktivna' : '' ?>">

      <td class="p-3"><?= $r['id'] ?></td>
      <td class="p-3 font-semibold"><?= htmlspecialchars($r['naziv']) ?></td>
      <td class="p-3"><?= htmlspecialchars($r['Lokacija']) ?></td>
      <td class="p-3 text-center"><?= htmlspecialchars($r['kapacitet']) ?></td>

      <!-- Boolean vrednosti prikazane kao ikone -->
      <td class="p-3 text-center"><?= $r['TV'] ? 'DA' : 'NE' ?></td>
      <td class="p-3 text-center"><?= $r['Projektor'] ? 'DA' : 'NE' ?></td>
      <td class="p-3 text-center"><?= $r['PametnaTabla'] ? 'DA' : 'NE' ?></td>
      <td class="p-3 text-center"><?= $r['Mikrofon'] ? 'DA' : 'NE' ?></td>
      <td class="p-3 text-center"><?= $r['Kamera'] ? 'DA' : 'NE' ?></td>

      <!-- Oprema (textualno polje) -->
      <td class="p-3"><?= htmlspecialchars($r['Oprema'] ?? '-') ?></td>

      <!-- Status -->
      <td class="p-3">
        <?php
          $statusColor = match($r['Status']) {
            'slobodna' => 'text-green-600',
            'zauzeta' => 'text-red-600',
            'neaktivna' => 'text-gray-500',
            default => 'text-gray-700'
          };
        ?>
        <span class="font-semibold <?= $statusColor ?>">
          <?= ucfirst($r['Status']) ?>
        </span>
      </td>

      <!-- Dostupna -->
      <td class="p-3 text-center"><?= $r['dostupna'] ? 'DA' : 'NE' ?></td>

          <td class="p-3 text-center space-x-2">
  <!-- Izmena -->
  <a href="<?= BASE_URL ?>admin/edit-room?id=<?= $r['id'] ?>"
     class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition">
      Izmeni
  </a>

  <!-- Brisanje -->
  <a href="<?= BASE_URL ?>admin/delete-room?id=<?= $r['id'] ?>"
     onclick="return confirm('Da li ste sigurni da želite obrisati ovu salu?')"
     class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">
      Obriši
  </a>

  <!-- Deaktivacija -->
  <?php if ($r['Status'] !== 'neaktivna'): ?>
    <a href="<?= BASE_URL ?>admin/deactivate-room?id=<?= $r['id'] ?>"
       class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
        Deaktiviraj
    </a>
  <?php else: ?>
    <span class="px-3 py-1 bg-gray-300 text-gray-700 rounded">Deaktivirana</span>
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
