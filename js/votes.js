const CLASSES = ['vote-up', 'voted-up', 'vote-down', 'voted-down'];

function change_vote(elem, new_vote, old_vote) {
    function reset(elem) {
        var parent = elem[0].parentElement;
        $(parent.children[0]).removeClass('voted-up')
        $(parent.children[0]).removeClass('vote-up')
        $(parent.children[2]).removeClass('voted-down')
        $(parent.children[2]).removeClass('vote-down')
        if (elem[0] === parent.children[0])
            $(parent.children[2]).addClass('vote-down')
        else
            $(parent.children[0]).addClass('vote-up')
    }

    let alreadyVoted = elem.hasClass(new_vote);

    reset(elem);
    if (alreadyVoted)
        elem.addClass(old_vote);
    else
        elem.addClass((new_vote));
}

$(document).ready(function () {
    $('.vote-up').click(function (event) {
        change_vote($(event.target), 'voted-up', 'vote-up');
    })
    $('.voted-up').click(function (event) {
        change_vote($(event.target), 'vote-up', 'voted-up');
    })
    $('.vote-down').click(function (event) {
        change_vote($(event.target), 'voted-down', 'vote-down');
    })
    $('.voted-down').click(function (event) {
        change_vote($(event.target), 'vote-down', 'voted-down');
    })
});