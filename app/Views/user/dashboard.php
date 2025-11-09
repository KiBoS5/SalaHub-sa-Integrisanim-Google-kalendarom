<!DOCTYPE html>
<html lang="sr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard | SalaHub</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

  <?php include __DIR__ . '/../layout/user-sidebar.php'; ?>

  <div class="flex-1 p-8">
    <h1 class="text-2xl font-bold text-blue-800 mb-6"> Kalendar rezervacija</h1>

    <div class="bg-white rounded shadow p-4">
      <iframe src="https://calendar.google.com/calendar/embed?src=bvkibos123%40gmail.com&ctz=Europe%2FBelgrade" style="border: 0" width="1000" height="600" frameborder="0" scrolling="no"></iframe>
      
    </div>
  </div>

</body>
</html>
