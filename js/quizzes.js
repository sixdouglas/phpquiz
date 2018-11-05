$(document).ready(function () {

    $('#addQuizModalSave').on('click', function (event) {
        var name = document.getElementById('addNameInput').value;
        var code = document.getElementById('addCodeInput').value;
        var open = document.getElementById('addOpenCheckbox').checked;
        $.ajax({
            url: "/phpquiz/admin/quizzes/add",
            method: "POST",
            data: { name: name, code: code, open: open },
            dataType: "json"
        }).done(function( msg ) {
            $('#addQuizModal').modal('toggle');
            $('.loading').addClass('show').css("display", "block");
            location.reload();
        }).fail(function( jqXHR, textStatus, errorThrown ) {
            $("#addQuizModal").find(".alert").removeClass("d-none");
            console.log( "Request add Quiz failed: " + textStatus + ", " + errorThrown );
        });
    });

    $('#editQuizModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var quizId = button.data('id');
        var quizName = button.data('name');
        var quizCode = button.data('code');
        var quizOpen = button.data('open');
        $('#editQuizModalSave').data('id', quizId);
        var modal = $(this);
        modal.find('.modal-title').text('Edit Quiz (' + quizId + ')');
        modal.find('#editNameInput').val(quizName);
        modal.find('#editCodeInput').val(quizCode);
        modal.find('#editOpenCheckbox').prop("checked", quizOpen);
    });

    $('#editQuizModalSave').on('click', function (event) {
        var name = document.getElementById('editNameInput').value;
        var code = document.getElementById('editCodeInput').value;
        var open = document.getElementById('editOpenCheckbox').checked;
        var id = $('#editQuizModalSave').data('id')
        $.ajax({
            url: "/phpquiz/admin/quizzes/edit/" + id,
            method: "POST",
            data: { id: id, name: name, code: code, open: open },
            dataType: "json"
        }).done(function( msg ) {
            $('#editQuizModal').modal('toggle');
            $('.loading').addClass('show').css("display", "block");
            location.reload();
        }).fail(function( jqXHR, textStatus, errorThrown ) {
            $("#editQuizModal").find(".alert").removeClass("d-none");
            console.log( "Request edit Quiz failed: " + textStatus + ", " + errorThrown );
        });
    });

    $('#removeQuizModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var quizId = button.data('id');
        var quizName = button.data('name');
        var quizCode = button.data('code');
        var quizOpen = button.data('open');
        $('#removeQuizModalSave').data('id', quizId);
        var modal = $(this);
        modal.find('.modal-title').text('Remove Quiz (' + quizId + ')');
        modal.find('#removeNameInput').val(quizName);
        modal.find('#removeCodeInput').val(quizCode);
        modal.find('#removeOpenCheckbox').prop("checked", quizOpen);
    });

    $('#removeQuizModalSave').on('click', function (event) {
        var name = document.getElementById('removeNameInput').value;
        var code = document.getElementById('removeCodeInput').value;
        var open = document.getElementById('removeOpenCheckbox').checked;
        var id = $('#removeQuizModalSave').data('id')
        $.ajax({
            url: "/phpquiz/admin/quizzes/remove/" + id,
            method: "POST",
            data: { id: id, name: name, code: code, open: open },
            dataType: "json"
        }).done(function( msg ) {
            $('#removeQuizModal').modal('toggle');
            $('.loading').addClass('show').css("display", "block");
            location.reload();
        }).fail(function( jqXHR, textStatus, errorThrown ) {
            $("#removeQuizModal").find(".alert").removeClass("d-none");
            console.log( "Request Remove Quiz failed: " + textStatus + ", " + errorThrown );
        });
    });
});
