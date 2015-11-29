<?php $confId = $_SESSION['confIdAddAdmin']; ?>
<div class="panel panel-primary  col-sm-6 col-sm-offset-3">
    <h1 class="text-center">Add admin:</h1>
    <?php
\Mvc\FormViewHelper::init()
    ->initForm("/conference/addAdmin/$confId", ['class' => 'form-group'], 'post')
    ->initLabel()->setValue("Username")->setAttribute('for', 'name')->create()
    ->initTextBox()->setName('name')->setAttribute('id', 'name')->setAttribute('class', 'form-control input-md')->create()
    ->initSubmit()->setAttribute('value', 'Add admin')->setAttribute('class', 'btn btn-primary btn-lg col-sm-4 col-sm-offset-4')->create()
    ->render(); ?>
</div>