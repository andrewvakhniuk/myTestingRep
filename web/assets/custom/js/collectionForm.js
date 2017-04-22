var $collectionHolder;
var $addLinkHolder;
var $deleteLink;

/**
 *
 * @param collectionHolder
 * @param addLink
 * @param deleteLink
 */
function initCollection(collectionHolder, addLink, deleteLink) {
    $collectionHolder = $(collectionHolder);
    $deleteLink  = deleteLink;

    // setup an "add" link
    var $addLink = $(addLink);

    // add a delete link to all of the existing elements
    $collectionHolder.find('.collection').each(function() {
        addTagFormDeleteLink($(this));
    });
    $collectionHolder;


    $collectionHolder.append($addLink);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new form
        addTagForm($collectionHolder, $addLink);
    });

}

/**
 *
 * @param $collectionHolder
 * @param $addLink
 */
function addTagForm($collectionHolder, $addLink) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    var $newFormLi = $('<li class="collection"></li>').append(newForm);

    $addLink.before($newFormLi);
   // $('select').material_select();

    var $lastCollectionChild = $('.collection').last();

    // add a delete link to the new form
    addTagFormDeleteLink($lastCollectionChild);
}

/**
 *
 * @param $form
 */
function addTagFormDeleteLink($form) {
    var $removeFormA = $($deleteLink);

    $form.append($removeFormA);


    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $form.remove();
    });
}

