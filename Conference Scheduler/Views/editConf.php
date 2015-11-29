<div class="panel panel-primary  col-sm-6 col-sm-offset-3">
    <h1 class="text-center">Edit a conference</h1>
    <?php
    \Mvc\FormViewHelper::init()
        ->initForm('/conference/edit', ['class' => 'form-group'], 'post')
        ->initLabel()->setValue("Conference name")->setAttribute('for', 'name')->create()
        ->initTextBox()->setName('name')->setAttribute('id', 'name')->setAttribute('class', 'form-control input-md')->create()
        ->initLabel()->setValue("Description")->setAttribute('for', 'description')->create()
        ->initTextBox()->setName('description')->setAttribute('id', 'description')->setAttribute('class', 'form-control input-md')->create()
        ->initLabel()->setValue("Start date")->setAttribute('for', 'start')->create()
        ->initTextBox()->setName('start')->setAttribute('id', 'start')->setAttribute('class', 'form-control input-md')->create()
        ->initLabel()->setValue("End date")->setAttribute('for', 'end')->create()
        ->initTextBox()->setName('end')->setAttribute('id', 'end')->setAttribute('class', 'form-control input-md')->create()
        ->initSubmit()->setAttribute('value', 'Edit')->setAttribute('class', 'btn btn-primary btn-lg col-sm-4 col-sm-offset-4')->create()
        ->render(); ?>
</div>