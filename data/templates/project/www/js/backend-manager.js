Backend.Manager = Class.create({
    name: '',
    table: null,
    form: null,
    editor: null,
    calendars: [],
    init: true,
    page: 1,

    initialize: function() {
        this.table = this.table || $(this.name + 'Items');
        this.form = this.form || $(this.name);
        this.editor = this.editor || $('editFormDiv');
        this.load();
    },

    showCriticalError: function(errorText)
    {
        $('errorText').update(errorText);
        $('error').show();
    },

    request: function(url, options)
    {
        options = Object.extend({
            method: 'post',
            onComplete: Prototype.emptyFunction,
            onSuccess: Prototype.emptyFunction,
            onException: Prototype.emptyFunction,
            onFailure: Prototype.emptyFunction
        }, options);

        rqOptions = Object.clone(options);

        rqOptions = Object.extend(rqOptions, { 
            onSuccess: function(t, json) {
                try {
                    json = json || t.responseJS || t.responseText.evalJSON();
                } catch(e) {
                    this.showCriticalError(t.responseText);
                };
                options.onSuccess(t, json);
            }.bind(this),
            onFailure: function(t) {
                this.showCriticalError(t.responseText);
                options.onFailure(t);
            }.bind(this),
            onException: function(obj, e) {
                this.showCriticalError(obj.transport.responseText);
                options.onException(obj, e);
            }.bind(this)
        });
        /*rqOptions.onComplete = function(t, json) {
            //json = json ? json : t.responseText.evalJSON();
            json = json || t.transport.responseJS || t.responseText.evalJSON();
            options.onComplete(t, json);
        }*/

        new Ajax.Request(url, rqOptions);
    },

    reset: function()
    {
        d = new Date();
        this.calendars.each(function(c) {
            $(c.inputField).value = d.print(c.ifFormat);
            $(c.displayArea).update(d.print(c.daFormat));
        });
        this.form.reset();
        this.id = null;
    },

    load: function(options) 
    {
        $('loading').show();
        options = options || {};
        options = Object.extend({
            url: '/manager/' + this.name + '/ajax/getall/',
            parameters: null,
            onSuccess: Prototype.emptyFunction
        }, options);

        var $onSuccess = options.onSuccess;
        delete(options.onSuccess);
        this.request(options.url, Object.extend(options, {
            onSuccess: function (t, json) {
                $(this.table).load(json.items, this.columns);
                $onSuccess(t, json);
                if (location.hash.indexOf('edit:') != -1) {
                    this.edit({id: eval(location.hash.slice(6))})
                };
                $('loading').hide();
            }.bind(this)
        }));

        this.calendars.each(function(c) {
            Calendar.setup(c);
        });
        this.reset();
    },

    save: function(options)
    {
        options = options || {};
        options = Object.extend({
            url: '/manager/' + this.name + '/ajax/save/',
            editor: this.editor,
            load: this.load,
            id: this.id
        }, options);

        this.request(options.url, {
            parameters: (options.id != undefined ? 'id=' + options.id + '&' : '') + this.form.serialize() ,
            onSuccess: function(t, json) {
                this.id = undefined;
                location.hash = '#list';
                this.load();
                if (this.editor != undefined) this.editor.hide();
                this.reset();
            }.bind(this)
        });

        return false; // Graceful degradation
    },

    edit: function(options)
    {
        options = options || {};
        defaultOptions = {
            url: '/manager/' + this.name + '/ajax/get/',
            editor: this.editor
        };
        options = Object.extend(defaultOptions, options);

        this.reset();
        if (options.id != undefined) {
            this.id = options.id;
            this.request('/manager/' + this.name + '/ajax/get/', {
                parameters: {id: this.id},
                onSuccess: function (t, json) {
                    this.form.deserialize(json);
                    this.calendars.each(function(c) {
                        $(c.displayArea).update(Backend.Prototype.Table.formatters.date(c.ifFormat, c.daFormat, $(c.inputField).value, c.inputField, {}));
                    });
                    if (this.editor != undefined) {
                        this.editor.setStyle({top: window.scrollY+20});
                        this.editor.show();
                    };

                    if (options.onComplete) options.onComplete(t, json);
                    /*if (options.onSuccess) options.onSuccess(t, json);*/
                }.bind(this)
            });
        } else {
            if (this.editor != undefined) this.editor.show();
        }
        return false; // Graceful degradation
    },

    'delete': function(options)
    {
        options = options || {};
        options = Object.extend({
            url: '/manager/' + this.name + '/ajax/delete/',
            id: this.id,
            reload: this.load
        }, options);

        this.request(options.url, {
            parameters: {id: options.id},
            onSuccess: function(t, json)
            {
                // options.load();
                $('row' + options.id).hide();
            }.bind(this)
        });
        return false; // Graceful degradation
    },
    
    close: function()
    {
        this.reset();
        this.editor.hide();
        location.hash = '#list';
        return false; // Graceful degradation
    }
});

Date.locale = Date.locales.ru;