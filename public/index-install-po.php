<?php
  require __DIR__ . '/header.php';
?>
            <!--Главный контент-->
            <section class="mb-3 itd-bg-install-po">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 mb-3" style="border-bottom: #95ACFD 1px solid;">
                            <h1 class="text-center p-3 itd-title-po">Установка Visual Studio.</h1>
                        </div>
                        <div class="row mb-3" style="border-bottom: #95ACFD 1px solid;">
                            <div class="col-xs-12">
                                <h3 class="mb-3">Шаг 1. Подготовка компьютера к установке Visual Studio</h3>
                                <p class="fs-5 ms-1">Перед началом установки Visual Studio:</p>
                                <ol>
                                    <li class="mb-2 fs-5">Проверьте требования к системе. Так вы узнаете, может ли ваш компьютер поддерживать Visual Studio 2022.</li>
                                    <li class="mb-2 fs-5">Убедитесь, что пользователь, выполняющий начальную установку, имеет разрешения администратора на компьютере. Дополнительные сведения см. в разделе Разрешения пользователей и Visual Studio.</li>
                                    <li class="mb-2 fs-5">Примените актуальные обновления Windows. Эти обновления гарантируют, что на компьютере установлены последние обновления для системы безопасности и необходимые системные компоненты для Visual Studio.</li>
                                    <li class="mb-2 fs-5">Перезапуск. Перезагрузка гарантирует, что ожидающие установки или обновления компоненты не будут препятствовать установке Visual Studio.</li>
                                    <li class="mb-2 fs-5">Освободите место. Удалите ненужные файлы и приложения с системного диска. Например, запустите приложение очистки диска.</li>
                                </ol>
                            </div>
                        </div>
                        <div class="row mb-3" style="border-bottom: #95ACFD 1px solid;">
                            <div class="col-xs-12">
                                <h3 class="mb-3">Шаг 2. Определение версии и выпуска Visual Studio для установки</h3>
                                <p class="fs-5 ms-1">Вам потребуется решить, какая версия и выпуск Visual Studio необходимо установить. Наиболее распространенными вариантами являются:</p>
                                <ul>
                                    <li class="mb-2 fs-5">Последний выпуск Visual Studio 2022, размещенный на серверах Майкрософт. Чтобы установить это, нажмите следующую кнопку и выберите нужный выпуск. Затем небольшой загрузочный файл будет скачан в папку downloads .</li>
                                    <a href="https://visualstudio.microsoft.com/ru/downloads/?cid=learn-onpage-download-install-visual-studio-page-cta" class="learn-btn text-decoration-none mt-3 mb-3">Скачать Visual Studio</a>
                                    <li class="mb-2 fs-5">Если у вас уже установлена Visual Studio, вы можете установить другую версию вместе с ней, выбрав ее на вкладке "Доступный установщик Visual Studio".</li>
                                    <li class="mb-2 fs-5">Загрузчик можно скачать для очень конкретной версии на странице журнала выпусков Visual Studio 2022 и использовать его для установки Visual Studio.</li>
                                    <li class="mb-2 fs-5">ИТ-администратор может указать вам определенное расположение для установки Visual Studio.</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mb-3" style="border-bottom: #95ACFD 1px solid;">
                            <div class="col-xs-12">
                                <h3 class="mb-3">Шаг 3. Запуск установки</h3>
                                <p class="fs-5 ms-1">Если вы скачали загрузочный файл, его можно использовать для установки Visual Studio, если у вас есть разрешения администратора. Загрузчик сначала установит последнюю версию установщика Visual Studio. Установщик — это отдельная программа, которая предоставляет все необходимые компоненты для установки и настройки Visual Studio.</p>
                                <ol>
                                    <li class="mb-2 fs-5">В папке "Загрузки" дважды щелкните загрузчик с именем VisualStudioSetup.exe или с именем vs_community.exe, чтобы начать установку.</li>
                                    <li class="mb-2 fs-5">Если появляется оповещение системы контроля учетных записей, нажмите кнопку Да. Мы попросим вас принять условия лицензии и заявление о конфиденциальности корпорации Майкрософт. Выберите Продолжить.</li>
                                </ol>
                                <img src="resourse/modals_window.png" class="mb-3 mt-2 mx-auto d-block" alt="модальное окно">
                                <p class="fs-5">Вы также можете инициировать установку любого продукта, предлагаемого на вкладке "Доступный установщик Visual Studio".</p>
                            </div>
                        </div>
                        <div class="row mb-3" style="border-bottom: #95ACFD 1px solid;">
                            <div class="col-xs-12">
                                <h3 class="mb-3">Шаг 4. Выбор рабочих нагрузок</h3>
                                <p class="fs-5 ms-1">После установки установщика Visual Studio его можно использовать для настройки установки, выбрав нужные наборы компонентов или рабочие нагрузки. Это делается следующим образом.</p>
                                <ol class="">
                                    <li class="mb-2 fs-5">Выберите нужную рабочую нагрузку в Visual Studio Installer.
                                        <img src="resourse/vs-installer-workloads.png" height="400" class="mx-auto d-block mt-3 mb-3" alt="выбор загрузки">
                                        Ознакомьтесь с описаниями рабочих нагрузок, чтобы решить, какая рабочая нагрузка поддерживает необходимые функции. Например, выберите рабочую нагрузку ASP.NET и веб-разработка, чтобы изменить веб-страницы ASP.NET с помощью интерактивного предварительного просмотра или создать быстрые веб-приложения с помощью Blazor. Или выберите рабочую нагрузку Классические и мобильные приложения для разработки кросс-платформенных приложений с помощью C# или проектов C++, предназначенных для C++20.
                                    </li>
                                    <li class="mb-2 fs-5">Выбрав нужные рабочие нагрузки, нажмите кнопку Установить.</li>
                                    <p class="fs-5">Далее будут отображаться экраны состояния, на которых демонстрируется ход установки Visual Studio.</p>
                                </ol>
                            </div>
                        </div>
                        <div class="row mb-3" style="border-bottom: #95ACFD 1px solid;">
                            <div class="col-xs-12">
                                <h3 class="mb-3">Шаг 5. Выбор отдельных компонентов (необязательно)</h3>
                                <p class="fs-5 ms-1"> Если вы не хотите использовать функцию "Рабочие нагрузки", чтобы настроить установку Visual Studio или добавить дополнительные компоненты, чем установка рабочей нагрузки, можно сделать это, установив или добавив отдельные компоненты на вкладке "Отдельные компоненты". Выберите нужные компоненты, а затем следуйте инструкциям.</p>
                                <img src="resourse/vs-installer-individual-components.png" height="400" class="mx-auto d-block mt-3 mb-3" alt="загрузка элементов">
                            </div>
                        </div>
                        <div class="row mb-3" style="border-bottom: #95ACFD 1px solid;">
                            <div class="col-xs-12">
                                <h3 class="mb-3">Шаг 6. Установка языковых пакетов (необязательно)</h3>
                                <p class="fs-5 ms-1">По умолчанию при первом запуске установщик пытается использовать язык операционной системы. Чтобы установить Visual Studio на нужном языке, выберите в Visual Studio Installer вкладку Языковые пакеты и следуйте указаниям.</p>
                                <img src="resourse/vs-installer-individual-components.png" height="400" class="mx-auto d-block mt-3 mb-3" alt="загрузка элементов">
                                
                            </div>
                        </div>
                        <div class="row mb-3" style="border-bottom: #95ACFD 1px solid;">
                            <div class="col-xs-12">
                                <h3 class="mb-3">Шаг 7. Выбор расположения установки (дополнительно)</h3>
                                <p class="fs-5 ms-1">Вы можете уменьшить место, занимаемое установкой Visual Studio на системном диске. Дополнительные сведения см. в разделе Выбор расположений установки.</p>
                                <img src="resourse/vs-installer-installation-locations.png" height="400" class="mx-auto d-block mt-3 mb-3" alt="загрузка элементов">
                                
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-xs-12">
                                <h3 class="mb-3">Шаг 8. Начало разработки</h3>
                                <ol>
                                    <li class="mb-2 fs-5">Когда установка Visual Studio завершится, нажмите кнопку Запустить, чтобы приступить к разработке в Visual Studio.</li>
                                    <li class="mb-2 fs-5">На начальном экране выберите Создать проект.</li>
                                    <li class="mb-2 fs-5">В поле поиска шаблонов введите тип приложения, которое вы хотите создать, чтобы просмотреть список доступных шаблонов. Список шаблонов зависит от рабочих нагрузок, выбранных во время установки. Чтобы просмотреть различные шаблоны, выберите разные рабочие нагрузки. <br>
                                        Можно также фильтровать поиск по определенному языку программирования с помощью раскрывающегося списка Язык. Вы также можете выбирать фильтры из списка Платформа и Тип проекта.</li>
                                    <li class="mb-2 fs-5">Новый проект откроется в Visual Studio, и вы можете приступить к написанию кода!</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--Footer главной страницы-->
<?php
  require __DIR__ . '/footer.php'; 
?>
