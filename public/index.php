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
  <link rel="stylesheet" href="/style_pg/subsection.css">
  
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
    <div class="wrapper flex-grow-1"></div>

<?php
  require __DIR__ . '/header.php';
?>
  <main class="content_page">
        <!--Content главной страницы-->
        
            <!--Секция Об сайте-->
          <section class="about_syte" id="about_syte">
            <div class="container container-itd">
              <div class="row">
                <div class="col-12">
                  <h2 class="text-center mb-4 justify-content-center m-auto">Об сайте</h2>
                </div>
                <div class="row justify-content-center">
                  <div class="col-xs-12 col-md-6 border rounded bg-light justify-content-center itd-color fw-medium align-items-center">
                    <p class="m-auto fs-4 text-center p-5">
                      LearnLang — это комплексный образовательный ресурс для программистов и начинающих, стремящихся изучить самые популярные и востребованные языки программирования.
                    </p> 
                  </div>
                  <div class="col-sm-12 col-md-6">
                      <img src="/resourse/1kbx.gif" class="justify-content-center m-auto" width="600" alt="">
                  </div>
                </div>
              </div>
            </div> 
          </section>
            <!--Секция Почему именно программирование-->
          <section class="about_programming" id="about_programming">
              <div class="container">
                <div class="row">
                  <div class="col-12 itd-bg-p">
                    <h3 class="text-center mb-2 ">Почему именно программирование</h3>
                </div>
              </div>
                <div class="row g-2">
                  <div class="col-xs-12">
                    <div class="p-3 d-flex justify-content-center mb-4 itd-bg-p">
                      <img src="/resourse/12217746_4903700 1.svg" class="me-4 justify-content-center" alt="Развитие технологий" height="200">
                      <P class="justify-content-center d-block m-auto fs-5 ">
                        1. Развитие технологий: В современном мире технологии играют ключевую роль в повседневной жизни. Программирование позволяет создавать новые технологии и улучшать существующие.
                      </P>
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="p-1 d-flex justify-content-center mb-4 itd-bg-p">
                      <p class="justify-content-center d-block m-auto fs-5">
                        2. Карьерные возможности: Навыки программирования ценятся многими компаниями, и работа в области IT может предоставить хорошие карьерные возможности и высокую заработную плату.
                      </p>
                      <img src="/resourse/15378168_5602758 1.svg" class="ms-4" alt="Карьерный возможности" height="200">
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="p-3 d-flex justify-content-center itd-bg-p">
                      <img src="/resourse/19184617_6100978 1.svg" class="me-4 justify-content-center" alt="Решение проблем" height="200">
                      <p class="justify-content-center d-block m-auto fs-5">
                        3. Решение проблем: Программирование учит аналитическому мышлению и способности решать сложные проблемы. Эти навыки пригодятся не только в сфере IT, но и в других областях.
                      </p>
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="p-3 d-flex justify-content-center ">
                    <p class="justify-content-center d-block m-auto fs-5">
                      4. Творческий потенциал: Создание программ и приложений может быть творческим процессом, открывающим новые возможности для самовыражения и реализации идей.
                    </p>
                    <img src="/resourse/22635615_6665862 1.svg" class="ms-4" alt="Творческий процесс" height="200">
                  </div>
                    </div>
                </div>
              </div>
          </section>

          <!-- Секция Выбери свой язык программирования -->
<section class="itd-bg-lang p-4" id="choice_lang">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="fs-50 text-center p-10 fw-bold text-light">Выбери свой язык программирования</h1>
            </div>
        </div>
    </div>
</section>

<!-- Динамические секции для каждого языка программирования -->
<?php foreach ($languages as $lang): 
    $lang_slug = htmlspecialchars($lang['slug']);
    $is_lang_active = ($current_uri === $lang_slug);
    $is_tasks_active = str_starts_with($current_uri, $lang_slug.'/tasks');
    
    // Определяем классы для разных языков
    $bg_class = '';
    $column_bg_class = '';
    $text_class = 'itd-text';
    
    switch ($lang_slug) {
        case 'c':
            $bg_class = 'itd-bg-c';
            $column_bg_class = 'itd-bg-column-c';
            break;
        case 'python':
            $bg_class = 'bg-primary';
            $column_bg_class = 'bg-warning';
            break;
        case 'cpp':
            $bg_class = 'itd-bg-c_plus';
            $column_bg_class = 'itd-bg-column-c_plus';
            break;
        case 'java':
            $bg_class = 'itd-bg-java';
            $column_bg_class = 'itd-column-bg-java';
            $text_class = 'text-light';
            break;
    }
    ?>
    
    <section class="language_programming <?= $bg_class ?>">
        <div class="container">
            <div class="row mb-4 itd-row">
                <div class="col-md-6 col-sm-12 itd-bg">
                    <img src="/resourse/<?= ucfirst($lang['name']) ?>.svg" width="150" class="d-block mx-auto rounded mb-4" alt="язык <?= $lang['name'] ?>">
                    <p class="<?= $text_class ?> mb-5"><?= $lang['description'] ?></p>
                    <a href="/<?= $lang_slug ?>" class="text-decoration-none learn-btn <?= $is_lang_active ? 'active' : '' ?>">Начнем</a>
                </div>
              
                <div class="col-md-6 col-sm-12 itd-exampale_bg <?= $column_bg_class ?>">
                    <h3 class="text-center <?= $text_class ?>">Пример:</h3>
                    <div class="block_lang fw-medium p-2">
                        <?php 
                        // Выводим пример кода в зависимости от языка
                        switch ($lang_slug) {
                            case 'c':
                                echo '<span>int main() { <br><span style="margin-left:10px;">printf("Hello, World");</span><br><span style="margin-left:10px;">return 0;</span><br>}</span>';
                                break;
                            case 'python':
                                echo '<span>print("Hello, World!");</span>';
                                break;
                            case 'cpp':
                                echo '<span>int main() {<br><span style="margin-left:10px;">std::cout<<"Hello, World"<<std::endl;</span><br><span style="margin-left:10px;">return 0;</span><br>}</span>';
                                break;
                            case 'java':
                                echo '<span>public static void main(String[] args) {<br><span style="margin-left:10px;">System.out.println("Hello, World");</span><br>}</span>';
                                break;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endforeach; ?>
 </main>
<?php
  require __DIR__ . '/footer.php'; 
?>
 </div>
    </body>
</html>