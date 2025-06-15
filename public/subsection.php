<!DOCTYPE html>
<html lang="ru">
<?php
require __DIR__ . '/head.php';
?>
<body class="d-flex flex-column min-vh-100">
    <div class="wrapper flex-grow-1">
        <?php
        require __DIR__ . '/header.php';
        
        // Sanitize and validate input parameters
        $lang_slug = isset($_GET['lang_slug']) ? trim(htmlspecialchars($_GET['lang_slug'])) : '';
        $section_slug = isset($_GET['section_slug']) ? trim(htmlspecialchars($_GET['section_slug'])) : '';
        $subsection_slug = isset($_GET['subsection_slug']) ? trim(htmlspecialchars($_GET['subsection_slug'])) : '';
        
        try {
            // Validate required parameters
            if (empty($lang_slug) || empty($section_slug) || empty($subsection_slug)) {
                throw new Exception("Missing required parameters");
            }

            // Get language data
            $stmt = $pdo->prepare("SELECT * FROM languages WHERE slug = ? LIMIT 1");
            $stmt->execute([$lang_slug]);
            $language = $stmt->fetch();

            if (!$language) {
                throw new Exception("Language not found");
            }

            // Get section data
            $stmt = $pdo->prepare("SELECT * FROM sections WHERE slug = ? AND language_id = ? LIMIT 1");
            $stmt->execute([$section_slug, $language['id']]);
            $current_section = $stmt->fetch();

            if (!$current_section) {
                throw new Exception("Section not found");
            }

            // Get subsection data
            $stmt = $pdo->prepare("SELECT * FROM subsections WHERE slug = ? AND section_id = ? LIMIT 1");
            $stmt->execute([$subsection_slug, $current_section['id']]);
            $current_subsection = $stmt->fetch();

            if (!$current_subsection) {
                throw new Exception("Subsection not found");
            }

            // Get content blocks
            $stmt = $pdo->prepare("SELECT * FROM content_blocks WHERE subsection_id = ? ORDER BY order_index");
            $stmt->execute([$current_subsection['id']]);
            $content_blocks = $stmt->fetchAll();

            if (empty($content_blocks)) {
                throw new Exception("No content found");
            }

            // Get sections for menu
            $stmt = $pdo->prepare("SELECT * FROM sections WHERE language_id = ? ORDER BY order_index");
            $stmt->execute([$language['id']]);
            $sections = $stmt->fetchAll();

        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            http_response_code(404);
            require __DIR__ . '/404.php';
            exit;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            http_response_code(500);
            require __DIR__ . '/500.php';
            exit;
        }
        ?>

        <main class="content_page">
            <div class="content_page d-flex">
                <!-- Sidebar Menu -->
                <aside class="flex-shrink-0 p-3 border-end shadow" style="width: 280px;">
                    <div class="d-flex align-items-center justify-content-center pb-3 mb-2 border-bottom border-danger-subtle">
                        <span class="text-center fs-5 fw-semibold">
                            <?= htmlspecialchars($language['name'] ?? '') ?>
                        </span>
                    </div>
                    
                    <ul class="list-unstyled ps-0 text-center">
                        <?php foreach ($sections as $section): 
                            $is_active_section = ($section['id'] == $current_section['id']);
                        ?>
                        <li class="mb-1 border-bottom border-1">
                            <button class="btn btn-toggle d-inline-flex align-items-center rounded collapsed" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#section-<?= htmlspecialchars($section['id'] ?? '') ?>"
                                    <?= $is_active_section ? 'aria-expanded="true"' : '' ?>>
                                <?= htmlspecialchars($section['title'] ?? '') ?>
                            </button>
                            <div class="collapse border p-3 rounded <?= $is_active_section ? 'show' : '' ?>" 
                                 id="section-<?= htmlspecialchars($section['id'] ?? '') ?>">
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
                                        <a href="/<?= htmlspecialchars($lang_slug) ?>/<?= htmlspecialchars($section['slug'] ?? '') ?>/<?= htmlspecialchars($subsection['slug'] ?? '') ?>" 
                                           class="link-body-emphasis d-inline-flex text-decoration-none ms-3 rounded <?= $is_active ? 'active-subsection' : '' ?>">
                                           <?= htmlspecialchars($subsection['title'] ?? '') ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </aside>

                <!-- Main Content -->
                <section class="w-100 h-100 flex-grow-1">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 mb-3 bg-danger">
                                <h1 class="text-center text-light p-2">
                                    <?= htmlspecialchars($current_subsection['title'] ?? '') ?>
                                </h1>
                            </div>
                        </div>

                        <?php foreach ($content_blocks as $block): ?>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <?php 
                                    $block_type = htmlspecialchars($block['block_type'] ?? '');
                                    $block_content = $block['content'] ?? '';
                                    $block_meta = $block['meta'] ?? '';
                                    
                                    switch ($block_type):
                                        case 'heading': ?>
                                            <h3 class="text-danger">
                                                <?= htmlspecialchars_decode($block_content) ?>
                                            </h3>
                                            <?php break; ?>
                                        
                                        <?php case 'subheading': ?>
                                            <<?= !empty($block_meta) ? htmlspecialchars($block_meta) : 'h4' ?> class="text-danger">
                                                <?= htmlspecialchars_decode($block_content) ?>
                                            </<?= !empty($block_meta) ? htmlspecialchars($block_meta) : 'h4' ?>>
                                            <?php break; ?>
                                        
                                        <?php case 'paragraph': ?>
                                            <p class="fs-5"><?= htmlspecialchars_decode($block_content) ?></p>
                                            <?php break; ?>
                                        
                                        <?php case 'code': ?>
                                            <pre class="code-block p-3 bg-light border rounded"><code><?= 
                                                htmlspecialchars(preg_replace('/^[ \t]+/m', '', $block_content))
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
                                                <li><?= htmlspecialchars_decode($item['content'] ?? '') ?></li>
                                                <?php endwhile; ?>
                                            </ul>
                                            <?php break; ?>
                                        
                                        <?php case 'table': ?>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped fs-5">
                                                    <?php
                                                    $rows = explode("\n", trim($block_content));
                                                    $is_first_row = true;
                                                    
                                                    foreach ($rows as $row):
                                                        $row = trim($row, "| \t\n\r\0\x0B");
                                                        if (empty($row)) continue;
                                                        
                                                        $cells = explode('|', $row);
                                                        ?>
                                                        <tr>
                                                            <?php foreach ($cells as $cell):
                                                                $cell = trim($cell);
                                                                if ($is_first_row): ?>
                                                                    <th><?= htmlspecialchars_decode($cell) ?></th>
                                                                <?php else: ?>
                                                                    <td><?= htmlspecialchars_decode($cell) ?></td>
                                                                <?php endif;
                                                            endforeach; ?>
                                                        </tr>
                                                        <?php 
                                                        $is_first_row = false;
                                                    endforeach; ?>
                                                </table>
                                            </div>
                                            <?php break; ?>
                                        
                                        <?php case 'note': ?>
                                            <div class="alert alert-info fs-5">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <?= htmlspecialchars_decode($block_content) ?>
                                            </div>
                                            <?php break; ?>
                                        
                                        <?php case 'warning': ?>
                                            <div class="alert alert-warning fs-5">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                <?= htmlspecialchars_decode($block_content) ?>
                                            </div>
                                            <?php break; ?>
                                        
                                        <?php default: ?>
                                            <div class="content-block">
                                                <?= htmlspecialchars_decode($block_content) ?>
                                            </div>
                                    <?php endswitch; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <div class="row mt-4 mb-5">
                            <div class="col-12 text-center">
                                <a href="/<?= htmlspecialchars($lang_slug) ?>/tasks" 
                                   class="btn btn-lg btn-danger">
                                   <i class="fas fa-tasks me-2"></i>Перейти к задачам
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>

        <?php 
        require __DIR__ . '/footer.php'; 
        ?>
    </div>
</body>
</html>