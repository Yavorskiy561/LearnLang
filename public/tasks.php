<?php
require __DIR__ . '/header.php';

try {
    // Проверяем наличие slug языка
    if (!isset($_GET['slug']) || empty($_GET['slug'])) {
        throw new Exception('Язык не указан');
    }

    $lang_slug = $_GET['slug'] ?? '';

    // Получаем данные языка
    $stmt = $pdo->prepare("SELECT * FROM languages WHERE slug = ?");
    $stmt->execute([$lang_slug]);
    $language = $stmt->fetch();

    if (!$language) {
        header("Location: /404.php");
        exit;
    }

    // Получаем задачи с пагинацией
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $stmt = $pdo->prepare("SELECT * FROM tasks 
                          WHERE language_id = :lang_id 
                          ORDER BY id ASC 
                          LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':lang_id', $language['id'], PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $tasks = $stmt->fetchAll();

    // Получаем общее количество задач
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE language_id = ?");
    $stmt->execute([$language['id']]);
    $totalTasks = $stmt->fetchColumn();

} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: /500.php");
    exit;
} catch (Exception $e) {
    error_log($e->getMessage());
    header("Location: /400.php");
    exit;
}
?>

<style>
    .task-card {
        transition: transform 0.2s;
        border-left: 4px solid #DF7070;
    }
    .task-card:hover {
        transform: translateY(-3px);
    }
    .solution-code {
        background: #f8f9fa;
        border-radius: 4px;
        padding: 15px;
        margin-top: 10px;
    }
    .pagination {
        justify-content: center;
        margin-top: 30px;
    }
</style>

<div class="content_page">
    <section class="container py-5">

        <div class="row mb-4">
            <div class="col-12">
                <div class="p-4 rounded-3" style="background: #DF7070;">
                    <h1 class="text-center text-white mb-0">Задачник по <?= htmlspecialchars($language['name']) ?></h1>
                </div>
            </div>
        </div>

        <?php if (!empty($tasks)): ?>
            <div class="row row-cols-1 g-4">
                <?php foreach ($tasks as $task): ?>
                <div class="col">
                    <div class="card task-card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title mb-0"><?= htmlspecialchars($task['title']) ?></h5>
                                <span class="badge bg-primary">
                                    <?= ucfirst(htmlspecialchars($task['difficulty'])) ?>
                                </span>
                            </div>
                            <p class="card-text text-muted"><?= nl2br(htmlspecialchars($task['description'])) ?></p>
                            
                            <button class="btn btn-outline-primary" 
                                    type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#solution-<?= $task['id'] ?>"
                                    aria-expanded="false">
                                Показать решение
                            </button>

                            <div class="collapse mt-3" id="solution-<?= $task['id'] ?>">
                                <div class="solution-code">
                                    <pre><code class="language-<?= htmlspecialchars($lang_slug) ?>"><?= htmlspecialchars(trim($task['solution'])) ?></code></pre>
                                </div>
                            </div>
                            <div class="code-submission mt-4">
                                <form class="submit-form" data-task-id="<?= $task['id'] ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Введите ваш код:</label>
                                        <textarea 
                                            class="form-control code-editor" 
                                            name="code" 
                                            rows="5"
                                            placeholder="// Напишите ваше решение здесь"
                                            required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-play me-2"></i>Проверить решение
                                    </button>
                                </form>
                                <div class="result mt-3" style="display: none;">
                                    <div class="alert alert-dismissible fade show">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        <span class="result-text"></span>
                                    </div>
                                </div>
                            </div>
                            <script src="/scripts/tasks-solution.js"></script>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Пагинация -->
            <?php if ($totalTasks > $limit): ?>
            <nav class="pagination">
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?slug=<?= $lang_slug ?>&page=<?= $page - 1 ?>">Назад</a>
                    </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= ceil($totalTasks / $limit); $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a class="page-link" href="?slug=<?= $lang_slug ?>&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>

                    <?php if ($page < ceil($totalTasks / $limit)): ?>
                    <li class="page-item">
                        <a class="page-link" href="?slug=<?= $lang_slug ?>&page=<?= $page + 1 ?>">Вперед</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php endif; ?>

        <?php else: ?>
            <div class="alert alert-info text-center">
                <h4 class="alert-heading">Заданий пока нет!</h4>
                <p>Мы активно работаем над добавлением новых задач. Загляните позже.</p>
                <a href="/<?= htmlspecialchars($lang_slug) ?>" class="btn btn-primary">
                    Вернуться к учебнику
                </a>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php 
require __DIR__ . '/footer.php'; 
?>