<div class="panel panel-primary  col-sm-6 col-sm-offset-3">
    <h1 class="text-center">Add a lecture</h1>
    <?php
    \Mvc\FormViewHelper::init()
        ->initForm('/lecture/add', ['class' => 'form-group'], 'post')
        ->initLabel()->setValue("Name")->setAttribute('for', 'name')->create()
        ->initTextBox()->setName('name')->setAttribute('id', 'name')->setAttribute('class', 'form-control input-md')->create()
        ->initLabel()->setValue("Description")->setAttribute('for', 'description')->create()
        ->initTextBox()->setName('description')->setAttribute('id', 'description')->setAttribute('class', 'form-control input-md')->create()
        ->initLabel()->setValue("Start")->setAttribute('for', 'start')->create()
        ->initTextBox()->setName('start')->setAttribute('id', 'start')->setAttribute('class', 'form-control input-md')->create()
        ->initLabel()->setValue("End")->setAttribute('for', 'end')->create()
        ->initTextBox()->setName('end')->setAttribute('id', 'end')->setAttribute('class', 'form-control input-md')->create()
        ->initLabel()->setValue("Speaker")->setAttribute('for', 'speaker')->create()
        ->initTextBox()->setName('speaker')->setAttribute('id', 'speaker')->setAttribute('class', 'form-control input-md')->create()
        ->initLabel()->setValue("Hall")->setAttribute('for', 'hall')->create()
        ->initTextBox()->setName('hall')->setAttribute('id', 'hall')->setAttribute('class', 'form-control input-md')->create()
        ->initSubmit()->setAttribute('value', 'Create')->setAttribute('class', 'btn btn-primary btn-md col-sm-4 col-sm-offset-4')->create()
        ->render(); ?>
</div>