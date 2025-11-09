<!DOCTYPE html>
<html lang="sr">
<head>
  <meta charset="UTF-8">
  <title>Dostupne sale | SalaHub</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

  <?php include __DIR__ . '/../layout/user-sidebar.php'; ?>

  <div class="flex-1 p-8">
    <h2 class="text-2xl font-bold mb-6 text-blue-800">Dostupne sale</h2>

    <!-- Ako nema sala -->
    <?php if (empty($sale)): ?>
      <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 rounded">
        <p> Nema slobodnih sala za izabrani termin.</p>
      </div>

      <a href="<?= BASE_URL ?>user/book-room" 
         class="inline-block mt-4 text-blue-600 hover:underline">← Nazad na odabir termina</a>

    <?php else: ?>
      <form method="POST" action="<?= BASE_URL ?>user/book-room-details">
        <!-- sakriveni podaci o terminu -->
        <input type="hidden" name="pocetak" value="<?= htmlspecialchars($pocetak) ?>">
        <input type="hidden" name="kraj" value="<?= htmlspecialchars($kraj) ?>">

        <div class="space-y-3">
          <?php foreach ($sale as $s): ?>
            <label class="flex items-center justify-between border p-3 rounded hover:bg-gray-50 cursor-pointer">
              <div class="flex items-center gap-3">
                <input type="radio" name="sala_id" value="<?= $s['id'] ?>" required>
                <div>
                  <p class="font-semibold text-gray-800"><?= htmlspecialchars($s['naziv']) ?></p>
                  <p class="text-sm text-gray-500">
                    Lokacija: <?= htmlspecialchars($s['Lokacija'] ?? '-') ?> | 
                    Kapacitet: <?= htmlspecialchars($s['kapacitet'] ?? '-') ?>
                  </p>
                </div>
              </div>

              <!-- Status opreme -->
              <div class="text-xs text-gray-500">
                <?php
                  $oprema = [];
                  if (!empty($s['TV'])) $oprema[] = 'TV';
                  if (!empty($s['Projektor'])) $oprema[] = 'Projektor';
                  if (!empty($s['PametnaTabla'])) $oprema[] = 'Pametna tabla';
                  if (!empty($s['Mikrofon'])) $oprema[] = 'Mikrofon';
                  if (!empty($s['Kamera'])) $oprema[] = 'Kamera';
                  echo !empty($oprema) ? implode(', ', $oprema) : 'Bez dodatne opreme';
                ?>
              </div>
            </label>
          <?php endforeach; ?>
        </div>

        <div class="mt-6">
          <button type="submit" 
                  class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
            Nastavi sa unosom detalja
          </button>
        </div>
      </form>
    <?php endif; ?>
  </div>
</body>
</html>
