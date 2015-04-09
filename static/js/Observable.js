define(function(require) {
    var EventEmitter = require('./events');

    var Observable = function(initialValue) {
        var self = new EventEmitter();
        var value = initialValue;

        self.get = function() { return value };
        self.set = function(updated) {
            value = updated;
            self.emit('change', updated);
        };
        self.mixin = function(key) {
            var cb = Math.random().toString();
            var mixin = {
                getInitialState: function() { var o = {}; o[key] = value; return o; },
                componentDidMount: function() {
                    self.on('change', this[cb]);
                    self.on('update', this.update);
                },
                componentWillUnmount: function() {
                    self.removeListener('change', this[cb]);
                    self.removeListener('update', this.update);
                }
            }

            mixin[cb] = function() {
                var o = {};
                o[key] = value;
                this.setState(o);
            };

            return mixin;
        }

        return self;
    };

    return Observable;
});
