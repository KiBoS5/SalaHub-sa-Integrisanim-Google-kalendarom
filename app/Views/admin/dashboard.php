<!DOCTYPE html>
<html lang="sr">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | SalaHub</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

  <?php include __DIR__ . '/../layout/sidebar.php'; ?>

  <div class="flex-1 p-8">
    <h1 class="text-2xl font-bold text-blue-800 mb-6"> Pregled rezervacija</h1>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
      <table class="min-w-full border border-gray-200">
        <thead class="bg-blue-600 text-white">
          <tr>
            <th class="p-3 text-left">Korisnik</th>
            <th class="p-3 text-left">Sala</th>
            <th class="p-3 text-left">Naziv sastanka</th>
            <th class="p-3 text-left">Početak</th>
            <th class="p-3 text-left">Kraj</th>
            <th class="p-3 text-left">Online</th>
            <th class="p-3 text-center">Akcije</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($reservations)): ?>
            <?php foreach ($reservations as $r): ?>
              <tr class="border-b hover:bg-gray-50 transition">
                <td class="p-3">
                  <?= htmlspecialchars($r['Ime']) . ' ' . htmlspecialchars($r['Prezime']) ?>
                </td>
                <td class="p-3"><?= htmlspecialchars($r['NazivSale']) ?></td>
                <td class="p-3"><?= htmlspecialchars($r['naziv_sastanka'] ?? '-') ?></td>
                <td class="p-3"><?= htmlspecialchars($r['pocetak']) ?></td>
                <td class="p-3"><?= htmlspecialchars($r['kraj']) ?></td>
                <td class="p-3 text-center">
                  <?= !empty($r['Online']) && $r['Online'] ? 'DA' : 'NE' ?>
                </td>
                <td class="p-3 text-center">
                <a href="<?= BASE_URL ?>admin/edit-reservation?id=<?= $r['id'] ?>"
                class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition">
                Izmeni
                </a>
</td>

              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="p-4 text-center text-gray-500">
                Trenutno nema rezervacija.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
