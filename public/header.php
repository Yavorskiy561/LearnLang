<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/databases/database.php";

try {
    $stmt = $pdo->query("SELECT * FROM languages ORDER BY id");
    $languages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: /500.php");
    exit;
}
?>
  <style>
        /* Изменение цвета выпадающего меню */
        .dropdown-menu {
            background-color: #f8f9fa !important; /* Светлый фон */
            border-color: #DF7070 !important;
        }

        .dropdown-item {
            color: #212529 !important; /* Тёмный цвет текста */
            transition: all 0.3s ease;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            background-color: #DF7070 !important;
            color: white !important;
        }

        .dropdown-item.active {
            background-color: #DF7070 !important;
            color: white !important;
        }
        .nav .dropdown-menu {
            background-color: #f8f9fa;
            border-color: #DF7070;
        }

        .nav .dropdown-item {
            color: #212529;
        }
    </style>

  
        <header class="d-flex flex-wrap justify-content-center py-3 border-bottom itd-bg-header mb-4">
          <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
              <img src="/resourse/logo.svg" height="60" alt="Логотип">
              <h1 class="logo_name text-white">LearnLang</h1>
          </a>
         <ul class="nav itd-nav nav-pills align-items-center">
            <li class="nav-item">
                <a href="/index-install-po.php" class="nav-link text-white">Установка ПО</a>
            </li>
            <?php 
            $current_uri = trim($_SERVER['REQUEST_URI'], '/');
            foreach ($languages as $lang): 
                $lang_slug = htmlspecialchars($lang['slug']);
                $is_lang_active = ($current_uri === $lang_slug);
                $is_tasks_active = str_starts_with($current_uri, $lang_slug.'/tasks');
            ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?= ($is_lang_active || $is_tasks_active) ? 'active bg-danger' : 'text-white' ?>" 
                href="#" role="button" data-bs-toggle="dropdown">
                    <?= htmlspecialchars($lang['name']) ?>
                </a>
                <ul class="dropdown-menu border-2">
                    <li>
                        <a class="dropdown-item<?= $is_lang_active ? 'active' : '' ?>" 
                        href="/<?= $lang_slug ?>">
                        Учебник
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item <?= $is_tasks_active ? 'active' : '' ?>" 
                        href="/<?= $lang_slug ?>/tasks">
                        Задачник
                        </a>
                    </li>
                </ul>
            </li>
            <?php endforeach; ?>
        </ul>
      </header>
    