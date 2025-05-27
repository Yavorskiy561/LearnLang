<?php
require __DIR__ . '/header.php';

// Парсинг URL с обработкой различных сценариев
$request_uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$uri_parts = $request_uri ? explode('/', $request_uri) : [];

$lang_slug = $uri_parts[0] ?? 'c';
$section_slug = $uri_parts[1] ?? null;
$subsection_slug = $uri_parts[2] ?? null;

try {
    // Получаем данные языка
    $stmt = $pdo->prepare("SELECT * FROM languages WHERE slug = ?");
    $stmt->execute([$lang_slug]);
    $language = $stmt->fetch();

    if (!$language) {
        header("Location: /404.php");
        exit;
    }

    // Получаем разделы языка
    $stmt = $pdo->prepare("SELECT * FROM sections 
                          WHERE language_id = ? 
                          ORDER BY order_index");
    $stmt->execute([$language['id']]);
    $sections = $stmt->fetchAll();

    // Логика обработки подразделов
    $current_subsection = null;
    $content_blocks = [];

    if ($section_slug && $subsection_slug) {
        // Получаем текущий раздел с проверкой языка
        $stmt = $pdo->prepare("SELECT * FROM sections 
                              WHERE slug = ? 
                              AND language_id = ?");
        $stmt->execute([$section_slug, $language['id']]);
        $current_section = $stmt->fetch();

        if ($current_section) {
            // Получаем подраздел
            $stmt = $pdo->prepare("SELECT * FROM subsections 
                                  WHERE slug = ? 
                                  AND section_id = ?");
            $stmt->execute([$subsection_slug, $current_section['id']]);
            $current_subsection = $stmt->fetch();

            if ($current_subsection) {
                // Получаем контент
                $stmt = $pdo->prepare("SELECT * FROM content_blocks 
                                      WHERE subsection_id = ? 
                                      ORDER BY order_index");
                $stmt->execute([$current_subsection['id']]);
                $content_blocks = $stmt->fetchAll();
            }
        }
    }

} catch (PDOException $e) {
    die("Ошибка базы данных: " . $e->getMessage());
}
?>

<div class="content_page d-flex">
    <!-- Боковое меню -->
    <div class="flex-shrink-0 p-3 border-end shadows border-3" style="width: 280px;">
        <div class="d-flex align-items-center justify-content-center pb-3 mb-2 border-bottom border-danger-subtle">
            <span class="text-center fs-5 fw-semibold">
                <?= htmlspecialchars($language['name']) ?> 
            </span>
        </div>
       <!-- Боковое меню -->
        <ul class="list-unstyled ps-0 text-center">
            <?php foreach ($sections as $section): 
                $is_active_section = ($section_slug === $section['slug']);
            ?>
            <li class="mb-1 border-bottom border-1">
                <button class="btn btn-toggle d-inline-flex align-items-center rounded collapsed" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#section-<?= $section['id'] ?>"
                        <?= $is_active_section ? 'aria-expanded="true"' : '' ?>>
                    <?= htmlspecialchars($section['title']) ?>
                </button>
                <div class="border rounded collapse p-3 <?= $is_active_section ? 'show' : '' ?>" 
                    id="section-<?= $section['id'] ?>">
                    <?php
                    $subsections = $pdo->prepare("SELECT * FROM subsections 
                                                WHERE section_id = ? 
                                                ORDER BY order_index");
                    $subsections->execute([$section['id']]);
                    $subsections_data = $subsections->fetchAll();
                    ?>
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <?php foreach ($subsections_data as $subsection): 
                            $is_active = ($subsection['slug'] === $subsection_slug);
                        ?>
                        <li class="border-bottom">
                            <a href="/<?= htmlspecialchars($language['slug']) ?>/<?= htmlspecialchars($section['slug']) ?>/<?= htmlspecialchars($subsection['slug']) ?>" 
                            class="link-body-emphasis d-inline-flex text-decoration-none ms-3 rounded <?= $is_active ? 'active-subsection' : '' ?>">
                            <?= htmlspecialchars($subsection['title']) ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <!-- Основной контент -->
    <section class="w-100 h-100 flex-grow-1 ">
        <div class="container ">
            <?php if ($current_subsection): ?>
                <!-- Заголовок подраздела -->
                <div class="row">
                    <div class="col-12 mb-3" style="background: #DF7070;">
                        <h1 class="text-center text-light p-2">
                            <?= htmlspecialchars($current_subsection['title']) ?>
                        </h1>
                    </div>
                </div>

                <!-- Блоки контента -->
                <?php foreach ($content_blocks as $block): ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <?php 
                        switch ($block['block_type']) {
                            case 'heading':
                                echo '<h2 class="mb-3">'.htmlspecialchars_decode($block['content']).'</h2>';
                                break;
                            
                            case 'subheading':
                                $tag = !empty($block['meta']) ? htmlspecialchars($block['meta']) : 'h3';
                                echo "<$tag class='mb-3'>".htmlspecialchars_decode($block['content'])."</$tag>";
                                break;
                            
                            case 'paragraph':
                                echo '<p class="fs-5">'.htmlspecialchars_decode($block['content']).'</p>';
                                break;
                            
                            case 'code':
                                echo '<div class="border border-3 rounded p-3 mb-3 code-block">';
                                echo '<pre><code class="language-'.htmlspecialchars($block['meta']).'">';
                                echo htmlspecialchars(trim($block['content']));
                                echo '</code></pre></div>';
                                break;
                            
                            case 'list':
                                echo '<ul class="fs-5">';
                                $list_items = $pdo->prepare("SELECT * FROM list_items 
                                                            WHERE content_block_id = ? 
                                                            ORDER BY order_index");
                                $list_items->execute([$block['id']]);
                                while ($item = $list_items->fetch()) {
                                    echo '<li>'.htmlspecialchars_decode($item['content']).'</li>';
                                }
                                echo '</ul>';
                                break;
                            
                            default:
                                echo '<div class="content-block">';
                                echo htmlspecialchars_decode($block['content']);
                                echo '</div>';
                        }
                        ?>
                    </div>
                </div>
                
                <?php endforeach; ?>
                <div class="row mt-4 mb-5">
                    <div class="col-12 text-center">
                        <a href="/<?= htmlspecialchars($language['slug']) ?>/tasks" 
                        class="btn btn-lg btn-danger">
                        <i class="fas fa-tasks me-2"></i>Перейти к задачам
                        </a>
                    </div>
                </div>
            <?php else: ?>
                
                <!-- Дефолтный контент -->
                <div class="row">
                    <div class="col-xs-12 mb-3" style="background: #DF7070;">
                        <h1 class="text-center mb-3 justify-content-center align-items-center text-light p-2" >Рекомендация перед изучением</h1>
                    </div>
                    <div class="col-xs-12">
                        <p class="fs-5 p-4">
                            Этот учебник предназначен для тех, кто хочет овладеть основами программирования и приобрести навыки, необходимые для создания программного обеспечения. Независимо от вашего уровня знаний, будь то абсолютный новичок или человек с небольшим опытом, этот учебник предложит вам курс, начиная с основных концепций и заканчивая практическими проектами.
                            Перед изучением материала рекомендуем посетить страницу <a href="index-install-po.php" >Установка ПО</a>, где подробно описанно установка программного обеспечения.
                        </p>
                    </div>
                    <div class="col-12 mb-3" style="background: #DF7070;">
                        <h1 class="text-center text-light p-2">
                            Учебник по <?= htmlspecialchars($language['name']) ?>
                        </h1>
                    </div>
                    <div class="col-12">
                        <?php if (!empty($language['description'])): ?>
                            <div class="fs-5 p-4">
                                <?= htmlspecialchars_decode($language['description']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php 
require __DIR__ . '/footer.php'; 
?>