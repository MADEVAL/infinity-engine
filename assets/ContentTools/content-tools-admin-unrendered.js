$(document).ready(function(){
    data = {
        _newPage:"create",
        "_PageName": window.templatePage
    }
    $.post(window.baseURL + 'admin/api/newPage', data, function(r){
        console.log(r);
        page_id = r.success[0];
        window.location = window.baseURL + "admin/edit/" + page_id;
    })
})