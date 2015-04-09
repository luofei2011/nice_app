require(['react', 'Observable'], function(React, Observable) {
    // 中间件，提供给外界操作。刷新列表的功能
    EXE.midWare = Observable();
    var List = React.createClass({
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
                    <div className="item" data-id={ item.id }>
                        <label for="">{ item.name }</label>
                        <input type="number"/>
                        <span className="unit">{ item.unit }</span>
                        <input type="hidden" value={ item.frequency }/>
                        <a href="javascript:void(0);" className="item-edit">
                            <i className="icon-pencil"></i>
                        </a>
                    </div>
                );
            });

            return (
                <div>
                {html}
                </div>
            );
        }
    });

    if (EXE.isLogin) {
        React.render(
            <List />,
            $('#wrapper .list').get(0)
        );
    }
});
