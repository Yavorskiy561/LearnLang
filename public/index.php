<!DOCTYPE html>
<html lang="ru">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  
  <!--Стили-->  
  <link rel="stylesheet" href="/style_pg/style-animation.css">
  <link rel="stylesheet" href="/style_pg/style_index_head_page.css">
  <link rel="stylesheet" href="/style_pg/style_index_head_page.css">
  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/resourse/logo.svg" height="10" type="image/x-icon">
  <title>learnlang</title>
</head>
<body>
    <!--Главная страница-->
    <div class="wrapper">
        <!--Header главной страницы-->
        <header class="d-flex flex-wrap justify-content-around py-3 border-bottom itd-bg-header p-2" id="header">
          <a href="#about_syte" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <img src="/resourse/logo.svg" height="60"  alt="Логотип">
            <h1 class="logo_name">LearnLang</h1>
          </a>
          <ul class="nav itd-nav nav-pills">
            <li class="nav-item"><a href="index-install-po.php" class="nav-link" id="link_python">Установка ПО</a></li>
            <li class="nav-item"><a href="index_one_python.php" class="nav-link" id="link_python">Python</a></li>
            <li class="nav-item"><a href="index-laungh.php" class="nav-link" id="link_c">C</a></li>
            <li class="nav-item"><a href="index_one_c++.php" class="nav-link" id="link_c_plus_plus">C++</a></li>
            <li class="nav-item"><a href="index_one_java.php" class="nav-link" id="link_java">Java</a></li>
            <li class="nav-item"><a href="index-task-python.php" class="nav-link" id="link_tasks_python">Задачник по Python</a></li>
            <li class="nav-item"><a href="index-task-c.php" class="nav-link" id="link_tasks_C">Задачник по C</a></li>
            <li class="nav-item"><a href="index-task-c++.php" class="nav-link" id="link_tasks_C++">Задачник по C++</a></li>
            <li class="nav-item"><a href="index-task-java.php" class="nav-link" id="link_tasks_java">Задачник по Java</a></li>
          </ul>
      </header>
        
        <!--Content главной страницы-->
        <div class="content_page">
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

          <!--Секция Выбери свой язык программирование-->
          <section class="itd-bg-lang p-4" id="choice_lang">
            <div class="container">
              <div class="row">
                <div class="col-xs-12">
                  <h1 class="fs-50 text-center p-10 fw-bold text-light">Выбери свой язык программирования</h1>
                </div>
              </div>
            </div>
            
          </section>
          <!--Язык программирования Python-->
          <section class="language_programming bg-primary">
            <div class="container">
              <div class="row mb-4 itd-row">
                <div class="col-md-6 col-sm-12 itd-bg">
                    <img src="/resourse/Python.svg" width="150" class="d-block mx-auto rouded mb-4"  alt="язык Python">
                    <p class="itd-text mb-5">Python - это простой и элегантный язык программирования, который обладает читаемым синтаксисом, мощными инструментами и широким спектром применения, от веб-разработки и научных вычислений до автоматизации задач и машинного обучения.</p>
                    <a href="index_one_python.php" class="text-decoration-none learn-btn">Начнем</a>
                </div>
              
                <div class="col-md-6 col-sm-12 bg-warning itd-exampale_bg ">
                  <h3 class="text-center  itd-text">Пример:</h3>
                  <div class="block_lang fw-medium p-2">
                    <span style="color: #FF0000; margin-left: 8px;">print</span><Span style="color: #0000FF">(</Span><span style="color: #008000">"Hello, World!"</span><span style="color: #0000FF">)</span><span style="color: #0000FF">;</span>   
                  </div>
                  
                </div>
              </div>
            </div>
          </section>
          <!--Язык программирования C-->
          <section class="language_programming itd-bg-c">
            <div class="container">
              <div class="row mb-4 itd-row">
                <div class="col-md-6 col-xs-12 itd-bg align-items-center justify-content-center">
                  <img src="/resourse/C.svg" width="150" class="rounded mx-auto d-block mb-4" alt="язык С">
                  <p class="itd-text mb-5">Язык программирования C - это мощный и эффективный язык, который позволяет разработчикам создавать высокопроизводительные и низкоуровневые программы, обладает широкой функциональностью и широко применяется в различных областях разработки программного обеспечения.</p>
                  <a href="index_one_c.php" class="text-decoration-none learn-btn ">Начнем</a>
                </div>
              
                <div class="col-md-6 col-xs-12 itd-bg-column-c itd-exampale_bg">
                  <h3 class="text-center  itd-text">Пример:</h3>
                  <div class="block_lang p-2 fw-medium ">
                    <span style="color: #0000FF">int </span><span style="color: #800080">main</span><span style="color: #0000FF">()</span> <span style="color: #0000FF">{</span><br>
                    <span style="color: #FF0000; margin-left: 8px;">printf</span><Span style="color: #0000FF">(</Span><span style="color: #008000">"Hello, World\n"</span><span style="color: #0000FF">)</span><span style="color: #0000FF">;</span><br>
                    <span style="color: #0000FF; margin-left: 8px;">return </span><span style="color: #800080">0</span><span style="color: #0000FF">;</span><br>
                    <span style="color: #0000FF">}</span>
                  </div>
                  
                </div>
              </div>
            </div>
          </section>
          <!--Язык программирования C++-->
          <section class="language_programming itd-bg-c_plus">
            <div class="container">
              <div class="row mb-4 itd-row">
                <div class="col-md-6 col-sm-12 itd-bg">         
                  <img src="/resourse/c++.svg"  width="150" class="rounded mx-auto d-block mb-4" alt="язык C++">
                  <p class="itd-text mb-5">C++ - это расширенный и мощный язык программирования, который сочетает в себе возможности языка C с объектно-ориентированным программированием, позволяя разработчикам создавать эффективные и гибкие приложения для различных платформ и областей применения.</p>
                  <a href="index_one_c++.php" class="text-decoration-none learn-btn">Начнем</a>
                </div>
              
                <div class="col-md-6 col-sm-12  itd-exampale_bg itd-bg-column-c_plus">
                  <h3 class="text-center  itd-text">Пример:</h3>
                  <div class="block_lang fw-medium p-2">
                    <span style="color: #0000FF">int </span><span style="color: #800080">main</span><span style="color: #0000FF">()</span> <span style="color: #0000FF">{</span><br>
                    <span style="color: #FF0000; margin-left: 8px;">std::cout</span><Span style="color: #0000FF"><<</Span><span style="color: #008000">"Hello, World"</span><span style="color: #0000FF"><<</span><span style="color: #0000FF">std::endl;</span><br>
                    <span style="color: #0000FF; margin-left: 8px;">return </span><span style="color: #800080">0</span><span style="color: #0000FF">;</span><br>
                    <span style="color: #0000FF">}</span>
                  </div>
                  
                </div>
              </div>
            </div>
          </section>
          <!--Язык программирования Java-->
          <section class="language_programming itd-bg-java">
            <div class="container">
              <div class="row mb-4 itd-row">
                <div class="col-md-6 col-sm-12 itd-bg">
                  <img src="/resourse/Java.svg" width="150" class="rounded mx-auto d-block mb-4" alt="язык Java">
                  <p class="text-java mb-5">Java - это универсальный и надежный язык программирования, который обеспечивает платформонезависимость, высокую производительность и обширные возможности разработки приложений, от мобильных устройств до корпоративных систем.</p>
                  <a href="index_one_java.php" class="text-decoration-none learn-btn">Начнем</a>
                </div>
              
                <div class="col-md-6 col-sm-12 itd-exampale_bg itd-column-bg-java ">
                  <h3 class="text-center text-light">Пример:</h3>
                  <div class="block_lang fw-medium p-2">
                    <span style="color: #0000FF">public static void </span><span style="color: #800080">main</span><span style="color: #0000FF">(String[] args)</span> <span style="color: #0000FF">{</span><br>
                      <span style="color: #FF0000; margin-left: 8px;">System.out.println</span><Span style="color: #0000FF">(</Span><span style="color: #008000">"Hello, World"</span><Span style="color: #0000FF">)</Span><span style="color: #0000FF">;</span><br>
                      <span style="color: #0000FF">}</span>
                  </div>
                  
                </div>
              </div>
            </div>
          </section>
        </div>
        <!--Footer главной страницы-->
        <footer class="d-flex  align-items-center p-4 border-top" id="footer">
          <p class="col-md-6 mb-0 text-light">Яворский Илья</p>
      
          <ul class="nav col-md-6 d-flex">
            <div class="container">
              <div class="row">
                <div class="col">
                  <li class="nav-item"><a href="index-install-po.php" class="nav-link px-2 text-light">Установка ПО</a></li>
                  <li class="nav-item"><a href="index_one_python.php" class="nav-link px-2 text-light">Python</a></li>
                </div>
            
                <div class="col">
                  <li class="nav-item"><a href="index_one_c.php" class="nav-link px-2 text-light">C</a></li>
                  <li class="nav-item"><a href="index_one_c++.php" class="nav-link px-2 text-light">C++</a></li>
                </div>
                <div class="col">
                  <li class="nav-item"><a href="index-task-python.php" class="nav-link px-2 text-light">Задачник по Python</a></li>
                  <li class="nav-item"><a href="index-task-c.php" class="nav-link px-2 text-light">Задачник по C</a></li>
                </div>
                <div class="col">
                  <li class="nav-item"><a href="index-task-c++.php" class="nav-link px-2 text-light">Задачник по C++</a></li>
                  <li class="nav-item"><a href="index-task-java.php" class="nav-link px-2 text-light">Задачник по Java</a></li>
                </div>
              </div>
            </div>
          </ul>
        </footer>
      </div>
    </div>
</body>
</html>
