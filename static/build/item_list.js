require(['react', 'Observable'], function(React, Observable) {
    // 中间件，提供给外界操作。刷新列表的功能
    EXE.midWare = Observable();
    var List = React.createClass({displayName: "List",
        mixins: [EXE.midWare.mixin('__update__')],
        getInitialState: function() {
            return {data: []};
        },
        getDataFromServer: function() {
            var xhr = $.ajax({
                url: EXE.base_url + '?f=get_items_by_name',
                dataType: 'json',
                type: 'post',
                data: {},
                success: function(msg) {
                    if (msg.toString() === "[object Object]") {
                        msg = [msg];
                    }
                    this.setState({items: msg});
                }.bind(this),
                error: function(xhr, status, err) {
                    console.error(status, err.toString());
                }.bind(this),
                always: function() {
                    xhr = null;
                }.bind(this)
            });
        },
        componentDidMount: function() {
            this.getDataFromServer();
        },
        update: function() {
            this.getDataFromServer();
        },
        render: function() {
            var items = this.state.items || [];
            var html = items.map(function(item) {
                return (
                    React.createElement("div", {className: "item", "data-id":  item.id}, 
                        React.createElement("label", {for: ""},  item.name), 
                        React.createElement("input", {type: "number"}), 
                        React.createElement("span", {className: "unit"},  item.unit), 
                        React.createElement("input", {type: "hidden", value:  item.frequency}), 
                        React.createElement("a", {href: "javascript:void(0);", className: "item-edit"}, 
                            React.createElement("i", {className: "icon-pencil"})
                        )
                    )
                );
            });

            return (
                React.createElement("div", null, 
                html
                )
            );
        }
    });

    if (EXE.isLogin) {
        React.render(
            React.createElement(List, null),
            $('#wrapper .list').get(0)
        );
    }
});
