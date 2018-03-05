<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Welcome to admin
            <small>
                <?php
                if ($objUser->login) {
                    echo $objUser->userName;
                }
                ?>
            </small>
        </h1>
    </div>
    <!-- /.row -->