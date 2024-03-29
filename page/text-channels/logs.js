var logs;
var xhr_data_obj;
var channels;
// Fomater for action (icons)
function actionFormatter(value, row) {
    var action = '<div class="iconsbox-text-logs">';
    if(row.action == 0){
        action += '<h5 class="text-log-icon"><span class="badge" style="background-color: #b70606!important;" title="Message Remnoved"><i class="fas fa-trash" style="margin-right: 5px;"></i> Message removed</span></h5>';

    }
    else if (row.action == 1) {
        action += '<h5 class="text-log-icon"><span class="badge bg-primary text-log-icon log-badge" title="Message Edited" ><i class="fas fa-pen" style="margin-right: 5px;"></i> Message edited</span></h5>';
    } else if (row.action == 2) {
        action += '<h5 class="text-log-icon"><span class="badge log-badge"  style="background-color: #de9500!important;" title="Attachment removed"><i class="fas fa-cut" style="margin-right: 5px;"></i> Attachment removed <br /> from message</span> </h5>';

    }
    action += '</div>'  
    return action;
}

//Formatter for content
function contentFormatter(value, row){
    if(row.action == 0){
        attachments ='';

        if (row.removed_attachments.length != 0) {
            if(row.message != null && row.message != "" && row.message != undefined){
                attachments += "<hr />";
            }
            
            for(var attachment of row.removed_attachments){
                attachments += `<button type="button" class="btn btn-primary attachmentbutton" data-bs-toggle="modal" data-bs-target="#attachment_modal" data-bs-attachment_id="${attachment.id}" data-bs-message_id="${row.message_id}"><i class="far fa-file-alt attachmenticon"></i>${attachment.id}</button>`;

            }
        }

        return sanitizeHTML(row.message) + attachments;
    }else if (row.action == 1){
        if (row.message_after != row.message_before){
            object = `
        <span class="badge bg-success">After</span> `+ sanitizeHTML(row.message_after) + `
        <hr />
        <span class="badge bg-light text-dark">Before</span> `+ sanitizeHTML(row.message_before);
        }else{
            return null;
        }

        
        return object;
    }else if (row.action == 2){
        object = `<button type="button" class="btn btn-primary attachmentbutton" data-bs-toggle="modal" data-bs-target="#attachment_modal" data-bs-attachment_id="${row.attachment_id}" ' data-bs-message_id="${row.message_id}"><i class="far fa-file-alt attachmenticon"></i>${row.attachment_id}</button>`;
        return object;
    }
}

// Function convert time UTC to user local on pc
function timecontrol(value, row){
    if(value != undefined){
        return timeconvert(value); 
    }
    return null
    
}

//Request data
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
    get_channels();
    //XHR REQUEST DATA
    var clear_data = request_logs();

    //JSON DECODE
    xhr_data_obj = JSON.parse(clear_data);
    logs = generateActions(xhr_data_obj);
    return logs;
}

function generateActions(logs){
    //get last time action for prevent fake logs
    var last_action_time = (logs.at(-1)).last_action;
    var actions = new Array;

    //Split all data generated in functions
    actions = actions.concat(gen_removed(logs), gen_edited_content(logs), gen_removed_attachments(logs));
    
    //Sort data by time
    actions.sort(function (a, b) {
        return a.action_time.localeCompare(b.action_time);
    }).reverse();

    //Remove data older than last action for prevent fake logs (older data dont sync with other in database)
    for (var i = 0; i < actions.length; i++){
        if(actions[i].action_time < last_action_time){
            actions.splice(i, 1);
        }
    }
   
    
    return actions;

}

//function generate list of actions with removed messages
function gen_removed(logs){
    var removed_array = new Array;
    for (var element of logs) {
        if (element.removed == 1){
            //Validate if removed message has attachment, what is not removed before action.
            var attachments_return = [];
            if (element.attachments.length != 0) {
                for (var attachment of element.attachments) {
                    if (attachment.removed != 1 || attachment.removed == null || attachment.removed == undefined) {
                        attachments_return.push(attachment)
                    }

                }
            }
            

            // PUSH DATA
            removed_array.push({ "action": 0, "action_time": element.remove_time, "message_id": element.message_id, "channel_id": element.channel_id, "client_id": element.client_id, "message": (element.content.at(-1)).content, "removed_attachments": attachments_return, "author_name": element.author_name});
        }
        
    }
    return removed_array;
}

//function generate list of actions with edited content
function gen_edited_content(logs){
    var cedit_array = [];
    for (var element of logs) {
        //Validate if messages is more than 1
        if ((element.content).length > 1){
            for (var i = 1; i <= ((element.content).length)-1; i++) {
                //PUSH DATA
                cedit_array.push({ "action": 1, "action_time": element.content[i].datetime, 'message_before': element.content[i - 1].content, "message_after": element.content[i].content, "message_id": element.message_id, "channel_id": element.channel_id, "client_id": element.client_id, "author_name": element.author_name})
             }
        }
    }

    return cedit_array;
}

//function generate list of actions with removed attachments
function gen_removed_attachments(logs){
    var arem_array = new Array;
    for (var element of logs) {
        //Attachment validator
        if (element.attachments.length != 0){
            for(var attachment of element.attachments){
                if(attachment.removed == 1 && attachment.remove_time != null){
                    //DATA PUSH
                    arem_array.push({ "action": 2, "action_time": attachment.remove_time, "attachment_id": attachment.id, "message_id": element.message_id, "channel_id": element.channel_id, "client_id": element.client_id, "author_name": element.author_name })
                }
                
            }
        }
        
    }
    return arem_array;

}
// GENERATE TABLE
$('#table').bootstrapTable({
    data: getData(),
    exportTypes: ['json', 'xml', 'csv', 'txt', 'sql', 'xlsx', 'doc', 'pdf', 'png'],
    exportOptions: { ignoreColumn: [0] },
    onExpandRow: function (index, row, $detail) {
        /* eslint no-use-before-define: ["error", { "functions": false }]*/
        $detail.html(RowDetails(row.message_id));
        execute_tables(row.message_id);
    }
})
function execute_tables(message_id){
    var message_obj = xhr_data_obj[xhr_data_obj.findIndex(x => x.message_id === message_id)];

    var $table = $(`#edit_${message_id}`);

    $table.bootstrapTable({ data: message_obj.content })


    var $attachments_table = $(`#attachmentstable_${message_id}`);

    $attachments_table.bootstrapTable({ data: message_obj.attachments })

}
//DETAILS ROW
function RowDetails(message_id){
    //object with message from clear data
    var message_obj = xhr_data_obj[xhr_data_obj.findIndex(x => x.message_id === message_id)];

    //MAIN FUNCTION RETURNING DATA
    function return_data(){
        return `<div class="row">` + simple_data() + table_edit(message_id) + attachments_edit(message_id) + `</div>`;
    }
    
    //construct simple informations
    function simple_data(){
        var edit;
        if(message_obj.edited == 1){
            edit = `Yes, last edit: ${timeconvert(message_obj.edit_time)}`;
        }else{
            edit = "No";
        }

        var remove;
        if (message_obj.removed == 1) {
            remove = `Yes: ${timeconvert(message_obj.remove_time)}`;
        } else {
            remove = "No";
        }
        var attachments_count = message_obj.attachments.length;
        return `
        <div class="col">
        <h3>Message details</h3>
        <p> 
            <b>Message id: </b> ${message_obj.message_id}<br />
            <b>Channel id: </b> ${message_obj.channel_id}<br />
            <b>Client id: </b> ${message_obj.client_id}<br />
            <b>Created on: </b> ${timeconvert(message_obj.create_time)}<br />
            <b>Edited: </b> ${edit}<br />
            <b>Removed: </b> ${remove}<br />
            <b>Attachments: </b> ${attachments_count}<br />
            <b>Edits: </b> ${message_obj.content.length - 1}<br />
        </p>
        </div>`;
    }
    function table_edit(message_id){
        return `
        <div class="col">
        <h3>Message history</h3>
        <table id="edit_${message_id}">
            <thead>
                <tr>
                <th data-field="content" data-formatter="string_secure">Content</th>
                <th data-field="datetime" data-formatter="timecontrol">Time</th>
                </tr>
            </thead>
        </table>
        </div>
        `;
        
    }

    function attachments_edit(message_id) {
        return `
        <div class="col">
        <h3>Attachments list</h3>
        <table id="attachmentstable_${message_id}">
            <thead>
                <tr>
                <th data-field="id">Id</th>
                <th data-field="removed">Removed</th>
                <th data-field="remove_time" data-formatter="timecontrol">Remove time</th>
                
                </tr>
            </thead>
        </table>
        </div>
        `;

    }
    return return_data();
}

function edit_mark(s1, s2){
    function words(s) {
        return s.toLowerCase().match(/\w+/g);
    }

    // str1 is the reference text. 
    var str1 = "I was sent to earth to protect my cousin";

    let a = words(str1);
    let b = words(str2);
    let res1 = b.filter(i => !a.includes(i));
    let res2 = a.filter(i => !b.includes(i));

    highlight(b, "str2", res1);
    highlight(a, "str1", res2);
    function highlight(str, id, res) {
        const div = document.createElement('div');
        var text = "";
        for (var i = 0; i < str.length; i++) {
            var hasVal = res.includes(str[i]);
            if (hasVal) {
                text += " <span class='imp'>" + str[i] + "</span> ";
            } else {
                text += " " + str[i] + " ";
            }
        }
        div.innerHTML = text;
        return div;
    }
    return;
}

function get_channels(){
    var result = "";
    $.ajax({
        url: "/api/get_channels.php",
        async: false,
        success: function (data) {
            channels = JSON.parse(data);
            
            
        }
    });
    return;

}

function channel_formatter(value, row){
    var channel = channels.find(x => x.id === parseInt(row.channel_id));
    return channel.name;
}

//MODAL
var attachment_modal = document.getElementById('attachment_modal')
attachment_modal.addEventListener('show.bs.modal', function (event) {

    
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var attachment_id = button.getAttribute('data-bs-attachment_id');
    var message_id = button.getAttribute('data-bs-message_id');


    //loading obj
    var loading = `
    <div class="d-flex justify-content-center">
    <div class="spinner-border m-5" role="status">
    <span class="sr-only">Loading...</span>
    </div>`;


    //Define html obj
    var modalTitle = attachment_modal.querySelector('.modal-title');
    var modalBody = attachment_modal.querySelector('.modal-body');
    var modalFooter = attachment_modal.querySelector('.modal-footer');
    modalBody.innerHTML = loading;
    modalFooter.innerHTML = null;
    modalTitle.textContent = 'Attachment: ' + attachment_id;

    // XHR Request
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/api/attachment.php" + `?message_id=${message_id}&attachment_id=${attachment_id}`, true);
    xhr.onload = function (e) {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                modalBody.innerHTML = `<img src="${xhr.responseURL}" class="attachment_image"></img>`;
                modalFooter.innerHTML = `<a href=${xhr.responseURL} type="button" class="btn btn-secondary" id="attachment_raw">Show full file</a>`;

            } else {
                console.error(xhr.statusText);
                modalBody.innerHTML = `<center>Error: (${xhr.status}) <br />${xhr.statusText} </center>`
            }
        }
    };
    xhr.onerror = function (e) {
        console.error(xhr.statusText);
    };
    xhr.send(null);


})
function sanitizeHTML (str) {
    return str.replace(/</g, "&lt;").replace(/>/g, "&gt;");
};

function string_secure(value,row){
    return sanitizeHTML(value);
}