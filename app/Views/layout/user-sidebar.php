<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<aside class="w-64 h-screen bg-gray-900 text-white flex flex-col">
    <div class="p-4 text-center border-b border-gray-700">
        <h2 class="text-2xl font-bold text-blue-400">SalaHub</h2>
        <p class="text-xs text-gray-400">Korisnički panel</p>
    </div>

    <nav class="flex-1 p-4 space-y-2">
        <a href="<?= BASE_URL ?>user/dashboard" class="block p-2 rounded hover:bg-gray-800"> Kalendar</a>
        <a href="<?= BASE_URL ?>user/book-room" class="block p-2 rounded hover:bg-gray-800"> Rezerviši salu</a>
        <a href="<?= BASE_URL ?>user/my-reservations" class="block p-2 rounded hover:bg-gray-800"> Moje rezervacije</a>
        <a href="<?= BASE_URL ?>logout" class="block p-2 rounded hover:bg-red-700 mt-4"> Odjava</a>
    </nav>

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

