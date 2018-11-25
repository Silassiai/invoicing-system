<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 25-11-2018
 * Time: 0:14
 */
;?>
<div class="container">
    <div class="row">
        <div class="col">
            <br />
            <a href="<?php echo site_url('/invoices/export');?>"><button type="button" class="btn btn-primary">export csv</button></a>
            <br /><br />
            <?php echo $invoices; ?>
            <br />
        </div>
    </div>
</div>
