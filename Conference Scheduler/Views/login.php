<div class="row row-eq-height">
    <div class="panel panel-primary  col-sm-5">
        <h1 class="text-center">Sign in</h1>
        <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
        <?php
        \Mvc\FormViewHelper::init()
            ->initForm('/user/login', ['class' => 'form-group margin-bottom10'], 'post')
            ->initLabel()->setValue("Username")->setAttribute('for', 'username')->create()
            ->initTextBox()->setName('username')->setAttribute('id', 'username')->setAttribute('class', 'form-control input-md')->create()
            ->initLabel()->setValue("Password")->setAttribute('for', 'password')->create()
            ->initPasswordBox()->setName('password')->setAttribute('id', 'password')->setAttribute('class', 'form-control input-md')->create()
            ->initSubmit()->setAttribute('value', 'Sign in')->setAttribute('class', 'btn btn-lg btn-primary btn-block btn-signin margin-top25')->create()
            ->render(); ?>
    </div>
    <div class="panel panel-primary col-sm-5 col-sm-offset-2">
        <h1 class="text-center">Register</h1>
        <?php
        \Mvc\FormViewHelper::init()
            ->initForm('/user/register', ['class' => 'form-group'], 'post')
            ->initLabel()->setValue("Username")->setAttribute('for', 'username')->create()
            ->initTextBox()->setName('username')->setAttribute('id', 'username')->setAttribute('class', 'form-control input-md')->create()
            ->initLabel()->setValue("Email")->setAttribute('for', 'email')->create()
            ->initTextBox()->setName('email')->setAttribute('id', 'email')->setAttribute('class', 'form-control input-md')->create()
            ->initLabel()->setValue("Password")->setAttribute('for', 'password')->create()
            ->initPasswordBox()->setName('password')->setAttribute('id', 'password')->setAttribute('class', 'form-control input-md')->create()
            ->initLabel()->setValue("Confirm Password")->setAttribute('for', 'confPassword')->create()
            ->initPasswordBox()->setName('confirm')->setAttribute('id', 'confPassword')->setAttribute('class', 'form-control input-md')->create()
            ->initSubmit()->setAttribute('value', 'Register')->setAttribute('class', 'btn btn-lg btn-primary btn-block btn-signin margin-top10')->create()
            ->render(true);
        ?>
    </div>
</div>