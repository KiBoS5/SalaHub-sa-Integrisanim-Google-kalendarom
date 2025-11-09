<!DOCTYPE html>
<html lang="sr">
<head>
  <meta charset="UTF-8">
  <title>Potvrdi rezervaciju | SalaHub</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">
  
  <?php include __DIR__ . '/../layout/user-sidebar.php'; ?>

  <div class="flex-1 p-8">
    <h1 class="text-2xl font-bold text-blue-800 mb-6"> Detalji sastanka</h1>

    <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-800 p-4 mb-6 rounded">
    <p><strong>Sala:</strong> <?= htmlspecialchars($sala['naziv']) ?></p>
    <p><strong>Lokacija:</strong> <?= htmlspecialchars($sala['Lokacija'] ?? '-') ?></p>
    <p><strong>Termin:</strong> <?= date('d.m.Y H:i', strtotime($pocetak)) ?> – <?= date('H:i', strtotime($kraj)) ?></p>
    </div>



    <form method="POST" action="<?= BASE_URL ?>user/confirm-booking"
          class="bg-white p-6 rounded shadow-md max-w-lg space-y-5">

      <input type="hidden" name="pocetak" value="<?= htmlspecialchars($pocetak) ?>">
      <input type="hidden" name="kraj" value="<?= htmlspecialchars($kraj) ?>">
      <input type="hidden" name="sala_id" value="<?= htmlspecialchars($sala['id']) ?>">


      <div>
        <label class="block text-gray-700 mb-1 font-medium">Naziv sastanka</label>
        <input type="text" name="naziv_sastanka" required
               class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label class="block text-gray-700 mb-1 font-medium">Tema</label>
        <input type="text" name="tema"
               class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label class="block text-gray-700 mb-1 font-medium">Pozvani (email adrese odvojene zarezom)</label>
        <textarea name="pozvani" rows="3" class="w-full p-2 border rounded"></textarea>
      </div>

      <div>
        <label class="flex items-center gap-2 text-gray-700">
          <input type="checkbox" name="online" class="w-4 h-4">
          Online sastanak (Google Meet link)
        </label>
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
         Potvrdi rezervaciju
      </button>

    </form>
  </div>
</body>
</html>
