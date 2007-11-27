<?
$page = new Form(array(
    'method'=>'post',
    'action'=>'.'
));
$page->add( new TableLayout() )
    ->addRow()->add("ID", new TextField(array('name'=>'values[name]', 'value'=>$data['id'])));
    ->addRow()->add("ID", new TextField(array('name'=>'values[name]', 'value'=>$data['id'])));
?>
