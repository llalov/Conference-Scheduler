<div class="panel panel-primary  col-sm-6 col-sm-offset-3">
    <h1 class="text-center">Are you sure you want to remove this lecture?</h1>
    <?php
    \Mvc\FormViewHelper::init()
        ->initForm('/lecture/deleteLecture/', ['class' => 'form-group'], 'post')
        ->initSubmit()->setAttribute('value', 'Remove lecture')->setAttribute('class', 'btn btn-primary btn-lg col-sm-4 col-sm-offset-4')->create()
        ->render(); ?>
</div>