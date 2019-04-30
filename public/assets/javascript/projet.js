$(".report").on("click", function(event) {

    event.preventDefault();
    var self = this;
    var id = $(this).data('commentid');

    $.ajax({
        url : '/report/' + id,
        type : 'POST',
        success : function(){
            $(self).replaceWith('<p>Signalement enregistré</p>');
        },
    });
});


$(".unreport").on("click", function(event) {

    event.preventDefault();
    var self = this;
    var id = $(this).data('commentid');

    $.ajax({
        url : '/unreport/' + id,
        type : 'POST',
        success : function(){
            $(self).replaceWith('<p>Signalement annulé</p>');
        },
    });
});


$(".postReport").on("click", function(event) {

    event.preventDefault();
    var self = this;
    var id = $(this).data('postid');

    $.ajax({
        url : '/post/' + id + '/report',
        type : 'POST',
        success : function(){
            $(self).replaceWith('<p class="button-replacement">Signalement enregistré</p>');
        },
    });
});


$(".removeReport").on("click", function(event) {

    event.preventDefault();
    var self = this;
    var id = $(this).data('postid');

    $.ajax({
        url : '/post/' + id + '/removeReport',
        type : 'POST',
        success : function(){
            $(self).replaceWith('<p>Signalement annulé</p>');
        },
    });
});


$(".vote").on("click", function(event) {

    event.preventDefault();
    var self = this;
    var id = $(this).data('postid');

    $.ajax({
        url : '/post/' + id + '/vote',
        type : 'POST',
        success : function(){
            $(self).replaceWith('<p class="button-replacement">Vote enregistré</p>');
        },
    });
});


$(".unvote").on("click", function(event) {

    event.preventDefault();
    var self = this;
    var id = $(this).data('postid');

    $.ajax({
        url : '/post/' + id + '/unvote',
        type : 'POST',
        success : function(){
            $(self).replaceWith('<p class="button-replacement">Vote annulé</p>');
        },
    });
});


$('#deletePost').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget);
    var postId = button.data('postid');
    var modal = $(this);

    modal.find('.modal-title').append();
    modal.find('#modal-post-id').val(postId);
});


$("#confirmer").on("click", function(){

    var id = $('#deletePost').find('#modal-post-id').val();

    $.ajax({
        url : '/admin/post/delete/' + id,
        type : 'POST',
        success : function(){
            $('.post_'+ id).remove();
        },
    });
    $("#deletePost").modal('hide');
});


$('#deleteComment').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget);
    var commentId = button.data('commentid');
    var modal = $(this);

    modal.find('.modal-title').append();
    modal.find('#modal-comment-id').val(commentId);
});


$("#confirmer-comment").on("click", function(){

    var id = $('#deleteComment').find('#modal-comment-id').val();

    $.ajax({
        url : '/admin/comment/delete/' + id,
        type : 'POST',
        success : function(){
            $('.comment_'+ id).remove();
        },
    });
    $("#deleteComment").modal('hide');
});