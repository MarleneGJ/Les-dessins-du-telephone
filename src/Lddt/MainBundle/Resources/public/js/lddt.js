
jQuery(document).ready(function() {
    // setup an "add a tag" link
    var $addTagLink = $('<a href="#" class="add_tag_link">Add a tag</a>');
    var $newLinkLi = $('<li></li>').append($addTagLink);
    // Get the ul that holds the collection of tags
    var $collectionHolder = $('ul.tags');

    // add a delete link to all of the existing tag form li elements
    $collectionHolder.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTagLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see code block below)
        addTagForm($collectionHolder, $newLinkLi);
    });



    // AJAX
    // Refresh Comments
    $('body').on('click','.refresh_comments',function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var lddt_blog_refresh_comments = Routing.generate('lddt_blog_refresh_comments',{id:id});
        $('.load_comments').load(lddt_blog_refresh_comments,function(data){
            $(this).html(data);
        });
    });

});

function addTagForm($collectionHolder, $newLinkLi) {
    //addTagFormDeleteLink($newFormLi);//
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);

    // also add a remove button, just for this example
    $newFormLi.append('<a href="#" class="remove-tag">x</a>');

    $newLinkLi.before($newFormLi);

    // handle the removal, just for this example
    $('.remove-tag').click(function(e) {
        e.preventDefault();

        $(this).parent().remove();

        return false;
    });
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a href="#">delete this tag</a>');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $tagFormLi.remove();
    });
}