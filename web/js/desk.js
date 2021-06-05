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
        // remove the spacer content from dropzone
        $("#"+id).remove();
        // add the draggable content
        elem.replaceWith(card);
    } catch (error) {
        console.warn("can't move the item to the same place");
    }
    updateDropzones();
}

const updateDropzones = () => {
    // after dropping, refresh the drop target areas so there is a dropzone after each item using jQuery here for simplicity
    var dz = $('<div class="dropzone rounded" ondrop="drop(event)" ondragover="allowDrop(event)" ondragleave="clearDrop(event)"> &nbsp; </div>');
    // delete old dropzones
    $('.dropzone').remove();
    // insert new dropzone in any empty swimlanes
    $(".items").append(dz);
    // insert new dropdzone after each item
    dz.insertBefore('.draggable');
};
