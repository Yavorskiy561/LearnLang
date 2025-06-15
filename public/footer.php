 <?php
 // footer.php
 ?>
<!-- footer страницы -->
             
     
<footer class="mt-auto py-4 bg-dark text-white">
    <div class="container">
        <div class="row">
            <!-- Блок с языками -->
            <div class="col-md-4 mb-4">
                <h5 class="text-warning">Языки программирования</h5>
                <ul class="nav flex-column">
                    <?php foreach ($languages as $lang): 
                        $is_active = (isset($_GET['lang']) && $_GET['lang'] === $lang['slug']);
                    ?>
                    <li class="nav-item">
                        <a href="/<?= htmlspecialchars($lang['slug']) ?>" 
                           class="nav-link <?= $is_active ? 'text-danger' : 'text-white' ?>">
                           <?= htmlspecialchars($lang['name']) ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Блок с задачниками -->
            <div class="col-md-4 mb-4">
                <h5 class="text-warning">Практика</h5>
                <ul class="nav flex-column">
                    
                    <?php foreach ($languages as $lang): ?>
                    <li class="nav-item">
                        <a href="/<?= htmlspecialchars($lang['slug']) ?>/tasks" 
                        class="nav-link text-white">
                        Задачи по <?= htmlspecialchars($lang['name']) ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Контакты -->
            <div class="col-md-4">
                <h5 class="text-warning">Контакты</h5>
                <div class="d-flex flex-column">
                    <a href="http://t.me/silux4" class="text-white mb-2">
                        <i class="fab fa-telegram me-2"></i>Telegram
                    </a>
                    <a href="mailto:yavorskiy_ilya@inbox.ru" class="text-white mb-2">
                        <i class="fas fa-envelope me-2"></i>Почта
                    </a>
                    <a href="https://github.com/Yavorskiy561/LearnLang" class="text-white">
                        <i class="fab fa-github me-2"></i>GitHub проекта
                    </a>
                </div>
            </div>
        </div>
        
        <div class="row mt-4 border-top pt-3">
            <div class="col-12 text-center">
                <p class="mb-0 text-light">&copy; <?= date('Y') ?> LearnLang. Все материалы находятся в свободном доступе</p>
            </div>
        </div>
    </div>
</footer>
       