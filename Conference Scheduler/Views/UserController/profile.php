<div class="panel margin-left2">
    <h2 class="form-group"><?= ($this->_viewBag['body']->getUsername()) ?>
    <?php if($_SESSION['role'] === 'site administrator'):?>
        <h3 class="form-group">Email: <?= ($this->_viewBag['body']->getEmail()) ?>
    <?php endif; ?>
        </h3>
    <?php if (strtolower($this->_viewBag['body']->getUsername()) === strtolower(\Mvc\App::getInstance()->getUsername())) : ?>
        <?php
        \Mvc\FormViewHelper::init()
            ->initForm('/user/changePass', ['class' => 'form-group'], 'put')
            ->initLabel()->setValue("Old Password")->setAttribute('for', 'oldPassword')->create()
            ->initPasswordBox()->setAttribute('id', 'oldPassword')->setName('oldPassword')->setAttribute('class', 'form-control input-md')->create()
            ->initLabel()->setValue("New Password")->setAttribute('for', 'newPassword')->create()
            ->initPasswordBox()->setAttribute('id', 'newPassword')->setName('newPassword')->setAttribute('class', 'form-control input-md')->create()
            ->initLabel()->setValue("Confirm Password")->setAttribute('for', 'conPassword')->create()
            ->initPasswordBox()->setAttribute('id', 'conPassword')->setName('confirm')->setAttribute('class', 'form-control input-md')->create()
            ->initSubmit()->setAttribute('value', 'Change password')->setAttribute('class', 'btn btn-default')->create()
            ->render();
    endif ?>
</div>