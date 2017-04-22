var $collectionHolder;
var $addLinkHolder;
var $deleteLink;
var $collectionName;
var $childrenCollectionHolder;
var $childrenCollectionName;
var $subAddLink;
var $subDeleteLink;
/**
 *
 * @param collectionHolder
 * @param collectionName
 * @param childrenCollectinHolder
 * @param childrenCollectionName
 * @param addLink
 * @param deleteLink
 * @param subAddLink
 * @param subDeleteLink
 */
function initCollection(collectionHolder, collectionName, childrenCollectionHolder,childrenCollectionName, addLink, deleteLink,
 subAddLink,subDeleteLink) {
    $collectionHolder = $(collectionHolder);
    $collectionName=$('.'+collectionName);
    $childrenCollectionHolder=$(childrenCollectionHolder);
    $childrenCollectionName=$('.'+childrenCollectionName);
    $deleteLink  = $(deleteLink);
    $subAddLink= $(subAddLink);
    $subDeleteLink=$(subDeleteLink);
    // setup an "add" link
    var $addLink = $(addLink);

    // add a delete link to all of the existing elements
    $collectionHolder.find($collectionName).each(function() {

        $(this).find($childrenCollectionName).each(function(){
            addTagFormDeleteLink($(this),$subDeleteLink);
        });

        $childrenCollectionHolder.append($subAddLink);

        // count the current form inputs we have (e.g. 2), use that as the new
        // index when inserting a new item (e.g. 2)
        $childrenCollectionHolder.data('index', $collectionHolder.find(':input').length);

        $subAddLink.on('click', function(e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();

            // add a new form
            addTagForm($childrenCollectionHolder, $subAddLink,childrenCollectionName);
        });

        addTagFormDeleteLink($(this),$deleteLink);
    });

    $collectionHolder.append($addLink);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new form
        addTagForm($collectionHolder, $addLink,collectionName);
    });

}

/**
 *
 * @param $collection
 * @param $addLink
 * @param collectionClass
 */
function addTagForm($collection, $addLink, collectionClass) {
    // Get the data-prototype explained earlier
    var prototype = $collection.data('prototype');
    var $collectionClass=$('.'+collectionClass);
    // get the new index
    var index = $collection.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collection.data('index', index + 1);

    var $newFormLi = $('<li class="'+collectionClass+'"></li>').append(newForm);

    $addLink.before($newFormLi);
    // $('select').material_select();

    var $lastCollectionChild = $collectionClass.last();

    // add a delete link to the new form
    addTagFormDeleteLink($lastCollectionChild);
}

/**
 *
 * @param $form
 * @param $deleteLink
 */
function addTagFormDeleteLink($form,$deleteLink) {
    var $removeFormA = $deleteLink;

    $form.append($removeFormA);


    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $form.remove();
    });
}

