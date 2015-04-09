var EXE = {
    collect: function(node) {
        var $items = node.find('input,select');
        var result = {};

        $items.each(function() {
            var $this = $(this);
            result[$this.attr('name')] = $.trim($this.val());
        });

        return result;
    }
};
