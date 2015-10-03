//弹出框
function showAlert(title, content){
    if (title == '') {
        title = '发生错误了';
    }
    var d = dialog({
        title: title,
        content : content
    });
    d.showModal();
    return false;
}