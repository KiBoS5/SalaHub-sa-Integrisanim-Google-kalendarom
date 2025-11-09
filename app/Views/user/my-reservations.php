<!DOCTYPE html>
<html lang="sr">
<head>
  <meta charset="UTF-8">
  <title>Moje rezervacije | SalaHub</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

  <?php include __DIR__ . '/../layout/user-sidebar.php'; ?>

  <div class="flex-1 p-8">
    <h1 class="text-2xl font-bold text-blue-800 mb-6"> Moje rezervacije</h1>

<form method="GET" class="bg-white p-4 rounded shadow mb-6 flex flex-wrap gap-4 items-end">

  <!-- Filtriraj po sali -->
  <div>
    <label class="block text-sm text-gray-700">Sala</label>
    <input type="text" name="sala" value="<?= htmlspecialchars($filters['sala'] ?? '') ?>"
           class="p-2 border rounded w-48" placeholder="npr. Sala A">
  </div>

  <!-- Datum od -->
  <div>
    <label class="block text-sm text-gray-700">Datum od</label>
    <input type="date" name="od" value="<?= htmlspecialchars($filters['od'] ?? '') ?>"
           class="p-2 border rounded w-48">
  </div>

  <!-- Datum do -->
  <div>
    <label class="block text-sm text-gray-700">Datum do</label>
    <input type="date" name="do" value="<?= htmlspecialchars($filters['do'] ?? '') ?>"
           class="p-2 border rounded w-48">
  </div>

  <!-- Online / Offline -->
  <div>
    <label class="block text-sm text-gray-700">Tip sastanka</label>
    <select name="online" class="p-2 border rounded w-48">
      <option value="">Svi</option>
      <option value="1" <?= (($_GET['online'] ?? '') === '1') ? 'selected' : '' ?>>Online</option>
      <option value="0" <?= (($_GET['online'] ?? '') === '0') ? 'selected' : '' ?>>U prostoriji</option>
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
  <thead>
    <tr class="bg-gray-200 text-gray-700">
      <th class="p-3 text-left">Sala</th>
      <th class="p-3 text-left">Datum</th>
      <th class="p-3 text-left">Trajanje (sati)</th>
      <th class="p-3 text-left">Online sastanak</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($rezervacije)): ?>
      <?php foreach ($rezervacije as $r): ?>
        <tr class="border-b hover:bg-gray-50">
          <td class="p-3 font-semibold"><?= htmlspecialchars($r['sala_naziv']) ?></td>
          <td class="p-3"><?= date('d.m.Y H:i', strtotime($r['datum'])) ?></td>
          <td class="p-3"><?= htmlspecialchars($r['trajanje']) ?></td>
          <td class="p-3"><?= $r['Online'] ? 'DA' : 'NE' ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="4" class="p-3 text-center text-gray-500">Nema aktivnih rezervacija.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<!-- Paginacija -->
<?php if ($pages > 1): ?>
  <div class="mt-6 flex justify-center space-x-2">
    <?php for ($i = 1; $i <= $pages; $i++): ?>
      <a href="?page=<?= $i ?>"
         class="px-3 py-1 border rounded <?= $i == $page ? 'bg-blue-600 text-white' : 'bg-white text-blue-600 hover:bg-blue-100' ?>">
        <?= $i ?>
      </a>
    <?php endfor; ?>
  </div>
<?php endif; ?>


  </div>

</body>
</html>
