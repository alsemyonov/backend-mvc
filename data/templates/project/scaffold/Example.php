<?
$scaffold = array(
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
        'company_name'=>array(
            'title'=>'Компания'
        ),
        'status'=>array(
            'title'=>'Статус',
            'valueTitles'=>array(
                'I'=>'Неактивен',
                'A'=>'Активен',
                'S'=>'Вход закрыт'
            )
        ),
        'company_name'=>array(
            'title'=>'Компания'
        ),
        'branch_id'=>array(
            'title'=>'Область деятельности'
        ),
        'comment'=>array(
            'title'=>'Комментарий'
        ),
        'city_id'=>array(
            'title'=>'Город'
        ),
        'region_id'=>array(
            'title'=>'Регион'
        ),
        'is_agency'=>array(
            'title'=>'Агентство'
        ),
        'is_developer'=>array(
            'title'=>'Застройщик'
        ),
        'is_renter'=>array(
            'title'=>'Арендодатель'
        ),
        'is_another'=>array(
            'title'=>'Сторонние организации'
        )
    ),

    'list'=>array(
        'title'=>'Пользователи',
        'columns'=>array(
            'id',
            'login'=>array('container'=>'editLink'),
            'email',
            'status',
            'company_name',
            'C1'=>array('container'=>'edit'),
            'C2'=>array('container'=>'del')
        ),
    ),

    'form'=>array(
        'title'=>'Пользователь',
        'sets'=>array(
            array(
                'legend'=>'Основное',
                'fields'=>array('login', 'email', 'password', 'status', 'company_name', 'branch_id', 'comment')
            ),
            array(
                'legend'=>'Местоположение',
                'fields'=>array('city_id', 'region_id')
            ),
            array(
                'legend'=>'Тип профиля',
                'fields'=>array('is_agency', 'is_developer', 'is_renter', 'is_another')
            )
        )
    )
);
?>