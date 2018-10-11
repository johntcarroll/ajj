<?php
    $root = "../";
    include $root . "view/layout/header.php";
?>
<div class='row custom-padding'>
    <div class='col col-xs-3 text-center'>
        <button class='btn btn-lg btn-success' id='db-load'>Load from DB</button>
    </div>
    <div class='col col-xs-3 text-center'>
        <button class='btn btn-lg btn-danger' id='db-verify'>Verify Sheet</button>
    </div>
    <div class='col col-xs-3 text-center'>
        <button class='btn btn-lg btn-warning' id='db-save'>Save to DB</button>
    </div>
    <div class='col col-xs-3 text-center'>
        <button class='btn btn-lg btn-danger' id='remove-rows'>Clear Table</button>
    </div>
</div>
<div class='row custom-padding'>
    <div class='col col-xs-4'>
        <label>Company</label>
        <select class='form-control filter' name='company_id'>
            <?=Company::filldrop();?>
        </select>
    </div>
    <div class='col col-xs-4'>
        <label>Date After</label>
        <input class='form-control filter' type='date' name='date_after'/>
    </div>
    <div class='col col-xs-4'>
        <label>Date Before</label>
        <input class='form-control filter' type='date' name='date_before'/>
    </div>
</div>
<div class='row custom-padding'>
    <div class='col col-xs-12' id='spreadsheet'>

    </div>
</div>
<?php
    include $root . "view/layout/footer.php";
