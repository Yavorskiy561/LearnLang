<!DOCTYPE html>
<html lang="ru">
<?php
require __DIR__ . '/head.php';
?>
<body class="d-flex flex-column min-vh-100">
    <div class="wrapper flex-grow-1">
        <?php
        require __DIR__ . '/header.php';
        ?>
        
        <main class="content_page">
            <section class="mb-3 itd-bg-install-po">
                <div class="container">
                    <div class="row">
                        <div class="col-12 mb-3 border-bottom border-primary">
                            <h1 class="text-center p-3 itd-title-po">Установка Visual Studio</h1>
                        </div>
                        
                        <!-- Step 1 -->
                        <div class="row mb-3 border-bottom border-primary">
                            <div class="col-12">
                                <h2 class="mb-3">Шаг 1. Подготовка компьютера к установке Visual Studio</h2>
                                <p class="fs-5 ms-1">Перед началом установки Visual Studio:</p>
                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item border-0 fs-5">Проверьте требования к системе. Так вы узнаете, может ли ваш компьютер поддерживать Visual Studio 2022.</li>
                                    <li class="list-group-item border-0 fs-5">Убедитесь, что пользователь, выполняющий начальную установку, имеет разрешения администратора на компьютере.</li>
                                    <li class="list-group-item border-0 fs-5">Примените актуальные обновления Windows. Эти обновления гарантируют, что на компьютере установлены последние обновления для системы безопасности и необходимые системные компоненты для Visual Studio.</li>
                                    <li class="list-group-item border-0 fs-5">Перезапуск. Перезагрузка гарантирует, что ожидающие установки или обновления компоненты не будут препятствовать установке Visual Studio.</li>
                                    <li class="list-group-item border-0 fs-5">Освободите место. Удалите ненужные файлы и приложения с системного диска. Например, запустите приложение очистки диска.</li>
                                </ol>
                            </div>
                        </div>
                        
                        <!-- Step 2 -->
                        <div class="row mb-3 border-bottom border-primary">
                            <div class="col-12">
                                <h2 class="mb-3">Шаг 2. Определение версии и выпуска Visual Studio для установки</h2>
                                <p class="fs-5 ms-1">Вам потребуется решить, какая версия и выпуск Visual Studio необходимо установить. Наиболее распространенными вариантами являются:</p>
                                <ul class="list-group">
                                    <li class="list-group-item border-0 fs-5">Последний выпуск Visual Studio 2022, размещенный на серверах Майкрософт. Чтобы установить это, нажмите следующую кнопку и выберите нужный выпуск.</li>
                                    <div class="text-center my-3">
                                        <a href="https://visualstudio.microsoft.com/ru/downloads/?cid=learn-onpage-download-install-visual-studio-page-cta" 
                                           class="btn btn-primary btn-lg" 
                                           target="_blank" 
                                           rel="noopener noreferrer">
                                            Скачать Visual Studio
                                        </a>
                                    </div>
                                    <li class="list-group-item border-0 fs-5">Если у вас уже установлена Visual Studio, вы можете установить другую версию вместе с ней, выбрав ее на вкладке "Доступный установщик Visual Studio".</li>
                                    <li class="list-group-item border-0 fs-5">Загрузчик можно скачать для очень конкретной версии на странице журнала выпусков Visual Studio 2022 и использовать его для установки Visual Studio.</li>
                                    <li class="list-group-item border-0 fs-5">ИТ-администратор может указать вам определенное расположение для установки Visual Studio.</li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Step 3 -->
                        <div class="row mb-3 border-bottom border-primary">
                            <div class="col-12">
                                <h2 class="mb-3">Шаг 3. Запуск установки</h2>
                                <p class="fs-5 ms-1">Если вы скачали загрузочный файл, его можно использовать для установки Visual Studio, если у вас есть разрешения администратора.</p>
                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item border-0 fs-5">В папке "Загрузки" дважды щелкните загрузчик с именем VisualStudioSetup.exe или с именем vs_community.exe, чтобы начать установку.</li>
                                    <li class="list-group-item border-0 fs-5">Если появляется оповещение системы контроля учетных записей, нажмите кнопку Да. Мы попросим вас принять условия лицензии и заявление о конфиденциальности корпорации Майкрософт. Выберите Продолжить.</li>
                                </ol>
                                <div class="text-center my-3">
                                    <img src="/resourse/modals_window.png" 
                                         class="img-fluid rounded border" 
                                         alt="Модальное окно установки Visual Studio">
                                    <p class="text-muted mt-2">Окно принятия лицензионного соглашения</p>
                                </div>
                                <p class="fs-5">Вы также можете инициировать установку любого продукта, предлагаемого на вкладке "Доступный установщик Visual Studio".</p>
                            </div>
                        </div>
                        
                        <!-- Step 4 -->
                        <div class="row mb-3 border-bottom border-primary">
                            <div class="col-12">
                                <h2 class="mb-3">Шаг 4. Выбор рабочих нагрузок</h2>
                                <p class="fs-5 ms-1">После установки установщика Visual Studio его можно использовать для настройки установки, выбрав нужные наборы компонентов или рабочие нагрузки.</p>
                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item border-0 fs-5">
                                        Выберите нужную рабочую нагрузку в Visual Studio Installer.
                                        <div class="text-center my-3">
                                            <img src="/resourse/vs-installer-workloads.png" 
                                                 class="img-fluid rounded border" 
                                                 alt="Выбор рабочих нагрузок в установщике Visual Studio">
                                            <p class="text-muted mt-2">Окно выбора рабочих нагрузок</p>
                                        </div>
                                        Ознакомьтесь с описаниями рабочих нагрузок, чтобы решить, какая рабочая нагрузка поддерживает необходимые функции.
                                    </li>
                                    <li class="list-group-item border-0 fs-5">Выбрав нужные рабочие нагрузки, нажмите кнопку Установить.</li>
                                </ol>
                                <p class="fs-5 mt-3">Далее будут отображаться экраны состояния, на которых демонстрируется ход установки Visual Studio.</p>
                            </div>
                        </div>
                        
                        <!-- Step 5 -->
                        <div class="row mb-3 border-bottom border-primary">
                            <div class="col-12">
                                <h2 class="mb-3">Шаг 5. Выбор отдельных компонентов (необязательно)</h2>
                                <p class="fs-5 ms-1">Если вы не хотите использовать функцию "Рабочие нагрузки", можно установить отдельные компоненты на вкладке "Отдельные компоненты".</p>
                                <div class="text-center my-3">
                                    <img src="/resourse/vs-installer-individual-components.png" 
                                         class="img-fluid rounded border" 
                                         alt="Выбор отдельных компонентов в установщике Visual Studio">
                                    <p class="text-muted mt-2">Окно выбора отдельных компонентов</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Step 6 -->
                        <div class="row mb-3 border-bottom border-primary">
                            <div class="col-12">
                                <h2 class="mb-3">Шаг 6. Установка языковых пакетов (необязательно)</h2>
                                <p class="fs-5 ms-1">По умолчанию при первом запуске установщик пытается использовать язык операционной системы.</p>
                                <div class="text-center my-3">
                                    <img src="/resourse/vs-installer-language-packs.png" 
                                         class="img-fluid rounded border" 
                                         alt="Выбор языковых пакетов в установщике Visual Studio">
                                    <p class="text-muted mt-2">Окно выбора языковых пакетов</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Step 7 -->
                        <div class="row mb-3 border-bottom border-primary">
                            <div class="col-12">
                                <h2 class="mb-3">Шаг 7. Выбор расположения установки (дополнительно)</h2>
                                <p class="fs-5 ms-1">Вы можете уменьшить место, занимаемое установкой Visual Studio на системном диске.</p>
                                <div class="text-center my-3">
                                    <img src="/resourse/vs-installer-installation-locations.png" 
                                         class="img-fluid rounded border" 
                                         alt="Выбор расположения установки Visual Studio">
                                    <p class="text-muted mt-2">Окно выбора расположения установки</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Step 8 -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <h2 class="mb-3">Шаг 8. Начало разработки</h2>
                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item border-0 fs-5">Когда установка Visual Studio завершится, нажмите кнопку Запустить, чтобы приступить к разработке в Visual Studio.</li>
                                    <li class="list-group-item border-0 fs-5">На начальном экране выберите Создать проект.</li>
                                    <li class="list-group-item border-0 fs-5">
                                        В поле поиска шаблонов введите тип приложения, которое вы хотите создать, чтобы просмотреть список доступных шаблонов. 
                                        <div class="alert alert-info mt-2">
                                            Список шаблонов зависит от рабочих нагрузок, выбранных во время установки.
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 fs-5">Новый проект откроется в Visual Studio, и вы можете приступить к написанию кода!</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        
        <?php
        require __DIR__ . '/footer.php'; 
        ?>
    </div>
</body>
</html>