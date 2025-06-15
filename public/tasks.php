<!DOCTYPE html>
<html lang="ru">
<?php
require __DIR__ . '/head.php';
?>
<body class="d-flex flex-column min-vh-100">
    <div class="wrapper flex-grow-1">
        <?php
        require __DIR__ . '/header.php';
        
        try {
            // Validate and sanitize language slug
            $lang_slug = isset($_GET['slug']) ? trim(htmlspecialchars($_GET['slug'])) : '';
            if (empty($lang_slug)) {
                throw new Exception('Язык не указан');
            }

            // Get language data
            $stmt = $pdo->prepare("SELECT * FROM languages WHERE slug = ? LIMIT 1");
            $stmt->execute([$lang_slug]);
            $language = $stmt->fetch();

            if (!$language) {
                header("HTTP/1.0 404 Not Found");
                require __DIR__ . '/404.php';
                exit;
            }

            // Get tasks with pagination
            $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
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

            // Get total tasks count
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE language_id = ?");
            $stmt->execute([$language['id']]);
            $totalTasks = (int)$stmt->fetchColumn();
            $totalPages = ceil($totalTasks / $limit);

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            header("HTTP/1.0 500 Internal Server Error");
            require __DIR__ . '/500.php';
            exit;
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            header("HTTP/1.0 400 Bad Request");
            require __DIR__ . '/400.php';
            exit;
        }
        ?>

        <style>
            .task-card {
                transition: transform 0.2s;
                border-left: 4px solid #DF7070;
                margin-bottom: 20px;
            }
            .task-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            }
            .solution-code {
                background: #f8f9fa;
                border-radius: 4px;
                padding: 15px;
                margin-top: 10px;
                border: 1px solid #dee2e6;
            }
            .pagination {
                justify-content: center;
                margin-top: 30px;
            }
            .difficulty-badge {
                font-size: 0.8rem;
                padding: 5px 10px;
            }
            .task-header {
                background: #DF7070;
                color: white;
                padding: 15px;
                border-radius: 5px;
            }
        </style>

        <main class="content_page">
            <div class="container py-5">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="task-header">
                            <h1 class="text-center mb-0">Задачник по <?= htmlspecialchars($language['name'] ?? '') ?></h1>
                        </div>
                    </div>
                </div>

                <?php if (!empty($tasks)): ?>
                    <div class="row row-cols-1 g-4">
                        <?php foreach ($tasks as $task): 
                            $task_id = (int)($task['id'] ?? 0);
                            $difficulty = htmlspecialchars($task['difficulty'] ?? 'medium');
                        ?>
                        <div class="col">
                            <div class="card task-card shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h5 class="card-title mb-0"><?= htmlspecialchars($task['title'] ?? '') ?></h5>
                                        <span class="badge difficulty-badge 
                                            <?= $difficulty === 'easy' ? 'bg-success' : 
                                               ($difficulty === 'hard' ? 'bg-danger' : 'bg-warning') ?>">
                                            <?= ucfirst($difficulty) ?>
                                        </span>
                                    </div>
                                    <p class="card-text text-muted"><?= nl2br(htmlspecialchars($task['description'] ?? '')) ?></p>
                                    
                                    <button class="btn btn-outline-primary" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#solution-<?= $task_id ?>"
                                            aria-expanded="false"
                                            aria-controls="solution-<?= $task_id ?>">
                                        Показать решение
                                    </button>

                                    <div class="collapse mt-3" id="solution-<?= $task_id ?>">
                                        <div class="solution-code">
                                            <pre><code class="language-<?= htmlspecialchars($lang_slug) ?>"><?= 
                                                htmlspecialchars(trim($task['solution'] ?? ''))
                                            ?></code></pre>
                                        </div>
                                    </div>
                                    
                                    <div class="code-submission mt-4">
                                        <form class="submit-form" data-task-id="<?= $task_id ?>">
                                            <div class="mb-3">
                                                <label for="code-<?= $task_id ?>" class="form-label">Введите ваш код:</label>
                                                <textarea 
                                                    id="code-<?= $task_id ?>"
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
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($totalTasks > $limit): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?slug=<?= htmlspecialchars($lang_slug) ?>&page=<?= $page - 1 ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo; Назад</span>
                                </a>
                            </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                <a class="page-link" href="?slug=<?= htmlspecialchars($lang_slug) ?>&page=<?= $i ?>"><?= $i ?></a>
                            </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?slug=<?= htmlspecialchars($lang_slug) ?>&page=<?= $page + 1 ?>" aria-label="Next">
                                    <span aria-hidden="true">Вперед &raquo;</span>
                                </a>
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
            </div>
        </main>

        <?php 
        require __DIR__ . '/footer.php'; 
        ?>
    </div>
    
    <!-- Move script to bottom of body -->
    <script src="/scripts/tasks-solution.js"></script>
</body>
</html>