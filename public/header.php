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
<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/themes/prism.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/prism.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!--Стили-->  
  <link rel="stylesheet" href="/style_pg/style-animation.css">
  <link rel="stylesheet" href="/style_pg/style_index_head_page.css">
  <link rel="stylesheet" href="/style_pg/style-python-one.css">
  <link rel="stylesheet" href="/style_pg/style-tasks.css">
  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/resourse/logo.svg" height="10" type="image/x-icon">
  <title>learnlang</title>
</head>
<body class="d-flex flex-column min-vh-100"> 
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
    <div class="wrapper flex-grow-1">
        <header class="d-flex flex-wrap justify-content-center py-3 border-bottom itd-bg-header">
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
      <main class="content_page">