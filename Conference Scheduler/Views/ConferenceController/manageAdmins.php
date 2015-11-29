<div class="row">
    <?php if (!$this->_viewBag['body']->getAdmins()) : ?>
        <h1 class="alert alert-info text-center">Currently this conference has no admins!</h1>
    <?php endif;?>
    <ul class="list-group col-sm-6 col-sm-offset-3">
        <?php foreach ($this->_viewBag['body']->getAdmins() as $user) : ?>
            <li class="height list-group-item"><a href="/user/<?= $user->getUsername() ?>/profile"><?= ($user->getUsername()) ?></a>
                <a class="height32 float-right btn btn-danger" href="conference/<?= $this->_viewBag['body']->getConfId() ;?>/deleteAdmin/<?= $user->getId() ?>">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a class="btn btn-success col-sm-3" href="conference/<?= $this->_viewBag['body']->getConfId() ;?>/add/">Add admin</a>
</div>
