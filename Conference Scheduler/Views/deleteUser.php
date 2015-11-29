<div class="panel panel-primary  col-sm-6 col-sm-offset-3">
    <h1 class="text-center">Are you sure you want to delete <i><?php echo $_SESSION['userToDelete']?></i>?</h1>
    <p>Warning: Delete users only as last resort! If their actions weren't harmful to any other user or the website, consider only contacting them.</p>
    <?php
    \Mvc\FormViewHelper::init()
        ->initForm('/users/deleteUser/', ['class' => 'form-group'], 'post')
        ->initSubmit()->setAttribute('value', 'Delete user')->setAttribute('class', 'btn btn-primary btn-lg col-sm-4 col-sm-offset-4')->create()
        ->render(); ?>
</div>