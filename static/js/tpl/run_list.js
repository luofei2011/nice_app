(function() {
    require(['react', 'Observable'], function(React, Observable) {
        var List = React.createClass({
            render: function() {
                return (
                    <p className="item"></p>
                );
            }
        });
    });

    React.render(
        <List />,
        $('.history').get(0)
    );
});
