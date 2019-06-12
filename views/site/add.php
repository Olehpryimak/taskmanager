<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container" style="margin: 5%">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-5">
                <?php if ($result): ?>
                    <div class="bg-success" style="text-align: center; font-weight: bold">
                        Ви додали задачу!
                    </div>
                <?php elseif (isset($errors) && is_array($errors)): ?>
                    <?php foreach ($errors as $error): ?>
                        <div class="bg-warning" style="text-align: center; font-weight: bold; margin: 1%">
                            <?php echo $error; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <div class="well row">
                    <div class="form-group ">
                        <h3 style="text-align: center">Add task</h3>
                        <form style="text-align: center;" action="/add" method="post">
                            <br>
                            <input class="form-control" type="text" name="name" placeholder="Enter your name">
                            <br>
                            <input class="form-control" type="email" name="email" placeholder="Enter email">
                            <br>
                            <input class="form-control" type="text" name="task" placeholder="Enter your task">
                            <br>
                            <button type="submit" class="btn btn-success" name="add_task">Add</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-3" style="text-align: right; display:flex; justify-content:space-around">

                <button style="width: 100%;" class="btn-lg btn-success fa fa-tasks" onclick="document.location.href = '/'" > Tasks</button>
                <?php if ($admin): ?>
                    <button style="width: 100%;"  class="btn-lg btn-success fa fa-sign-out" onclick="document.location.href = '/admin/logout'" > Log out</button>
                <?php else: ?>
                    <button style="width: 100%;"  class="btn-lg btn-success fa fa-sign-in" onclick="document.location.href = '/admin/login'" > Log in</button>
                <?php endif; ?>
            </div>


        </div>
    </div>
</section>
