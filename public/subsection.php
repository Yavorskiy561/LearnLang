<?php
require __DIR__ . '/header.php';

// Парсинг URL через параметры GET
$lang_slug = trim($_GET['lang_slug'] ?? '');
$section_slug = trim($_GET['section_slug'] ?? '');
$subsection_slug = trim($_GET['subsection_slug'] ?? '');

try {
    // Check required parameters
    if (empty($lang_slug) || empty($section_slug) || empty($subsection_slug)) {
        http_response_code(404);
        require __DIR__ . '/404.php';
        exit;
    }

    // Get language data
    $stmt = $pdo->prepare("SELECT * FROM languages WHERE slug = ? LIMIT 1");
    $stmt->execute([$lang_slug]);
    $language = $stmt->fetch();

    if (!$language) {
        header("Location: /404.php", true, 302);
        exit;
    }

    // Get section data
    $stmt = $pdo->prepare("SELECT * FROM sections WHERE slug = ? AND language_id = ? LIMIT 1");
    $stmt->execute([$section_slug, $language['id']]);
    $current_section = $stmt->fetch();

    if (!$current_section) {
        header("Location: /404.php", true, 302);
        exit;
    }

    // Get subsection data
    $stmt = $pdo->prepare("SELECT * FROM subsections WHERE slug = ? AND section_id = ? LIMIT 1");
    $stmt->execute([$subsection_slug, $current_section['id']]);
    $current_subsection = $stmt->fetch();

    if (!$current_subsection) {
        header("Location: /404.php", true, 302);
        exit;
    }

    // Get content blocks
    $stmt = $pdo->prepare("SELECT * FROM content_blocks WHERE subsection_id = ? ORDER BY order_index");
    $stmt->execute([$current_subsection['id']]);
    $content_blocks = $stmt->fetchAll();

    // Get sections for menu
    $stmt = $pdo->prepare("SELECT * FROM sections WHERE language_id = ? ORDER BY order_index");
    $stmt->execute([$language['id']]);
    $sections = $stmt->fetchAll();

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    die("An error occurred while processing your request.");
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
        
        <ul class="list-unstyled ps-0 text-center ">
            <?php foreach ($sections as $section): 
                $is_active_section = ($section['id'] == $current_section['id']);
            ?>
            <li class="mb-1 border-bottom border-1 ">
                <button class="btn btn-toggle d-inline-flex align-items-center rounded collapsed" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#section-<?= $section['id'] ?>"
                        <?= $is_active_section ? 'aria-expanded="true"' : '' ?>>
                    <?= htmlspecialchars($section['title']) ?>
                </button>
                <div class="collapse border p-3 rounded <?= $is_active_section ? 'show' : '' ?>" id="section-<?= $section['id'] ?>">
                    <?php
                    $subsections = $pdo->prepare("SELECT * FROM subsections 
                                                WHERE section_id = ? 
                                                ORDER BY order_index");
                    $subsections->execute([$section['id']]);
                    $subsections_data = $subsections->fetchAll();
                    ?>
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <?php foreach ($subsections_data as $subsection): 
                            $is_active = ($subsection['id'] == $current_subsection['id']);
                        ?>
                        <li class="border-bottom">
                            <a href="/<?= $lang_slug ?>/<?= $section['slug'] ?>/<?= $subsection['slug'] ?>" 
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
    <section class="w-100 h-100 flex-grow-1">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-3" style="background: #DF7070;">
                    <h1 class="text-center text-light p-2">
                        <?= htmlspecialchars($current_subsection['title']) ?>
                    </h1>
                </div>
            </div>

            <?php foreach ($content_blocks as $block): ?>
            <div class="row mb-4">
                <div class="col-12">
                    <?php switch ($block['block_type']):
                        case 'heading': ?>
                            <h3 style="color: #DF7070;">
                                <?= htmlspecialchars_decode($block['content']) ?>
                            </h3>
                            <?php break; ?>
                        
                        <?php case 'subheading': ?>
                            <<?= $block['meta'] ?: 'h4' ?> style="color: #DF7070;">
                                <?= htmlspecialchars_decode($block['content']) ?>
                            </<?= $block['meta'] ?: 'h4' ?>>
                            <?php break; ?>
                        
                        <?php case 'paragraph': ?>
                            <p class="fs-5"><?= htmlspecialchars_decode($block['content']) ?></p>
                            <?php break; ?>
                        
                        <?php case 'code': ?>
                            <pre class="code-block"><code><?= 
                                // Удаляем все начальные пробелы и табы в каждой строке
                                htmlspecialchars(preg_replace('/^[ \t]+/m', '', $block['content']))
                            ?></code></pre>
                        <?php break; ?>
                        
                        <?php case 'list': ?>
                            <ul class="fs-5">
                                <?php
                                $list_items = $pdo->prepare("SELECT * FROM list_items 
                                                            WHERE content_block_id = ? 
                                                            ORDER BY order_index");
                                $list_items->execute([$block['id']]);
                                while ($item = $list_items->fetch()): ?>
                                <li><?= htmlspecialchars_decode($item['content']) ?></li>
                                <?php endwhile; ?>
                            </ul>
                            <?php break; ?>
                    <?php endswitch; ?>
                </div>
            </div>
            <?php endforeach; ?>

            <div class="row mt-4 mb-5">
                <div class="col-12 text-center">
                    <a href="/<?= $lang_slug ?>/tasks" 
                       class="btn btn-lg btn-danger">
                       <i class="fas fa-tasks me-2"></i>Перейти к задачам
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<?php 
require __DIR__ . '/footer.php'; 
?>