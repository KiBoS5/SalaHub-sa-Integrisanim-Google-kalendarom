<!DOCTYPE html>
<html lang="sr">
<head>
  <meta charset="UTF-8">
  <title>Dodaj salu | SalaHub</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

  <?php include __DIR__ . '/../layout/sidebar.php'; ?>

  <div class="flex-1 p-8">
    <h1 class="text-2xl font-bold text-blue-800 mb-6"> Dodaj novu salu</h1>

   <?php
$isEdit = isset($room);
$actionUrl = $isEdit ? BASE_URL . 'admin/edit-room' : BASE_URL . 'admin/add-room';
?>
    <form method="POST" action="<?= $actionUrl ?>" 
          class="bg-white p-6 rounded-lg shadow w-full max-w-lg space-y-5">

       <?php if ($isEdit): ?>
       <input type="hidden" name="id" value="<?= $room['id'] ?>">
       <?php endif; ?>
      
      <!-- Naziv sale -->
      <div>
        <label class="block text-gray-700 mb-1 font-medium">Naziv sale</label>
        <input type="text" name="naziv" required
               class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400">
      </div>

      <!-- Lokacija -->
      <div>
        <label class="block text-gray-700 mb-1 font-medium">Lokacija</label>
        <input type="text" name="lokacija" required
               class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400">
      </div>

      <!-- Kapacitet -->
      <div>
        <label class="block text-gray-700 mb-1 font-medium">Kapacitet</label>
        <input type="number" name="kapacitet" min="1" required
               class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400">
      </div>

      <!-- Oprema -->
      <div>
        <label class="block text-gray-700 mb-2 font-medium">Oprema u sali</label>
        <div class="grid grid-cols-2 gap-2 text-gray-700">
          <label class="flex items-center gap-2">
            <input type="checkbox" name="tv" value="1" class="accent-blue-600"> TV
          </label>
          <label class="flex items-center gap-2">
            <input type="checkbox" name="projektor" value="1" class="accent-blue-600"> Projektor
          </label>
          <label class="flex items-center gap-2">
            <input type="checkbox" name="pametna_tabla" value="1" class="accent-blue-600"> Pametna tabla
          </label>
          <label class="flex items-center gap-2">
            <input type="checkbox" name="kamera" value="1" class="accent-blue-600"> Kamera
          </label>
          <label class="flex items-center gap-2">
            <input type="checkbox" name="mikrofon" value="1" class="accent-blue-600"> Mikrofon
          </label>
        </div>
      </div>

      <!-- Status -->
      <div>
        <label class="block text-gray-700 mb-1 font-medium">Status sale</label>
        <select name="status" class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400">
          <option value="slobodna">Slobodna</option>
          <option value="zauzeta">Zauzeta</option>
          <option value="deaktivna">Deaktivna</option>
        </select>
      </div>

      <!-- Submit -->
      <div class="pt-4">
        <button type="submit"
                class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition">
           <?= $isEdit ? 'Sačuvaj izmene' : 'Dodaj salu' ?>
        </button>
      </div>

    </form>
  </div>

</body>
</html>
