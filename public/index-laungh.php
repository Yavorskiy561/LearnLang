<!DOCTYPE html>
<html lang="ru">
<?php
require __DIR__ . '/head.php';
?>
<body class="d-flex flex-column min-vh-100"> 
    <div class="wrapper flex-grow-1">
        <?php
        require __DIR__ . '/header.php';
        
        // Improved URL parsing with error handling
        $request_uri = isset($_SERVER['REQUEST_URI']) ? trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') : '';
        $uri_parts = $request_uri ? explode('/', $request_uri) : [];
        
        $lang_slug = htmlspecialchars($uri_parts[0] ?? 'c');
        $section_slug = isset($uri_parts[1]) ? htmlspecialchars($uri_parts[1]) : null;
        $subsection_slug = isset($uri_parts[2]) ? htmlspecialchars($uri_parts[2]) : null;
        
        try {
            // Get language data with prepared statement
            $stmt = $pdo->prepare("SELECT * FROM languages WHERE slug = ?");
            $stmt->execute([$lang_slug]);
            $language = $stmt->fetch();
        
            if (!$language) {
                header("HTTP/1.0 404 Not Found");
                header("Location: /404.php");
                exit;
            }
        
            // Get language sections
            $stmt = $pdo->prepare("SELECT * FROM sections 
                                  WHERE language_id = ? 
                                  ORDER BY order_index");
            $stmt->execute([$language['id']]);
            $sections = $stmt->fetchAll();
        
            // Subsection logic
            $current_subsection = null;
            $content_blocks = [];
            $current_section = null;
        
            if ($section_slug && $subsection_slug) {
                // Get current section with language check
                $stmt = $pdo->prepare("SELECT * FROM sections 
                                      WHERE slug = ? 
                                      AND language_id = ?");
                $stmt->execute([$section_slug, $language['id']]);
                $current_section = $stmt->fetch();
        
                if ($current_section) {
                    // Get subsection
                    $stmt = $pdo->prepare("SELECT * FROM subsections 
                                          WHERE slug = ? 
                                          AND section_id = ?");
                    $stmt->execute([$subsection_slug, $current_section['id']]);
                    $current_subsection = $stmt->fetch();
        
                    if ($current_subsection) {
                        // Get content blocks
                        $stmt = $pdo->prepare("SELECT * FROM content_blocks 
                                              WHERE subsection_id = ? 
                                              ORDER BY order_index");
                        $stmt->execute([$current_subsection['id']]);
                        $content_blocks = $stmt->fetchAll();
                    }
                }
            }
        
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            header("Location: /500.php");
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
                            $section_id = htmlspecialchars($section['id'] ?? '');
                            $section_slug_val = htmlspecialchars($section['slug'] ?? '');
                            $section_title = htmlspecialchars($section['title'] ?? '');
                            $is_active_section = ($section_slug === $section_slug_val);
                        ?>
                        <li class="mb-1 border-bottom border-1">
                            <button class="btn btn-toggle d-inline-flex align-items-center rounded collapsed" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#section-<?= $section_id ?>"
                                    <?= $is_active_section ? 'aria-expanded="true"' : '' ?>>
                                <?= $section_title ?>
                            </button>
                            <div class="border rounded collapse p-3 <?= $is_active_section ? 'show' : '' ?>" 
                                id="section-<?= $section_id ?>">
                                <?php
                                $subsections = $pdo->prepare("SELECT * FROM subsections 
                                                            WHERE section_id = ? 
                                                            ORDER BY order_index");
                                $subsections->execute([$section['id']]);
                                $subsections_data = $subsections->fetchAll();
                                ?>
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <?php foreach ($subsections_data as $subsection): 
                                        $subsection_slug_val = htmlspecialchars($subsection['slug'] ?? '');
                                        $subsection_title = htmlspecialchars($subsection['title'] ?? '');
                                        $is_active = ($subsection_slug_val === $subsection_slug);
                                    ?>
                                    <li class="border-bottom">
                                        <a href="/<?= htmlspecialchars($language['slug']) ?>/<?= $section_slug_val ?>/<?= $subsection_slug_val ?>" 
                                        class="link-body-emphasis d-inline-flex text-decoration-none ms-3 rounded <?= $is_active ? 'active-subsection' : '' ?>">
                                        <?= $subsection_title ?>
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
                        <?php if ($current_subsection): ?>
                            <!-- Subsection Header -->
                            <div class="row">
                                <div class="col-12 mb-3 bg-danger">
                                    <h1 class="text-center text-light p-2">
                                        <?= htmlspecialchars($current_subsection['title'] ?? '') ?>
                                    </h1>
                                </div>
                            </div>

                            <!-- Content Blocks -->
                            <?php foreach ($content_blocks as $block): 
                                $block_type = htmlspecialchars($block['block_type'] ?? '');
                                $block_content = $block['content'] ?? '';
                                $block_meta = $block['meta'] ?? '';
                            ?>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <?php 
                                    switch ($block_type) {
                                        case 'heading':
                                            echo '<h2 class="mb-3">'.htmlspecialchars_decode($block_content).'</h2>';
                                            break;
                                        
                                        case 'subheading':
                                            $tag = !empty($block_meta) ? htmlspecialchars($block_meta) : 'h3';
                                            echo "<$tag class='mb-3'>".htmlspecialchars_decode($block_content)."</$tag>";
                                            break;
                                        
                                        case 'paragraph':
                                            echo '<p class="fs-5">'.htmlspecialchars_decode($block_content).'</p>';
                                            break;
                                        
                                        case 'code':
                                            echo '<div class="border border-3 rounded p-3 mb-3 code-block">';
                                            echo '<pre><code class="language-'.htmlspecialchars($block_meta).'">';
                                            echo htmlspecialchars(trim($block_content));
                                            echo '</code></pre></div>';
                                            break;
                                        
                                        case 'list':
                                            echo '<ul class="fs-5">';
                                            $list_items = $pdo->prepare("SELECT * FROM list_items 
                                                                        WHERE content_block_id = ? 
                                                                        ORDER BY order_index");
                                            $list_items->execute([$block['id']]);
                                            while ($item = $list_items->fetch()) {
                                                echo '<li>'.htmlspecialchars_decode($item['content'] ?? '').'</li>';
                                            }
                                            echo '</ul>';
                                            break;
                                        
                                        default:
                                            echo '<div class="content-block">';
                                            echo htmlspecialchars_decode($block_content);
                                            echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            
                            <!-- Tasks Button -->
                            <div class="row mt-4 mb-5">
                                <div class="col-12 text-center">
                                    <a href="/<?= htmlspecialchars($language['slug']) ?>/tasks" 
                                    class="btn btn-lg btn-danger">
                                    <i class="fas fa-tasks me-2"></i>Перейти к задачам
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Default Content -->
                            <div class="row">
                                <div class="col-12 mb-3 bg-danger">
                                    <h1 class="text-center text-light p-2">Рекомендация перед изучением</h1>
                                </div>
                                <div class="col-12">
                                    <p class="fs-5 p-4">
                                        Этот учебник предназначен для тех, кто хочет овладеть основами программирования и приобрести навыки, необходимые для создания программного обеспечения. Независимо от вашего уровня знаний, будь то абсолютный новичок или человек с небольшим опытом, этот учебник предложит вам курс, начиная с основных концепций и заканчивая практическими проектами.
                                        Перед изучением материала рекомендуем посетить страницу <a href="/index-install-po.php">Установка ПО</a>, где подробно описана установка программного обеспечения.
                                    </p>
                                </div>
                                <div class="col-12 mb-3 bg-danger">
                                    <h1 class="text-center text-light p-2">
                                        Учебник по <?= htmlspecialchars($language['name'] ?? '') ?>
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
        </main>
        
        <?php 
        require __DIR__ . '/footer.php'; 
        ?>
    </div>
</body>
</html>