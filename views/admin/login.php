<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container" style="margin: 5%">
        <div class="col-md-3"></div>
        <div class="col-md-5">
            <?php if ($errors): ?>
                <?php foreach ($errors as $error): ?>
                    <div class="bg-warning" style="text-align: center; font-weight: bold; margin: 1%">
                        <?php echo $error; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="well">

                <div class="form-group">
                    <form action="/admin/login" method="post">
                        <div style="text-align: center">
                            <h2>Sign In</h2>
                        </div>
                        <br>
                        <input type="text" name="login" value="" class="form-control" placeholder="Enter login" required>
                        <br>
                        <input type="password" name="password" value="" class="form-control" placeholder="Enter password" required>
                        <br>

                        <div style="text-align: center">
                            <button type="submit"  name="do_login" class="btn btn-success btn-md" >Enter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-3" style="text-align: right; display:flex; justify-content:space-around">

            <button style="width: 100%;" class="btn-lg btn-success fa fa-tasks" onclick="document.location.href = '/'" > Tasks</button>
            <button style="width: 100%;"  class="btn-lg btn-success fa fa-plus" onclick="document.location.href = '/add'" > Add task</button>

        </div>
    </div>
</section>