var logs;
function actionFormatter(value, row) {
    /*var action = '<div class="iconsbox-text-logs">';
    console.log(row.removed, row.edited);
    if(row.removed == 1){
        action += '<h5 class="text-log-icon"><span class="badge bg-danger" title="Removed: ' + row.remove_time +'"><i class="fas fa-trash"></i></span></h5>';

    }
    if (row.edited == 1) {
        action += '<h5 class="text-log-icon"><span class="badge bg-primary text-log-icon" title="Last edit: ' + row.edit_time +'" ><i class="fas fa-pen"></i></h5>';
    }
    action += '</div>'  */  
    return row.action;
}
var ojoj = getData();
function testAjax() {
    return $.ajax({
        url: "logs.php"
    });
}
function getData(){
    //XHR REQUEST DATA
    clear_data = testAjax();
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "logs.php", true);
    xhr.onload = function (e) {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            //Create data
            var xhr_data_obj = JSON.parse(xhr.responseText);
            logs = generateActions(xhr_data_obj);
            console.log('end');
            console.log(logs)
            
        } else {
            //Return when error
            console.log('error');
        }
        
    }
    };
    xhr.send(null);
}
function generateActions(logs){
    var last_action_time = (logs.at(-1)).last_action;
    var actions = new Array;
    actions = actions.concat(gen_removed(logs), gen_edited_content(logs), gen_removed_attachments(logs));
    actions.sort(function (a, b) {
        return a.action_time.localeCompare(b.action_time);
    }).reverse();
    for (var i = 0; i < actions.length; i++){
        if(actions[i].action_time < last_action_time){
            actions.splice(i, 1);
        }
    }
   
    
    return actions;

}
function gen_removed(logs){
    var removed_array = [];
    for (var element of logs) {
        if (element.removed == 1){
            removed_array.push({"action": 0, "action_time": element.remove_time, "message_id":element.message_id});
        }
        
    }
    return removed_array;
}
function gen_edited_content(logs){
    var cedit_array = [];
    for (var element of logs) {
        if ((element.content).length > 1){
            for (var i = 1; i <= ((element.content).length)-1; i++) {
                cedit_array.push({ "action": 1, "action_time": element.content[i].datetime, 'message_before': element.content[i - 1].content, "message_after": element.content[i].content, "message_id": element.message_id})
             }
        }
    }

    return cedit_array;
}

function gen_removed_attachments(logs){
    var arem_array = new Array;
    for (var element of logs) {
        if (element.attachments.length != 0){
            for(var attachment of element.attachments){
                if(attachment.removed == 1 && attachment.remove_time != null){
                    arem_array.push({ "action": 3, "action_time": attachment.remove_time, "attachment_id": attachment.id, "message_id": element.message_id })
                }
                
            }
        }
        
    }
    return arem_array;

}
$(function () {
    $('#table').bootstrapTable({
        data: getData()
    })
})