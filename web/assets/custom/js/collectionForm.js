var $collectionHolder = [];
var $deleteLink = [];

/**
 *
 * @param collectionHolder
 * @param addLink
 * @param deleteLink
 */
function initCollection(collectionHolder, addLink, deleteLink, indexNumber) {
    $collectionHolder[indexNumber] = $(collectionHolder);
    $deleteLink[indexNumber]  = deleteLink;

    // setup an "add" link
    var $addLink = $(addLink);

    // add a delete link to all of the existing elements
    $collectionHolder[indexNumber].find('.collection' + indexNumber).each(function() {
        addTagFormDeleteLink($(this), indexNumber);
    });

    $collectionHolder[indexNumber].append($addLink);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)

    // var numberOfInputs = $collectionHolder[indexNumber].find(':input').length;
    var numberOfElements = $collectionHolder[indexNumber].find('.collection' + indexNumber).length;
    $collectionHolder[indexNumber].data('index', numberOfElements);


    $addLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new form
        addTagForm($collectionHolder[indexNumber], $addLink, indexNumber);
    });

}

/**
 *
 * @param $collectionHolder
 * @param $addLink
 */
function addTagForm($collectionHolder, $addLink, indexNumber) {

    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // var newForm = prototype.replace(/__name__/g, index);


    if($collectionHolder.attr('id') == 'fieldTypes') {
        var newForm = prototype.replace(/__fieldTypes__/g, index);
    } else if($collectionHolder.attr('id') == 'choiceItems' + indexNumber) {
        var newForm = prototype.replace(/__choiceItems__/g, index);
    }

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    var $newFormLi = $('<li class="collection'+ indexNumber + '"></li>').append(newForm);

    $addLink.before($newFormLi);
   // $('select').material_select();

    var $lastCollectionChild = $('.collection' + indexNumber).last();

    // add a delete link to the new form
    addTagFormDeleteLink($lastCollectionChild, indexNumber);
}

/**
 *
 * @param $form
 */
function addTagFormDeleteLink($form, indexNumber) {
    var $removeFormA = $($deleteLink[indexNumber]);

    $form.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $form.remove();
    });
}

