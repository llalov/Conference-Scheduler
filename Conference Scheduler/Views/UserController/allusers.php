<div class="row margin-left2">
    <?php if (!$this->_viewBag['body']->getUsers()) : ?>
        <h1 class="alert alert-info text-center">No more users</h1>
    <?php endif;?>
    <ul class="list-group col-sm-6 col-sm-offset-3">
        <?php foreach ($this->_viewBag['body']->getUsers() as $user) : ?>
            <li class="height list-group-item"><a href="/user/<?= $user->getUserName() ?>/profile"><?= ($user->getUserName()) ?></a>
                <?php if($_SESSION['role'] === 'site administrator') :?>
                <a class="height32 float-right btn btn-danger" href="/users/delete/<?= $user->getUserName() ?>">Delete</a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<ul class="pager">
    <li><a href="/users/all/<?php
        $start = $this->_viewBag['body']->getStart();
        if ($start - 10 >= 0) {
            echo $start -= 10;
        } else {
            echo 0;
        }
        ?>/<?php
        $end = $this->_viewBag['body']->getEnd();
        if ($end - 10 > 0) {
            echo $end -= 10;
        } else {
            echo 10;
        }
        ?>">Previous</a></li>
    <?php if ($this->_viewBag['body']->getUsers()) : ?>
        <li><a href="/users/all/<?php
            $start = $this->_viewBag['body']->getStart();
            echo $start += 10;
            ?>/<?php
            $end = $this->_viewBag['body']->getEnd();
            echo $end += 10;
            ?>"> Next</a></li>
    <?php endif; ?>
</ul>