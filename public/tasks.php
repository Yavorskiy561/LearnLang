<?php
require __DIR__ . 'header.php';

$lang_slug = $_GET['slug'];

// Получаем задачи для языка
$stmt = $pdo->prepare("SELECT t.* FROM tasks t
                      JOIN languages l ON t.language_id = l.id
                      WHERE l.slug = ?");
$stmt->execute([$lang_slug]);
$tasks = $stmt->fetchAll();
?>

<div class="content_page d-flex">
    <section class="w-100% h-100%">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-3" style="background: #DF7070;">
                    <h1 class="text-center text-light p-2">Задачник по <?= $lang_slug ?></h1>
                </div>
                <div class="col-12">
                    <?php foreach ($tasks as $task): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?= $task['title'] ?></h5>
                            <p class="card-text"><?= $task['description'] ?></p>
                            <button class="btn btn-primary" data-bs-toggle="collapse" 
                                    data-bs-target="#solution-<?= $task['id'] ?>">
                                Показать решение
                            </button>
                            <div class="collapse mt-2" id="solution-<?= $task['id'] ?>">
                                <pre><code><?= $task['solution'] ?></code></pre>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require __DIR__ . 'footer.php'; ?>