$(function (){
    $(".trigger-change-task").on('click',function (){
        let taskId = $(this).data("task-id");

        let name = $("#name-"+taskId).text();
        let description = $("#description-"+taskId).text();
        let deadline = $("#deadline-"+taskId).text();
        let priority = $("#priority-"+taskId).text();
        let responsible = $("#responsible-"+taskId).data("responsible-id");


        $("#name-change").val(name);
        $("#description-change").val(description);
        $("#deadline-change").val(deadline);
        $(`#priority-change select option[value=${priority}]`).attr('selected','selected');
        $(`#responsible-change select option[value="${responsible}"]`).attr('selected','selected');
        $("#change-values").val(taskId);
        console.log(name, description,deadline,priority,responsible);
    })
})
