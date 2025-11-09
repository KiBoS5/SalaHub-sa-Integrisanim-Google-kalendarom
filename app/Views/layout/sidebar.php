
 <?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<aside class="w-64 h-screen bg-gray-900 text-white flex flex-col">
    <div class="p-4 text-center border-b border-gray-700">
        <h2 class="text-2xl font-bold text-blue-400">SalaHub</h2>
        <p class="text-xs text-gray-400">Admin panel</p>
    </div>

    <nav class="flex-1 p-4 space-y-2">
        <a href="<?= BASE_URL ?>admin/dashboard" class="block p-2 rounded hover:bg-gray-800"> Dashboard</a>
        <a href="<?= BASE_URL ?>admin/add-room" class="block p-2 rounded hover:bg-gray-800"> Dodaj salu</a>
        <a href="<?= BASE_URL ?>admin/register-user" class="block p-2 rounded hover:bg-gray-800"> Registruj korisnika</a>

            <!-- Dropdown meni: Liste -->
<div x-data="{ open: false }" class="mt-2">
  <button @click="open = !open"
          class="w-full flex justify-between items-center bg-gray-800 text-gray-300 px-4 py-2 rounded hover:bg-gray-700 transition">
    <span> Liste</span>
    <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
    </svg>
  </button>

  <div x-show="open" class="ml-4 mt-2 space-y-1">
    <a href="<?= BASE_URL ?>admin/list-users" class="block text-gray-400 hover:text-white"> Lista korisnika</a>
    <a href="<?= BASE_URL ?>admin/list-rooms" class="block text-gray-400 hover:text-white"> Lista sala</a>
  </div>
</div>

        <a href="<?= BASE_URL ?>logout" class="block p-2 rounded hover:bg-red-700 mt-4"> Odjava</a>
    </nav>
    


<script src="https://unpkg.com/alpinejs" defer></script>


    <!--  sekcija za ulogovanog korisnika -->
    <a href="<?= BASE_URL ?>profile"
   class="mt-auto bg-gray-800 text-gray-300 p-4 text-sm rounded-t flex items-center gap-3 hover:bg-gray-700 transition">

    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
        <?= strtoupper(substr($_SESSION['user_name'] ?? '?', 0, 1)) ?>
    </div>

    <div>
        <p class="font-semibold text-blue-400"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Nepoznat') ?></p>
        <p class="text-xs text-gray-400"><?= htmlspecialchars($_SESSION['user_role'] ?? 'N/A') ?></p>
    </div>
</a>

</aside>


