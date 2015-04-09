require(['react', 'Observable'], function(React, Observable) {
    data = {
        sidebarItems: Observable([]),
        playlists: Observable([])
    };

    var App = React.createClass({
        mixins: [data.sidebarItems.mixin('sidebar')],
        render: function() {
            return (
                <div>{this.state.sidebar}</div>
            );
        }
    });

    data.sidebarItems.set('test');

    React.render(
        <App />,
        document.getElementById('test')
    );
});
