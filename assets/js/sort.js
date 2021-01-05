document.addEventListener("DOMContentLoaded", function (event) {
    if (document.getElementById('Lists')) {
        const start = function (e, ui) {
            let originals = ui.helper.children();
            ui.placeholder.children().each(function (index) {
                $(this).width(originals.eq(index).width());
            });
        }
        const helper = function (e, tr) {
            let helper = tr.clone();
            let originals = tr.children();
            helper.children().each(function (index) {
                $(this).width(originals.eq(index).outerWidth(true));
            });
            return helper;
        };

        function DragSortableInit() {
            $('body #Lists tbody').sortable({
                helper: helper,
                start: start,
                items: "tr",
                cursor: 'move',
                opacity: 0.6,
                update: function (event, ui, items) {
                    sendData();
                }
            }).disableSelection();
        }
        DragSortableInit();

        function sendData() {
            const data_id = [];
            const star_position = [];
            $('#Lists tbody tr').each(function (index, element) {
                star_position.push(
                    element.querySelector('.list-cell-name-sort_drag').innerText,
                );
                data_id.push(
                    element.querySelector('.list-cell-name-id').innerText,
                );
            });
            $.request('onSort', {
                data: {
                    id: data_id,
                    min: Math.min(...star_position),
                    max: Math.max(...star_position)
                },

                success: function (data) {
                    this.success(data);
                    DragSortableInit();
                }
            });
        }

        const targetNode = document.getElementById('Lists');
        const config = { attributes: false, childList: true, subtree: false };
        const callback = function (mutationsList, observer) {
            for (const mutation of mutationsList) {
                if (mutation.type === 'childList') {
                    DragSortableInit();
                }
            }
        };
        const observer = new MutationObserver(callback);
        observer.observe(targetNode, config);
    }

});


