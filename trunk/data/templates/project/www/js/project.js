var Rockbee = {
    containerTemplates: { 
        editLink: function (v, row) { v = v||'&mdash; отсутствует &mdash;';return '<a href="#edit:' + row.id + '" onclick="javascript: page.edit({id:' + row.id + '});">'+v+'</a>'; },
        edit: function (v, row) { return '<a href="#edit:' + row.id + '" onclick="javascript: page.edit({id:' + row.id + '});">Изменить</a>'; },
        del: function (v, row) { return '<a href="#editFormDiv" onclick="javascript: if (confirm(\'Щас кааааак удалю!\')) page.delete({id:' + row.id + '}); return false;">Удалить</a>'; }
    }
};

Rockbee.Page = Class.create(Backend.Manager, {
});