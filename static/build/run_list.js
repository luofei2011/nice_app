(function() {
    require(['react', 'Observable'], function(React, Observable) {
        var List = React.createClass({displayName: "List",
            render: function() {
                return (
                    React.createElement("p", {className: "item"})
                );
            }
        });
    });

    React.render(
        React.createElement(List, null),
        $('.history').get(0)
    );
});
