<?
$scaffold = array(
    'prefix'=>'',
    'projectName'=>'Project',
    'formTitle'=>'Пример',
    'pageTitle'=>'Пример',
    'columns'=>array(
        'id'=>array(
            'title'=>'ID',
            'isColumn'=>true
        ),
        'name'=>array(
            'title'=>'Name'
        ),
        'surname'=>array(
            'title'=>'Surname'
        ),
        'category_id'=>array(
            'title'=>'Category',
            'relation'=>array(
                'labelField'=>'title'
            )
        )
    ),

    'sets'=>array(
        array(
            'legend'=>'Основное',
            'fields'=>array('id', 'name', 'surname', 'category_id')
        )
    )
);
?>