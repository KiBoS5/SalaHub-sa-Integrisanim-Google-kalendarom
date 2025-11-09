<!DOCTYPE html>
<html lang="sr">
<head>
  <meta charset="UTF-8">
  <title>Rezerviši salu | SalaHub</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

  <?php include __DIR__ . '/../layout/user-sidebar.php'; ?>

  <div class="flex-1 p-8">
    <h1 class="text-2xl font-bold text-blue-800 mb-6"> Rezerviši salu</h1>

    <form method="POST" action="<?= BASE_URL ?>user/find-rooms" class="bg-white p-6 rounded shadow w-full max-w-lg space-y-4">

  <div>
    <label class="block text-gray-700 mb-1 font-medium">Datum sastanka</label>
    <input type="date" name="datum" required class="w-full p-2 border rounded">
  </div>

  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="block text-gray-700 mb-1 font-medium">Vreme početka</label>
      <input type="time" name="vreme_pocetka" required class="w-full p-2 border rounded">
    </div>
    <div>
      <label class="block text-gray-700 mb-1 font-medium">Vreme kraja</label>
      <input type="time" name="vreme_kraja" required class="w-full p-2 border rounded">
    </div>
  </div>

  <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
     Prikaži slobodne sale
  </button>

</form>

  </div>

</body>
</html>
