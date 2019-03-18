<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Users', 'url' => ['/user/index']],
                    ['label' => 'Projects', 'url' => ['/project/index']],
                    ['label' => 'Tasks', 'url' => ['/task/index']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Assignments', 'url' => ['/admin/assignment']],
                    ['label' => 'Roles', 'url' => ['/admin/role']],
                    ['label' => 'Permissions', 'url' => ['/admin/permission']],
                    ['label' => 'Routes', 'url' => ['/admin/route']],
                    ['label' => 'Rules', 'url' => ['/admin/rule']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                ],
            ]
        ) ?>

    </section>

</aside>
