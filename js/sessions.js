$(document).ready(function () {

    $('#addSessionModalSave').on('click', function (event) {
        var name = document.getElementById('addNameInput').value;
        var code = document.getElementById('addCodeInput').value;
        $.ajax({
            url: "/phpquiz/admin/sessions/add",
            method: "POST",
            data: { name: name, code: code },
            dataType: "json"
        }).done(function( msg ) {
            $('#addSessionModal').modal('toggle');
            $('.loading').addClass('show').css("display", "block");
            location.reload();
        }).fail(function( jqXHR, textStatus, errorThrown ) {
            $("#addSessionModal").find(".alert").removeClass("d-none");
            console.log( "Request add Session failed: " + textStatus + ", " + errorThrown );
        });
    });

    $('#editSessionModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var sessionId = button.data('id');
        var sessionName = button.data('name');
        var sessionCode = button.data('code');
        $('#editSessionModalSave').data('id', sessionId);
        var modal = $(this);
        modal.find('.modal-title').text('Edit Session (' + sessionId + ')');
        modal.find('#editNameInput').val(sessionName);
        modal.find('#editCodeInput').val(sessionCode);
    });

    $('#editSessionModalSave').on('click', function (event) {
        var name = document.getElementById('editNameInput').value;
        var code = document.getElementById('editCodeInput').value;
        var id = $('#editSessionModalSave').data('id')
        $.ajax({
            url: "/phpquiz/admin/sessions/edit/" + id,
            method: "POST",
            data: { id: id, name: name, code: code },
            dataType: "json"
        }).done(function( msg ) {
            $('#editSessionModal').modal('toggle');
            $('.loading').addClass('show').css("display", "block");
            location.reload();
        }).fail(function( jqXHR, textStatus, errorThrown ) {
            $("#editSessionModal").find(".alert").removeClass("d-none");
            console.log( "Request edit Session failed: " + textStatus + ", " + errorThrown );
        });
    });

    $('#removeSessionModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var sessionId = button.data('id');
        var sessionName = button.data('name');
        var sessionCode = button.data('code');
        $('#removeSessionModalSave').data('id', sessionId);
        var modal = $(this);
        modal.find('.modal-title').text('Remove Session (' + sessionId + ')');
        modal.find('#removeNameInput').val(sessionName);
        modal.find('#removeCodeInput').val(sessionCode);
    });

    $('#removeSessionModalSave').on('click', function (event) {
        var name = document.getElementById('removeNameInput').value;
        var code = document.getElementById('removeCodeInput').value;
        var id = $('#removeSessionModalSave').data('id')
        $.ajax({
            url: "/phpquiz/admin/sessions/remove/" + id,
            method: "POST",
            data: { id: id, name: name, code: code },
            dataType: "json"
        }).done(function( msg ) {
            $('#removeSessionModal').modal('toggle');
            $('.loading').addClass('show').css("display", "block");
            location.reload();
        }).fail(function( jqXHR, textStatus, errorThrown ) {
            $("#removeSessionModal").find(".alert").removeClass("d-none");
            console.log( "Request Remove Session failed: " + textStatus + ", " + errorThrown );
        });
    });
});
