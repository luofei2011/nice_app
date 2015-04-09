require(['react', 'Observable'], function(React, Observable) {
    data = {
        sidebarItems: Observable([]),
        playlists: Observable([])
    };

    var App = React.createClass({displayName: "App",
        mixins: [data.sidebarItems.mixin('sidebar')],
        render: function() {
            return (
                React.createElement("div", null, this.state.sidebar)
            );
        }
    });

    data.sidebarItems.set('test');

    React.render(
        React.createElement(App, null),
        document.getElementById('test')
    );
});
