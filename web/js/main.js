$(function() {
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/" + App.config.aceTheme);
    editor.getSession().setMode("ace/mode/" + $("#language").val());
    editor.setFontSize(16);
    $("#btn-run").on("click", function() {
        var language = $("#language").val();
        $.ajax({
            'url': App.config.requestUrl,
            'data': {
                'code': editor.getValue(),
                'language': language,
            },
            'dataType': 'json',
            'type': 'post',
        }).done(function(response) {
            $output = $("#output");
            $output.find(".panel-footer").addClass("hide");
            if (response.Stderr) {
                $output.removeClass("panel-info panel-success").addClass("panel-danger");
            	$output.find(".panel-footer").html(response.Stderr).removeClass("hide");
            } else {
                $output.removeClass("panel-info panel-danger").addClass("panel-success");
            }
            $output.find(".panel-body").html(response.Stdout.replace(/(\n)/g, "<br/>"));
        });
    });
    $("#language").on("change", function() {
        var language = $(this).val();
        editor.getSession().setMode("ace/mode/"+App.config.aceModes[language].mode);
    });
});