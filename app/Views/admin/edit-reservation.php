<!DOCTYPE html>
<html lang="sr">
<head>
  <meta charset="UTF-8">
  <title>Izmena rezervacije | SalaHub</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">
  <?php include __DIR__ . '/../layout/sidebar.php'; ?>

  <div class="flex-1 p-8">
    <h1 class="text-2xl font-bold text-blue-800 mb-6">Izmeni rezervaciju</h1>

    <form method="POST" action="<?= BASE_URL ?>admin/edit-reservation"
          class="bg-white p-6 rounded shadow w-full max-w-lg space-y-4">
      <input type="hidden" name="id" value="<?= htmlspecialchars($reservation['id']) ?>">

      <div>
        <label class="block text-gray-700 mb-1">Sala</label>
        <select name="sala_id" class="w-full p-2 border rounded">
          <?php foreach ($rooms as $room): ?>
            <option value="<?= $room['id'] ?>" <?= $room['id'] == $reservation['sala_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($room['naziv']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label class="block text-gray-700 mb-1">Korisnik</label>
        <select name="korisnik_id" class="w-full p-2 border rounded">
          <?php foreach ($users as $user): ?>
            <option value="<?= $user['id'] ?>" <?= $user['id'] == $reservation['korisnik_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($user['ime'] . ' ' . $user['Prezime']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label class="block text-gray-700 mb-1">Datum</label>
        <input type="date" name="datum" value="<?= htmlspecialchars($reservation['datum']) ?>"
               class="w-full p-2 border rounded">
      </div>

      <div>
        <label class="block text-gray-700 mb-1">Trajanje (sati)</label>
        <input type="number" name="trajanje" value="<?= htmlspecialchars($reservation['trajanje']) ?>"
               class="w-full p-2 border rounded" min="1">
      </div>

      <div>
        <label class="block text-gray-700 mb-1">Naziv sastanka</label>
        <input type="text" name="naziv_sastanka" value="<?= htmlspecialchars($reservation['naziv_sastanka']) ?>"
               class="w-full p-2 border rounded">
      </div>

      <div>
        <label class="block text-gray-700 mb-1">Tema</label>
        <input type="text" name="tema" value="<?= htmlspecialchars($reservation['tema']) ?>"
               class="w-full p-2 border rounded">
      </div>

      <div>
        <label class="block text-gray-700 mb-1">Lokacija</label>
        <input type="text" name="lokacija" value="<?= htmlspecialchars($reservation['lokacija']) ?>"
               class="w-full p-2 border rounded">
      </div>

      <div class="flex items-center">
        <input type="checkbox" name="online" id="online"
               <?= $reservation['Online'] ? 'checked' : '' ?> class="mr-2">
        <label for="online" class="text-gray-700">Online sastanak</label>
      </div>

      <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">
        Sačuvaj izmene
      </button>
    </form>
  </div>
</body>
</html>
