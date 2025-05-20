<?php
// header.php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/databases/database.php";

// Получаем языки из базы данных
try {
    $stmt = $pdo->query("SELECT * FROM languages ORDER BY id");
    $languages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Ошибка загрузки меню: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/themes/prism.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/prism.min.js"></script>
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
  <style>
        /* Добавьте в head */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .content_page {
            flex: 1;
        }
      </style>
<body class="d-flex flex-column min-vh-100"> 
    <div class="wrapper flex-grow-1">
    
        <header class="d-flex flex-wrap justify-content-center py-3 border-bottom itd-bg-header" id="header">
          <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <img src="resourse/logo.svg" height="60"  alt="Логотип">
            <h1 class="logo_name">LearnLang</h1>
          </a>
          <ul class="nav itd-nav nav-pills">
            <!-- Статический пункт "Установка ПО" -->
            <li class="nav-item">
                <a href="index-install-po.php" class="nav-link">Установка ПО</a>
            </li>

            <!-- Динамические пункты для языков -->
            <?php foreach ($languages as $lang): ?>
            <li class="nav-item">
                <a href="index_one_<?= htmlspecialchars($lang['slug']) ?>.php" 
                   class="nav-link"
                   id="link_<?= htmlspecialchars($lang['slug']) ?>">
                   <?= htmlspecialchars($lang['name']) ?>
                </a>
            </li>
            <?php endforeach; ?>

            <!-- Динамические пункты для задачников -->
            <?php foreach ($languages as $lang): ?>
            <li class="nav-item">
                <a href="index-task-<?= htmlspecialchars($lang['slug']) ?>.php" 
                   class="nav-link"
                   id="link_tasks_<?= htmlspecialchars($lang['slug']) ?>">
                   Задачник по <?= htmlspecialchars($lang['name']) ?>
                </a>
            </li>
            <?php endforeach; ?>
          </ul>
      </header>