<?php
require __DIR__ . '/header.php';

try {
    // Получаем параметры с проверкой
    $lang_slug = $_GET['lang_slug'] ?? '';
    $section_slug = $_GET['section_slug'] ?? '';
    $subsection_slug = $_GET['subsection_slug'] ?? '';

    // Получаем данные языка
    $stmt = $pdo->prepare("SELECT * FROM languages WHERE slug = ?");
    $stmt->execute([$lang_slug]);
    $language = $stmt->fetch();

    if (!$language) {
        throw new Exception("Язык не найден");
    }

    // Получаем данные подраздела
    $stmt = $pdo->prepare("SELECT subs.*, sec.title AS section_title 
                          FROM subsections subs
                          JOIN sections sec ON subs.section_id = sec.id
                          JOIN languages lang ON sec.language_id = lang.id
                          WHERE lang.slug = ? 
                            AND sec.slug = ? 
                            AND subs.slug = ?");
    $stmt->execute([$lang_slug, $section_slug, $subsection_slug]);
    $subsection = $stmt->fetch();

    if (!$subsection) {
        http_response_code(404);
        include __DIR__ . '/404.php';
        exit;
    }

    // Получаем контент подраздела
    $stmt = $pdo->prepare("SELECT * FROM content_blocks 
                      WHERE subsection_id = ? 
                      ORDER BY order_index");
    $stmt->execute([$subsection['id']]);
    $content_blocks = $stmt->fetchAll();

    // Получаем все разделы для меню
    $stmt = $pdo->prepare("SELECT * FROM sections 
                          WHERE language_id = ? 
                          ORDER BY order_index");
    $stmt->execute([$language['id']]);
    $sections = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Ошибка базы данных: " . $e->getMessage());
} catch (Exception $e) {
    die($e->getMessage());
}
?>
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
            min-height: 120vh;
        }
        .content_page{
            display: flex;
            flex-direction: column;
            min-height: 390vh;
        }
        .content_page {
            flex: 1;
        }
        
    </style>
<div class="content_page d-flex">
    <!-- Боковое меню -->
    <div class="flex-shrink-0 p-3 border-end shadows border-3" style="width: 280px;">
        <div class="d-flex align-items-center justify-content-center pb-3 mb-2 border-bottom border-danger-subtle">
            <span class="text-center fs-5 fw-semibold">
                <?= htmlspecialchars($language['name']) ?>
            </span>
        </div>
        <ul class="list-unstyled ps-0">
            <?php foreach ($sections as $section): 
                $is_active = ($section['slug'] === $section_slug);
            ?>
            <li class="mb-1 border-bottom border-1">
                <button class="btn btn-toggle d-inline-flex align-items-center rounded collapsed <?= $is_active ? 'active' : '' ?>" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#<?= htmlspecialchars($section['slug']) ?>"
                        <?= $is_active ? 'aria-expanded="true"' : '' ?>>
                    <?= htmlspecialchars($section['title']) ?>
                </button>
                <div class="collapse <?= $is_active ? 'show' : '' ?>" id="<?= htmlspecialchars($section['slug']) ?>">
                    <?php
                    $subsections = $pdo->prepare("SELECT * FROM subsections 
                                                WHERE section_id = ? 
                                                ORDER BY order_index");
                    $subsections->execute([$section['id']]);
                    $subsections_data = $subsections->fetchAll();
                    ?>
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <?php foreach ($subsections_data as $sub): 
                            $is_sub_active = ($sub['slug'] === $subsection_slug && $section['slug'] === $section_slug);
                        ?>
                        <li>
                            <a href="/<?= htmlspecialchars($lang_slug) ?>/<?= htmlspecialchars($section['slug']) ?>/<?= htmlspecialchars($sub['slug']) ?>" 
                               class="link-body-emphasis d-inline-flex text-decoration-none ms-3 rounded <?= $is_sub_active ? 'active-subsection' : '' ?>">
                               <?= htmlspecialchars($sub['title']) ?>
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
    <section class="w-100% h-100%">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-3" style="background: #DF7070;">
                    <h1 class="text-center text-light p-2">
                        <?= htmlspecialchars($subsection['title']) ?>
                    </h1>
                </div>
                <div class="col-12">
                    <?php foreach ($content_blocks as $block): ?>
                        <div class="mb-4">
                            <?php switch($block['block_type']):
                                case 'heading': ?>
                                    <h3><?= htmlspecialchars_decode($block['content']) ?></h3>
                                <?php break; ?>
                                
                                <?php case 'subheading': ?>
                                    <<?= $block['meta'] ?: 'h4' ?>>
                                        <?= htmlspecialchars_decode($block['content']) ?>
                                    </<?= $block['meta'] ?: 'h4' ?>>
                                <?php break; ?>
                                
                                <?php case 'paragraph': ?>
                                    <p class="fs-5"><?= htmlspecialchars_decode($block['content']) ?></p>
                                <?php break; ?>
                                
                                <?php case 'code': ?>
                                    <pre class="border p-3"><code class="language-<?= $block['meta'] ?>">
                                        <?= htmlspecialchars(trim($block['content'])) ?>
                                    </code></pre>
                                <?php break; ?>
                                
                            <?php endswitch; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require __DIR__ . '/footer.php'; ?>