var logs;
function actionFormatter(value, row) {
    var action = '<div class="iconsbox-text-logs">';
    console.log(row.removed, row.edited);
    if(row.action == 0){
        action += '<h5 class="text-log-icon"><span class="badge" style="background-color: #b70606!important;" title="Message Remnoved"><i class="fas fa-trash" style="margin-right: 5px;"></i> Message removed</span></h5>';

    }
    else if (row.action == 1) {
        action += '<h5 class="text-log-icon"><span class="badge bg-primary text-log-icon log-badge" title="Message Edited" ><i class="fas fa-pen" style="margin-right: 5px;"></i> Message edited</span></h5>';
    } else if (row.action == 2) {
        action += '<h5 class="text-log-icon"><span class="badge log-badge"  style="background-color: #de9500!important;" title="Attachment removed"><i class="fas fa-cut" style="margin-right: 5px;"></i> Attachment removed</span> </h5>';

    }
    action += '</div>'  
    return action;
}
function contentFormatter(value, row){
    if(row.action == 0){
        attachments ='';
        if (row.removed_attachments.length != 0) {
            for(var attachment of row.removed_attachments){
                attachments += '<button type="button" class="btn btn-primary attachmentbutton" data-bs-toggle="modal" data-bs-target="#attachmentmodal" data-bs-attachment-id="' + attachment.id + ' data-bs-message-id="' + row.message_id + '"><i class="far fa-file-alt attachmenticon"></i> ' + attachment.id + '</button>';

            }

        }
        return row.message + attachments;
    }else if (row.action == 1){
        object = `
        <span class="badge bg-success">After</span> `+ row.message_after + `
        <hr />
        <span class="badge bg-light text-dark">Before</span> `+ row.message_before+ `
        
        `;
        
        return object;
    }else if (row.action == 2){
        object = '<button type="button" class="btn btn-primary attachmentbutton" data-bs-toggle="modal" data-bs-target="#attachmentmodal" data-bs-attachment-id="' + row.attachment_id + ' data-bs-message-id="' + row.message_id + '"><i class="far fa-file-alt attachmenticon"></i> ' + row.attachment_id + '</button>';
        return object;
    }
}
function timecontrol(value, row){
    return timeconvert(value);
}
function request_logs() {
    var result = "";
    $.ajax({
        url: "logs.php",
        async: false,
        success: function (data) {
            result = data;
        }
    });
    return result;
}
function getData(){
    //XHR REQUEST DATA
    clear_data = request_logs();
    var xhr_data_obj = JSON.parse(clear_data);
    logs = generateActions(xhr_data_obj);
    //console.log('end');
    //console.log(logs)
    console.log(logs);

    return logs;
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
    var removed_array = new Array;
    for (var element of logs) {
        if (element.removed == 1){
            //CHECK ATTACHMENT
            var attachments_return = [];
            if (element.attachments.length != 0) {
                for (var attachment of element.attachments) {
                    if (attachment.removed != 1 || attachment.removed == null || attachment.removed == undefined) {
                        attachments_return.push(attachment)
                    }

                }
            }
            

            // PUSH DATA
            removed_array.push({ "action": 0, "action_time": element.remove_time, "message_id": element.message_id, "channel_id": element.channel_id, "client_id": element.client_id, "message": (element.content.at(-1)).content, "removed_attachments": attachments_return});
        }
        
    }
    return removed_array;
}
function gen_edited_content(logs){
    var cedit_array = [];
    for (var element of logs) {
        if ((element.content).length > 1){
            for (var i = 1; i <= ((element.content).length)-1; i++) {
                cedit_array.push({ "action": 1, "action_time": element.content[i].datetime, 'message_before': element.content[i - 1].content, "message_after": element.content[i].content, "message_id": element.message_id, "channel_id": element.channel_id, "client_id": element.client_id})
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
                    arem_array.push({ "action": 2, "action_time": attachment.remove_time, "attachment_id": attachment.id, "message_id": element.message_id, "channel_id": element.channel_id, "client_id": element.client_id })
                }
                
            }
        }
        
    }
    return arem_array;

}
$('#table').bootstrapTable({
    data: getData()
})
