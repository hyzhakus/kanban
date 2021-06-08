const drag = (event) => {
    event.dataTransfer.setData("text/plain", event.target.id);
}

const allowDrop = (ev) => {
    ev.preventDefault();
    var elem = $(ev.target);
    if ( elem.hasClass("dropzone") ) {
        elem.addClass("droppable");
    }
}

const clearDrop = (ev) => {
    $(ev.target).removeClass("droppable");
}

const drop = (event) => {
    event.preventDefault();
    var id = event.dataTransfer.getData("text/plain");
    var card = $("#"+id)[0].outerHTML;
    var elem = $(event.target);
    try {
        // видалити початкову картку
        $("#"+id).remove();
        // додати картку в нове иісто
        elem.after(card);
    } catch (error) {
        console.warn("can't move the item to the same place");
    }
    updateDb(id);
    updateDropzones();
}


const updateDb = (id) => {
    var url = '/task/move';
    var task_id = id.substr(2)
    var desk_id = $("#"+id).parents("div.card").data("id");
    var data = {task_id: task_id, desk_id: desk_id};
    $.post(url, data);
}

const updateDropzones = () => {
    // html код зони скидання
    var dz = '<div class="dropzone rounded" ondrop="drop(event)" ondragover="allowDrop(event)" ondragleave="clearDrop(event)"> &nbsp;</div>';
    // видалити старі зони скидання
    $('.dropzone').remove();
    // вставити нові зони скидання після кожної картки
    $("div.draggable").after(dz);
    // вставити нові зони скидання на початку кожного стовпчика
    $(".items").after(dz);
};
