<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Conference Scheduler</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><?php Mvc\FormViewHelper::init()
                            ->initLink()->setAttribute('href', '/')->setValue('Home')->create()
                            ->render(); ?></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true"
                           aria-expanded="false">Lectures<span
                                class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><?php \Mvc\FormViewHelper::init()
                                    ->initLink()->setAttribute('href', '/lecture')->setValue('All lectures')->create()
                                    ->render(); ?></li>
                            <?php if (\Mvc\App::getInstance()->isLogged()) : ?>
                            <li><?php \Mvc\FormViewHelper::init()
                                    ->initLink()->setAttribute('href', '/lecture/open')->setValue('Open lectures')->create()
                                    ->render(); ?></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true"
                           aria-expanded="false">Conferences<span
                                class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><?php \Mvc\FormViewHelper::init()
                                    ->initLink()->setAttribute('href', '/conference/0/3')->setValue('All conferences')->create()
                                    ->render(); ?></li>
                            <li><?php \Mvc\FormViewHelper::init()
                                    ->initLink()->setAttribute('href', '/conference/open')->setValue('Open conferences')->create()
                                    ->render(); ?></li>
                        </ul>
                    </li>
                    <?php if (\Mvc\App::getInstance()->isLogged()) : ?>
                        <li><?php \Mvc\FormViewHelper::init()
                                ->initLink()->setAttribute('href', '/conference/create')->setValue('Add conference')->create()
                                ->render() ?></li>
                    <?php endif; ?>
                </ul>
                <?php if (!\Mvc\App::getInstance()->isLogged()) : ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li><?php \Mvc\FormViewHelper::init()
                                ->initLink()->setAttribute('href', '/home/login')->setValue('Register')->create()
                                ->render(); ?></li>
                        <li><?php \Mvc\FormViewHelper::init()
                                ->initLink()->setAttribute('href', '/home/login')->setValue('Login')->create()
                                ->render(); ?></li>
                    </ul>
                <?php else : ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true"
                               aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                <?= \Mvc\App::getInstance()->getUsername() ?>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><?php \Mvc\FormViewHelper::init()
                                        ->initLink()
                                        ->setAttribute('href', "/user/" . \Mvc\App::getInstance()->getUsername() . "/profile")
                                        ->setValue('Edit Profile')
                                        ->create()
                                        ->render(); ?></li>
                                <li><?php \Mvc\FormViewHelper::init()
                                        ->initLink()->setAttribute('href', '/lecture/my')->setValue('My schedule')->create()
                                        ->render(); ?></li>
                                <li><?php \Mvc\FormViewHelper::init()
                                        ->initLink()
                                        ->setAttribute('href', "/users/all/0/10")
                                        ->setValue('All users')
                                        ->create()
                                        ->render(); ?></li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <?php Mvc\FormViewHelper::init()
                                        ->initLink()->setAttribute('href', '/user/logout')->setValue('Logout')->create()
                                        ->render();
                                    ?>
                                </li>
                            </ul>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
</header>
