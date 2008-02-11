<?= "<?php\n";?>
class <?= $modelClassName.'ManagerController'; ?> extends AjaxControllerBase
{
    function __construct()
    {
        $this->model = new <?= $modelClassName; ?>();
        $this->cName = <?= $modelClassName; ?>;
    }
}
?>