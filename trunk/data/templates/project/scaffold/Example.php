<?
$scaffold = array(
    'prefix'=>'re',
    'projectName'=>'Real',

    'columns'=>array(
        'id'=>array(
            'title'=>'ID'
        ),
        'login'=>array(
            'title'=>'Логин'
        ),
        'password'=>array(
            'title'=>'Пароль'
        ),
        'email'=>array(
            'title'=>'E-mail'
        ),
        'status'=>array(
            'title'=>'Статус'
        )
    ),

    'list'=>array(
        'title'=>'Пользователи',
        'columns'=>array('id', 'login', 'email', 'status')
    ),

    'form'=>array(
        'title'=>'Пользователь',
        'sets'=>array(
            array(
                'legend'=>'Основное',
                'fields'=>array('id', 'login', 'email', 'password', 'status')
            )
        )
    )
);
?>