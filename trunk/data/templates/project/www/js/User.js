
Real.User = Class.create(Real.Page, {
    name: 'user',

    columns: [
        { id:'id' },
{ id:'login' },
{ id:'password' },
{ id:'email' },
{ id:'a_code' },
{ id:'status' },
{ id:'created_at' },
{ id:'updated_at' }    ],

    calendars: [
            ],

    initialize: function($super) {
        $super();
            }
});

FastInit.addOnLoad(function() {page = new Real.User(); });